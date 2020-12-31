'use strict';

import React, { Component } from 'react';

import StoreReceiptItem from '../component/StoreReceiptItem';
import axios from '../lib/Axios';

import Types from '../Types';
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



class StoreOrderComplitePage extends Component{

  constructor(props){
    super(props);

    this.state = {
      store_order_id: null,
      product_state: Types.product_state.FILE
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    const storeOrderIDDom = document.querySelector('#store_order_id');
    if(storeOrderIDDom){
      console.log(storeOrderIDDom.value);

      this.setState({
        store_order_id: Number(storeOrderIDDom.value)
      }, () => {
        this.requestStoreInfo();
      })
    }    
    // store_order_id
  };

  requestStoreInfo = () => {
    axios.post('/orders/store/info', {
      store_order_id: this.state.store_order_id
    }, (result) => {
      const data = {
        ...result.data
      }

      this.setState({
        product_state: data.product_state
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){

    let storeReceiptItemDom = <></>;
    if(this.state.store_order_id){
      storeReceiptItemDom = <StoreReceiptItem store_order_id={this.state.store_order_id}></StoreReceiptItem>
    }

    let askTitle = '🤔 콘텐츠는 언제, 어떻게 받나요?';
    let askContent = '크리에이터가 주문을 승인하고 콘텐츠를 준비하면 크티가 입력해주신 연락처로 완성된 콘텐츠를 전달해드립니다. 잠시만 기다려주세요!';
    if(this.state.product_state === Types.product_state.ONE_TO_ONE){
      askTitle = '🤔 1:1 실시간 콘텐츠는 언제 시작하나요?';
      askContent = '크리에이터가 확인 후 선택하신 시간대 안에서 최종 진행 시간을 결정하여 알려드립니다!';
    }

    return(
      <div className={"StoreOrderComplitePage"}>
        <div className={'label_title_text'}>
          주문 완료
        </div>
        <div className={"container_box"}>
          <div className={"how_ask_text"}>
            {askTitle}
          </div>
          <div className={"under_line"}>
          </div>
          <div className={"how_answer_text"}>
            {askContent}
          </div>
        </div>

        <div className={'receipt_label_text'}>
          주문내역
        </div>

        <div className={'container_box'}>
          {storeReceiptItemDom}
        </div>
      </div>
    )
  }
};


export default StoreOrderComplitePage;