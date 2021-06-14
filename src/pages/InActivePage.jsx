'use strict';

import React, { Component } from 'react';
import _axios from 'axios';
import axios from '../lib/Axios';
import Util from '../lib/Util';
import Types from '../Types';

import Login from '../lib/Login';

import Str from '../component/Str';

import StrLib from '../lib/StrLib';
import Storage from '../lib/Storage';
import * as storageType from '../StorageKeys';

import PhoneConfirm from '../component/PhoneConfirm';

class InActivePage extends Component{

  PhoneConfirm_ref = null;

  constructor(props){
    super(props);

    let email = this.props.sns_email;
    if(email === null){
      email = '';
    }
    this.state = {
      email: email,

      inputWarningClassName: 'input_warning',
      email_explain_text: '',
      language_code: 'kr',

      isInit: false
    }

    // console.log(this.props.sns_email);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    if(this.props.sns_id === undefined || this.props.sns_id === null || this.props.sns_id === ''){
      window.location.href='/auth/login';
      return;
    }
    
    this.setLanguageCode();
  };

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
      })
    })
  }

  componentWillUnmount(){
    this.PhoneConfirm_ref = null;
  };

  componentDidUpdate(){
  }

  onChangeEmail = (e) => {

    let email_explain_text = '';
    if(e.target.value === ''){
      email_explain_text = StrLib.getStr('s61', this.state.language_code); //
    }else{
      if(!Util.isCheckEmailValid(e.target.value)){
        email_explain_text = StrLib.getStr('s108', this.state.language_code);  //
      }
    }

    this.setState({
      email: e.target.value,
      email_explain_text: email_explain_text
    });
  }

  requestSNSLogin = (data) => {  

    // showLoadingNoContentPopup();

    var csrfToken = Util.getMeta("csrf-token");

    _axios.post(Util.getBaseURL('/social/gologin'), {
      ...data,
      _token: csrfToken
    }).then((result) => {
      const data = result.data;
      if(data.state === "success"){
        Login.end(data.user_id);
      }else{

      }
    }).catch((error) => {
      stopLoadingPopup();
    })    
  }

  onClickJoin = (e) => {
    e.preventDefault();

    if(!this.PhoneConfirm_ref.getIsCertification()){
      this.PhoneConfirm_ref.setErrorMessageType(Types.input_error_messages.is_confirm_phone);
      return;
    }

    const contact = this.PhoneConfirm_ref.getPhoneNumber();
    const country_code = this.PhoneConfirm_ref.getCountryCode();
    const advertising = this.PhoneConfirm_ref.getAdvertisingAgree();
    
    showLoadingNoContentPopup();

    if(this.props.is_email_login){
      this.requsetLogin();
    }else{
      this.requestSNSLogin({
        'id' : this.props.sns_id,
        'name' : this.props.sns_name,
        'email' : this.state.email,
        'profile_photo_url' : this.props.sns_profile_photo_url,
        'type' : this.props.sns_type,
        'contact' : contact,
        'country_code' : country_code,
        'advertising' : advertising
      });
    }
  }

  requsetLogin = () => {
    const contact = this.PhoneConfirm_ref.getPhoneNumber();
    const country_code = this.PhoneConfirm_ref.getCountryCode();
    const advertising = this.PhoneConfirm_ref.getAdvertisingAgree();

    var csrfToken = Util.getMeta("csrf-token");
    _axios.post(Util.getBaseURL('/auth/login'), {
      email: this.state.email,
      password: this.props.password,
      contact: contact,
      country_code: country_code,
      advertising: advertising,
      _token: csrfToken,
      ispopup: 'TRUE',
      version: 'v1'
    }).then((result) => {
      const data = result.data;
      if(data.state === "success"){
        Login.end(data.user_id);
      }else{

      }
    }).catch((error) => {
      stopLoadingPopup();
    })
  }


  render(){

    return(
      <div className={'InActivePage'}>
        <div className={'title_text'}>
          <Str strKey={'s158'} />
        </div>
        <div className={'content_text'}>
          <Str strKey={'s159'} />
        </div>

        <div className={'input_box_container'}>
          <div className={'input_label'} style={{marginBottom: 4}}>
            <Str strKey={'s147'} />
          </div>
          <PhoneConfirm
            ref={(ref) => {
              this.PhoneConfirm_ref = ref;
            }}
            language_code={this.state.language_code}
            user_id={this.props.user_id}
          ></PhoneConfirm>
        </div>

        <button className={'reset_button'} onClick={(e) => {this.onClickJoin(e)}}>
          <Str strKey={'s160'} />
        </button>
      </div>
    )
  }
};

export default InActivePage;