'use strict';

import React, { Component } from 'react';
import _axios from 'axios';
import Util from '../lib/Util';
import axios from '../lib/Axios';

import ic_eye_on from '../res/img/ic-eye-on.svg';
import ic_eye_off from '../res/img/ic-eye-off.svg';

import Login from '../lib/Login';

class LoginJoinPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',

      isShowPassword: false,
      isShowPassword_confirmation: false,

      inputWarningClassName: 'input_warning',

      name_explain_text: '',
      email_explain_text: '',
      password_explain_text: '',
      password_confirm_explain_text: ''
    }
  };

  componentDidMount(){    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  onChangeName = (e) => {
    let name_explain_text = '';
    if(e.target.value === ''){
      name_explain_text = '이름을 입력해주세요';
    }

    this.setState({
      name: e.target.value,
      name_explain_text: name_explain_text
    });
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

  onClickJoinButton = (e) => {
    e.preventDefault();

    if(this.state.name === ''){
      this.setState({
        name_explain_text: '이름을 입력해주세요.'
      })
      return;
    }

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

    axios.post('/user/any/email/join/check/web', {
      email: this.state.email,
    }, (result_email) => {

      if(result_email.id === null){
        _axios.post(Util.getBaseURL('/auth/register'), 
        {
          name: this.state.name,
          nick_name: this.state.name,
          email: this.state.email,
          password: this.state.password,
          password_confirmation: this.state.password_confirmation,
          age: null,
          gender: null,
          ispopup: 'TRUE',
        }).then((result) => {
          const data = result.data;
          if(data.state === 'success'){
            Login.end(data.user_id);
          }else{
            stopLoadingPopup();
            //여기는 laravel 체크
            let errorMessage = '';
            if(data.message.email)
            {
              errorMessage = data.message.email[0];
            }
            else if(data.message.password)
            {
              errorMessage = data.message.password[0];
            }

            alert(errorMessage);
            return;
          }
        }).catch((error) => {
          stopLoadingPopup();
        })
      }else{
        stopLoadingPopup();
        this.props.callbackSnsArray(result_email.sns_array, this.state.email);
      }
    }, (error_email) => {
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

    let name_explain_dom = <></>;
    let name_input_warning_classname = '';
    if(this.state.name_explain_text !== ''){
      name_input_warning_classname = this.state.inputWarningClassName;
      name_explain_dom = <div className={'explain_warning_text'}>
                            {this.state.name_explain_text}
                          </div>
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
      <div className={'LoginJoinPage'}>

        <div className={'page_label_text'}>
          회원가입
        </div>
        <div className={'content_container'}>
          <div className={'input_label'}>
            이름
          </div>
          <input className={name_input_warning_classname} type="text" name={'name'} placeholder={'이름을 입력해주세요.'} value={this.state.name} onChange={(e) => {this.onChangeName(e)}} onBlur={(e) => {this.onChangeName(e)}} />
          {name_explain_dom}

          <div className={'input_label'} style={{marginTop: 16}}>
            이메일
          </div>
          <input className={email_input_warning_classname} type="email" name={'email'} placeholder={'이메일을 입력해주세요.'} value={this.state.email} onChange={(e) => {this.onChangeEmail(e)}} onBlur={(e) => {this.onChangeEmail(e)}} />
          {email_explain_dom}
          
          <div className={'input_label'} style={{marginTop: 16}}>
            비밀번호
          </div>

          <div className={'password_container'}>
            <input className={password_input_warning_classname+' input_password'} type={password_type} name={'password'} placeholder={'비밀번호를 입력해주세요.'} value={this.state.password} onChange={(e) => {this.onChangePassword(e)}} onBlur={(e) => {this.onChangePassword(e)}} />

            <button onClick={(e) => {this.onClickShowPassword(e)}} className={'password_show_button'}>
              <img src={show_password_img} />
            </button>
          </div>

          {password_explain_dom}

          <div className={'input_label'} style={{marginTop: 16}}>
            비밀번호 확인
          </div>

          <div className={'password_container'}>
            <input className={password_confirm_input_warning_classname+' input_password'} type={password_confirm_type} name={'password'} placeholder={'비밀번호를 한 번 더 입력해주세요.'} value={this.state.password_confirmation} onBlur={(e) => {this.onChangePasswordConfirm(e)}} onChange={(e) => {this.onChangePasswordConfirm(e)}} />

            <button onClick={(e) => {this.onClickShowPasswordConfirm(e)}} className={'password_show_button'}>
              <img src={show_password_confirm_img} />
            </button>
          </div>

          {password_confirm_explain_dom}
        </div>
        
        <div className={'buttons_container'}>
          <button className={'set_password_button'} onClick={(e) => {this.onClickJoinButton(e)}}>
            동의하고 회원가입하기
          </button>
        </div>

        <div className={'term_container'}>
          <span className={'term_text'}><a href='/terms' target='_blank'><u>이용약관</u></a></span>과 <span className={'term_text'}><a href='/join_agree' target='_blank'><u>개인정보 수집이용</u></a></span> 내용을 확인하였으며, 이에 동의합니다.
        </div>
      </div>
    )
  }
};

export default LoginJoinPage;

/*
'use strict';

import React, { Component } from 'react';

// import {
//   Link
// } from "react-router-dom";

import _axios from 'axios';
import Util from '../lib/Util';
import Login from '../lib/Login';

class LoginJoinPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      ispopup: 'TRUE',
    }
  };

  componentDidMount(){    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  onClickJoinButton = (e) => {
    e.preventDefault();

    showLoadingNoContentPopup();

    _axios.post(Util.getBaseURL('/auth/register'), 
    {
      name: this.state.name,
      nick_name: this.state.name,
      email: this.state.email,
      password: this.state.password,
      password_confirmation: this.state.password_confirmation,
      age: null,
      gender: null,
      ispopup: 'TRUE',
    }).then((result) => {
      const data = result.data;

      if(data.state === 'success'){

        Login.end(data.user_id);
      }else{
        
        stopLoadingPopup();
        //여기는 laravel 체크
        let errorMessage = '';
        if(data.message.email)
        {
          errorMessage = data.message.email[0];
        }
        else if(data.message.password)
        {
          errorMessage = data.message.password[0];
        }

        alert(errorMessage);
        return;
      }
    }).catch((error) => {

    })
    
  }

  onChangeName = (e) => {
    this.setState({
      name: e.target.value
    })
  }
  onChangeEmail = (e) => {
    this.setState({
      email: e.target.value
    });
  }

  onChangePassword = (e) => {
    this.setState({
      password: e.target.value
    });
  }

  onChangePasswordConfirmation = (e) => {
    this.setState({
      password_confirmation: e.target.value
    });
  }

  render(){
    return(
      <div className={'LoginEmailPage'}>
        <div>
          <input type="text" name={'name'} placeholder={'이름을 입력해주세요'} value={this.state.name} onChange={(e) => {this.onChangeName(e)}} />
        </div>
        <div>
          <input type="email" name={'email'} placeholder={'이메일을 입력해주세요.'} value={this.state.email} onChange={(e) => {this.onChangeEmail(e)}} />
        </div>
        <div>
          <input type="password" name={'password'} placeholder={'비밀번호를 입력해주세요.'} value={this.state.password} onChange={(e) => {this.onChangePassword(e)}} />
        </div>
        <div>
          <input type="password" name={'password_confirmation'} placeholder={'비밀번호를 한 번 더 입력해주세요.'} value={this.state.password_confirmation} onChange={(e) => {this.onChangePasswordConfirmation(e)}} />
        </div>
        
        
        
        <button onClick={(e) => {this.onClickJoinButton(e)}}>
          동의하고 회원가입하기
        </button>
        <div>
          이용약관과 개인정보 수집이용 내용을 확인하였으며, 이에 동의합니다.
        </div>
      </div>
    )
  }
};

export default LoginJoinPage;
*/