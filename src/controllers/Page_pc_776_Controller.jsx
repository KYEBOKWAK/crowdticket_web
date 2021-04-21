'use strict';

import React, { Component } from 'react';

import * as AppKeys from '../AppKeys';

import WithdrawalPage from '../pages/WithdrawalPage';


class Page_pc_776_Controller extends Component {
  
  constructor(props) {
    super(props);
    this.state = { 
      pageKey: AppKeys.WEB_PAGE_KEY_HOME,

      // isSearchPage: false,
      // isSearchResultPage: false
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

  componentWillUnmount(){
  };

  render() {
    
    let isNewPage = false;
    let isNoPage = false;

    let pageView = <></>;
    const _pageKey = this.state.pageKey

    if(_pageKey == AppKeys.WEB_PAGE_KEY_HOME){
      pageView = <></>;
    }
    else if(_pageKey === AppKeys.WEB_PAGE_WITHDRAWAL){
      pageView = <WithdrawalPage></WithdrawalPage>;
    }
    else{
      isNoPage = true;
    }

    if(isNoPage){
      return (<></>)
    }

    return (
      <div className={'Page_pc_776_Controller'}>
        {pageView}
      </div>
    );
  }
}

export default Page_pc_776_Controller;