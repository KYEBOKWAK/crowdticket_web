'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Util from '../lib/Util';

import StoreOrderItem from './StoreOrderItem';

import moment from 'moment';
import Types from '../Types';

import radio_button_img_n from '../res/img/radio-btn-n.svg';
import radio_button_img_s from '../res/img/radio-btn-s.svg';

import ic_down_arrow_img from '../res/img/ic-down-arrow.svg';
import ic_up_arrow_img from '../res/img/ic-up-arrow.svg';

import FileUploader from '../component/FileUploader';

import Popup_text_editor from '../component/Popup_text_editor';

import Popup_text_viewer from '../component/Popup_text_viewer';
// import moment_timezone from 'moment-timezone';
// moment_timezone.tz.setDefault("Asia/Seoul");
// const moment_timezone = require('moment-timezone');
// moment_timezone.tz.setDefault("Asia/Seoul");

const REFUND_STATE_NONE = "REFUND_STATE_NONE";
const REFUND_STATE_SELECT = "REFUND_STATE_SELECT";

const REFUND_ETC_KEY = 0;

const MAX_TEXT_LENGTH = 255;

class StoreReceiptItem extends Component{

  fileUploaderRef = React.createRef();

  constructor(props){
    super(props);

    this.state = {
      store_ready_state: Types.store_ready_state.default,
      thanks_text: '',
      popup_editor: false,

      item_title: '',
      item_price: 0,
      item_content: '',
      item_thumb_img_url: '',
      total_price: 0,
      store_id: null,
      item_nick_name: '',
      item_product_state: Types.product_state.TEXT,
      item_file_upload_state: Types.file_upload_state.NONE,

      store_item_id: null,
      store_title: '',
      state_string: '',
      state: 0,
      card_state_text: '',
      requestContent: '',
      created_at: '',

      refund_state: REFUND_STATE_NONE,

      refund_reason_value: '',
      refund_reason_select_key: null,
      refund_reasons: [
        {
          key: 1,
          value: '죄송해요, 지금은 너무 바빠서 요청을 들어드리기 어려워요'
        },
        {
          key: 2,
          value: '콘텐츠 전달에 필요한 요청사항을 안 적어주셨어요'
        },
        {
          key: 3,
          value: '요청소재가 논란이 될 수 있을 것 같아요'
        },
        {
          key: 4,
          value: '제 콘텐츠의 가치를 훼손시키는 요청이에요'
        },
        {
          key: 5,
          value: '요청이 너무 선정적 또는 폭력적이에요'
        },
        {
          key: 6,
          value: '중복 / 스팸성 / 악의성 요청이에요'
        },
        {
          key: REFUND_ETC_KEY,
          value: '기타사유'
        }
      ],

      order_refund_reason: '',
      order_user_id: null,

      order_user_name: '',
      order_user_real_name: '',
      order_user_profile_photo_url: '',

      product_title: null,
      product_text: null,

      files_customer_hide: false,
      files_product_hide: true,

      store_user_profile_photo_url: '',
      product_answer: null,

      comment_id: null,
      comment_contents: '',

      isOpenProductText: false
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    // this.requestStoreContents();
    this.requestOrderInfo();
    this.requestAnswerComment();
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){ 
  }

  requestOrderUserInfo = () => {
    if(this.state.order_user_id === null){
      return;
    }
    axios.post("/user/info/userid", {
      target_user_id: this.state.order_user_id
    }, (result) => {
      const userInfo = result.userInfo;

      const name = Util.getUserName(userInfo);
      this.setState({
        order_user_real_name: name,
        order_user_profile_photo_url: userInfo.profile_photo_url
      })
    }, (error) => {

    })
  }

  requestAnswerComment = () => {
    axios.post("/comments/second/get", {
      second_target_id: this.props.store_order_id,
      second_target_type: Types.comment.secondTargetType.store_order
    }, (result) => {
      this.setState({
        comment_id: result.comment_id,
        comment_contents: result.contents
      })
    }, (error) => {

    })
  }

  requestItemInfo(){
    axios.post('/store/any/item/info', {
      store_item_id: this.state.store_item_id
    }, (result) => {
      const data = result.data;
      this.setState({
        item_title: data.title,
        item_price: data.price,
        item_content: data.content,
        item_thumb_img_url: data.img_url,
        // total_price: data.price,
        store_id: data.store_id,
        item_nick_name: data.nick_name,

        store_title: data.store_title,

        item_product_state: data.product_state,
        item_file_upload_state: data.file_upload_state,

        store_user_profile_photo_url: data.profile_photo_url
      })
    }, (error) => {

    })
  }

  requestOrderInfo(){
    axios.post('/orders/store/info', {
      store_order_id: this.props.store_order_id
    }, (result) => {
      const data = {
        ...result.data
      }

      this.setState({
        total_price: data.total_price,
        state_string: data.state_string,
        store_item_id: data.item_id,
        state: data.state,
        card_state_text: data.card_state_text,
        requestContent: data.requestContent,
        created_at: data.created_at,
        order_refund_reason: data.refund_reason,
        order_user_id: data.order_user_id,
        order_user_name: data.name,

        product_answer: data.product_answer
      }, () => {
        this.requestItemInfo();
        this.requestProductText();
        this.requestOrderUserInfo();
      })
    }, (error) => {

    })
  }

  itemClick(e){
    /*
    e.preventDefault();
    
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    let goURL = baseURL + '/item/store/' + this.props.store_item_id;

    window.location.href = goURL;
    */
  }

  clikcDetailReceipt(e){
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    let goURL = baseURL + '/receipt/detail/store/' + this.props.store_order_id;

    window.location.href = goURL;
  }

  clickRefund(e){
    e.preventDefault();

    
    this.setState({
      refund_state: REFUND_STATE_SELECT
    })
    /*
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
    */
  }

  clickOk(e){
    e.preventDefault();

    
    swal("해당 주문을 승인하시겠습니까? (주문번호: "+this.props.store_order_id+" )", {
      buttons: {
        nosave: {
          text: "아니오",
          value: "notsave",
        },
        save: {
          text: "예",
          value: "ok",
        },
      },
    })
    .then((value) => {
      switch (value) {
        case "ok":
        {
          this.requsetStoreOrderOk();
        }
        break;
      }
    });
  }

  clickContentsUpload = (e) => {
    e.preventDefault();

    
    this.setState({
      store_ready_state: Types.store_ready_state.product_upload
    })
  }

  clickRelay(e){
    e.preventDefault();

    swal("해당 상품을 크티에 전달하셨습니까? (주문번호: "+this.props.store_order_id+" )", {
      buttons: {
        nosave: {
          text: "아니오",
          value: "notsave",
        },
        save: {
          text: "예",
          value: "ok",
        },
      },
    })
    .then((value) => {
      switch (value) {
        case "ok":
        {
          this.requsetStoreRelayCT();
        }
        break;
      }
    });
  }

  clickRelayCustomer = (e) => {
    e.preventDefault();

    swal("해당 상품을 고객에게 전달하셨습니까? (주문번호: "+this.props.store_order_id+" )", {
      buttons: {
        nosave: {
          text: "아니오",
          value: "notsave",
        },
        save: {
          text: "예",
          value: "ok",
        },
      },
    })
    .then((value) => {
      switch (value) {
        case "ok":
        {
          this.requestSendCustomer();
        }
        break;
      }
    });
  }

  requestSendCustomer = (e) => {
    if(this.state.item_product_state !== Types.product_state.ONE_TO_ONE){
      this.fileUploaderRef.uploadFiles(this.state.order_user_id, Types.file_upload_target_type.product_file, 
        (result_upload_files) => {
          let filesInsertID = [];
          for(let i = 0 ; i < result_upload_files.list.length ; i++){
            const data = result_upload_files.list[i];
            let _data = {
              file_id: data.insertId
            }
            
            filesInsertID.push(_data);
          }
    
          if(filesInsertID.length === 0){
            this.requestStoreRelayCustomer();
          }else{
            axios.post("/store/file/set/orderid", {
              store_order_id: this.props.store_order_id,
              filesInsertID: filesInsertID.concat()
            }, (result_files) => {
              this.requestStoreRelayCustomer();
            }, (error_files) => {
              alert("파일 ORDER ID 셋팅 에러");
              return;
            })
          }
    
        }, (error_upload_files) => {
          alert('파일 업로드 실패. 새로고침 후 다시 시도해주세요.');
          return;
        });
    }else{
      this.requestStoreRelayCustomer();
    }

    // this.fileUploaderRef.uploadFiles(this.state.order_user_id, Types.file_upload_target_type.product_file, 
    // (result_upload_files) => {
    //   let filesInsertID = [];
    //   for(let i = 0 ; i < result_upload_files.list.length ; i++){
    //     const data = result_upload_files.list[i];
    //     let _data = {
    //       file_id: data.insertId
    //     }
        
    //     filesInsertID.push(_data);
    //   }

    //   if(filesInsertID.length === 0){
    //     this.requestStoreRelayCustomer();
    //   }else{
    //     axios.post("/store/file/set/orderid", {
    //       store_order_id: this.props.store_order_id,
    //       filesInsertID: filesInsertID.concat()
    //     }, (result_files) => {
    //       this.requestStoreRelayCustomer();
    //     }, (error_files) => {
    //       alert("파일 ORDER ID 셋팅 에러");
    //       return;
    //     })
    //   }

    // }, (error_upload_files) => {
    //   alert('파일 업로드 실패. 새로고침 후 다시 시도해주세요.');
    //   return;
    // });
  }

  requsetStoreOrderOk(){
    showLoadingPopup('변경중입니다..');

    axios.post("/orders/store/state/ok", {
      store_order_id: this.props.store_order_id
    }, (result) => {
      stopLoadingPopup();
      this.setState({
        state: result.data.state
      }, () => {
        this.requestOrderInfo();
      })
    }, (error) => {
      stopLoadingPopup();
    })
  }

  requsetStoreRelayCT(){
    showLoadingPopup('변경중입니다..');

    axios.post("/orders/store/state/relay/ct", {
      store_order_id: this.props.store_order_id
    }, (result) => {
      stopLoadingPopup();
      this.setState({
        state: result.data.state
      }, () => {
        this.requestOrderInfo();
      })
    }, (error) => {
      stopLoadingPopup();
    })
  }

  requestStoreRelayCustomer = () => {
    showLoadingPopup('변경중입니다..');

    axios.post("/orders/store/state/relay/customer", {
      store_order_id: this.props.store_order_id,
      product_answer: this.state.thanks_text
    }, (result) => {
      stopLoadingPopup();
      this.setState({
        state: result.data.state
      }, () => {
        this.requestOrderInfo();
      })
    }, (error) => {
      stopLoadingPopup();
    })
  }

  clickReason(e, key){
    e.preventDefault();

    this.setState({
      refund_reason_select_key: key,
      refund_reason_value: ''
    })
  }

  onChangeTextArea(e){
    e.preventDefault();

    this.setState({
      refund_reason_value: e.target.value
    })
  }

  clickRefundButton(e){
    e.preventDefault();

    let refund_value = '';
    const refund_data_value = this.state.refund_reasons.find((value) => {
                                if(value.key === this.state.refund_reason_select_key){
                                  return value.value
                                }
                              })

    if(this.state.refund_reason_select_key === REFUND_ETC_KEY){
      refund_value = this.state.refund_reason_value;
      if(refund_value === ''){
        alert("기타 사유를 입력해주세요");
        return;
      }
    }else{
      refund_value = refund_data_value.value;
    }


    swal("반려하시겠습니까? (주문번호: "+this.props.store_order_id+" ) / (내용: "+refund_value+")", {
      buttons: {
        nosave: {
          text: "아니오",
          value: "notsave",
        },
        save: {
          text: "예",
          value: "refund",
        },
      },
    })
    .then((value) => {
      switch (value) {
        case "refund":
        {
          this.requestRefund(refund_value);
          // console.log(refund_value);
          
        }
        break;
      }
    });
  }

  compliteRefund(state){
    stopLoadingPopup();

    this.setState({
      state: state
    }, () => {
      this.requestOrderInfo();
    })
  }

  requestRefund(refund_reason){
    showLoadingPopup('반려중입니다..');
    axios.post("/orders/store/cancel", {
      store_order_id: this.props.store_order_id,
      order_user_id: this.state.order_user_id
    }, (result) => {
      axios.post("/orders/store/state/refund", {
        store_order_id: this.props.store_order_id,
        refund_reason: refund_reason
      }, (result) => {

        axios.post("/store/item/order/quantity", {
          item_id: this.state.store_item_id
        }, (result_quantity) => {
          this.compliteRefund(result.data.state);
        }, (error_quantity) => {
          this.compliteRefund(result.data.state);
        })

        
      }, (error) => {
        stopLoadingPopup();  
      })
    }, (error) => {
      stopLoadingPopup();
    })
  }

  onChangeInput = (e) => {
    e.preventDefault();

    this.setState({
      thanks_text: e.target.value
    })
  }

  onClickEditPopup = (e) => {
    e.preventDefault();

    this.setState({
      popup_editor: true
    })
  }

  onClickCustomerArrow = (e) => {
    e.preventDefault();

    let files_customer_hide = false;
    if(this.state.files_customer_hide){
      files_customer_hide = false;
    }else{
      files_customer_hide = true;
    }

    this.setState({
      files_customer_hide: files_customer_hide
    })
  }

  onClickProductArrow = (e) => {
    e.preventDefault();

    let files_product_hide = false;
    if(this.state.files_product_hide){
      files_product_hide = false;
    }else{
      files_product_hide = true;
    }

    this.setState({
      files_product_hide: files_product_hide
    })
  }

  requestProductText = () => {
    axios.post('/store/product/text/get', {
      store_order_id: this.props.store_order_id
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

  clickContentsOk = (e) => {
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    let goURL = baseURL + '/store/content/' + this.props.store_order_id;

    window.location.href = goURL;

  }

  clickProductText = (e) => {
    e.preventDefault();

    this.setState({
      isOpenProductText: true
    })
  }

  render(){
    let _storeOrderItemDom = <></>;
    if(this.state.store_item_id){
      _storeOrderItemDom = <StoreOrderItem 
                              id={this.state.store_item_id} 
                              store_item_id={this.state.store_item_id}
                              thumbUrl={this.state.item_thumb_img_url}
                              name={this.state.item_nick_name}
                              title={this.state.item_title}
                              price={this.state.item_price}
                              store_title={this.state.store_title}
                            ></StoreOrderItem>
    }

    let _goDetailButtonDom = <></>;
    if(this.props.isGoDetailButton){

      if(this.state.state === Types.order.ORDER_STATE_APP_STORE_RELAY_CUSTOMER ||
        this.state.state === Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE){
        _goDetailButtonDom = <div className={'receipt_button_container'}>
                                <button onClick={(e) => {this.clickContentsOk(e)}} className={'receipt_contents_ok_button'}>
                                  콘텐츠 확인하기
                                </button>
                                <button 
                                  className={'detail_receipt_button'} 
                                  onClick={(e) => {this.clikcDetailReceipt(e)}}
                                  >
                                  주문상세
                                </button>
                              </div>
      }else{
        _goDetailButtonDom = <div className={'receipt_button_container'}>
                                <button 
                                  className={'detail_receipt_button'} 
                                  onClick={(e) => {this.clikcDetailReceipt(e)}}
                                  >
                                  주문상세
                                </button>
                              </div>
      }
      
    }

    let stateButtonDom = <></>;
    let stateRefundButtonLabel = <></>;
    let stateRefundButtonSubLabel = <></>;
    let bottomLongButtonDom = <></>;
    let order_id_dom = <></>;
    let state_container_marginTop = 0;

    let refundStateContainer = <></>;
    let orderNameDom = <></>;

    let store_ready_state_dom = <></>;

    let store_editor_popup_dom = <></>;
    
    let refundExpDate = moment(this.state.created_at).add(7, 'd').format('YYYY.MM.DD');
    if(this.props.isManager){
      order_id_dom = <div style={{marginBottom: 5}}>주문번호 {this.props.store_order_id}</div>;

      orderNameDom = <div className={'order_user_name'}>
                      구매자 이름:<span style={{marginLeft:2}}>{this.state.order_user_name}</span>
                    </div>;

      // state_container_marginTop = 8;
      if(this.state.state === Types.order.ORDER_STATE_APP_STORE_PAYMENT){
        if(this.state.refund_state === REFUND_STATE_NONE){
          stateButtonDom = <div className={'state_button_container'}>
                            <button onClick={(e) => {this.clickRefund(e)}} className={'state_button_refund'}>
                              반려하기
                            </button>
                            <button onClick={(e) => {this.clickOk(e)}} className={'state_button_ok'}>
                              승인하기
                            </button>
                          </div>

          stateRefundButtonLabel = <div className={'state_button_refund_label_container'}>
                                    <span className={'state_button_refund_label_point_color'}>
                                      {refundExpDate}
                                    </span>
                                    <span style={{marginLeft: 2}}>까지</span>
                                    <span className={'state_button_refund_label_point_color'} style={{marginLeft: 2}}>승인/반려</span>
                                    <span style={{marginLeft: 2}}>를 결정해주세요</span>
                                  </div>

          stateRefundButtonSubLabel = <div className={'stateRefundButtonSubLabel'}>
                                        승인기간 경과시 승인만료 처리 됩니다.
                                      </div>
        }else{
          
          //반려 리스트 만들기
          let _reason_list = [];
          for(let i = 0 ; i < this.state.refund_reasons.length ; i++){
            const data = this.state.refund_reasons[i];
            let selectButtonImg = <></>;
            if(data.key === this.state.refund_reason_select_key){
              selectButtonImg = <img src={radio_button_img_s} />
            }else{
              selectButtonImg = <img src={radio_button_img_n} />
            }
            let reason_item_dom = <button key={data.key} onClick={(e) => {this.clickReason(e, data.key)}} className={'radio_list_item_container'}>
                                    {selectButtonImg}
                                    <div className={'radio_list_item_value'}>
                                      {data.value}
                                    </div>
                                  </button>

            _reason_list.push(reason_item_dom);
          }

          let _reasonEtcDom = <></>;
          if(this.state.refund_reason_select_key === REFUND_ETC_KEY){
            _reasonEtcDom = <div>
                              기타사유
                              <textarea className={'refund_etc_textarea'} value={this.state.refund_reason_value} onChange={(e) => {this.onChangeTextArea(e)}} maxLength={MAX_TEXT_LENGTH} placeholder={"기타 사유 입력"}></textarea>
                              <div className={'refund_etc_length'}>
                                {this.state.refund_reason_value.length}/{MAX_TEXT_LENGTH}
                              </div>
                            </div>;
          }

          refundStateContainer = <div className={'radio_list_container'}>
                                  {_reason_list}
                                  {_reasonEtcDom}

                                  <button onClick={(e) => {this.clickRefundButton(e)}} className={'refund_button'}>
                                    콘텐츠 반려하기
                                  </button>
                                </div>
        }
        
      }
      else if(this.state.state === Types.order.ORDER_STATE_APP_STORE_READY){

        if(this.state.item_product_state === Types.product_state.ONE_TO_ONE){
          bottomLongButtonDom = <button onClick={(e) => {this.clickRelay(e)}} className={'state_button_relay'}>
                                  콘텐츠 전달하기
                                </button>
        }else{
          if(this.state.store_ready_state === Types.store_ready_state.default){
            bottomLongButtonDom = <button onClick={(e) => {this.clickContentsUpload(e)}} className={'state_button_relay'}>
                                    콘텐츠 올리기
                                  </button>
          }else if(this.state.store_ready_state === Types.store_ready_state.product_upload){
  
            let product_content_dom = <></>;
            let product_content_container_dom = <></>;
            if(this.state.product_text) {
              product_content_dom = <div className={'product_container'}>
                                      <div className={'product_title_text'}>
                                        {this.state.product_title}
                                      </div>
                                      <div className={'product_text_text'}>
                                        {this.state.product_text}
                                      </div>
                                    </div>
            }else{
              product_content_dom = <div className={'product_container'}>
                                      <u style={{fontSize: 15}}>콘텐츠 작성하기</u>
                                    </div>
            }

            if(this.state.item_product_state === Types.product_state.TEXT){
              product_content_container_dom = <button className={'product_button'} onClick={(e) => {this.onClickEditPopup(e)}}>
                                                {product_content_dom}
                                              </button>
            }
  
            bottomLongButtonDom = <button onClick={(e) => {this.clickRelayCustomer(e)}} className={'state_button_relay'}>
                                    콘텐츠 전달하기
                                  </button>
  
            let fileUploadDom = <></>;
            
            fileUploadDom = <FileUploader ref={(ref) => {this.fileUploaderRef = ref;}} file_upload_target_type={Types.file_upload_target_type.product_file} state={Types.file_upload_state.FILES} isUploader={true} store_order_id={this.props.store_order_id}></FileUploader>;
            

            store_ready_state_dom = <div className={'product_upload_container'}>
                                      <div className={'under_line'}>
                                      </div>
                                      {product_content_container_dom}
                                      {/* <button className={'product_button'} onClick={(e) => {this.onClickEditPopup(e)}}>
                                        {product_content_dom}
                                      </button> */}
                                      <div className={'under_line'}>
                                      </div>
                                      {fileUploadDom}
                                      {/* <FileUploader ref={(ref) => {this.fileUploaderRef = ref;}} file_upload_target_type={Types.file_upload_target_type.product_file} state={Types.file_upload_state.FILES} isUploader={true} store_order_id={this.props.store_order_id}></FileUploader> */}
  
                                      <textarea className={'thank_text_area'} value={this.state.thanks_text} onChange={(e) => {this.onChangeInput(e)}} placeholder={"구매자를 위한 감사인사를 간단하게 적어주세요!\n예: 구매해 주셔서 감사합니다."}></textarea>
                                    </div>                                  
          }
        }
        //콘텐츠 제작중
        // bottomLongButtonDom = <button onClick={(e) => {this.clickRelay(e)}} className={'state_button_relay'}>
        //                         콘텐츠 전달하기
        //                       </button>

        /*
        if(this.state.store_ready_state === Types.store_ready_state.default){
          bottomLongButtonDom = <button onClick={(e) => {this.clickContentsUpload(e)}} className={'state_button_relay'}>
                                  콘텐츠 올리기
                                </button>
        }else if(this.state.store_ready_state === Types.store_ready_state.product_upload){

          let product_content_dom = <></>;
          if(this.state.product_text) {
            product_content_dom = <div className={'product_container'}>
                                    <div className={'product_title_text'}>
                                      {this.state.product_title}
                                    </div>
                                    <div className={'product_text_text'}>
                                      {this.state.product_text}
                                    </div>
                                  </div>
          }else{
            product_content_dom = <div className={'product_container'}>
                                    텍스트 콘텐츠 작성하기
                                  </div>
          }

          bottomLongButtonDom = <button onClick={(e) => {this.clickRelay(e)}} className={'state_button_relay'}>
                                  콘텐츠 전달하기
                                </button>

          store_ready_state_dom = <div className={'product_upload_container'}>
                                    <div className={'under_line'}>
                                    </div>
                                    <button className={'product_button'} onClick={(e) => {this.onClickEditPopup(e)}}>
                                      {product_content_dom}
                                    </button>
                                    <div className={'under_line'}>
                                    </div>
                                    <FileUploader state={Types.file_upload_state.FILES} isUploader={true} store_order_id={this.props.store_order_id}></FileUploader>

                                    <textarea className={'thank_text_area'} value={this.state.thanks_text} onChange={(e) => {this.onChangeInput(e)}} placeholder={"구매자를 위한 감사인사를 간단하게 적어주세요!\n예: 구매해 주셔서 감사합니다."}></textarea>
                                  </div>                                  
        }
        */
      }
    }
    

    let refund_reason_dom = <></>;
    if(this.state.state === Types.order.ORDER_STATE_CANCEL_STORE_RETURN){
      refund_reason_dom = <div className={'order_refund_reason'}>
                            사유: {this.state.order_refund_reason}
                          </div>
    }

    if(this.state.popup_editor){
      store_editor_popup_dom = <Popup_text_editor store_order_id={this.props.store_order_id} closeCallback={() => {
        this.setState({
          popup_editor: false
        }, () => {
          this.requestProductText();
        })
      }}></Popup_text_editor>;
    }

    //파일

    let customer_files_dom = <></>;
    let product_files_dom = <></>;

    let store_manager_answer = <></>;
    if(this.state.item_file_upload_state !== Types.file_upload_state.NONE){

      let arrowImg = ic_up_arrow_img;
      let filesListDom = <></>;
      if(this.state.files_customer_hide){
        arrowImg = ic_down_arrow_img;
      }else{
        filesListDom = <div className={'files_container'}>
                         <FileUploader state={Types.file_upload_state.FILES} isUploader={false} store_order_id={this.props.store_order_id}></FileUploader>
                        </div>
      }
      

      customer_files_dom = <div className={'files_container_wrapper'}>
                            <button onClick={(e) => {this.onClickCustomerArrow(e)}} className={'file_label_button'}>
                              요청한 파일
                              <img className={'file_label_arrow_img'} src={arrowImg} />
                            </button>

                            {filesListDom}
                          </div>
    }

    if(this.props.isManager){
      if(this.state.state >= Types.order.ORDER_STATE_APP_STORE_RELAY_CUSTOMER && this.state.item_product_state !== Types.product_state.ONE_TO_ONE){
      
        let arrowImg = ic_up_arrow_img;
        let filesListDom = <></>;
        if(this.state.files_product_hide){
          arrowImg = ic_down_arrow_img;
        }else{
          filesListDom = <div className={'files_container'}>
                            <FileUploader file_upload_target_type={Types.file_upload_target_type.product_file} state={Types.file_upload_state.FILES} isUploader={false} store_order_id={this.props.store_order_id}></FileUploader>
                          </div>
        }
  
        product_files_dom = <div className={'files_container_wrapper'}>
                              <button onClick={(e) => {this.onClickProductArrow(e)}} className={'file_label_button'}>
                                완성된 콘텐츠 상품
                                <img className={'file_label_arrow_img'} src={arrowImg} />
                              </button>
  
                              {filesListDom}
                            </div>
  
        
      }
    }
    

    let product_answer_dom = <></>;
    let review_dom = <></>;
    let product_after_confirm_content_dom = <></>;

    let openProductTextView = <></>;
    if(this.props.isManager){
      if(this.state.state >= Types.order.ORDER_STATE_APP_STORE_RELAY_CUSTOMER){
        // store_manager_answer
        if(this.state.product_answer !== null && this.state.product_answer !== ''){
          //크리에이터 구매 답변
          product_answer_dom =  <div className={'product_answer_wrapper'}>
                                  <div className={'under_line'}>
                                  </div>
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

        if(this.state.comment_contents !== ''){
          review_dom = <div className={'product_answer_wrapper'}>
                        <div className={'product_answer_container review_container'}>
                          <div className={'product_answer_content_container review_answer_content_container'}>
                            <div className={'product_answer_name review_answer_name'}>
                              {this.state.order_user_real_name}
                            </div>
                            <div className={'product_answer_content'}>
                            {this.state.comment_contents}
                            </div>
                          </div>
                          <img className={'product_answer_img'} src={this.state.order_user_profile_photo_url} />
                        </div>
                      </div>
        }

        
        if(this.state.product_text) {
          product_after_confirm_content_dom = <button onClick={(e) => {this.clickProductText(e)}} style={{paddingBottom: 0}} className={'product_container'}>
                                                <div className={'product_title_text'}>
                                                  {this.state.product_title}
                                                </div>
                                                <div className={'product_text_text'}>
                                                  {this.state.product_text}
                                                </div>
                                              </button>
        }
      }
    }

    if(this.state.isOpenProductText){
      openProductTextView = <Popup_text_viewer store_order_id={this.props.store_order_id} closeCallback={() => {
        this.setState({
          isOpenProductText: false
        })
      }}></Popup_text_viewer>
    }
    

    return(
      <div className={'StoreReceiptItem'}>
        {order_id_dom}
        {_storeOrderItemDom}

        {orderNameDom}
        <div className={'request_content'}>
          {this.state.requestContent}
        </div>

        <div className={'under_line'}>
        </div>

        <div className={'state_container'} style={{marginTop: state_container_marginTop}}>
          <div className={'state_text'}>
            {this.state.state_string}
          </div>
        </div>

        <div className={'pay_state_text_container'}>
          <div>
            {Util.getNumberWithCommas(this.state.total_price)}원 {this.state.card_state_text}
          </div>
          <div>
            {moment(this.state.created_at).format('YYYY-MM-DD HH:mm') }
          </div>
        </div>

        <div className={'under_line'}>
        </div>
        
        {product_after_confirm_content_dom}
        {customer_files_dom}
        {product_files_dom}
        
        {product_answer_dom}
        {review_dom}

        {stateButtonDom}

        {refund_reason_dom}

        {store_ready_state_dom}

        {bottomLongButtonDom}
        {stateRefundButtonLabel}
        {stateRefundButtonSubLabel}
        {refundStateContainer}

        {_goDetailButtonDom}

        {store_editor_popup_dom}

        {openProductTextView}
      </div>
    )

    /*
    return(
      <div className={'StoreReceiptItem'}>
        {order_id_dom}
        {_storeOrderItemDom}

        {orderNameDom}
        <div className={'request_content'}>
          {this.state.requestContent}
        </div>

        <div className={'under_line'}>
        </div>

        <FileUploader state={Types.file_upload_state.FILES} isUploader={false} store_order_id={this.props.store_order_id}></FileUploader>

        <div className={'pay_state_text_container'}>
          <div>
            {Util.getNumberWithCommas(this.state.total_price)}원 {this.state.card_state_text}
          </div>
          <div>
            {moment(this.state.created_at).format('YYYY-MM-DD HH:mm') }
          </div>
        </div>

        <div className={'state_container'} style={{marginTop: state_container_marginTop}}>
          <div className={'state_text'}>
            {this.state.state_string}
          </div>
          {stateButtonDom}
        </div>

        {refund_reason_dom}

        {bottomLongButtonDom}
        {stateRefundButtonLabel}
        {stateRefundButtonSubLabel}
        {refundStateContainer}

        {_goDetailButtonDom}        
      </div>
    )
    */
  }
};

StoreReceiptItem.defaultProps = {
  // store_item_id: null
  isGoDetailButton: true,
  isManager: false
}

export default StoreReceiptItem;