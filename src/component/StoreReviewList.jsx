'use strict';

import React, { Component } from 'react';

import Util from '../lib/Util';
import Login from '../lib/Login';

import StoreReviewItem from './StoreReviewItem';
import axios from '../lib/Axios';
import Types from '../Types';

import Str from '../component/Str';

const REQUEST_ONCE_ITME = 10;
let isRequestInitData = false;

class StoreReviewList extends Component{
  isUnmount = false;

  constructor(props){
    super(props);

    this.state = {
      items: [],
      hasMore: true,
      isRefreshing: true
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    
    this.requestStoreContents();

    this.requestMoreData();
    
    window.addEventListener('scroll', this.handleScroll);
  };

  componentWillUnmount(){
    this.isUnmount = true;
    window.removeEventListener('scroll', this.handleScroll);
  };

  componentDidUpdate(){
    
  }

  requestStoreContents(){
  }

  requestMoreData = () => {
    if(this.state.items.length === 0 && this.isRequestInitData){
      return;
    }

    if(this.state.items.length === 0){
      this.isRequestInitData = true;
    }

    axios.post('/comments/any/list', {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items.length,
      target_id: this.props.store_id,
      commentType: Types.comment.commentType.store
      // lastID: 
    }, 
    (result) => {
      if(this.isUnmount){
        return;
      }

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
        isRefreshing: false,
        hasMore: hasMore
      });
    }, (error) => {

    })
  };

  goWriteReviewPage = () => {
    window.location.href = this.getWriteReviewPage();
  }

  getWriteReviewPage = () => {
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    return baseURL + '/review/store/write/' + this.props.store_id;
  }

  clickWriteReview(e){
    e.preventDefault();

    if(!isLogin())
    {
      Login.start();      
      return;
    }else{
      this.goWriteReviewPage()
    }

    

    //관리자 상점 들어가야함!!! 관리자만 남음!

    // window.location.replace(reviewWriteURL);
    
    // console.log(reviewWriteURL);
  }

  handleScroll = () => {
    let refresh_target_dom = document.querySelector('#refresh_fake_dom');
    if(refresh_target_dom){
      const { top, height } = refresh_target_dom.getBoundingClientRect();

      const windowHeight = window.innerHeight;

      if(top <= windowHeight){
        if(!this.state.isRefreshing && this.state.hasMore){
          this.setState({
            isRefreshing: true
          }, () => {
            this.requestMoreData();
          })
        }
      }
    }
  }

  render(){
    let itemList = [];
    for(let i = 0 ; i < this.state.items.length ; i++){
      const data = this.state.items[i];
      const itemObject = <div key={data.comment_id} style={{marginTop: 32}}>
                          <StoreReviewItem user_id={data.user_id} created_at={data.created_at} id={data.comment_id} store_id={this.props.store_id} name={data.name} nick_name={data.nick_name} content={data.contents} profile_photo_url={data.profile_photo_url}></StoreReviewItem>
                        </div>

      itemList.push(itemObject);
    }

    return(
      
        
      <div className={'StoreReviewList'}>
        <div style={{paddingLeft: 10, paddingRight: 10, width: '100%'}}>
          <button onClick={(e) => {this.clickWriteReview(e)}} className={'reviewButton'}>
            <Str strKey={'s145'} />
          </button>
        </div>

        {itemList}

        <div id={'refresh_fake_dom'}>
        </div>
      </div>
      
    )
  }
};

StoreReviewList.defaultProps = {
  store_id: 0
}

export default StoreReviewList;