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

      sort_title_option: []
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
  };

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
    axios.post("/store/order/ready/count", {
      store_id: this.props.store_id
    }, (result) => {
      this.setState({
        ready_total_count: result.ready_total_count
      })
    }, (error) => {

    })
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
        }else{
          confirm_at = moment_timezone(data.confirm_at).format("YYYY-MM-DD");
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
    return(
      <div className={'StoreManagerTabOrderListPage'}>
        
        {/* <div className={'summary_container'}>
          <div className={'summary_content_container'}>
            <div className={'summary_content_label_text'}>
              총 콘텐츠 구매
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
              승인 대기
            </div>
            <div className={'summary_content_value_text'}>
              {this.state.ready_total_count}건
            </div>
          </div>

          <div className={'summary_content_container'}>
            <div className={'summary_content_label_text'}>
              전달 완료
            </div>
            <div className={'summary_content_value_text'}>
              {this.state.ready_success_total_count}건
            </div>
          </div>
          
          <div className={'summary_under_line'}>
          </div>

          <div className={'summary_content_container'} style={{marginBottom: 0}}>
            <div className={'summary_total_label_text'}>
              총 판매 금액
            </div>
            <div className={'summary_total_value_text'}>
              {Util.getNumberWithCommas(this.state.total_price)}원
            </div>
          </div>
        </div> */}
       

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
            <div className={'summary_total_value_text'}>
              {Util.getNumberWithCommas(this.state.total_price)}원
            </div>
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
        <div className={'order_list_container'}>
          <div className={'order_list_title_container'}>
            <div className={'order_title_date order_title_font'}>
              일시
            </div>
            <div className={'order_title_contents order_title_font select_box'}>
              콘텐츠 종류
              <img style={{width: 12, height: 8, marginLeft:2}} src={imgIconBox} />

              <select className={'select_tag'} value={this.state.sort_item_id} onChange={this.onChangeContent}>
                {this.state.sort_title_option}
              </select>

            </div>
            <div className={'order_title_count order_title_font'}>
              개수
            </div>
            <div className={'order_title_price order_title_font'}>
              결제금액
            </div>
            <div className={'order_title_state order_title_font select_box'}>
              상태
              <img style={{width: 12, height: 8, marginLeft:2}} src={imgIconBox} />
              
              <select className={'select_tag'} value={this.state.sort_state} onChange={this.onChangeSelect}>
                <option key={0} value={0}>{'모두보기'}</option>;
                <option key={1} value={Types.order.ORDER_STATE_APP_STORE_PAYMENT}>{'승인대기'}</option>;
                <option key={2} value={Types.order.ORDER_STATE_APP_STORE_READY}>{'승인완료(콘텐츠 제작중)'}</option>;
                <option key={3} value={Types.order.ORDER_STATE_APP_STORE_SUCCESS}>{'크티 전달완료'}</option>;
                <option key={4} value={Types.order.ORDER_STATE_APP_STORE_RELAY_CUSTOMER}>{'고객 전달완료'}</option>;
                <option key={5} value={Types.order.ORDER_STATE_CANCEL_STORE_RETURN}>{'반려'}</option>;
                <option key={6} value={Types.order.ORDER_STATE_CANCEL}>{'취소됨'}</option>;
              </select>
            </div>
          </div>

          {/* <InfiniteScroll
            // style={{backgroundColor: 'red'}}
            dataLength={this.state.items.length} //This is important field to render the next data
            next={this.requestMoreData}
            hasMore={this.state.hasMore}
            loader=
            {
              <div style={{display: 'flex', justifyContent: 'center'}}>
                <h4>Loading...</h4>
              </div>
            }
            endMessage={
              <></>
              // <p style={{ textAlign: 'center' }}>
              //   <b>Yay! You have seen it all</b>
              // </p>
            }
            // below props only if you need pull down functionality
            // refreshFunction={this.refresh}
            // pullDownToRefresh
            pullDownToRefreshThreshold={50}
            pullDownToRefreshContent={
              <></>
            }
            releaseToRefreshContent={
              <></>
            }
          >
            {this.state.items.map((data) => {
              return <div key={data.id} className={'order_list_title_container order_list_item_container'}>
                      <div className={'order_title_date order_list_item_text'}>
                        {moment_timezone(data.created_at).format('YYYY-MM-DD')}
                      </div>
                      <div className={'order_title_contents order_list_item_text'}>
                        {data.title}
                      </div>
                      <div className={'order_title_count order_list_item_text'}>
                        {data.count}
                      </div>
                      <div className={'order_title_price order_list_item_text'}>
                        {Util.getNumberWithCommas(data.total_price)}원
                      </div>
                      <div className={'order_title_state order_list_item_text'}>
                        {this.getStateText(data.state)}
                      </div>
                    </div>
            })}
          </InfiniteScroll> */}
          
        </div>
      </div>
    )
  }
};

export default StoreManagerTabOrderListPage;