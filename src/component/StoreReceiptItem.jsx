'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Util from '../lib/Util';

import StoreOrderItem from './StoreOrderItem';

import moment from 'moment';
// import moment_timezone from 'moment-timezone';
// moment_timezone.tz.setDefault("Asia/Seoul");
// const moment_timezone = require('moment-timezone');
// moment_timezone.tz.setDefault("Asia/Seoul");


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
      state_string: '',
      state: 0,
      card_state_text: '',
      requestContent: '',
      created_at: ''
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
        item_nick_name: data.nick_name
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
        created_at: data.created_at
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
    return(
      <div className={'StoreReceiptItem'}>
        {_storeOrderItemDom}
        <div className={'request_content'}>
          {this.state.requestContent}
        </div>

        <div className={'under_line'}>
        </div>
        <div className={'pay_state_text_container'}>
          <div>
            {Util.getNumberWithCommas(this.state.total_price)}원 {this.state.card_state_text}
          </div>
          <div>
            {moment(this.state.created_at).format('YYYY-MM-DD HH:mm') }
          </div>

        </div>
        <div className={'state_text'}>
          {this.state.state_string}
        </div>

        {_goDetailButtonDom}        
      </div>
    )
  }
};

// props 로 넣어줄 스토어 상태값
// const mapStateToProps = (state) => {
//   // console.log(state);
//   return {
//     // pageViewKeys: state.page.pageViewKeys.concat()
//   }
// };

// const mapDispatchToProps = (dispatch) => {
//   return {
//     // handleAddPageViewKey: (pageKey: string, data: any) => {
//     //   dispatch(actions.addPageViewKey(pageKey, data));
//     // },
//     // handleAddToastMessage: (toastType:number, message: string, data: any) => {
//     //   dispatch(actions.addToastMessage(toastType, message, data));
//     // }
//   }
// };

StoreReceiptItem.defaultProps = {
  // store_item_id: null
  isGoDetailButton: true
}


// export default connect(mapStateToProps, mapDispatchToProps)(Templite);
export default StoreReceiptItem;