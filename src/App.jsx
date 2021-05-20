'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

// import TestButton from './component/TestButton';
import PageController from './controllers/PageController';

// import '/css/App.css'
import './res/css/App.css';

// import Templite from './pages/Templite';
import Footer_React from './component/Footer_React';

import StrLib from './lib/StrLib';
import Storage from './lib/Storage';
import * as storageType from './StorageKeys';

class App extends Component {
  
  constructor(props) {
    super(props);

    this.state = {
      isLoad: false,
      language_code: 'kr'
    }
    
  }

  setTopMenuStr = (strKey, document) => {
    //탑메뉴는 html로 되어 있어서 별도로 셋팅해준다.
    if(document === undefined || document === null){
      return;
    }

    let text = StrLib.getStr(strKey, this.state.language_code);

    document.innerText = text;
  }

  componentDidMount(){

    const languageDom = document.querySelector('#g_language');
    if(languageDom){
      // console.log(baseURLDom.value);
      if(languageDom.value !== ''){
        const language_code = languageDom.value;

        Storage.load(storageType.LANGUAGE_CODE, (result) => {
          if(result.value){
            let language_code_saved = result.value;
            if(language_code !== language_code_saved){
              //언어가 다르면 저장하고 리로드
              Storage.save(storageType.LANGUAGE_CODE, language_code, (result) => {
                //값이 없는데 kr 이 아니면 셋팅 후 재시작 한다.
                window.location.reload();
              });
            }
           
          }else{
            //값이 없음
            Storage.save(storageType.LANGUAGE_CODE, language_code, (result) => {
              //값이 없는데 kr 이 아니면 셋팅 후 재시작 한다.
              if(language_code !== 'kr'){
                window.location.reload();
              }
            });
          }
        })
      }
    }

    this.setLanguageCode();
  }

  setLanguageCode = () => {
    Storage.load(storageType.LANGUAGE_CODE, (result) => {
      let language_code = 'kr';
      if(result.value){
        language_code = result.value;      
      }else{
        //값이 없음 
      }

      this.setState({
        language_code: language_code
      }, () => {
        this.setTopMenuStr('s1', document.getElementById('top_menu_store'));
        this.setTopMenuStr('s2', document.getElementById('top_menu_fanevent'));
        this.setTopMenuStr('s3', document.getElementById('top_menu_magazine'));

        this.setTopMenuStr('s4', document.getElementById('top_side_menu_login'));
        this.setTopMenuStr('s5', document.getElementById('top_side_menu_profile_edit'));
        this.setTopMenuStr('s6', document.getElementById('top_side_menu_my_store'));
        this.setTopMenuStr('s7', document.getElementById('top_side_menu_my_orders'));
        this.setTopMenuStr('s8', document.getElementById('top_side_menu_my_events'));
        this.setTopMenuStr('s9', document.getElementById('top_side_menu_logout'));

        document.getElementById('logo_home_link').addEventListener('click', this.onClickLogoHome);
        document.getElementById('top_menu_store').addEventListener('click', this.onClickStoreMenu);
        document.getElementById('top_menu_fanevent').addEventListener('click', this.onClickProjectMenu);
        document.getElementById('top_menu_magazine').addEventListener('click', this.onClickMagazineMenu);
      })
    })
  }

  onClickLogoHome = () => {
    Storage.load(storageType.LANGUAGE_CODE, (result) => {
      let language_code = 'kr';
      if(result.value){
        language_code = result.value;      
      }else{
        //값이 없음 
      }

      if(language_code === 'en'){
        if(confirm(StrLib.getStr('s144', language_code))){
          window.location.href = '/';
        }else {
          
        }
      }else{
        window.location.href = '/';
      }
    })
  }

  onClickStoreMenu = () => {
    Storage.load(storageType.LANGUAGE_CODE, (result) => {
      let language_code = 'kr';
      if(result.value){
        language_code = result.value;      
      }else{
        //값이 없음 
      }

      if(language_code === 'en'){
        if(confirm(StrLib.getStr('s144', language_code))){
          window.location.href = '/store';
        }else {
        }
      }else{
        window.location.href = '/store';
      }
    })
  }

  onClickMagazineMenu = () => {
    Storage.load(storageType.LANGUAGE_CODE, (result) => {
      let language_code = 'kr';
      if(result.value){
        language_code = result.value;      
      }else{
        //값이 없음 
      }

      if(language_code === 'en'){
        if(confirm(StrLib.getStr('s144', language_code))){
          window.location.href = '/magazine';
        }else {
        }
      }else{
        window.location.href = '/magazine';
      }
    })
  }

  onClickProjectMenu = () => {
    Storage.load(storageType.LANGUAGE_CODE, (result) => {
      let language_code = 'kr';
      if(result.value){
        language_code = result.value;      
      }else{
        //값이 없음 
      }

      if(language_code === 'en'){
        if(confirm(StrLib.getStr('s144', language_code))){
          window.location.href = '/projects';
        }else {
        }
      }else{
        window.location.href = '/projects';
      }
    })
  }

  componentWillUnmount() {
    document.getElementById('logo_home_link').removeEventListener('click', this.onClickLogoHome);
    document.getElementById('top_menu_store').removeEventListener('click', this.onClickStoreMenu);
    document.getElementById('top_menu_fanevent').removeEventListener('click', this.onClickProjectMenu);
    document.getElementById('top_menu_magazine').removeEventListener('click', this.onClickMagazineMenu);
  }

  render() {
    return (
      <div>
        <PageController></PageController>
      </div>
    );
  }
}

let domContainer = document.querySelector('#react_root');
ReactDOM.render(<App />, domContainer);

let footerContainer = document.querySelector('#react_footer');
ReactDOM.render(<Footer_React />, footerContainer);