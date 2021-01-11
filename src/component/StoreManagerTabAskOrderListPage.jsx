'use strict';

import React, { Component } from 'react';

import StoreReceiptItem from '../component/StoreReceiptItem';
import axios from '../lib/Axios';

import InfiniteScroll from 'react-infinite-scroll-component';

import cryingHamImg from '../res/img/icCryingHamGray.png';

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


const REQUEST_ONCE_ITME = 3;
let isRequestInitData = false;

class StoreManagerTabAskOrderListPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      listDom: [],
      items: [],
      hasMore: true
    }

    this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){

    this.requestMoreData();
    

    /*
    axios.post("/store/orders/ask/list", {
      store_id: this.props.store_id
    }, (result) => {
      let _listDom = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        let listItemDom = <div key={data.store_order_id} className={'container_box'}>
                            <StoreReceiptItem 
                              store_order_id={data.store_order_id} 
                              isGoDetailButton={false}
                              isManager={true}
                            ></StoreReceiptItem>
                          </div>

        _listDom.push(listItemDom)
      }

      this.setState({
        listDom: _listDom.concat()
      })

    }, (error) => {

    })
    */
  };

  requestMoreData(){
    
    if(this.state.items.length === 0 && this.isRequestInitData){
      return;
    }

    if(this.state.items.length === 0){
      this.isRequestInitData = true;
    }


    axios.post('/store/orders/ask/list/get', {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items.length,
      store_id: this.props.store_id
    }, 
    (result) => {
      
      let _items = this.state.items.concat();      
      let hasMore = true;
      if(REQUEST_ONCE_ITME > result.list.length ){
        hasMore = false;
      }

      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        
        _items.push(data);
        // itemIndex++;
      }
      
      this.setState({
        items: _items.concat(),
        hasMore: hasMore
      });
    }, (error) => {

    })    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){

    let contentDom = [];
    if(this.state.items.length === 0){
      contentDom = <div> 
                    <div className={'hamImg_container'}>
                      <img className={'hamImg'} src={cryingHamImg}/>
                      <div className={'no_contents_text'}>
                        요청된 콘텐츠가 없어요!
                      </div>
                    </div>
                    
                  </div>
    }else{
      // contentDom = this.state.listDom.concat();
      contentDom = <InfiniteScroll
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
          // <h3 style={{ textAlign: 'center' }}>&#8595; Pull down to refresh</h3>
        }
        releaseToRefreshContent={
          <></>
          // <h3 style={{ textAlign: 'center' }}>&#8593; Release to refresh</h3>
        }
      >
        {this.state.items.map((data) => {
          return <div key={data.store_order_id} className={'container_box'}>
                  <StoreReceiptItem 
                    store_order_id={data.store_order_id} 
                    isGoDetailButton={false}
                    isManager={true}
                  ></StoreReceiptItem>
                </div>
        })}
      </InfiniteScroll>
    }
    return(
      <div className={'StoreManagerTabAskOrderListPage'}>
        <div className={'tip_text'}>
          요청된 콘텐츠의 알림을 받으려면 [정산] 탭의 비상용 연락처와 이메일을 반드시 적어주세요.
        </div>
        {contentDom}
      </div>
    )
  }
};

export default StoreManagerTabAskOrderListPage;