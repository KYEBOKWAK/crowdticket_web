'use strict';

import React, { Component } from 'react';

import InfiniteScroll from 'react-infinite-scroll-component';

import StoreHomeStoreListItem from '../component/StoreHomeStoreListItem';
import axios from '../lib/Axios';

import random from 'array-random';


const REQUEST_ONCE_ITME = 3;
let isRequestInitData = false;

class StoreHomeStoreList extends Component{

  constructor(props){
    super(props);

    this.state = {
      items: [],
      item_ids: [],
      hasMore: true
    }

    this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    // this.requestStoreContents();
    this.requestMoreData();
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
    
  }

  requestStoreContents(){
  }

  requestMoreData(){
    
    if(this.state.items.length === 0 && this.isRequestInitData){
      return;
    }

    if(this.state.items.length === 0){
      this.isRequestInitData = true;
    }


    axios.post('/store/any/home/store/list', {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items.length,

      show_ids: this.state.item_ids.concat()
      // lastID: 
    }, 
    (result) => {
      
      // let itemsData = random(result.list);
      let _items = this.state.items.concat();
      let _item_ids = this.state.item_ids.concat();
      
      let hasMore = true;
      if(REQUEST_ONCE_ITME > result.list.length ){
        hasMore = false;
      }

      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        
        _items.push(data);
        _item_ids.push(data.store_id);
        // itemIndex++;
      }
      
      this.setState({
        items: _items.concat(),
        item_ids: _item_ids.concat(),
        hasMore: hasMore
      });
    }, (error) => {

    })    
  };

  render(){
    return(
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
          return <StoreHomeStoreListItem key={data.store_id} store_id={data.store_id} store_alias={data.alias}></StoreHomeStoreListItem>
        })}
      </InfiniteScroll>
    )
  }
};

export default StoreHomeStoreList;