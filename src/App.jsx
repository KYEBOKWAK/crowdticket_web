'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

// import TestButton from './component/TestButton';
import PageController from './controllers/PageController';

import { createStore } from 'redux';
import { Provider } from 'react-redux';
import reducers from './reducers';

// import '/css/App.css'
import './res/css/App.css';

import axios from './lib/Axios';

import Storage from './lib/Storage';
import * as storageType from  './StorageKeys';

import * as actions from './actions/index';

// import Templite from './pages/Templite';
import Footer_React from './component/Footer_React';

// import dotEnv from 'dotenv';

// require('dotenv').config()

const store = createStore(reducers);

class App extends Component {
  // loginRectRef = React.createRef();

  constructor(props) {
    super(props);

    this.state = {
      isLoad: false
    }
    // this.requestLoginToken = this.requestLoginToken.bind(this);
  }

  componentDidMount(){

    const myID = Number(document.querySelector('#myId').value);
    if(myID === 0){
      //ID값이 0이면 로그인 안함.
      Storage.load(storageType.REFRESH_TOKEN, (result) => {
        if(result.value){
          //값이 있을때만 api 서버에도 로그아웃 요청
          // console.log(result);
          this.requestLogout(result.value);
        }else{
          //값이 없음
          console.log("이미 로그아웃됨");
        }        
      })      
    }else{
      // axios.post("/user/info", {}, 
      // (result) => {
      //   const data = {
      //     ...result.userInfo
      //   }

      //   store.dispatch(actions.setUserInfo(data.name, data.nick_name, data.contact, data.email, data.user_id));
      // }, (error) => {

      // })
    }
  }
  
  requestLogout(refresh_token){
    axios.post("/user/any/logout", {
      token: refresh_token
    }, function(result){
      Storage.delete(storageType.REFRESH_TOKEN, function(){
        Storage.delete(storageType.ACCESS_TOKEN, function(){

          const baseUrl = document.querySelector('#base_url').value
          window.location.assign(baseUrl+'/auth/logout');
        });
      });
    }, function(error){

    })
  }

  requestLoginToken(user_id, isCallback){
    // console.log("aaaa");
    
    axios.post("/user/any/login", {
      id: user_id,
      push_token: '',
      os: 'web'
    }, function(data){
      // console.log(result);

      if(data.refresh_token){
        Storage.save(storageType.REFRESH_TOKEN, data.refresh_token, (result) => {

          if(data.access_token){
            Storage.save(storageType.ACCESS_TOKEN, data.access_token, (result) => {
              if(isCallback){
                loginCallback();
              }else{
                window.location.reload();
              }
            });
          }else{
            alert("access token error");    
          }

        });
      }else{
        alert("refresh token error");
      }


    }, function(error){
      console.log(error);
    })

    
    // localStorage.setItem('myValueInLocalStorage', 'testtestvalue');
  }

  loginReact(){
    // loginAjaxSuccess({state: 'success'});
    const myID = Number(document.querySelector('#myId').value);
    if(myID === 0){
      //ID값이 0이면 로그인 안함.
      alert("유저 ID가 없습니다.");
    }else{
      this.requestLoginToken(myID, false);
    }
  }

  logoutReact(){
    Storage.load(storageType.REFRESH_TOKEN, (result) => {
      if(result.value){
        //값이 있을때만 api 서버에도 로그아웃 요청
        // console.log(result);
        this.requestLogout(result.value);
      }else{
        //값이 없음
        this.requestLogout(result.value);
      }        
    })
  }

  loginReactCallback(){
    const myID = Number(document.querySelector('#myId').value);
    if(myID === 0){
      //ID값이 0이면 로그인 안함.
      alert("유저 ID가 없습니다.");
    }else{
      this.requestLoginToken(myID, true);
    }
  }

  // FindIE() {
  
  //   var ua = window.navigator.userAgent;
  //   var msie = ua.indexOf("MSIE ");

  //   if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) 
  //   {
  //     alert("크티는 더이상 Internet Explorer를 지원하지 않습니다. 타 브라우저, 모바일을 이용해주세요. Edge로 자동 이동합니다.");
  //     window.location.href = 'microsoft-edge:https://crowdticket.kr/'
  //     // document.write("The Internet Explorer browser is not supported by this site. We suggest you visit the site using supported browsers." + "<A HREF='microsoft-edge:http://<<Your site address..........>>'>Click here to launch the site in the MS Edge browser</A>");
        
  //   }

  //   return false;
  // }

  render() {
    return (
      <Provider store={store}>
        <div className={'login_react'} onClick={() => {this.loginReact()}}>
        </div>
        <div className={'login_react_callback'} onClick={() => { this.loginReactCallback() }}>
        </div>
        <div className={'logout_react'} onClick={() => { this.logoutReact() }}>
        </div>
        <PageController></PageController>
      </Provider>
    );
  }
}

let domContainer = document.querySelector('#react_root');
ReactDOM.render(<App />, domContainer);

let footerContainer = document.querySelector('#react_footer');
ReactDOM.render(<Footer_React />, footerContainer);