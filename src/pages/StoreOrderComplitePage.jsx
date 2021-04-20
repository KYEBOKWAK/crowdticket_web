'use strict';

import React, { Component } from 'react';

import StoreReceiptItem from '../component/StoreReceiptItem';
import axios from '../lib/Axios';

import Types from '../Types';

class StoreOrderComplitePage extends Component{

  constructor(props){
    super(props);

    this.state = {
      store_order_id: null,
      product_state: Types.product_state.FILE,
      item_type_contents: Types.contents.customized
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
        product_state: data.product_state,
        item_type_contents: data.type_contents
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
    let askContent = '크리에이터가 주문을 승인하고 콘텐츠를 업로드하면 크티에서 바로 확인하실 수 있도록 알림을 보내드릴거에요. 잠시만 기다려주세요!';
    if(this.state.product_state === Types.product_state.ONE_TO_ONE){
      askTitle = '🤔 1:1 실시간 콘텐츠는 언제 시작하나요?';
      askContent = '크리에이터가 요청을 승인한 후 주문 시 입력한 이메일 또는 전화번호로 연락을 드립니다. 연락처는 요청 승인 이후에만 전달되었다가 콘텐츠 진행 이후에는 삭제됩니다.';
    }

    if(this.state.item_type_contents === Types.contents.completed){
      askTitle = `🤔 콘텐츠는 어떻게 받나요?`;
      askContent = `아래 주문내역의 ‘콘텐츠 다운로드’ 버튼을 눌러주세요!\n지금 바로 구매하신 콘텐츠를 다운로드 받고 확인할 수 있습니다.\n※ 구매한 콘텐츠들은 ‘나의 콘텐츠 주문’에서도 모두 보실 수 있습니다.`
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