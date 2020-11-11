'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';
import Util from '../lib/Util';

import StoreUserSNSList from '../component/StoreUserSNSList';

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
      store_item_id: null,
      store_id: null,
      typeContent: '',
      title: '',
      price: 0,
      content: '',
      thumb_img_url: '',

      store_title: '',
      store_content: '',
      store_user_profile_photo_url: '',
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
        this.requestStoreInfo();
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

  requestStoreInfo(){
    axios.post("/store/any/info/itemid", {
      store_item_id: this.state.store_item_id
    }, (result) => {
      this.setState({
        store_id: result.data.store_id,
        store_title: result.data.title,
        store_content: result.data.content,
        store_user_profile_photo_url: result.data.profile_photo_url,
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
    if(this.state.store_item_id === null){
      return(
        <></>
      )
    }

    let store_user_dom = <></>;
    if(this.state.store_id){
      store_user_dom = <div className={'user_info_container'}>
                          <div style={{display: 'flex', alignItems: 'center'}}>
                            <img className={'user_img'} src={this.state.store_user_profile_photo_url} />
                            <div className={'store_contents_container'}>
                              <div className={'store_contents_title'}>
                                {this.state.store_title}
                              </div>
                              <div className={'store_contents_content'}>
                                {this.state.store_content}
                              </div>
                            </div>
                          </div>
                          <div style={{display: "flex", alignItems: 'flex-end'}}>
                            <StoreUserSNSList store_id={this.state.store_id} isPositionNone={true}></StoreUserSNSList>
                          </div>
                        </div>
    }

    return(
      <div className={'StoreItemDetailPage'}>
        <div className={'item_img_container'}>
          <img className={'item_img'} src={this.state.thumb_img_url} />
          <div className={'item_img_cover'}>
          </div>
          {store_user_dom}
        </div>
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

    /*
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
    */
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