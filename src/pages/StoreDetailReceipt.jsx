'use strict';

import React, { Component } from 'react';

import StoreReceiptItem from '../component/StoreReceiptItem';
import Util from '../lib/Util';
import axios from '../lib/Axios';

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
      total_price: 0,

      refundButtonText: '',

      isRefund: false,
      refundPolicyText: '',

      is_owner: false
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

        store_item_id: data.item_id
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

    return(
      <div className={'StoreDetailReceipt'}>
        <div className={'page_title'}>
          주문 상세
        </div>
        <div className={'page_sub_title'}>
          주문내역
        </div>
        <div className={'container_box'}>
          {storeReceiptItemDom}
        </div>

        <div className={'container_box_label'}>
          결제정보
        </div>

        <div className={'container_box'}>
          <div className={'pay_info_container'}>
            <div className={'pay_info_label'}>
              {this.state.item_title}
            </div>
            <div className={'pay_info_value'}>
              {Util.getNumberWithCommas(this.state.item_price)}원
            </div>

            
          </div>

          <div className={'pay_info_under_line'}>
          </div>

          <div className={'pay_info_total_price'}>
            <div style={{display: "flex", justifyContent: 'space-between'}}>
              <div>
                총 결제 금액
              </div>
              <div>
                {Util.getNumberWithCommas(this.state.total_price)}원
              </div>
            </div>
          </div>
        </div>

        <button className={'refund_button'} onClick={(e) => {this.clickCancelOrder(e)}} disabled={isRefundDisable} style={{backgroundColor: refundBackgroundColor}}>
          {this.state.refundButtonText}
        </button>

        <div className={'policy_container'}>
          <div className={'policy_title'}>
            크티 취소/환불 규정
          </div>
          <div className={'policy_content'}>
            {this.state.refundPolicyText}
          </div>
        </div>

        <div className={'container_box_label'}>
          신청자 정보
        </div>
        <div className={'container_box'}>
          <div className={'input_label'} style={{marginTop: 0}}>이름</div>
          <input className={'input_box'} disabled={true} type="name" name={'name'} placeholder={'이름을 입력해주세요'} value={this.state.name} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_NAME)}}/>

          <div className={'input_label'}>전화번호</div>
          <input className={'input_box'} disabled={true} type="tel" name={'tel'} placeholder={'전화번호를 입력해주세요'} value={this.state.contact} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CONTACT)}}/>

          <div className={'input_label'}>이메일</div>
          <input className={'input_box'} disabled={true} type="email" name={'email'} placeholder={'이메일을 입력해주세요'} value={this.state.email} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_EMAIL)}}/>
          
        </div>

      </div>
    )
  }
};

export default StoreDetailReceipt;