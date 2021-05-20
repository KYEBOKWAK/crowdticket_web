'use strict';

import React, { Component } from 'react';

import InfiniteScroll from 'react-infinite-scroll-component';

import Util from '../lib/Util';
import Login from '../lib/Login';

import StoreReviewItem from './StoreReviewItem';
import axios from '../lib/Axios';
import Types from '../Types';

import Str from '../component/Str';

const REQUEST_ONCE_ITME = 5;
let isRequestInitData = false;

class StoreReviewList extends Component{

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
    
    this.requestStoreContents();

    this.requestMoreData();
    // let _items = [];

    // let itemIndex = _items.length;
    // if(itemIndex < 0){
    //   itemIndex = 0;
    // }

    // // let hasMore = true;
    // for(let i = 0 ; i < REQUEST_ONCE_ITME ; i++){
    //   if(itemIndex >= itemsData.length ){
    //     // hasMore = false;
    //     break;
    //   }

    //   _items.push(itemsData[itemIndex]);
    //   itemIndex++;
    // }
    
    // this.setState({
    //   items: _items.concat(),
    // });
    
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

    axios.post('/comments/any/list', {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items.length,
      target_id: this.props.store_id,
      commentType: Types.comment.commentType.store
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
        
        _items.push(data);
        // itemIndex++;
      }
      
      this.setState({
        items: _items.concat(),
        hasMore: hasMore
      });
    }, (error) => {

    })

    /*
    setTimeout(() => {
      let _items = this.state.items.concat();

      // if(_items.length === 0){
      //   _items = itemsData.
      // }else{

      // }

      let itemIndex = _items.length;
      if(itemIndex < 0){
        itemIndex = 0;
      }

      let hasMore = true;
      for(let i = 0 ; i < REQUEST_ONCE_ITME ; i++){
        if(itemIndex >= itemsData.length ){
          hasMore = false;
          break;
        }

        _items.push(itemsData[itemIndex]);
        itemIndex++;
      }
      
      this.setState({
        items: _items.concat(),
        hasMore: hasMore
      });
    }, 1000);
    */
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

  render(){
    return(
      <div className={'StoreReviewList'}>
        <div style={{paddingLeft: 10, paddingRight: 10, width: '100%'}}>
          <button onClick={(e) => {this.clickWriteReview(e)}} className={'reviewButton'}>
            {/* 작성하기 */}
            <Str strKey={'s145'} />
          </button>
        </div>
        <InfiniteScroll
          // style={{width: '100%'}}
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
            <p style={{ textAlign: 'center' }}>
              {/* <b>Yay! You have seen it all</b> */}
            </p>
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
            return <div key={data.comment_id} style={{marginTop: 32}}>
                    <StoreReviewItem user_id={data.user_id} created_at={data.created_at} id={data.comment_id} store_id={this.props.store_id} name={data.name} nick_name={data.nick_name} content={data.contents} profile_photo_url={data.profile_photo_url}></StoreReviewItem>
                  </div>
          })}
        </InfiniteScroll>
      </div>
    )
  }
};

StoreReviewList.defaultProps = {
  store_id: 0
}

export default StoreReviewList;