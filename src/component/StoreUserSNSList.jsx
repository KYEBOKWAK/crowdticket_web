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

// const list = [
//   {
//     img_store_url: 'https://s3-ap-northeast-1.amazonaws.com/crowdticket0/channels/twitter_logo.png'
//   }
// ]



class StoreUserSNSList extends Component{

  constructor(props){
    super(props);

    this.state = {
      store_user_id: null,
      snsInfoList: [],

      bottom: 32,
      right: 24
    }

    this.updateDimensions = this.updateDimensions.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    
    axios.post("/store/any/info/storeid", {
      store_id: this.props.store_id
    }, (result) => {
      
      this.setState({
        store_user_id: result.data.store_user_id
      }, () => {
        this.requestSNSInfo();
      })
    }, (error) => {

    });

    window.addEventListener('resize', this.updateDimensions);

    this.updateDimensions();
  };

  updateDimensions(){
    if(window.innerWidth > 520){
      //pc
      this.setState({
        bottom: 32,
        right: 32
      })
    }else{
      //mobile
      this.setState({
        bottom: 77,
        right: 24
      })
      
    }
  }

  requestSNSInfo(){
    axios.post("/store/any/sns/list", {
      store_user_id: this.state.store_user_id
    }, (result) => {
      this.setState({
        snsInfoList: result.list.concat()
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  requestItemInfo(){
    // console.log(this.state.store_item_id);
    // axios.post('/store/any/item/info', {
    //   store_item_id: this.state.store_item_id
    // }, (result) => {
    //   const data = result.data;
    //   this.setState({
    //     title: data.title,
    //     price: data.price,
    //     content: data.content,
    //     thumb_img_url: data.img_url
    //   })
    // }, (error) => {

    // })
  }

  clickSNS(e, link_url){
    e.preventDefault();

    if(link_url === ''){
      return;
    }

    window.open(link_url);

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

   

  //  let baseURL = 'https://crowdticket.kr'
  //  const baseURLDom = document.querySelector('#base_url');
  //  if(baseURLDom){
  //    // console.log(baseURLDom.value);
  //    baseURL = baseURLDom.value;
  //  }
   
  //  let hrefURL = baseURL+'/order/store/'+this.state.store_item_id;
   
  //  window.location.href = hrefURL;

  }

  render(){

    let StoreUserSNSListStyle = {
      
    }

    let storeListContainerStyle = {

    }

    let buttonClassName = '';

    if(this.props.inItemDetailPage){
      storeListContainerStyle = {
        flexDirection: 'column'
      }

      buttonClassName = 'sns_img_item_detail_container';
      // StoreUserSNSListStyle = {
      //   position: 'relative', 
      //   // bottom: 32, 
      //   // right: 32
      // }
    }else {

      buttonClassName = 'sns_img_container';

      StoreUserSNSListStyle = {
        position: 'absolute', 
        bottom: this.state.bottom, 
        right: this.state.right
      }
    }


    let snsList = [];
    snsList = this.state.snsInfoList.map((item) => {
      return <button className={buttonClassName} key={item.id} onClick={(e) => {this.clickSNS(e, item.link_url)}}>
              <img className={'sns_img'} src={item.img_store_url} />
            </button>
    })

    return(
      <div className={'StoreUserSNSList'} style={StoreUserSNSListStyle}>
        <div className={'sns_list_container'} style={storeListContainerStyle}>
          {snsList}
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

StoreUserSNSList.defaultProps = {
  inItemDetailPage: false
}

export default StoreUserSNSList;