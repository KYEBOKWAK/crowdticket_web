'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';
import Util from '../lib/Util';

import StoreUserSNSList from '../component/StoreUserSNSList';
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



class StoreItemDetailPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      store_item_id: null,
      store_id: null,
      store_alias: '',
      typeContent: '',
      title: '',
      price: 0,
      content: '',
      thumb_img_url: '',

      store_title: '',
      store_content: '',
      store_user_profile_photo_url: '',

      item_state: Types.item_state.SALE,
      innerWidth: window.innerWidth
    }

    this.updateDimensions = this.updateDimensions.bind(this);
  };

  updateDimensions(){
    this.setState({
      innerWidth: window.innerWidth
    })
  }

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    const storeItemIDDom = document.querySelector('#store_item_id');
    if(storeItemIDDom){
      this.setState({
        store_item_id: Number(storeItemIDDom.value)
      }, function(){
        //아이템 정보 가져오기
        this.requestItemInfo();
        this.requestStoreInfo();
      })
    }

    window.addEventListener('resize', this.updateDimensions);

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
        thumb_img_url: data.img_url,

        item_state: data.state
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
        store_alias: result.data.alias,
        store_title: result.data.title,
        store_content: result.data.content,
        store_user_profile_photo_url: result.data.profile_photo_url,
      })
    }, (error) => {

    })
  }

  clickOrder(e){
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

  clickGoStore(e){
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }
    
    let tailUrl = this.state.store_alias;
    if(tailUrl === ''){
      tailUrl = this.state.store_id;
    }
    let hrefURL = baseURL+'/store/'+tailUrl;
    
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
                          <div className={'user_info_wrapper'}>
                            <div style={{display: 'flex', alignItems: 'center'}}>
                              <div style={{}}>
                                <img className={'user_img'} src={this.state.store_user_profile_photo_url} />
                              </div>
                              <div className={'store_contents_container'}>
                                <div className={'store_contents_title'}>
                                  {this.state.store_title}
                                </div>
                                <div className={'store_contents_content'}>
                                  {this.state.store_content}
                                </div>
                              </div>
                            </div>
                          </div>
                          <div style={{display: "flex", alignItems: 'flex-start'}}>
                            <StoreUserSNSList store_id={this.state.store_id} inItemDetailPage={true}></StoreUserSNSList>
                          </div>
                        </div>
    }

    let isButtonDisabel = false;
    let buttonText = '주문하기';
    let warningNoticeDom = <></>;
    let isMobile = false;

    if(this.state.innerWidth < 520){
      isMobile = true;
    }

    if(this.state.item_state === Types.item_state.SALE_STOP ||
      this.state.item_state === Types.item_state.SALE_PAUSE){
        isButtonDisabel = true;
        buttonText = '';

        let pauseText = "";
        if(this.state.item_state === Types.item_state.SALE_STOP){
          pauseText = "판매가 중지되었습니다.";
          buttonText = "판매중지";
        }else if(this.state.item_state === Types.item_state.SALE_PAUSE){
          pauseText = "콘텐츠 재 입고 준비 중입니다. 다음에 다시 찾아주세요!";

          buttonText = "준비 중";
        }

        warningNoticeDom = <div className={'warning_notice_dom_container'}>{pauseText}</div>
      }
      // console.log(this.state.item_state)

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

          <div className={'flex_layer'}>
            <button onClick={(e) => {this.clickOrder(e)}} className={'button_pay'} disabled={isButtonDisabel}>
              {buttonText}
            </button>
            <div className={'button_gap'}>
            </div>
            <button onClick={(e) => {this.clickGoStore(e)}} className={'button_go_store'}>
              상점가기
            </button>
          </div>
        </div>
        {warningNoticeDom}
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