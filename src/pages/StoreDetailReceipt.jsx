'use strict';

import React, { Component } from 'react';

import StoreReceiptItem from '../component/StoreReceiptItem';
import Util from '../lib/Util';
import axios from '../lib/Axios';
import Types from '../Types';

import Str from '../component/Str';

class StoreDetailReceipt extends Component{

  constructor(props){
    super(props);

    this.state = {
      store_order_id: null,
      store_item_id: null,

      name: '',
      contact: '',
      email: '',

      item_title: '',

      item_price: 0,
      item_price_usd: 0,
      total_price: 0,
      total_price_usd: 0,
      currency_code: Types.currency_code.Won,

      ordet_state: Types.order.ORDER_STATE_STAY,

      refundButtonText: '',

      isRefund: false,
      refundPolicyText: '',

      is_owner: false,

      type_contents: Types.contents.customized
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

  requestOrderInfo(){
    axios.post('/orders/store/info', {
      store_order_id: this.state.store_order_id
    }, (result) => {
      const data = {
        ...result.data
      }

      this.setState({
        contact: data.contact, 
        email: data.email, 
        name: data.name,
        item_title: data.item_title,
        item_price: data.item_price,
        total_price: data.total_price,

        refundButtonText: data.refundButtonText,

        isRefund: data.isRefund,
        refundPolicyText: data.refundPolicyText,

        store_item_id: data.item_id,

        item_price_usd: data.price_USD,
        total_price_usd: data.total_price_USD,
        currency_code: data.currency_code,

        ordet_state: data.state,
        type_contents: data.type_contents
      }, () => {
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

  render(){
    if(!this.state.is_owner){
      return <>접근 불가능한 페이지 입니다.</>;
    }

    let storeReceiptItemDom = <></>;
    if(this.state.store_order_id){
      storeReceiptItemDom = <StoreReceiptItem store_order_id={this.state.store_order_id} isGoDetailButton={false}></StoreReceiptItem>
    }

    let isRefundDisable = true;
    let refundBackgroundColor = '#cccccc';
    if(this.state.isRefund){
      isRefundDisable = false; 
      refundBackgroundColor = '#ffffff';
    }

    let refundButtonText = null;
    if(this.state.ordet_state === Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE){
      // console.log(this.state.ordet_state);
      refundButtonText = <Str strKey={'s79'} />
    }else{
      refundButtonText = this.state.refundButtonText
    }

    let refundPolicyText = null;
    if(this.state.type_contents === Types.contents.completed){
      refundPolicyText = <Str strKey={'s70'} />
    }else{
      refundPolicyText = this.state.refundPolicyText;
    }

    return(
      <div className={'StoreDetailReceipt'}>
        <div className={'page_title'}>
          {/* 주문 상세 */}
          <Str strKey={'s92'} />
        </div>
        <div className={'page_sub_title'}>
          {/* 주문내역 */}
          <Str strKey={'s93'} />
        </div>
        <div className={'container_box'}>
          {storeReceiptItemDom}
        </div>

        <div className={'container_box_label'}>
          {/* 결제정보 */}
          <Str strKey={'s94'} />
        </div>

        <div className={'container_box'}>
          <div className={'pay_info_container'}>
            <div className={'pay_info_label'}>
              {this.state.item_title}
            </div>
            <div className={'pay_info_value'}>
              {Util.getPriceCurrency(this.state.item_price, this.state.item_price_usd, this.state.currency_code)}
            </div>

            
          </div>

          <div className={'pay_info_under_line'}>
          </div>

          <div className={'pay_info_total_price'}>
            <div style={{display: "flex", justifyContent: 'space-between'}}>
              <div>
                {/* 총 결제 금액 */}
                <Str strKey={'s95'} />
              </div>
              <div>
                {Util.getPriceCurrency(this.state.total_price, this.state.total_price_usd, this.state.currency_code)}
              </div>
            </div>
          </div>
        </div>

        <button className={'refund_button'} onClick={(e) => {this.clickCancelOrder(e)}} disabled={isRefundDisable} style={{backgroundColor: refundBackgroundColor}}>
          {/* {this.state.refundButtonText} */}
          {refundButtonText}
        </button>

        <div className={'policy_container'}>
          <div className={'policy_title'}>
            <Str strKey={'s96'} />
          </div>
          <div className={'policy_content'}>
            {/* {this.state.refundPolicyText} */}
            {refundPolicyText}
          </div>
        </div>

        <div className={'container_box_label'}>
          <Str strKey={'s55'} />
        </div>
        <div className={'container_box'}>
          <div className={'input_label'} style={{marginTop: 0}}><Str strKey={'s56'} /></div>
          <input className={'input_box'} disabled={true} type="name" name={'name'} placeholder={'이름을 입력해주세요'} value={this.state.name} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_NAME)}}/>

          <div className={'input_label'}><Str strKey={'s57'} /></div>
          <input className={'input_box'} disabled={true} type="tel" name={'tel'} placeholder={'전화번호를 입력해주세요'} value={this.state.contact} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CONTACT)}}/>

          <div className={'input_label'}><Str strKey={'s58'} /></div>
          <input className={'input_box'} disabled={true} type="email" name={'email'} placeholder={'이메일을 입력해주세요'} value={this.state.email} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_EMAIL)}}/>
          
        </div>

      </div>
    )
  }
};

export default StoreDetailReceipt;