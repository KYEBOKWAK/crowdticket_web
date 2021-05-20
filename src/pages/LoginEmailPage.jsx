'use strict';

import React, { Component } from 'react';

import {
  Link
} from "react-router-dom";

import RoutesTypes from '../Routes_types';
// import axios from '../lib/Axios';
import _axios from 'axios';
import axios from '../lib/Axios';
import Util from '../lib/Util';
import Login from '../lib/Login';

import ic_eye_on from '../res/img/ic-eye-on.svg';
import ic_eye_off from '../res/img/ic-eye-off.svg';

import { ToastContainer, toast } from 'react-toastify';

import Str from '../component/Str';
import StrLib from '../lib/StrLib';
import Storage from '../lib/Storage';
import * as storageType from '../StorageKeys';

class LoginEmailPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      email: '',
      password: '',
      isShowPassword: false,

      inputWarningClassName: 'input_warning',

      email_explain_text: '',
      password_explain_text: '',

      language_code: 'kr'
    }
  };

  componentDidMount(){
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

  onClickLogin = (e) => {
    e.preventDefault();

    if(this.state.email === ''){
      this.setState({
        email_explain_text: '이메일을 입력해주세요.'
      })
      return;
    }

    if(!Util.isCheckEmailValid(this.state.email)){
      this.setState({
        email_explain_text: '올바른 이메일 양식이 아닙니다.'
      })
      return;
    }

    if(this.state.password === ''){
      this.setState({
        password_explain_text: '비밀번호를 입력해주세요.'
      })
      return;
    }
    else if(this.state.password.length < 6){
      this.setState({
        password_explain_text: '비밀번호는 6글자 이상 입력해주세요'
      })
      return;
    }

    showLoadingNoContentPopup();

    axios.post('/user/any/login/email/web', {
      email: this.state.email,
      password: this.state.password
    }, (result_user) => {
      if(result_user.state_login === 'success'){
        this.requsetLogin();
      }else{
        stopLoadingPopup();

        let message = result_user.message;
        if(StrLib.getStr('s130', 'kr') === result_user.message){
          message = StrLib.getStr('s130', this.state.language_code);
        }else if(StrLib.getStr('s131', 'kr') === result_user.message){
          message = StrLib.getStr('s131', this.state.language_code);
        }

        toast.dark(message, {
          position: "top-center",
          autoClose: 3000,
          hideProgressBar: true,
          closeOnClick: true,
          pauseOnHover: true,
          draggable: true,
          progress: undefined,
          });

        if(result_user.sns_array.length > 0){
          this.props.callbackSnsArray(result_user.sns_array, this.state.email);
        }
      }

    }, (error_user) => {
      stopLoadingPopup();
    })
  }

  requsetLogin = () => {
    var csrfToken = Util.getMeta("csrf-token");
    _axios.post(Util.getBaseURL('/auth/login'), {
      email: this.state.email,
      password: this.state.password,
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

  onChangeEmail = (e) => {
    let email_explain_text = '';
    if(e.target.value === ''){
      // email_explain_text = '이메일을 입력해주세요';
      email_explain_text = StrLib.getStr('s61', this.state.language_code);
    }else{
      if(!Util.isCheckEmailValid(e.target.value)){
        email_explain_text = StrLib.getStr('s108', this.state.language_code);;
      }
    }

    this.setState({
      email: e.target.value,
      email_explain_text: email_explain_text
    });
  }

  onChangePassword = (e) => {
    let password_explain_text = '';
    if(e.target.value === ''){
      password_explain_text = StrLib.getStr('s107', this.state.language_code);;;
    }else if(e.target.value.length < 6){
      password_explain_text = StrLib.getStr('s109', this.state.language_code);;;
    }

    this.setState({
      password: e.target.value,
      password_explain_text: password_explain_text
    })
  }

  // onClickForgetPassword = (e) => {
  //   e.preventDefault();
  //   // var url = $('#base_url').val() + '/password/email';
  //   let url = Util.getBaseURL('/password/email');
  //   window.location.href = url;
  // }

  onClickShowPassword = (e) => {
    e.preventDefault();

    let isShowPassword = this.state.isShowPassword;
    if(isShowPassword){
      isShowPassword = false;
    }else{
      isShowPassword = true;
    }

    this.setState({
      isShowPassword: isShowPassword
    })
  }

  render(){

    let show_password_img = '';
    let password_type = 'password';
    if(this.state.isShowPassword){
      show_password_img = ic_eye_on;
      password_type = 'text';
    }else{
      show_password_img = ic_eye_off;
      password_type = 'password';
    }

    let email_explain_dom = <></>;
    let email_input_warning_classname = '';
    if(this.state.email_explain_text !== ''){
      email_input_warning_classname = this.state.inputWarningClassName;
      email_explain_dom = <div className={'explain_warning_text'}>
                            {this.state.email_explain_text}
                          </div>
    }

    let password_explain_dom = <></>;
    let password_input_warning_classname = '';
    if(this.state.password_explain_text !== ''){
      password_input_warning_classname = this.state.inputWarningClassName;
      password_explain_dom = <div className={'explain_warning_text'}>
                              {this.state.password_explain_text}
                            </div>
    }

    return(
      <div className={'LoginEmailPage'}>
        <div className={'page_label_text'}>
          {/* 로그인 */}
          <Str strKey={'s102'} />
        </div>
        <div className={'content_container'}>
          <div className={'input_label'}>
            {/* 이메일 */}
            <Str strKey={'s58'} />
          </div>
          <input className={email_input_warning_classname} type="email" name={'email'} placeholder={StrLib.getStr('s61', this.state.language_code)} value={this.state.email} onChange={(e) => {this.onChangeEmail(e)}} onBlur={(e) => {this.onChangeEmail(e)}} />
          {email_explain_dom}
          
          <div className={'input_label'} style={{marginTop: 16}}>
            {/* 비밀번호 */}
            <Str strKey={'s103'} />
          </div>

          <div className={'password_container'}>
            <input className={password_input_warning_classname+' input_password'} type={password_type} name={'password'} placeholder={StrLib.getStr('s107', this.state.language_code)} value={this.state.password} onChange={(e) => {this.onChangePassword(e)}} onBlur={(e) => {this.onChangePassword(e)}} />

            <button onClick={(e) => {this.onClickShowPassword(e)}} className={'password_show_button'}>
              <img src={show_password_img} />
            </button>
          </div>

          {password_explain_dom}
          
          <div className={'forgot_password_text'}>
            <Link to={RoutesTypes.login.forget_email}>
              <u><Str strKey={'s104'} /></u>
            </Link>
          </div>
        </div>
        
        <div className={'buttons_container'}>
          <button className={'login_button'} onClick={(e) => {this.onClickLogin(e)}}><Str strKey={'s105'} /></button>
          
          <Link to={RoutesTypes.login.join}>
            <div className={'join_button'}>
              <Str strKey={'s106'} />
            </div>
          </Link>
        </div>
        

        <ToastContainer 
          position="top-center"
          autoClose={5000}
          hideProgressBar
          newestOnTop={false}
          closeOnClick
          rtl={false}
          pauseOnFocusLoss
          draggable
          pauseOnHover
        />
      </div>
    )
  }
};

export default LoginEmailPage;