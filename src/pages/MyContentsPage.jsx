'use strict';

import React, { Component } from 'react';

import StoreReceiptItem from '../component/StoreReceiptItem';
import Util from '../lib/Util';
import axios from '../lib/Axios';

import InfiniteScroll from 'react-infinite-scroll-component';

const REQUEST_ONCE_ITME = 3;
let isRequestInitData = false;

class MyContentsPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      myID: null,
      // order_datas: [],
      // orders_item_doms: [],

      items: [],
      hasMore: true
    }

    this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    const myID = Number(document.querySelector('#myId').value);
    if(myID === 0){
      //ID값이 0이면 로그인 안함.
      // alert("유저 ID가 없습니다.");
      

    }else{
      // this.requestLoginToken(myID, true);
      this.setState({
        myID: myID
      }, () => {
        this.requestMyStoreOrder();
      })
    }
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  requestMyStoreOrder = () => {

    this.requestMoreData();
    /*
    axios.post("/orders/store/item/list", {}, 
    (result) => {
      this.setState({
        order_datas: result.list.concat()
      }, () => {
        this.setOrderItem();
      })
    }, (error) => {

    })
    */
  }

  requestMoreData(){
    
    if(this.state.items.length === 0 && this.isRequestInitData){
      return;
    }

    if(this.state.items.length === 0){
      this.isRequestInitData = true;
    }


    axios.post('/orders/store/item/list/get', {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items.length
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

  /*
  setOrderItem(){
    // console.log(this.state.order_datas);
    let _orders_item_doms = [];
    for(let i = 0 ; i < this.state.order_datas.length ; i++){
      const data = this.state.order_datas[i];
      let domObject = <div key={data.store_order_id} className={'container_box'}>
                        <StoreReceiptItem store_order_id={data.store_order_id} isGoDetailButton={true}></StoreReceiptItem>
                      </div>
      _orders_item_doms.push(domObject);
    }

    this.setState({
      orders_item_doms: _orders_item_doms.concat()
    })
  }
  */

  render(){
    if(!this.state.myID){
      return (
        <></>
      )
    }

    return(
      <div className={'MyContentsPage'}>
        <div className={'myContentsTitle'}>
          나의 콘텐츠
        </div>
        
        <InfiniteScroll
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
                    <StoreReceiptItem store_order_id={data.store_order_id} isGoDetailButton={true}></StoreReceiptItem>
                  </div>
          })}
        </InfiniteScroll>
      </div>
    )
  }
};

export default MyContentsPage;