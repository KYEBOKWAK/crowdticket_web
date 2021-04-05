'use strict';

import React, { Component } from 'react';

import * as AppKeys from '../AppKeys';
// import { connect } from 'react-redux';
// import actions from '../actions/index.js';
// import * as actions from '../actions/index';

import LoginPage from '../pages/LoginPage';

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

    // document.querySelector("#g_login_react").addEventListener("click", this.onClickLogin);
    
  }

  componentWillUnmount(){
    // window.removeEventListener('scroll', this.handleScroll);
    // document.querySelector("#g_login_react").removeEventListener("click", this.onClickLogin);
  };

  onClickLogin = () => {
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      baseURL = baseURLDom.value;
    }

    let goURL = baseURL + '/login';
    window.location.href = goURL;
  }

  // handleScroll = () => {
  //   let navBar = document.querySelector("#navbar_container");
  //   const navFakeBar = document.querySelector("#navbar_fake_dom");

  //   const { top, height } = navBar.getBoundingClientRect();

  //   const fakeTop = navFakeBar.getBoundingClientRect().top;

  //   let _top = (fakeTop) * -1;

  //   if(_top > height){
  //     navBar.style.position = 'fixed';
  //     navBar.style.top = 0;
  //     navBar.style.left = 0;
  //     navBar.style.boxShadow = 0;
  //     navBar.style.zIndex = 1;
  //   }else{
  //     navBar.style.position = 'relative';
  //     navBar.style.top = 0;
  //     navBar.style.left = 0;
  //     navBar.style.boxShadow = '6px 4px 15px 0 rgba(25, 25, 25, 0.05)';
  //     navBar.style.zIndex = 1;
  //   }
  // }
  

  // onClickSearch = () => {
  //   // console.log('adfdsf');
  //   this.setState({
  //     isSearchPage: true
  //   })
  // }

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
    else{
      isNoPage = true;
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

    // let searchPage = <></>;
    // if(this.state.isSearchPage){
    //   searchPage = <SearchPage closeCallback={() => {
    //     this.setState({
    //       isSearchPage: false
    //     })
    //   }}></SearchPage>;
    // }

    if(isNoPage){
      pageController = <></>;
    }

    return (
      <>
        {pageController}
      </>
    );
  }
}

export default PageLoginController;