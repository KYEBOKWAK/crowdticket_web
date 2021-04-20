'use strict';

import React, { Component } from 'react';

import * as AppKeys from '../AppKeys';

import LoginPage from '../pages/LoginPage';
import LoginResetPasswordPage from '../pages/LoginResetPasswordPage';
import PasswordResetPage from '../pages/PasswordResetPage';

import Login from '../lib/Login';



// import Storage from './lib/Storage';
// import * as storageType from  './StorageKeys';

class PageLoginController extends Component {
  
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

    // window.addEventListener('scroll', this.handleScroll);

    document.querySelector("#g_go_login_react").addEventListener("click", this.onGoLogin);

    const login_button_dom = document.querySelector('#g_login');
    if(login_button_dom){
      login_button_dom.addEventListener("click", this.onClickLogin);
    }
  }

  componentWillUnmount(){
    // window.removeEventListener('scroll', this.handleScroll);
    document.querySelector("#g_go_login_react").removeEventListener("click", this.onGoLogin);

    const login_button_dom = document.querySelector('#g_login');
    if(login_button_dom){
      login_button_dom.removeEventListener("click", this.onClickLogin);
    }
  };

  onGoLogin = () => {
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      baseURL = baseURLDom.value;
    }

    //기존 auth/login과 겹치는데 해결방법을 찾아야함.
    let goURL = baseURL + '/auth/login';
    window.location.href = goURL;
  }

  onClickLogin = () => {
    Login.start();
  }

  render() {
    
    let isNewPage = false;
    let isNoPage = false;

    let pageView = <></>;
    const _pageKey = this.state.pageKey

    if(_pageKey == AppKeys.WEB_PAGE_KEY_HOME){
      pageView = <></>;
    }
    if(_pageKey === AppKeys.WEB_PAGE_LOGIN){
      pageView = <LoginPage></LoginPage>;
    }
    else if(_pageKey === AppKeys.WEB_PAGE_PASSWORD_RESET_EMAIL){
      pageView = <LoginResetPasswordPage email_reset={true}></LoginResetPasswordPage>
    }
    else if(_pageKey === AppKeys.WEB_PAGE_PASSWORD_RESET) {
      pageView = <PasswordResetPage></PasswordResetPage>
    }
    else{
      isNoPage = true;
    }

    // let searchPage = <></>;
    // if(this.state.isSearchPage){
    //   searchPage = <SearchPage closeCallback={() => {
    //     this.setState({
    //       isSearchPage: false
    //     })
    //   }}></SearchPage>;
    // }

    if(isNoPage){
      return (<></>)
    }

    return (
      <div className={'PageLoginController'}>
        {pageView}
      </div>
    );
  }
}

export default PageLoginController;