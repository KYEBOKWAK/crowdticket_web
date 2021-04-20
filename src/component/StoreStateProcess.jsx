'use strict';

import React, { Component } from 'react';

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
        {
          key: Types.order.ORDER_STATE_APP_STORE_SUCCESS,
          text: '크티 전달'
        },
        {
          key: Types.order.ORDER_STATE_APP_STORE_PLAYING_DONE_CONTENTS,
          text: '진행완료'
        }
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
            Types.order.ORDER_STATE_APP_STORE_PLAYING_DONE_CONTENTS,
            // Types.order.ORDER_STATE_APP_STORE_RELAY_CUSTOMER,
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

    if(this.props.order_state > Types.order.ORDER_STATE_PAY_END){
      return (
        <></>
      )
    }

    // if(this.props.product_state === Types.product_state.ONE_TO_ONE){
    //   return (
    //     <></>
    //   )
    // }

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

      let text = textData.text;
      if(data === Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE){
        if(this.props.product_state === Types.product_state.ONE_TO_ONE){
          text = '확인완료';
        }
      }

      const dom = <div key={i} className={'process_item_container'}>
                    <img style={{backgroundColor: 'white'}} src={imgSrc}/>
                    <div className={'process_item_text'} style={{color: colorRGB}}>
                      {text}
                    </div>
                  </div>

      processItemArrayDom.push(dom);
    }

    let container_wrapper_className = 'process_container_wrapper';
    if(_processData.process.length >= 5){
      container_wrapper_className = 'process_container_wrapper_over_five';
    }

    return(
      <div className={'StoreStateProcess'}>
        <div className={container_wrapper_className}>
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