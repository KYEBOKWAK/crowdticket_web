'use strict';

import React, { Component } from 'react';

import InfiniteScroll from 'react-infinite-scroll-component';

// import Util from '../lib/Util';

import StoreItemDetailReviewItem from './StoreItemDetailReviewItem';
import axios from '../lib/Axios';
import Types from '../Types';

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

class StoreItemDetailReviewList extends Component{

  constructor(props){
    super(props);

    this.state = {
      items: [],
      hasMore: false,
      isMore: false
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
      
      let hasMore = this.state.hasMore;
      if(REQUEST_ONCE_ITME > itemsData.length ){
        hasMore = false;
      }

      for(let i = 0 ; i < itemsData.length ; i++){
        // const data = itemsData[i];
        const index = _items.length;
        const data = {
          ...itemsData[i],
          index: index
        }

        _items.push(data);
      }
      
      this.setState({
        items: _items.concat(),
        hasMore: hasMore
      });
    }, (error) => {

    })
  };

  goWriteReviewPage(){
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    let reviewWriteURL = baseURL + '/review/store/write/' + this.props.store_id;

    window.location.href = reviewWriteURL;
  }

  onClickMoreButton = (e) => {
    e.preventDefault();

    this.setState({
      hasMore: true,
      isMore: true
    }, () => {
      this.requestMoreData();
    })
  }
  /*
  clickWriteReview(e){
    e.preventDefault();

    if(!isLogin())
    {
      // loginPopup(null, null);
      loginPopup(() => {
        if(isLogin()){
          swal.close();
          this.goWriteReviewPage()
        }
      }, null);
      return;
    }else{
      this.goWriteReviewPage()
    }
  }
  */

  render(){

    if(this.state.items.length === 0){
      return (
        <div className={'StoreReviewTalk'}>
          <div className={'no_data_text'}>
            {`이 콘텐츠 상품의\n`}
            <span className={'no_data_text_point_color'}>첫 구매자</span>
            {`가 되어주세요!`}
          </div>
        </div>
      )
    }

    let moreButtonDom = <></>;
    if(!this.state.isMore){
      moreButtonDom = <button onClick={(e) => {this.onClickMoreButton(e)}} className={'more_button'}>
                        더보기 +
                      </button> 
    }
    return(
      <div className={'StoreItemDetailReviewList'}>
        <div style={{paddingLeft: 10, paddingRight: 10, width: '100%'}}>
          {/* <button onClick={(e) => {this.clickWriteReview(e)}} className={'reviewButton'}>
            작성하기
          </button> */}
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

            let itemContainerStyle = {};
            if(data.index === 0){
              itemContainerStyle = {
                marginTop: 0
              }
            }

            return <div key={data.comment_id} className={'item_container'} style={itemContainerStyle}>
                    <StoreItemDetailReviewItem store_order_id={data.second_target_id} user_id={data.user_id} created_at={data.created_at} id={data.comment_id} store_id={this.props.store_id} name={data.name} nick_name={data.nick_name} content={data.contents} profile_photo_url={data.profile_photo_url}></StoreItemDetailReviewItem>
                  </div>
          })}
        </InfiniteScroll>

        {moreButtonDom}
      </div>
    )
  }
};

StoreItemDetailReviewList.defaultProps = {
  store_id: 0
}

export default StoreItemDetailReviewList;