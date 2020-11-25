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
      const domObject = <StoreContentsListItem key={i} store_title={data.store_title} store_id={data.store_id} id={data.id} store_item_id={data.id} thumbUrl={data.img_url} name={data.nick_name} title={data.title} price={data.price} isHomeList={true} store_alias={data.alias}></StoreContentsListItem>;

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