'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Util from '../lib/Util';

import StoreOrderItem from './StoreOrderItem';

import moment from 'moment';
import Types from '../Types';

import radio_button_img_n from '../res/img/radio-btn-n.svg';
import radio_button_img_s from '../res/img/radio-btn-s.svg';

import FileUploader from '../component/FileUploader';
// import moment_timezone from 'moment-timezone';
// moment_timezone.tz.setDefault("Asia/Seoul");
// const moment_timezone = require('moment-timezone');
// moment_timezone.tz.setDefault("Asia/Seoul");

const REFUND_STATE_NONE = "REFUND_STATE_NONE";
const REFUND_STATE_SELECT = "REFUND_STATE_SELECT";

const REFUND_ETC_KEY = 0;

const MAX_TEXT_LENGTH = 255;

class StoreReceiptItem extends Component{

  constructor(props){
    super(props);

    this.state = {
      item_title: '',
      item_price: 0,
      item_content: '',
      item_thumb_img_url: '',
      total_price: 0,
      store_id: null,
      item_nick_name: '',

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

      order_user_name: ''
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    // this.requestStoreContents();
    this.requestOrderInfo();
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){ 
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

        store_title: data.store_title
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
        order_user_name: data.name
      }, () => {
        this.requestItemInfo();
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
      _goDetailButtonDom = <button 
                            className={'detail_receipt_button'} 
                            onClick={(e) => {this.clikcDetailReceipt(e)}}
                            >
                            주문상세
                          </button>
    }

    let stateButtonDom = <></>;
    let stateRefundButtonLabel = <></>;
    let stateRefundButtonSubLabel = <></>;
    let stateRelayButtonDom = <></>;
    let order_id_dom = <></>;
    let state_container_marginTop = 0;

    let refundStateContainer = <></>;
    let orderNameDom = <></>;

    
    let refundExpDate = moment(this.state.created_at).add(7, 'd').format('YYYY.MM.DD');
    if(this.props.isManager){
      order_id_dom = <div style={{marginBottom: 5}}>주문번호 {this.props.store_order_id}</div>;

      orderNameDom = <div className={'order_user_name'}>
                      구매자 이름:<span style={{marginLeft:2}}>{this.state.order_user_name}</span>
                    </div>;

      state_container_marginTop = 8;
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
        stateRelayButtonDom = <button onClick={(e) => {this.clickRelay(e)}} className={'state_button_relay'}>
                                콘텐츠 전달하기
                              </button>
                              
      }
    }
    

    let refund_reason_dom = <></>;
    if(this.state.state === Types.order.ORDER_STATE_CANCEL_STORE_RETURN){
      refund_reason_dom = <div className={'order_refund_reason'}>
                            사유: {this.state.order_refund_reason}
                          </div>
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

        {stateRelayButtonDom}
        {stateRefundButtonLabel}
        {stateRefundButtonSubLabel}
        {refundStateContainer}

        {_goDetailButtonDom}        
      </div>
    )
  }
};

StoreReceiptItem.defaultProps = {
  // store_item_id: null
  isGoDetailButton: true,
  isManager: false
}

export default StoreReceiptItem;