
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
  }

  render() {
    
    let pageView = <></>;
    const _pageKey = this.state.pageKey
    if(_pageKey === AppKeys.WEB_PAGE_KEY_HOME){
      pageView = <></>;
    }else if(_pageKey === AppKeys.WEB_PAGE_KEY_STORE_HOME){
      pageView = <StoreHome></StoreHome>;
    }else if(_pageKey === AppKeys.WEB_STORE_PAGE_DETAIL){
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

    return (
      <>
      <div className={'pageController'}>
        {pageView}
      </div>
      </>
    );
  }
}

export default PageController;