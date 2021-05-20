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

class LoginSNSSetEmailPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      email: '',

      inputWarningClassName: 'input_warning',
      email_explain_text: '',
      language_code: 'kr'
    }
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
      _token: csrfToken,
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

    if(this.state.email === ''){
      this.setState({
        email_explain_text: StrLib.getStr('s61', this.state.language_code) //
      })
      return;
    }

    if(!Util.isCheckEmailValid(this.state.email)){
      this.setState({
        email_explain_text: StrLib.getStr('s108', this.state.language_code) //
      })
      return;
    }
    
    showLoadingNoContentPopup();

    axios.post('/user/any/check/email/sns/web', {
      email: this.state.email,
    }, (result_email) => {
      if(result_email.id === null){
        //가입 고고
        this.requestSNSLogin({
          'id' : this.props.sns_id,
          'name' : this.props.sns_name,
          'email' : this.state.email,
          'profile_photo_url' : this.props.sns_profile_photo_url,
          'type' : this.props.sns_type
        });
      }else{
        // result_email.sns_array
        stopLoadingPopup();
        if(result_email.sns_array.length === 0){
          alert(StrLib.getStr('s139', this.state.language_code));
          return;
        }

        let sns_titles = '';
        for(let i = 0 ; i < result_email.sns_array.length ; i++){
          const data = result_email.sns_array[i];

          let title_slush = '';
          if(i > 0){
            title_slush = '/';
          }
          
          
          if(data === Types.login.facebook){
            // sns_titles = sns_titles + title_slush + '페이스북';
            sns_titles = sns_titles + title_slush + StrLib.getStr('s140', this.state.language_code);
          }else if(data === Types.login.google){
            sns_titles = sns_titles + title_slush + StrLib.getStr('s141', this.state.language_code);
          }else if(data === Types.login.kakao){
            sns_titles = sns_titles + title_slush + StrLib.getStr('s142', this.state.language_code);
          }
        }

        if(this.state.language_code === 'kr'){
          alert(sns_titles+'로 가입 되어 있는 이메일 입니다. 해당 sns로 로그인 후 설정에서 연동 해주세요');
        }else{
          alert(StrLib.getStr('s143', this.state.language_code) + ' / ' + sns_titles);
        }
        
        return;
      }
    }, (error_email) => {
      stopLoadingPopup();
    })
  }

  render(){
    let email_explain_dom = <></>;
    let email_input_warning_classname = '';
    if(this.state.email_explain_text !== ''){
      email_input_warning_classname = this.state.inputWarningClassName;
      email_explain_dom = <div className={'explain_warning_text'}>
                            {this.state.email_explain_text}
                          </div>
    }

    return(
      <div className={'LoginSNSSetEmailPage'}>
        <div className={'title_text'}>
          <Str strKey={'s136'} />
        </div>
        <div className={'content_text'}>
          <Str strKey={'s137'} />
        </div>

        <div className={'input_box_container'}>
          <div className={'input_label'}>
            <Str strKey={'s58'} />
          </div>
          <input className={email_input_warning_classname} type="email" name={'email'} placeholder={StrLib.getStr('s112', this.state.language_code)} value={this.state.email} onBlur={(e) => {this.onChangeEmail(e)}} onChange={(e) => {this.onChangeEmail(e)}} />
          {email_explain_dom}
        </div>

        <button className={'reset_button'} onClick={(e) => {this.onClickJoin(e)}}>
          <Str strKey={'s138'} />
        </button>
        
      </div>
    )
  }
};

export default LoginSNSSetEmailPage;