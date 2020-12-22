'use strict';

import React, { Component } from 'react';


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
import Types from '../Types';


import ic_checkbox_btn_circle_s from '../res/img/ic-checkbox-btn-circle-s.svg';
import ic_checkbox_btn_circle_n from '../res/img/ic-checkbox-btn-circle-n.svg';


class StoreStateProcess extends Component{

  constructor(props){
    super(props);

    this.state = {
      processTextData: 
      [
        {
          key: Types.order.ORDER_STATE_APP_STORE_PAYMENT,
          text: '승인 대기'
        },
        {
          key: Types.order.ORDER_STATE_APP_STORE_READY,
          text: '콘텐츠 준비'
        },
        {
          key: Types.order.ORDER_STATE_APP_STORE_RELAY_CUSTOMER,
          text: '콘텐츠 전달'
        },
        {
          key: Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE,
          text: '콘텐츠 확인'
        },
      ],
      processData: 
      [
        {
          product_state: Types.product_state.TEXT,
          process: [
            Types.order.ORDER_STATE_APP_STORE_PAYMENT, 
            Types.order.ORDER_STATE_APP_STORE_READY, 
            Types.order.ORDER_STATE_APP_STORE_RELAY_CUSTOMER,
            Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE
          ]
        },

        {
          product_state: Types.product_state.FILE,
          process: [
            Types.order.ORDER_STATE_APP_STORE_PAYMENT, 
            Types.order.ORDER_STATE_APP_STORE_READY, 
            Types.order.ORDER_STATE_APP_STORE_RELAY_CUSTOMER,
            Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE
          ]
        },

        {
          product_state: Types.product_state.ONE_TO_ONE,
          process: [
            Types.order.ORDER_STATE_APP_STORE_PAYMENT, 
            Types.order.ORDER_STATE_APP_STORE_READY, 
            Types.order.ORDER_STATE_APP_STORE_RELAY_CUSTOMER,
            Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE
          ]
        }
      ]
    }
  };

  componentDidMount(){    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){
    const _processData = this.state.processData.find((value) => {return value.product_state === this.props.product_state});
    if(_processData === undefined){
      return (
        <></>
      )
    }

    let processItemArrayDom = [];
    let isLastState = false;
    for(let i = 0 ; i < _processData.process.length ; i++){
      let isCheck = true;
      if(isLastState){
        //마지막 상태값을 통과하면 체크는 false가 된다.
        isCheck = false;
      }
      const data = _processData.process[i];

      const textData = this.state.processTextData.find((value) => {return value.key === data});
      if(textData === undefined){
        alert("프로세스 텍스트 데이터가 없습니다." + data);
        break;
      }

      if(this.props.order_state === data){
        isLastState = true;
      }

      let imgSrc = ic_checkbox_btn_circle_s;
      let colorRGB = '#00a2d9';
      if(!isCheck){
        imgSrc = ic_checkbox_btn_circle_n;
        colorRGB = '#e3e3e3';
      }

      const dom = <div key={i} className={'process_item_container'}>
                    <img style={{backgroundColor: 'white'}} src={imgSrc}/>
                    <div className={'process_item_text'} style={{color: colorRGB}}>
                      {textData.text}
                    </div>
                  </div>

      processItemArrayDom.push(dom);
    }

    return(
      <div className={'StoreStateProcess'}>
        <div className={'process_container_wrapper'}>
          <div className={'dot_line'}>
          </div>
          <div className={'process_container'}>
            {processItemArrayDom}
          </div>
        </div>
      </div>
    )
  }
};

export default StoreStateProcess;