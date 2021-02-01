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
// import Types from '~/Types';

import axios from '../lib/Axios';

import Util from '../lib/Util';
import Types from '../Types';
// import InfiniteScroll from 'react-infinite-scroll-component';
// import moment from 'moment';
import moment_timezone from 'moment-timezone';

import TableComponent from '../component/TableComponent';

const REQUEST_ONCE_ITME = 5;
let isRequestInitData = false;

class StoreManagerTabAccountPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      items: [],
      hasMore: true,

      contact: '',
      email: '',

      total_payment_price: 0,

      next_deposit_date: '',
      standard_payment_date_start: '',
      standard_payment_date_end: '',

      // policy: `1. 정산은 상품 결제가 진행된 후 구매자에게 콘텐츠 전달까지 모두 완료된 건들에 한하여 진행됩니다.
      // 2. 크티 '콘텐츠 상점 beta' 수수료는 현재 카드결제 수수료 3.5%를 포함하여 총 15%로, 총 결제 금액에서 수수료를 제외한 금액을 정산하여 입금해드립니다.
      // 3. 콘텐츠 상점 정산일은 매 달 15일과 30일입니다.
      // 4. 매 달 1일~15일 사이에 판매가 완료된 건은 같은 달 30일에 정산이 진행되며, 16일~31일 사이에 판매가 완료된 건은 다음 달 15일에 정산됩니다.
      // 5. 정산일이 주말 또는 공휴일인 경우 그 다음 평일에 정산이 진행됩니다.
      // 6. 콘텐츠 판매자는 정산 받은 금액에 대해 부과되거나 의무가 있는 모든 세금을 성실하게 신고하고 납부할 의무가 있습니다.`,

      policy: `1. 정산은 구매 요청 승인 후, 콘텐츠를 제공하여 구매자가 확인 완료까지 마쳐 판매가 완료된 내역에 한하여 진행됩니다.

        2. 크티 콘텐츠 상점 수수료는 현재 카드결제 수수료 3.5%를 포함하여 총 15%로, 총 결제 금액에서 수수료를 제외한 금액을 정산하여 입금드립니다.

        3. 콘텐츠 상점 정산일은 매 달 1일과 16일입니다.

        4. 매 달 1일~15일 사이에 판매가 완료된 건은 다음 달 1일에 정산이 진행되며, 16일~31일 사이에 판매가 완료된 건은 다음 달 16일에 정산됩니다.

        5. 정산일이 주말 또는 공휴일인 경우 그 다음 평일에 정산이 진행됩니다.
        
        6. 콘텐츠 판매자는 정산 받은 금액에 대해 부과되거나 의무가 있는 모든 세금을 성실하게 신고하고 납부할 의무가 있습니다.`,
      
      payment_detail_datas: []
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  componentDidMount(){
    // this.requestMoreData();
    this.requestStoreInfo();

    this.requestPaidList();
    this.requestPaymentInfo();
  };

  componentDidUpdate(prevProps, prevState, snapshot) {
  }

  componentWillUnmount(){
  };

  requestStoreInfo(){
    axios.post("/store/info/userid", {
      store_user_id: this.props.store_user_id
    }, (result) => {
      
      this.setState({        
        contact: result.data.contact,
        email: result.data.email,
      })
    }, (error) => {

    })
  }

  requestPaymentInfo = () => {
    axios.post('/store/manager/payment/info', {
      store_id: this.props.store_id
    },
    (result) => {
      let total_payment_price = 0;
      let payment_detail_datas = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];

        total_payment_price += data.payment_price;

        payment_detail_datas.push(data);
      }

      this.setState({
        next_deposit_date: result.next_deposit_date,
        standard_payment_date_start: result.standard_payment_date_start,
        standard_payment_date_end: result.standard_payment_date_end,

        total_payment_price: total_payment_price,

        payment_detail_datas: payment_detail_datas.concat()
      })
    }, (error) => {

    })
  }

  requestPaidList = () => {
    axios.post('/store/manager/account/paid/list', {
      store_id: this.props.store_id
    }, 
    (result) => {
      let itemsData = result.list.concat();
      let _items = [];

      for(let i = 0 ; i < itemsData.length ; i++){
        let data = itemsData[i];

        if(data.explain === null || data.explain === ''){
          data.explain = '-';
        }

        data.created_at = moment_timezone(data.created_at).format("YYYY-MM-DD");

        // console.log(data.created_at);
        _items.push(data);
      }
      
      this.setState({
        items: _items.concat()
      });
    }, (error) => {

    })
  }

  /*
  requestMoreData(){
    if(this.state.items.length === 0 && this.isRequestInitData){
      return;
    }

    if(this.state.items.length === 0){
      this.isRequestInitData = true;
    }

    axios.post('/store/manager/account/paid/list', {
      store_id: this.props.store_id,
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items.length,
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
        
        _items.push(data);
        // itemIndex++;
      }
      
      this.setState({
        items: _items.concat(),
        hasMore: hasMore
      });
    }, (error) => {

    })
  }
  */

  render(){
    let next_deposit_date = moment_timezone(this.state.next_deposit_date).format('YYYY. MM. DD');
    
    let stanard_moment_start = moment_timezone(this.state.standard_payment_date_start);

    let stanard_moment_end = moment_timezone(this.state.standard_payment_date_end);

    let stanard_payment_date = '';
    let stanard_payment_start = stanard_moment_start.format('YYYY. MM. DD');
    let stanard_payment_end = stanard_moment_end.format('YYYY. MM. DD');
    if(stanard_moment_start.year() === stanard_moment_end.year()){
      stanard_payment_end = stanard_moment_end.format('MM. DD');
    }else{
      stanard_payment_end = stanard_moment_end.format('YYYY. MM. DD');
    }

    stanard_payment_date = stanard_payment_start + ' ~ ' + stanard_payment_end;

    return(
      <div className={'StoreManagerTabAccountPage'}>

        
        <div className={'total_payment_box'}>
          <div className={'total_payment_container'}>
            <div className={'total_payment_title'}>
              정산 예정 금액
            </div>
            <div className={'total_payment_price'}>
              {Util.getNumberWithCommas(this.state.total_payment_price)}원
            </div>
          </div>
        </div>

        <div className={'second_container'}>
          <div className={'second_box'}>
            <div className={'second_box_title'}>
              입금 예정일
            </div>
            <div className={'second_box_date'}>
              {next_deposit_date}
            </div>
          </div>

          <div style={{width: 14}}>
          </div>
          <div className={'second_box'}>
            <div className={'second_box_title'}>
              정산 기준일
            </div>
            <div className={'second_box_date'}>
              {stanard_payment_date}
            </div>
          </div>
        </div>

        <div className={'second_box_explain'}>
          수수료 프로모션이나 주문 상태 업데이트에 따라 실제 입금 금액은 바뀔 수 있습니다
        </div>
        

        
        <div className={'box_container'}>
          <div className={'label_title'}>
            세부내역
          </div>
          <TableComponent
            table_type={Types.table_type.total_payment}
            columns={
              [
                {title:"주문ID", field:"id", align:"center", sorter:"string", headerFilter:"input"},
                {title:"콘텐츠명", field:"title", align:"center", sorter:"string", headerFilter:"input", ellipsize: true},
                {title:"판매완료일", field:"confirm_at", align:"center", sorter:"string", headerFilter:"input"},
                {title:"결제금액", field:"total_price", type:Types.table_columns_type.price, align:"center", sorter:"string", headerFilter:"input", bottomCalc: 'sum'},
                {title:"수수료", field:"commission", type:Types.table_columns_type.price, align:"center", sorter:"string", headerFilter:"input", bottomCalc: 'sum'},
                {title:"정산금액", field:"payment_price", type:Types.table_columns_type.price, align:"center", sorter:"string", headerFilter:"input", bottomCalc: 'sum'},
              ]
            }
            datas={this.state.payment_detail_datas}
          ></TableComponent>
        </div>
         

        <div className={'box_container'}>
          <div className={'label_title'}>
            정산안내
          </div>

          <div className={'policy_container'}>
            <div className={'policy_label'}>
              크티 정산 규정
            </div>
            <div className={'policy_contents'}>
              {this.state.policy}
            </div>
          </div>
        </div>
        

        

        <div className={'box_container'}>

          <div className={'label_title'}>
            정산내역
          </div>

          <div className={'paid_list_container'}>
            
            <TableComponent
              columns={
                [
                  {title:"정산일", field:"created_at"},
                  {title:"정산 금액", field:"pay_price", type:Types.table_columns_type.price},
                  {title:"비고", field:"explain"},
                ]
              }
              datas={this.state.items}
            ></TableComponent>
           
            
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
                return <div key={data.id} className={'paid_list_title_container paid_list_item_container'}>
                        <div className={'paid_title_date paid_list_item_text'}>
                          {moment_timezone(data.created_at).format('YYYY-MM-DD')}
                        </div>
                        <div className={'paid_title_price paid_list_item_text'}>
                          {Util.getNumberWithCommas(data.pay_price)}원
                        </div>
                      </div>
              })}
            </InfiniteScroll> */}
            
            
          </div>
        </div>
      </div>
    )
  }
};

export default StoreManagerTabAccountPage;