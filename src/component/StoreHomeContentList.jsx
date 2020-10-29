'use strict';

import React, { Component } from 'react';

import InfiniteScroll from 'react-infinite-scroll-component';

import Util from '../lib/Util';

import StoreContentsListItem from '../component/StoreContentsListItem';
import axios from '../lib/Axios';

import random from 'array-random';

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
    
    /*
    setTimeout(() => {
      let _items = this.state.items.concat();

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
          return <StoreContentsListItem key={data.id} id={data.id} store_item_id={data.id} thumbUrl={data.img_url} name={data.nick_name} title={data.title} price={data.price}></StoreContentsListItem>
        })}
      </InfiniteScroll>
    )
  }
};

// props 로 넣어줄 스토어 상태값
// const mapStateToProps = (state) => {
//   // console.log(state);
//   return {
//     // pageViewKeys: state.page.pageViewKeys.concat()
//   }
// };

// const mapDispatchToProps = (dispatch) => {
//   return {
//     // handleAddPageViewKey: (pageKey: string, data: any) => {
//     //   dispatch(actions.addPageViewKey(pageKey, data));
//     // },
//     // handleAddToastMessage: (toastType:number, message: string, data: any) => {
//     //   dispatch(actions.addToastMessage(toastType, message, data));
//     // }
//   }
// };

// export default connect(mapStateToProps, mapDispatchToProps)(Templite);
export default StoreHomeContentList;