'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';
import Util from '../lib/Util';


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



class StoreItemDetailPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      store_item_id: 0,
      typeContent: '분류?',
      title: '컨텐츠명',
      price: 10000,
      content: '이거슨 컨텐츠 내용입니다요요요요요오',
      thumb_img_url: 'https://yt3.ggpht.com/a/AGF-l7-d5lvs0qqvvoUJiOGmRfrY17AI-gj7vmtM=s800-mo-c-c0xffffffff-rj-k-no'
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    const storeItemIDDom = document.querySelector('#store_item_id');
    if(storeItemIDDom){
      console.log(storeItemIDDom.value);

      this.setState({
        store_item_id: Number(storeItemIDDom.value)
      }, function(){
        //아이템 정보 가져오기
        this.requestItemInfo();
      })
    }

    // history.pushState(null, null, location.href);
    // window.onpageshow = function(event){
    //   if(event.persisted || (window.performance && window.performance.navigation.type == 2)){
    //     console.log("adsfsdf");
    //   }
    // }
    // window.onpopstate = function(event) {
    //   console.log("asdfasdf");
    //     // history.go(1);
    // };
    // console.log("########");
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  requestItemInfo(){
    // console.log(this.state.store_item_id);
    axios.post('/store/any/item/info', {
      store_item_id: this.state.store_item_id
    }, (result) => {
      const data = result.data;
      this.setState({
        title: data.title,
        price: data.price,
        content: data.content,
        thumb_img_url: data.img_url
      })
    }, (error) => {

    })
  }

  clickOrder(e){

    // window.$.ajax({
		// 	'url': 'http://localhost:8000/order/store',
		// 	'method': 'get',
		// 	'data': {abc: 'aaa'},
		// 	'success': function(result){console.log(result)},
		// 	'error': function(){console.log('error')}
		// })
    /*
    axios.post('http://localhost:8000/order/store', {
      test: 'abc'
    }, (function(result){
      console.log(result);
    }), function(error){
      console.log(error);
    })
    */

   e.preventDefault();

   let baseURL = 'https://crowdticket.kr'
   const baseURLDom = document.querySelector('#base_url');
   if(baseURLDom){
     // console.log(baseURLDom.value);
     baseURL = baseURLDom.value;
   }
   
   let hrefURL = baseURL+'/order/store/'+this.state.store_item_id;
   
   window.location.href = hrefURL;

  }

  render(){
    return(
      <div className={'StoreItemDetailPage'}>
        <img className={'item_img'} src={this.state.thumb_img_url} />
        <div className={'content_container'}>
          <div className={'content_title'}>
            {this.state.title}
          </div>
          <div className={'content_price'}>
            {Util.getNumberWithCommas(this.state.price)}원
          </div>
          <div className={'content_text'}>
            {this.state.content}
          </div>

          <button onClick={(e) => {this.clickOrder(e)}} className={'button_pay'}>
            주문하기
          </button>
        </div>
      </div>
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

// export default connect(mapStateToProps, mapDispatchToProps)(StoreItemDetailPage);
export default StoreItemDetailPage;