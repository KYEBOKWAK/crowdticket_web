'use strict';

import React, { Component } from 'react';

import Util from '../lib/Util';
import axios from '../lib/Axios';
import InfiniteScroll from 'react-infinite-scroll-component';

import moment_timezone from 'moment-timezone';
import Types from '../Types';

import imgIconBox from '../res/img/icon-box.svg';

import TableComponent from '../component/TableComponent';

const REQUEST_ONCE_ITME = 5;
let isRequestInitData = false;
class StoreManagerTabOrderListPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      total_buy_count: 0,
      cancel_refund_total_count: 0,
      ready_total_count: 0,
      ready_success_total_count: 0,

      total_price: 0,

      items: [],
      hasMore: true,

      sort_state: 0,
      sort_item_id: -1,

      sort_title_option: [],
      doller_count: 0
    }

    this.onChangeSelect = this.onChangeSelect.bind(this);
    this.onChangeContent = this.onChangeContent.bind(this);
  };

  componentDidMount(){
    this.requestMoreData();

    this.requestTotalBuyCount();
    this.requestCancelRefundTotalCount();
    this.requestReadyTotalCount();
    this.requestReadySuccessTotalCount();

    this.requestOrderTotalPrice();

    this.requestItemListTitle();

    //임시로 달러 구매가 있는지만 확인한다.
    this.requestDollerOrderCount();
  };

  requestDollerOrderCount = () => {
    axios.post("/store/order/doller/count", {
      store_id: this.props.store_id
    }, (result) => {
      this.setState({
        doller_count: result.doller_count
      })
    }, (error) => {

    })
  }

  requestTotalBuyCount(){
    axios.post("/store/order/all/count", {
      store_id: this.props.store_id
    }, (result) => {
      
      this.setState({
        total_buy_count: result.total_buy_count
      })
    }, (error) => {

    })
  }

  requestCancelRefundTotalCount(){
    
    axios.post("/store/order/cancelrefund/count", {
      store_id: this.props.store_id
    }, (result) => {
      
      this.setState({
        cancel_refund_total_count: result.cancel_refund_total_count
      })
    }, (error) => {

    })
  }

  requestReadyTotalCount(){
    axios.post("/store/order/saling/count", {
      store_id: this.props.store_id
    }, (result) => {
      this.setState({
        ready_total_count: result.ready_total_count
      })
    }, (error) => {

    })

    /*
    axios.post("/store/order/ready/count", {
      store_id: this.props.store_id
    }, (result) => {
      this.setState({
        ready_total_count: result.ready_total_count
      })
    }, (error) => {

    })
    */
  }

  requestReadySuccessTotalCount(){
    // 
    axios.post("/store/order/readysuccess/count", {
      store_id: this.props.store_id
    }, (result) => {
      this.setState({
        ready_success_total_count: result.ready_success_total_count
      })
    }, (error) => {

    })

    // axios.post("/store/order/comfirm/count", {
    //   store_id: this.props.store_id
    // }, (result) => {
    //   this.setState({
    //     ready_success_total_count: result.ready_success_total_count
    //   })
    // }, (error) => {

    // })
  }

  requestOrderTotalPrice(){
    axios.post("/store/order/total/price", {
      store_id: this.props.store_id
    }, (result) => {
      this.setState({
        total_price: result.total_price
      })
    }, (error) => {

    })
  }

  requestItemListTitle(){
    axios.post("/store/item/list/sort", {
      store_id: this.props.store_id
    }, (result) => {
      let _options = [];
      _options.push(<option key={-1} value={-1}>{'모두보기'}</option>)
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        const optionDom = <option key={data.id} value={data.id}>{data.title}</option>;
        _options.push(optionDom);
      }

      this.setState({
        sort_title_option: _options.concat()
      })
    }, (error) => {

    })
  }

  

  requestMoreData = () => {
    if(this.state.items.length === 0 && this.isRequestInitData){
      return;
    }

    if(this.state.items.length === 0){
      this.isRequestInitData = true;
    }

    axios.post('/store/manager/order/list', {
      store_id: this.props.store_id,
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items.length,

      sort_state: this.state.sort_state,
      sort_item_id: this.state.sort_item_id
      // lastID: 
    }, 
    (result) => {
      
      let itemsData = result.list.concat();
      let _items = this.state.items.concat();
      
      let hasMore = true;
      if(REQUEST_ONCE_ITME > itemsData.length ){
        hasMore = false;
      }

      for(let i = 0 ; i < itemsData.length ; i++){
        const data = itemsData[i];

        let confirm_at = "진행 중";
        if(data.confirm_at === undefined || data.confirm_at === null){
          confirm_at = "진행 중";
          if(data.state === Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE){
            confirm_at = moment_timezone(data.updated_at).format("YYYY-MM-DD");
          }
        }else{
          confirm_at = moment_timezone(data.confirm_at).format("YYYY-MM-DD");
        }

        if(data.state > Types.order.ORDER_STATE_PAY_END){
          confirm_at = '-'
        }
        
        
        const newData = {
          ...data,
          state_text: this.getStateText(data.state),
          created_at: moment_timezone(data.created_at).format("YYYY-MM-DD"),
          confirm_at: confirm_at
        }
        
        _items.push(newData);
      }
      
      this.setState({
        items: _items.concat(),
        hasMore: hasMore
      });
    }, (error) => {

    })
  }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  onChangeSelect(event){
    // event.target.value
    
    let _item_state_show = ''
    let value = Number(event.target.value);

    this.setState({
      sort_state: value,
      items: []
    }, () => {
      this.isRequestInitData = false;
      // this.requestMoreData();
    })
  }

  onChangeContent(event){
    let value = Number(event.target.value);

    this.setState({
      sort_item_id: value,
      items: []
    }, () => {
      this.isRequestInitData = false;
      // this.requestMoreData();
    })
  }

  getStateText(state){
    if(state === Types.order.ORDER_STATE_APP_STORE_PAYMENT)
    {
      return '승인대기'
    }
    else if(state === Types.order.ORDER_STATE_APP_STORE_READY)
    {
      return '승인완료(콘텐츠 제작중)'
    }
    else if(state === Types.order.ORDER_STATE_APP_STORE_SUCCESS)
    {
      return '크티 전달완료'
    }
    else if(state === Types.order.ORDER_STATE_APP_STORE_RELAY_CUSTOMER)
    {
      return '고객 전달완료';
    }
    else if(state === Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE)
    {
      return '고객 확인완료';
    }
    else if(state === Types.order.ORDER_STATE_CANCEL_STORE_RETURN)
    {
      return '반려'
    }
    else if(state === Types.order.ORDER_STATE_CANCEL_STORE_WAIT_OVER)
    {
      return '승인 만료(취소됨)'
    }
    else if(state === Types.order.ORDER_STATE_CANCEL_STORE_RETURN)
    {
      return '반려'
    }
    else if(state === Types.order.ORDER_STATE_CANCEL)
    {
      return '취소됨';
    }
    else if(state === Types.order.ORDER_STATE_APP_STORE_PLAYING_DONE_CONTENTS)
    {
      return '진행 완료';
    }

    return '';
  }

  render(){

    let total_price_dom = <></>;
    if(this.state.doller_count > 0){
      //달러가 있다면,
      //
      total_price_dom = <div style={{display: 'flex', flexDirection: 'column', alignItems: 'flex-end'}}>
                          <div className={'summary_total_value_text'}>
                            {Util.getNumberWithCommas(this.state.total_price)}원
                          </div>
                          <div style={{fontSize: 12, fontWeight: 500, color: '#acacac'}}>
                            외화 결제 금액 미포함
                          </div>
                        </div>
    }else{
      total_price_dom = <div className={'summary_total_value_text'}>
                          {Util.getNumberWithCommas(this.state.total_price)}원
                        </div>
    }
    return(
      <div className={'StoreManagerTabOrderListPage'}>
        <div className={'summary_container'}>
          <div className={'summary_content_container'}>
            <div className={'summary_content_label_text'}>
              전체 주문 수
            </div>
            <div className={'summary_content_value_text'}>
              {this.state.total_buy_count}건
            </div>
          </div>

          <div className={'summary_content_container'}>
            <div className={'summary_content_label_text'}>
              취소 및 반려
            </div>
            <div className={'summary_content_value_text'}>
              {this.state.cancel_refund_total_count}건
            </div>
          </div>

          <div className={'summary_content_container'}>
            <div className={'summary_content_label_text'}>
              판매 진행 중
            </div>
            <div className={'summary_content_value_text'}>
              {this.state.ready_total_count}건
            </div>
          </div>

          <div className={'summary_content_container'}>
            <div className={'summary_content_label_text'}>
              확인 완료된 주문
            </div>
            <div className={'summary_content_value_text'}>
              {this.state.ready_success_total_count}건
            </div>
          </div>
          
          <div className={'summary_under_line'}>
          </div>

          <div className={'summary_content_container'} style={{marginBottom: 0}}>
            <div className={'summary_total_label_text'}>
              최종 판매 금액
            </div>
            {total_price_dom}
            {/* <div className={'summary_total_value_text'}>
              {Util.getNumberWithCommas(this.state.total_price)}원
            </div> */}
          </div>
        </div>

        <div className={'order_list_container'}>
          <TableComponent
            isInfinite={true}
            hasMore={this.state.hasMore}
            requestMoreDataCallback={() => {this.requestMoreData()}}
            columns={
              [
                {title:"주문ID", field:"id"},
                {title:"콘텐츠명", field:"title", isSort: true, ellipsize: true},
                {title:"구매자", field:"name"},
                {title:"결제금액", field:"total_price", type:Types.table_columns_type.price},
                {title:"판매완료일", field:"confirm_at"},
                {title:"주문상태", field:"state_text", isSort: true},
              ]
            }
            datas={this.state.items}
          ></TableComponent>
        </div>
      </div>
    )
  }
};

export default StoreManagerTabOrderListPage;