'use strict';

import React, { Component } from 'react';

import InfiniteScroll from 'react-infinite-scroll-component';

import StoreContentsListItem from '../component/StoreContentsListItem';
import axios from '../lib/Axios';

import random from 'array-random';
import Types from '../Types';


const REQUEST_ONCE_ITME = 5;
let isRequestInitData = false;

class StoreHomeContentList extends Component{

  constructor(props){
    super(props);

    this.state = {
      items: [],
      hasMore: true
    }

    this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    if(!this.props.type){
      alert("타입 없음");
      return;
    }

    this.requestMoreData();
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
    
  }

  requestMoreData(){
    
    if(this.state.items.length === 0 && this.isRequestInitData){
      return;
    }

    if(this.state.items.length === 0){
      this.isRequestInitData = true;
    }

    
    axios.post('/store/any/item/list', {
      type: this.props.type
    }, 
    (result) => {
      
      // let itemsData = random(result.list);
      let _items = [];

      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        
        _items.push(data);
        // itemIndex++;
      }
      
      this.setState({
        items: _items.concat(),
      });
    }, (error) => {

    })


    /*
    axios.post('/store/any/item/list', {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items.length
      // lastID: 
    }, 
    (result) => {
      
      let itemsData = random(result.list);
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
    */
  };

  render(){
    let _contentList = [];
    for(let i = 0 ; i < this.state.items.length ; i++){
      const data = this.state.items[i];
      const domObject = <StoreContentsListItem key={i} store_id={data.store_id} id={data.id} store_item_id={data.id} thumbUrl={data.img_url} name={data.nick_name} title={data.title} price={data.price} isHomeList={true} store_alias={data.alias}></StoreContentsListItem>;

      // const domObject = <StoreContentsListItem key={data.id} store_id={data.store_id} id={data.id} store_item_id={data.id} thumbUrl={data.img_url} name={data.nick_name} title={data.title} price={data.price} isHomeList={true} store_alias={data.alias}></StoreContentsListItem>;

      _contentList.push(domObject);
    }
    return(
      <div>
      {_contentList}
      </div>
    )
  }
};

export default StoreHomeContentList;
/*
'use strict';

import React, { Component } from 'react';

import InfiniteScroll from 'react-infinite-scroll-component';

import StoreContentsListItem from '../component/StoreContentsListItem';
import axios from '../lib/Axios';

import random from 'array-random';


const REQUEST_ONCE_ITME = 5;
let isRequestInitData = false;

class StoreHomeContentList extends Component{

  constructor(props){
    super(props);

    this.state = {
      items: [],
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


    axios.post('/store/any/item/list', {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items.length
      // lastID: 
    }, 
    (result) => {
      
      let itemsData = random(result.list);
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
          return <StoreContentsListItem key={data.id} store_id={data.store_id} id={data.id} store_item_id={data.id} thumbUrl={data.img_url} name={data.nick_name} title={data.title} price={data.price} isHomeList={true} store_alias={data.alias}></StoreContentsListItem>
        })}
      </InfiniteScroll>
    )
  }
};

export default StoreHomeContentList;
*/