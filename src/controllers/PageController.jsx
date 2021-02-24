
import React, { Component } from 'react';

import * as AppKeys from '../AppKeys';
import { connect } from 'react-redux';
// import actions from '../actions/index.js';
import * as actions from '../actions/index';

import StoreHome from '../pages/StoreHome';
import StoreManager from '../pages/StoreManager';
import StoreDetailPage from '../pages/StoreDetailPage';
import ReviewWritePage from '../pages/ReviewWritePage';
import StoreItemDetailPage from '../pages/StoreItemDetailPage';
import StoreOrderPage from '../pages/StoreOrderPage';
import StoreOrderComplitePage from '../pages/StoreOrderComplitePage';
import MyContentsPage from '../pages/MyContentsPage';
import StoreAddItemPage from '../pages/StoreAddItemPage';
import StoreDetailReceipt from '../pages/StoreDetailReceipt';
import StoreContentConfirm from '../pages/StoreContentConfirm';

import StoreISPOrderComplitePage from '../pages/StoreISPOrderComplitePage';

import EventPage from '../pages/EventPage';

import StoreHomeOld from '../pages/StoreHome_2021_02_17';

'use strict';

class PageController extends Component {
  
  constructor(props) {
    super(props);
    this.state = { 
      pageKey: AppKeys.WEB_PAGE_KEY_HOME
    };
  }

  componentDidMount(){
    const pageKeyDom = document.querySelector('#app_page_key');
    if(pageKeyDom){
      this.setState({
        pageKey: pageKeyDom.value
      })
    }

    window.addEventListener('scroll', this.handleScroll);

    // document.querySelector("#button_search").addEventListener("click", this.test);
  }

  componentWillUnmount(){
    window.removeEventListener('scroll', this.handleScroll);
    // document.querySelector("#button_search").removeEventListener("click", this.test);
  };

  handleScroll = () => {
    let navBar = document.querySelector("#navbar_container");
    const navFakeBar = document.querySelector("#navbar_fake_dom");

    const { top, height } = navBar.getBoundingClientRect();

    const fakeTop = navFakeBar.getBoundingClientRect().top;

    
    // console.log(fakeTop);

    let _top = (fakeTop) * -1;

    if(_top > height){
      navBar.style.position = 'fixed';
      navBar.style.top = 0;
      navBar.style.left = 0;
      navBar.style.boxShadow = 0;
    }else{
      navBar.style.position = 'relative';
      navBar.style.top = 0;
      navBar.style.left = 0;
      navBar.style.boxShadow = '6px 4px 15px 0 rgba(25, 25, 25, 0.05)';
    }
  }
  

  test = () => {
    console.log('adfdsf');
  }

  render() {
    
    let isNewPage = false;

    let pageView = <></>;
    const _pageKey = this.state.pageKey
    if(_pageKey === AppKeys.WEB_PAGE_KEY_HOME){
      pageView = <></>;
    }else if(_pageKey === AppKeys.WEB_PAGE_KEY_STORE_HOME){
      pageView = <StoreHome></StoreHome>;
      isNewPage = true;
    }
    else if(_pageKey === AppKeys.WEB_PAGE_KEY_STORE_HOME_OLD){
      pageView = <StoreHomeOld></StoreHomeOld>;
    }
    else if(_pageKey === AppKeys.WEB_STORE_PAGE_DETAIL){
      pageView = <StoreDetailPage></StoreDetailPage>;
    }else if(_pageKey === AppKeys.WEB_STORE_PAGE_MANAGER){
      pageView = <StoreManager></StoreManager>;
    }else if(_pageKey === AppKeys.WEB_STORE_REVIEW_WRITE){
      pageView = <ReviewWritePage></ReviewWritePage>;
    }else if(_pageKey === AppKeys.WEB_STORE_ITEM_DETAIL){
      pageView = <StoreItemDetailPage></StoreItemDetailPage>;
    }else if(_pageKey === AppKeys.WEB_STORE_ORDER_PAGE){
      pageView = <StoreOrderPage></StoreOrderPage>;
    }else if(_pageKey === AppKeys.WEB_STORE_ORDER_COMPLITE_PAGE){
      pageView = <StoreOrderComplitePage></StoreOrderComplitePage>;
    }else if(_pageKey === AppKeys.WEB_MY_CONTENTS_PAGE){
      pageView = <MyContentsPage></MyContentsPage>;
    }else if(_pageKey === AppKeys.WEB_STORE_ITEM_ADD_PAGE){
      pageView = <StoreAddItemPage></StoreAddItemPage>;
    }else if(_pageKey === AppKeys.WEB_STORE_DETAIL_RECEIPT){
      pageView = <StoreDetailReceipt></StoreDetailReceipt>;
    }else if(_pageKey === AppKeys.WEB_STORE_CONTENT_CONFIRM){
      pageView = <StoreContentConfirm></StoreContentConfirm>;
    }else if(_pageKey === AppKeys.WEB_STORE_ISP_ORDER_COMPLITE_PAGE){
      pageView = <StoreISPOrderComplitePage></StoreISPOrderComplitePage>;
    }else if(_pageKey === AppKeys.WEB_EVENT_PAGE){
      pageView = <EventPage></EventPage>;
    }

    let pageController = <></>;
    if(isNewPage){
      pageController = <div className={'pageController_home'}>
                        {pageView}
                      </div>
    }else{
      pageController = <div className={'pageController'}>
                        {pageView}
                      </div>
    }

    return (
      <>
        {pageController}
      </>

      // <div className={'pageController'}>
      //   {pageView}
      // </div>
    );
  }
}

export default PageController;