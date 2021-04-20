'use strict';

import React, { Component } from 'react';
import _axios from 'axios';
import axios from '../lib/Axios';
import Util from '../lib/Util';
import Types from '../Types';

import Login from '../lib/Login';

class LoginSNSSetEmailPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      email: '',

      inputWarningClassName: 'input_warning',
      email_explain_text: '',
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
          alert('이미 가입되어 있는 이메일 입니다. 이메일로 로그인 후 SNS를 연동 해주세요.');
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
            sns_titles = sns_titles + title_slush + '페이스북';
          }else if(data === Types.login.google){
            sns_titles = sns_titles + title_slush + '구글';
          }else if(data === Types.login.kakao){
            sns_titles = sns_titles + title_slush + '카카오';
          }
        }

        alert(sns_titles+'로 가입 되어 있는 이메일 입니다. 해당 sns로 로그인 후 설정에서 연동 해주세요');
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
          이메일만 입력하면 가입 완료!
        </div>
        <div className={'content_text'}>
          입력하신 이메일로 필수 콘텐츠 정보 및 주문 내역을 안내드립니다.
        </div>

        <div className={'input_box_container'}>
          <div className={'input_label'}>
            이메일
          </div>
          <input className={email_input_warning_classname} type="email" name={'email'} placeholder={'가입하신 이메일을 입력해주세요.'} value={this.state.email} onBlur={(e) => {this.onChangeEmail(e)}} onChange={(e) => {this.onChangeEmail(e)}} />
          {email_explain_dom}
        </div>

        <button className={'reset_button'} onClick={(e) => {this.onClickJoin(e)}}>
          회원가입하기
        </button>
        
      </div>
    )
  }
};

export default LoginSNSSetEmailPage;