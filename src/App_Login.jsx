'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import PageLoginController from './controllers/PageLoginController';

import './res/css/App.css';

import axios from './lib/Axios';

import Storage from './lib/Storage';
import * as storageType from  './StorageKeys';

import Util from './lib/Util';
// import Footer_React from './component/Footer_React';

class App_Login extends Component {
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
          // console.log("이미 로그아웃됨");
        }        
      })      
    }else{
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
                //이거는 이전 로그인 팝업 형식이 팬 이벤트에도 남아있어서 남겨둠
                loginCallback();
              }else{
                // redirectURL
                const redirectURLDom = document.querySelector('#redirectURL');
                if(redirectURLDom){
                  if(redirectURLDom.value === ''){
                    window.location.href = Util.getBaseURL();
                  }else{
                    window.location.href = redirectURLDom.value;
                  }
                }else{
                  window.location.href = Util.getBaseURL();
                }
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

  render() {
    return (
      <div>
        <div className={'login_react'} onClick={() => {this.loginReact()}}>
        </div>
        <div className={'login_react_callback'} onClick={() => { this.loginReactCallback() }}>
        </div>
        <div className={'logout_react'} onClick={() => { this.logoutReact() }}>
        </div>
        <PageLoginController></PageLoginController>
      </div>
    );
  }
}

let domContainer = document.querySelector('#react_app_login');
ReactDOM.render(<App_Login />, domContainer);

// let footerContainer = document.querySelector('#react_footer');
// ReactDOM.render(<Footer_React />, footerContainer);