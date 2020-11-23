'use strict';

import React, { Component } from 'react';

import axios from '../lib/Axios';
import Types from '../Types';

import StoreContentsListItem from '../component/StoreContentsListItem';
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



class StoreHomeStoreListItem extends Component{

  constructor(props){
    super(props);

    this.state = {
      profile_photo_url: '',
      title: '',
      store_user_id: null,
      name: '',

      snsInfoList: [],
      items: []
    }

    this.requestSNSInfo = this.requestSNSInfo.bind(this);
    this.requestItemList = this.requestItemList.bind(this);
  };

  componentDidMount(){
    if(!this.props.store_id){
      alert("스토어 정보가 없음");
      return;
    }

    this.requestStoreInfo();
  };

  componentWillUnmount(){};

  requestStoreInfo(){
    axios.post('/store/any/detail/info', {
      store_alias: this.props.store_alias,
      store_id: this.props.store_id
    }, (result) => {
      this.setState({
        // store_id: result.data.id,
        // store_alias: result.data.alias,
        profile_photo_url: result.data.profile_photo_url,
        // thumb_img_url: result.data.thumb_img_url,
        title: result.data.title,
        store_user_id: result.data.user_id,
        name: result.data.nick_name,
        // store_content: result.data.store_content
      }, function(){
        // this.initData();
        this.initData();
      })
    }, (error) => {

    })
 }

  initData(){
    this.requestSNSInfo();
    this.requestItemList();
  }

  requestSNSInfo(){
    if(!this.state.store_user_id){
      return;
    }

    axios.post("/store/any/sns/list", {
      store_user_id: this.state.store_user_id
    }, (result) => {
      this.setState({
        snsInfoList: result.list.concat()
      })
    }, (error) => {

    })
  }

  requestItemList(){
    axios.post('/store/any/item/list', {
      type: Types.store_home_item_list.IN_ITEM,
      store_id: this.props.store_id
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
  }

  moreClick(e){
    e.preventDefault();
    
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    let goURL = '';
    if(!this.props.store_alias || this.props.store_alias === ''){
      goURL = baseURL + '/store/' + this.props.store_id;
    }else{
      goURL = baseURL + '/store/' + this.props.store_alias;
    }
      
    window.location.href = goURL;
  }

  render(){
    let snsList = [];

    for(let i = 0 ; i < this.state.snsInfoList.length ; i++){
      const item = this.state.snsInfoList[i];

      let gapDom = <></>;
      if(i < this.state.snsInfoList.length - 1){
        gapDom = <div style={{width: 26}}></div>;
        
      }

      const buttomDom = <div key={item.id} className={'sns_img_button_container'}>
                          <button className={'sns_img_button'} onClick={(e) => {this.clickSNS(e, item.link_url)}}>
                            <img className={'sns_img'} src={item.img_store_url} />
                          </button>
                          {gapDom}
                        </div>

      snsList.push(buttomDom);
    }

    let _contentList = [];
    for(let i = 0 ; i < this.state.items.length ; i++){
      const data = this.state.items[i];
      const domObject = <StoreContentsListItem key={i} store_id={data.store_id} id={data.id} store_item_id={data.id} thumbUrl={data.img_url} name={data.nick_name} title={data.title} price={data.price} isHomeList={true} store_alias={data.alias} type={Types.store_home_item_list.IN_ITEM}></StoreContentsListItem>;

      _contentList.push(domObject);
    }

    /*
    snsList = this.state.snsInfoList.map((item) => {
      return <button className={'sns_img_button'} key={item.id} onClick={(e) => {this.clickSNS(e, item.link_url)}}>
              <img className={'sns_img'} src={item.img_store_url} />
            </button>
    })
    */

    return(
      <div className={'StoreHomeStoreListItem'}>
        <div className={'user_thumb_img_container'}>
          <img className={'user_thumb_img'} src={this.state.profile_photo_url} />
        </div>
        <div className={'store_title'}>
          {this.state.title}
        </div>
        <div className={'sns_container'}>
          {snsList}
        </div>

        {_contentList}

        
        <button onClick={(e) => {this.moreClick(e)}} className={'more_button'}>
          상품 더보기 {'>'}
        </button>
        
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
export default StoreHomeStoreListItem;