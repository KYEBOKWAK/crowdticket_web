'use strict';

import React, { Component } from 'react';

import StoreContentsListItem from '../component/StoreContentsListItem';
// import Util from '../lib/Util';
import axios from '../lib/Axios';

import Types from '../Types';

import FileUploader from '../component/FileUploader';

import ic_arrive_icon_img from '../res/img/ic-arrive-icon.svg';
import ic_ct_thumb_img from '../res/img/ic-ct-thumb.svg';

import Util from '../lib/Util';

import Popup_text_viewer from '../component/Popup_text_viewer';
// import { scale, verticalScale, moderateScale } from 'react-native-size-matters';
// import FontWeights from '@lib/fontWeights';

// import * as appKeys from '~/AppKeys';
// import Util from '@lib/Util';
// import * as GlobalKeys from '~/GlobalKeys';

//redux START
// import * as actions from '@actions/index';
// import { connect } from 'react-redux';
//redux END
// import Colors from '@lib/colors';
// import Types from '~/Types';



class StoreContentConfirm extends Component{

  constructor(props){
    super(props);

    this.state = {
      store_order_id: null,
      store_item_id: null,

      store_id: null,
      store_alias: '',
      store_title: '',

      item_img_url: '',
      item_title: '',
      item_price: 0,
      item_product_state: Types.product_state.TEXT,
      item_file_upload_state: Types.file_upload_state.NONE,

      store_user_profile_photo_url: '',

      product_answer: '',

      comment_id: null,
      comment_contents: '',

      input_comment_value: '',

      state: 0,


      is_owner: false,

      order_user_name: '',
      order_user_profile_photo_url: '',

      product_title: null,
      product_text: null,
      isOpenProductText: false
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    const storeOrderIDDom = document.querySelector('#store_order_id');
    if(storeOrderIDDom){
      this.setState({
        store_order_id: Number(storeOrderIDDom.value)
      }, function(){
        //아이템 정보 가져오기
        axios.post("/orders/store/owner/check", {
          store_order_id: this.state.store_order_id
        }, (result) => {
          this.setState({
            is_owner: true
          }, () => {
            this.requestOrderInfo();
            this.requestAnswerComment();
            this.requestOrderUserInfo();
            this.requestProductText();
          })
          
        }, (error) => {

        })

        
      })
    }
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  requestProductText = () => {
    axios.post('/store/product/text/get', {
      store_order_id: this.state.store_order_id
    }, (result) => {
      let _product_text = result.product_text;
      if(_product_text){
        _product_text = _product_text.replace(/(<br>|<br\/>|<br \/>)/g, '\r\n');
        _product_text = _product_text.replace(/<(\/)?([a-zA-Z]*)(\s[a-zA-Z]*=[^>]*)?(\s)*(\/)?>/ig, "");
      }

      this.setState({
        product_title: result.product_title_text,
        product_text: _product_text
      })
    }, (error) => {

    })
  }

  requestOrderUserInfo = () => {
    axios.post("/user/info", {}, 
    (result) => {
      const userInfo = result.userInfo;

      const name = Util.getUserName(userInfo);
      this.setState({
        order_user_name: name,
        order_user_profile_photo_url: userInfo.profile_photo_url
      })
      
    }, (error) => {

    })
  }

  requestAnswerComment = () => {
    axios.post("/comments/second/get", {
      second_target_id: this.state.store_order_id,
      second_target_type: Types.comment.secondTargetType.store_order
    }, (result) => {
      this.setState({
        comment_id: result.comment_id,
        comment_contents: result.contents
      })
    }, (error) => {

    })
  }

  requestOrderInfo(){
    axios.post('/orders/store/info', {
      store_order_id: this.state.store_order_id
    }, (result) => {
      const data = {
        ...result.data
      }

      //     isHomeList={true} store_alias={data.alias} type={Types.store_home_item_list.IN_ITEM}

      this.setState({
        store_id: data.store_id,
        item_id: data.item_id,

        item_img_url: data.item_img_url,
        store_title: data.store_title,

        item_title: data.item_title,
        item_price: data.item_price,
        product_answer: data.product_answer,

        state: data.state,

        store_alias: data.alias,

        item_file_upload_state: data.file_upload_state
      }, () => {
        this.requestItemInfo();
      })
    }, (error) => {

    })
  }

  requestItemInfo(){
    axios.post('/store/any/item/info', {
      store_item_id: this.state.item_id
    }, (result) => {
      const data = result.data;
      this.setState({
        // item_title: data.title,
        // item_price: data.price,
        // item_content: data.content,
        // item_thumb_img_url: data.img_url,
        // // total_price: data.price,
        // store_id: data.store_id,
        // item_nick_name: data.nick_name,

        // store_title: data.store_title,

        item_product_state: data.product_state,
        // item_file_upload_state: data.file_upload_state,

        store_user_profile_photo_url: data.profile_photo_url
      })
    }, (error) => {

    })
  }

  clickCancelOrder(e){
    e.preventDefault();

    swal("주문을 취소하시겠습니까?", {
      buttons: {
        nosave: {
          text: "아니오",
          value: "notsave",
        },
        save: {
          text: "예",
          value: "cancel",
        },
      },
    })
    .then((value) => {
      switch (value) {
        case "cancel":
        {
          this.requestOrderCancel();
        }
        break;
      }
    });    
  }

  requestOrderCancel(){
    showLoadingPopup('취소가 진행중입니다..');

    axios.post("/orders/store/cancel", {
      store_order_id: this.state.store_order_id
    }, (result) => {

      axios.post("/store/item/order/quantity", {
        item_id: this.state.store_item_id
      }, (result_quantity) => {
        this.successCancelPopup();
      }, (error_quantity) => {
        this.successCancelPopup();
      })

    }, (error) => {
      stopLoadingPopup();
      alert("취소 에러");
    })
  }

  successCancelPopup(){
    stopLoadingPopup();
    swal("주문 취소 성공!", 'success').then(() => {
      window.location.reload();
    })
  }

  onChangeInput = (e) => {
    e.preventDefault();

    this.setState({
      input_comment_value: e.target.value
    })
  }

  onClickContact = (e) => {
    plusFriendChat();
  }

  onClickOK = (e) => {
    e.preventDefault();

    if(this.state.state === Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE){
      let baseURL = 'https://crowdticket.kr'
      const baseURLDom = document.querySelector('#base_url');
      if(baseURLDom){
        // console.log(baseURLDom.value);
        baseURL = baseURLDom.value;
      }

      let goURL = '';
      if(!this.state.store_alias || this.state.store_alias === ''){
        goURL = baseURL + '/store/' + this.state.store_id;
      }else{
        goURL = baseURL + '/store/' + this.state.store_alias;
      }
        
      window.location.href = goURL;
    }else{
      axios.post('/orders/store/state/confirm/ok', {
        store_order_id: this.state.store_order_id
      }, (result) => {

        if(this.state.input_comment_value === ''){
          this.setState({
            state: result.data.state
          }, () => {
            this.successAlert();
          })

          return;
        }

        axios.post('/comments/second/add', {
          commentType: Types.comment.commentType.store,
          target_id: this.state.store_id,
          comment_value: this.state.input_comment_value,
          second_target_id: this.state.store_order_id,
          second_target_type: Types.comment.secondTargetType.store_order
        }, (result_comment) => {
          this.setState({
            state: result.data.state
          }, () => {
            this.requestAnswerComment();
            this.successAlert();
          })
        }, (error_comment) => {
          
        })
        

        
      }, (error) => {

      })
    }
  }

  successAlert = () => {
    swal('구매 완료!', '구매해주셔서 감사합니다. :)', 'success');
  }

  clickProductText = (e) => {
    e.preventDefault();

    this.setState({
      isOpenProductText: true
    })
  }

  render(){
    if(!this.state.is_owner){
      return <>접근 불가능한 페이지 입니다.</>;
    }

    if(this.state.store_id === null){
      return <></>;
    }

    if(this.state.state >= Types.order.ORDER_STATE_CANCEL_START){
      return <>취소 | 결제된 주문입니다.</>;
    }

    if(this.state.state !== Types.order.ORDER_STATE_APP_STORE_PLAYING_DONE_CONTENTS){
      if(this.state.state < Types.order.ORDER_STATE_APP_STORE_RELAY_CUSTOMER ||
        this.state.state > Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE){
          return <>아직 완성이 안된 콘텐츠 입니다.</>
      }
    }
    

    let product_answer_dom = <></>;
    let review_placehold_text = '기대평 & 리뷰를 남겨보세요!';
    if(this.state.item_product_state === Types.product_state.ONE_TO_ONE){
      review_placehold_text = '콘텐츠 후기를 남겨주세요!';
    }

    if(this.state.product_answer !== null && this.state.product_answer !== ''){
      review_placehold_text = '크리에이터에게 답장을 해보세요!';
      product_answer_dom = <div className={'product_answer_wrapper'}>
                              <div className={'product_answer_container'}>
                                <img className={'product_answer_img'} src={this.state.store_user_profile_photo_url} />
                                <div className={'product_answer_content_container'}>
                                  <div className={'product_answer_name'}>
                                    {this.state.store_title}
                                  </div>
                                  <div className={'product_answer_content'}>
                                    {this.state.product_answer}
                                  </div>
                                </div>
                              </div>
                            </div>
    }

    let buttonText = '구매 완료 하기';
    let textAreaDom = <></>;
    let contact_explain_dom = <></>;
    let review_dom = <></>;
    if(this.state.state === Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE){
      buttonText = '상점으로 가기';

      if(this.state.comment_contents !== ''){
        review_dom = <div className={'product_answer_wrapper'}>
                      <div className={'product_answer_container review_container'}>
                        <div className={'product_answer_content_container review_answer_content_container'}>
                          <div className={'product_answer_name review_answer_name'}>
                            {this.state.order_user_name}
                          </div>
                          <div className={'product_answer_content'}>
                          {this.state.comment_contents}
                          </div>
                        </div>
                        <img className={'product_answer_img'} src={this.state.order_user_profile_photo_url} />
                      </div>
                    </div>
      }
    }else{
      textAreaDom = <textarea className={'review_textarea'} type="text" name={'review'} placeholder={review_placehold_text} value={this.state.input_comment_value} onChange={(e) => {this.onChangeInput(e)}}/>

      contact_explain_dom = <div className={'product_answer_wrapper'}>
                              <div className={'product_answer_container'}>
                                <img className={'product_answer_img'} src={ic_ct_thumb_img} />
                                <div className={'product_answer_content_container'}>
                                  <div className={'product_answer_name'}>
                                    크티 고객팀
                                  </div>
                                  <div className={'product_answer_content'}>
                                  {'받아보신 콘텐츠는 어떠셨나요? \n\n크리에이터에게 감사 인사 및 콘텐츠 이용 후기를 아래에 남겨주세요! 여러분이 작성하신 리뷰와 응원이 크리에이터에게 힘이 됩니다!'}
                                  </div>
                                </div>
                              </div>
                            </div>
    }

    let product_after_confirm_content_dom = <></>;
    if(this.state.item_product_state === Types.product_state.TEXT && this.state.product_text) {
      product_after_confirm_content_dom = <div>
                                            <div className={'product_container'}>
                                              <div className={'product_title_text'}>
                                                {this.state.product_title}
                                              </div>
                                              <div className={'product_text_text'}>
                                                {this.state.product_text}
                                              </div>
                                            </div>
                                            <button onClick={(e) => {this.clickProductText(e)}} style={{paddingBottom: 0}} className={'product_show_text'}>
                                              {`전체보기 >`}
                                            </button>
                                          </div>
      
    }

    let openProductTextView = <></>;

    if(this.state.isOpenProductText){
      openProductTextView = <Popup_text_viewer store_order_id={this.state.store_order_id} closeCallback={() => {
        this.setState({
          isOpenProductText: false
        })
      }}></Popup_text_viewer>
    }

    return(
      <div className={'StoreContentConfirm'}>
        <div className={'title_container'}>
          <img style={{}} src={ic_arrive_icon_img} />
          <div className={'title_text'}>
            {'주문하신 콘텐츠 상품이\n도착했습니다!'}
          </div>
        </div>

        <div className={'store_contents_item_container'}>
          <StoreContentsListItem store_id={this.state.store_id} id={this.state.item_id} store_item_id={this.state.item_id} thumbUrl={this.state.item_img_url} store_title={this.state.store_title} title={this.state.item_title} price={this.state.item_price} isHomeList={true} store_alias={''} isLink={false}></StoreContentsListItem>
        </div>

        {product_after_confirm_content_dom}

        <div className={'under_line'}>

        </div>

        <div className={'file_upload_container'}>
          <FileUploader product_state={this.state.item_product_state} file_upload_target_type={Types.file_upload_target_type.product_file} state={this.state.item_file_upload_state} isUploader={false} store_order_id={this.state.store_order_id} isListEndBlurCover={false}></FileUploader>
        </div>

        <div className={'community_container'}>
          {product_answer_dom}
          {contact_explain_dom}
          {review_dom}
        </div>

        <div className={'review_textarea_container'}>
          {textAreaDom}
          <div className={'explain_text'}>
            {'[상점 - 리뷰&기대평]에서 확인 할 수 있습니다.'}
          </div>
        </div>

        <div className={'problem_button_container'}>
          <button className={'problem_button'} onClick={(e) => {this.onClickContact(e)}}>
            <u>콘텐츠에 문제가 있나요?</u>
          </button>
        </div>

        <button className={'ok_button'} onClick={(e) => {this.onClickOK(e)}}>
          {buttonText}
        </button>

        {openProductTextView}
      </div>
    )
  }
};

export default StoreContentConfirm;