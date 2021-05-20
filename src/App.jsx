'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

// import TestButton from './component/TestButton';
import PageController from './controllers/PageController';

// import '/css/App.css'
import './res/css/App.css';

// import Templite from './pages/Templite';
import Footer_React from './component/Footer_React';

import Storage from './lib/Storage';
import * as storageType from './StorageKeys';
import language from './res/json/language/language.json';

class App extends Component {
  
  constructor(props) {
    super(props);

    this.state = {
      isLoad: false
    }
    
  }

  setTopMenuStr = (strKey, document) => {
    //탑메뉴는 html로 되어 있어서 별도로 셋팅해준다.
    if(document === undefined || document === null){
      return;
    }

    Storage.load(storageType.LANGUAGE_CODE, (result) => {
      let language_code = 'kr';
      if(result.value){
        language_code = result.value;      
      }else{
        //값이 없음 
      }
 
      const stringKey = strKey;
      let text = stringKey;
 
      if(stringKey === ''){
       text = '##EMPTY##';
      }
      else if(language[stringKey] === undefined){
       text = stringKey;
      }else if(language[stringKey][language_code] === undefined || language[stringKey][language_code] === null){
       text = stringKey;
      }else{
       text = language[stringKey][language_code];
      }
      
      document.innerText = text+'('+strKey+')';
    })
  }

  componentDidMount(){
    // let language_code = 'kr'

    this.setTopMenuStr('s1', document.getElementById('top_menu_store'));
    this.setTopMenuStr('s2', document.getElementById('top_menu_fanevent'));
    this.setTopMenuStr('s3', document.getElementById('top_menu_magazine'));

    this.setTopMenuStr('s4', document.getElementById('top_side_menu_login'));
    this.setTopMenuStr('s5', document.getElementById('top_side_menu_profile_edit'));
    this.setTopMenuStr('s6', document.getElementById('top_side_menu_my_store'));
    this.setTopMenuStr('s7', document.getElementById('top_side_menu_my_orders'));
    this.setTopMenuStr('s8', document.getElementById('top_side_menu_my_events'));
    this.setTopMenuStr('s9', document.getElementById('top_side_menu_logout'));


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