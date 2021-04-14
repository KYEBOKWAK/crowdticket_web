'use strict';

import React, { Component } from 'react';
import _axios from 'axios';
import Util from '../lib/Util';
import axios from '../lib/Axios';

import ic_eye_on from '../res/img/ic-eye-on.svg';
import ic_eye_off from '../res/img/ic-eye-off.svg';

class LoginResetPasswordPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      email: '',
      password: '',
      password_confirmation: '',

      isShowPassword: false,
      isShowPassword_confirmation: false,

      inputWarningClassName: 'input_warning',

      email_explain_text: '',
      password_explain_text: '',
      password_confirm_explain_text: ''
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  onChangeEmail = (e) => {

    let email_explain_text = '';
    if(e.target.value === ''){
      email_explain_text = '이메일을 입력해주세요';
    }else{
      if(!Util.isCheckEmailValid(e.target.value)){
        email_explain_text = '올바른 이메일 양식이 아닙니다.';
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
      password_explain_text = '비밀번호를 입력해주세요';
    }else if(e.target.value.length < 6){
      password_explain_text = '비밀번호는 6글자 이상 입력해주세요';
    }

    this.setState({
      password: e.target.value,
      password_explain_text: password_explain_text
    });
  }

  onChangePasswordConfirm = (e) => {

    let password_confirm_explain_text = '';

    if(e.target.value === ''){

    }
    else if(e.target.value !== this.state.password){
      password_confirm_explain_text = '비밀번호가 다릅니다.';
    }

    this.setState({
      password_confirmation: e.target.value,
      password_confirm_explain_text: password_confirm_explain_text
    });
  }

  onClickSetPassword = (e) => {
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

    if(this.state.password !== this.state.password_confirmation){
      this.setState({
        password_confirm_explain_text: '비밀번호가 다릅니다. 다시 입력해주세요.'
      })
      return;
    }

    showLoadingNoContentPopup();

    axios.post('/user/any/email/check/web', {
      email: this.state.email
    }, (result_email) => {
      //비번 셋팅 하는 곳 작업
      var csrfToken = Util.getMeta("csrf-token");

      const token = document.querySelector('#password_reset_token').value;

      _axios.post(Util.getBaseURL('/password/reset'), {
        _token: csrfToken,
        token: token,
        email: this.state.email,
        password: this.state.password,
        password_confirmation: this.state.password_confirmation
      }).then((result) => {
        stopLoadingPopup();
        const data = result.data;
        if(data.state === 'success'){
          swal('변경완료!', '', 'success').then(() => {
            if(this.props.email_reset){
              window.location.href = Util.getBaseURL();
            }
          }).catch((error) => {
          })
          
          
        }else{
          alert(data.message);
          return;
        }
      }).catch((error) => {
        alert('에러! 비밀번호가 일치하지 않거나 이메일이 다릅니다');
        stopLoadingPopup();
        return;
      })

    }, (result_error) => {
      stopLoadingPopup();
    })
  }

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

  onClickShowPasswordConfirm = (e) => {
    e.preventDefault();

    let isShowPassword_confirmation = this.state.isShowPassword_confirmation;
    if(isShowPassword_confirmation){
      isShowPassword_confirmation = false;
    }else{
      isShowPassword_confirmation = true;
    }

    this.setState({
      isShowPassword_confirmation: isShowPassword_confirmation
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

    let show_password_confirm_img = '';
    let password_confirm_type = 'password';
    if(this.state.isShowPassword_confirmation){
      show_password_confirm_img = ic_eye_on;
      password_confirm_type = 'text';
    }else{
      show_password_confirm_img = ic_eye_off;
      password_confirm_type = 'password';
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

    let password_confirm_explain_dom = <></>;
    let password_confirm_input_warning_classname = '';
    if(this.state.password_confirm_explain_text !== ''){
      password_confirm_input_warning_classname = this.state.inputWarningClassName;
      password_confirm_explain_dom = <div className={'explain_warning_text'}>
                                      {this.state.password_confirm_explain_text}
                                    </div>
    }

    return(
      <div className={'LoginResetPasswordPage'}>

        <div className={'page_label_text'}>
          비밀번호 변경
        </div>
        <div className={'content_container'}>
          <div className={'input_label'}>
            이메일
          </div>
          <input className={email_input_warning_classname} type="email" name={'email'} placeholder={'이메일을 입력해주세요.'} value={this.state.email} onBlur={(e) => {this.onChangeEmail(e)}} onChange={(e) => {this.onChangeEmail(e)}} />
          {email_explain_dom}
          
          <div className={'input_label'} style={{marginTop: 16}}>
            비밀번호
          </div>

          <div className={'password_container'}>
            <input className={password_input_warning_classname+' input_password'} type={password_type} name={'password'} placeholder={'비밀번호를 입력해주세요.'} value={this.state.password} onBlur={(e) => {this.onChangePassword(e)}} onChange={(e) => {this.onChangePassword(e)}} />

            <button onClick={(e) => {this.onClickShowPassword(e)}} className={'password_show_button'}>
              <img src={show_password_img} />
            </button>
          </div>

          {password_explain_dom}

          <div className={'input_label'} style={{marginTop: 16}}>
            비밀번호 확인
          </div>

          <div className={'password_container'}>
            <input className={password_confirm_input_warning_classname+' input_password'} type={password_confirm_type} name={'password'} placeholder={'비밀번호를 한 번 더 입력해주세요.'} value={this.state.password_confirmation} onChange={(e) => {this.onChangePasswordConfirm(e)}} onBlur={(e) => {this.onChangePasswordConfirm(e)}} />

            <button onClick={(e) => {this.onClickShowPasswordConfirm(e)}} className={'password_show_button'}>
              <img src={show_password_confirm_img} />
            </button>
          </div>

          {password_confirm_explain_dom}
        </div>
        
        <div className={'buttons_container'}>
          <button className={'set_password_button'} onClick={(e) => {this.onClickSetPassword(e)}}>
            비밀번호 변경하기
          </button>
        </div>
      </div>
    )
  }
};

LoginResetPasswordPage.defaultProps = {
  email_reset: false
}

export default LoginResetPasswordPage;