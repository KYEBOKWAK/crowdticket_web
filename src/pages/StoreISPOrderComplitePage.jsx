'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';
import Types from '../Types';

class StoreISPOrderComplitePage extends Component{

  waitTimerInterval = null;

  constructor(props){
    super(props);

    this.state = {
      store_order_id: null,
      imp_uid: null,
      imp_success: false,
      merchant_uid: null,
      is_complite: false,

      timer_sec: 10,
      show_ok_button: false
    }
  };

  componentDidMount(){
    const imp_uid_dom = document.querySelector('#imp_uid');
    if(!imp_uid_dom){
      alert("잘못된 접근입니다");
      return;
    }

    const imp_success_dom = document.querySelector('#imp_success');
    if(!imp_success_dom){
      alert("잘못된 접근입니다");
      return;
    }

    const merchant_uid_dom = document.querySelector('#merchant_uid');
    if(!merchant_uid_dom){
      alert("잘못된 접근입니다");
      return;
    }

    const store_order_id_dom = document.querySelector('#store_order_id');
    if(!store_order_id_dom){
      alert("잘못된 접근입니다");
      return;
    }

    this.setState({
      imp_uid: imp_uid_dom.value,
      imp_success: imp_success_dom.value,
      merchant_uid: merchant_uid_dom.value,
      store_order_id: Number(store_order_id_dom.value),
      is_complite: false
    }, () => {
      if(this.state.imp_success === 'false'){
        this.requestISPError(this.state.imp_uid, this.state.merchant_uid, '');
        return;
      }

      this.ispOrderProcessStart();
    })
  };

  componentWillUnmount(){
    this.stopWaitTimer();
  };

  componentDidUpdate(){
  }

  startWaitTimer = () => {
    this.stopWaitTimer();
    
    this.waitTimerInterval = setInterval(() => {

      let waitTimer = this.state.timer_sec;
      waitTimer--;
      if(waitTimer < 0){
        this.stopWaitTimer();
        this.setState({
          show_ok_button: true,
          timer_sec: 0
        })
      }
      this.setState({
        timer_sec: waitTimer
      });
     }, 1000);
  }

  stopWaitTimer = () => {
    clearInterval(this.waitTimerInterval);
    this.waitTimerInterval = null;
  };

  ispOrderProcessStart = () => {
    axios.post("/orders/store/complite/check", {
      imp_uid: this.state.imp_uid,
      merchant_uid: this.state.merchant_uid,
      store_order_id: this.state.store_order_id,
    }, (result) => {
      if(result.is_complite){
        this.setState({
          is_complite: true
        }, () => {
          this.startWaitTimer();
          this.requestNextIspComplite();
        })
      }
    }, (error) => {

    })
  }

  requestNextIspComplite = () => {
    this.requestISPSuccess(this.state.imp_uid, this.state.merchant_uid, this.state.store_order_id);
  }

  onClickOrderComplite = (e) => {
    e.preventDefault();

    this.requestNextIspComplite();
  }

  goOrderComplite(order_id){
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      baseURL = baseURLDom.value;
    }

    let goURL = baseURL + '/complite/store/'+order_id;

    window.location.href = goURL;
  }

  requestISPSuccess = (imp_uid, merchant_uid, store_order_id) => {
    showLoadingPopup('결제 완료중..');
    axios.post("/pay/store/isp/success", {
      imp_uid: imp_uid,
      merchant_uid: merchant_uid,
      order_id: store_order_id,
      pay_method: Types.pay_method.PAY_METHOD_TYPE_CARD
    }, (result) => {

      axios.post("/pay/store/send/message", {
        store_order_id: store_order_id
      }, (result_message) => {
        stopLoadingPopup();
        this.goOrderComplite(result.order_id);
      }, (error_message) => {
        stopLoadingPopup();
        this.goOrderComplite(result.order_id);
      })

    }, (error) => {
      stopLoadingPopup();
      swal("결제 DB 에러", '결제 DB STATE 상태 변경 실패', 'error');
    })
  }

  requestISPError = (imp_uid, merchant_uid, error_msg) => {
    axios.post("/pay/store/isp/error", {
      imp_uid: imp_uid,
      merchant_uid: merchant_uid
    }, (result) => {
      swal("결제 실패", error_msg, 'error');
    }, (error) => {
      swal("결제 실패", error_msg, 'error');
    })
  }

  render(){
    if(!this.state.is_complite){
      return (
        <div className={'StoreISPOrderComplitePage'}>
        <div className={'content_container'}>
          <div>
            만료된 페이지 입니다.
          </div>
        </div>
      </div>
      )
    }

    let buttonDom = <></>;
    if(this.state.show_ok_button){
      buttonDom = <button className={'ok_button'} onClick={(e) => {this.onClickOrderComplite(e)}}>
                    확인
                  </button>
    }

    return(
      <div className={'StoreISPOrderComplitePage'}>
        <div className={'content_container'}>
          <div>
            결제 진행중입니다. 자동으로 다음 화면으로 넘어가지 않으면 확인 버튼을 눌러주세요.
          </div>
          <div>
            {this.state.timer_sec}
          </div>

          {buttonDom}
        </div>
      </div>
    )
  }
};

export default StoreISPOrderComplitePage;