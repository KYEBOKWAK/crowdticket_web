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

import CompletedFileUpLoader from '../component/CompletedFileUpLoader';

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
      item_price_usd: 0,
      currency_code: Types.currency_code.Won,
      item_product_state: Types.product_state.TEXT,
      item_file_upload_state: Types.file_upload_state.NONE,
      item_type_contents: Types.contents.customized,

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
      isOpenProductText: false,

      review_button_disabled: false
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

        item_file_upload_state: data.file_upload_state,

        item_type_contents: data.type_contents,

        item_price_usd: data.price_USD,
        currency_code: data.currency_code
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
        item_product_state: data.product_state,
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
    e.preventDefault();

    plusFriendChat();
  }

  onClickReview = (e) => {
    e.preventDefault();

    if(this.state.input_comment_value === ''){
      alert('리뷰를 작성해주세요~!');
      return;
    }

    this.setState({
      review_button_disabled: true
    }, () => {
      axios.post('/comments/second/add', {
        commentType: Types.comment.commentType.store,
        target_id: this.state.store_id,
        comment_value: this.state.input_comment_value,
        second_target_id: this.state.store_order_id,
        second_target_type: Types.comment.secondTargetType.store_order
      }, (result_comment) => {
        this.requestAnswerComment();
        this.successReviewAlert();
      }, (error_comment) => {
        
      })
    })
  }

  onClickGoStore = (e) => {
    e.preventDefault();

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
  }

  onClickOK = (e) => {
    e.preventDefault();

    axios.post('/orders/store/state/confirm/ok', {
      store_order_id: this.state.store_order_id
    }, (result) => {
      this.setState({
        state: result.data.state
      }, () => {
        this.successAlert();
      })
    }, (error) => {

    })
  }

  successAlert = () => {
    swal('구매 완료!', '구매해주셔서 감사합니다. :)', 'success');
  }

  successReviewAlert = () => {
    swal('리뷰 작성 완료!', '감사합니다. :)', 'success');
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
    

    
    let review_placehold_text = '기대평 & 리뷰를 남겨보세요!';
    let buttonText = '구매 완료 하기';
    if(this.state.item_product_state === Types.product_state.ONE_TO_ONE){
      review_placehold_text = '콘텐츠 후기를 남겨주세요!';
      buttonText = '콘텐츠 확인 완료';
    }
    
    let ok_button_dom = <></>;
    let go_store_button_dom = <></>;
    if(this.state.state === Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE){

      let goStoreButtonTopSize = 20;
      if(this.state.comment_id === null){
        goStoreButtonTopSize = 8;
      }
      go_store_button_dom = <button style={{marginTop: goStoreButtonTopSize}} onClick={(e) => {this.onClickGoStore(e)}} className={'white_button'}>
                              상점 가기
                            </button>
    }else{
      ok_button_dom = <button className={'ok_button'} onClick={(e) => {this.onClickOK(e)}}>
                        {buttonText}
                      </button>
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

    let review_talk_container_dom = <></>;
    if(this.state.comment_id === null){
      let product_answer_dom = <></>;
      let review_dom = <></>;

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

      const textAreaDom = <textarea className={'review_textarea'} type="text" name={'review'} placeholder={review_placehold_text} value={this.state.input_comment_value} onChange={(e) => {this.onChangeInput(e)}}/>
      
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

      const contact_explain_dom = <div className={'product_answer_wrapper'}>
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

      let reviewButtonStyle = {}
      if(this.state.state === Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE){
        reviewButtonStyle = {
          backgroundColor: '#00bfff',
          color: '#ffffff'
        }
      }
      review_talk_container_dom = <div className={'community_container_box'}>
                                    <div className={'community_top_line'}>
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

                                    <button disabled={this.state.review_button_disabled} style={reviewButtonStyle} onClick={(e) => {this.onClickReview(e)}} className={'white_button'}>
                                      리뷰 작성 완료
                                    </button>
                                  </div>
    }

    let file_list_dom = <></>;
    let under_line_dom = <></>;
    if(this.state.item_type_contents === Types.contents.completed) {
      file_list_dom = <div>
                        <CompletedFileUpLoader store_order_id={this.state.store_order_id} store_item_id={this.state.item_id} isUploader={false}></CompletedFileUpLoader>
                      </div>

      under_line_dom = <div style={{marginBottom: 0}} className={'under_line'}></div>
    }else{
      file_list_dom = <div className={'file_upload_container'}>
                        <FileUploader product_state={this.state.item_product_state} file_upload_target_type={Types.file_upload_target_type.product_file} state={this.state.item_file_upload_state} isUploader={false} store_order_id={this.state.store_order_id} isListEndBlurCover={false}></FileUploader>
                      </div>

      under_line_dom = <div className={'under_line'}></div>
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
          <StoreContentsListItem store_id={this.state.store_id} id={this.state.item_id} store_item_id={this.state.item_id} thumbUrl={this.state.item_img_url} store_title={this.state.store_title} title={this.state.item_title} price={this.state.item_price} isHomeList={true} store_alias={''} isLink={false} type_contents={this.state.item_type_contents} price_USD={this.state.item_price_usd} currency_code={this.state.currency_code}></StoreContentsListItem>
        </div>

        {product_after_confirm_content_dom}

        {under_line_dom}

        {file_list_dom}
        {/* <div className={'file_upload_container'}>
          <FileUploader product_state={this.state.item_product_state} file_upload_target_type={Types.file_upload_target_type.product_file} state={this.state.item_file_upload_state} isUploader={false} store_order_id={this.state.store_order_id} isListEndBlurCover={false}></FileUploader>
        </div> */}

        <div className={'problem_button_container'}>
          <button className={'problem_button'} onClick={(e) => {this.onClickContact(e)}}>
            <u>콘텐츠에 문제가 있나요?</u>
          </button>
        </div>
  
        {ok_button_dom}
        {/* <button className={'ok_button'} onClick={(e) => {this.onClickOK(e)}}>
          {buttonText}
        </button> */}

        {review_talk_container_dom}

        {go_store_button_dom}

        {openProductTextView}
      </div>
    )
  }
};

export default StoreContentConfirm;