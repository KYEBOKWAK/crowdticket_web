'use strict';

import React, { Component } from 'react';

import img_logo_facebook from '../res/img/img-logo-facebook.png';
import img_logo_google from '../res/img/img-logo-google.svg';
import img_logo_kakao from '../res/img/img-logo-kakao.svg';

import img_logo_mail from '../res/img/img-logo-mail.svg';

import Types from '../Types';

import { ToastContainer, toast } from 'react-toastify';

import {
  Link
} from "react-router-dom";

import RoutesTypes from '../Routes_types';

import Popup_resetSendMail from '../component/Popup_resetSendMail';
import _axios from 'axios';
import Util from '../lib/Util';

class LoginKnowSNSPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      successPopup: false
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    // if(this.props.sns_array.length === 0){
    //   window.location.href='/auth/login';
    // }

    if(this.props.email === undefined || this.props.email === null || this.props.email === ''){
      window.location.href='/auth/login';
      return;
    }

    if(this.props.sns_is_password){
      toast.dark('비밀번호가 틀렸습니다.', {
        position: "top-center",
        autoClose: 3000,
        hideProgressBar: true,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: undefined,
        });
    }
  };

  componentWillUnmount(){
  };

  componentDidUpdate(){
  }

  onClickSendPassword = (e) => {
    e.preventDefault();

    if(this.props.email === undefined || this.props.email === null || this.props.email === ''){
      alert('이메일 정보가 없습니다. 다시 시도해주세요');
      return;
    }

    showLoadingNoContentPopup();

    var csrfToken = Util.getMeta("csrf-token");
    _axios.post(Util.getBaseURL('/password/email'), {
      email: this.props.email,
      _token: csrfToken
    }).then((result) => {

      stopLoadingPopup();

      const data = result.data;
      if(data.state === 'success'){
        this.setState({
          successPopup: true
        })
      }else{
        alert(data.message);
        return;
      }
    }).catch((error) => {
      stopLoadingPopup();
    })
  }

  render(){

    let img_array = [];
    let content_title = '';
    let content_sub = '';

    if(this.props.sns_array.length === 0){
      content_title = '이미 가입된 계정입니다.';
      content_sub = <div className={'logo_explain_text_box'}>
                      이메일로 다시 로그인하시거나,<br/>
                      계정 정보를 잊으셨다면 비밀번호를 재설정 후 사용해주세요.
                    </div>
      let img_dom = <div className={'logo_img_box'} key={0}>
                      <img className={'logo_img'} src={img_logo_mail} />
                    </div>

      img_array.push(img_dom);

    }
    else{
      let sns_titles = '';

      for(let i = 0 ; i < this.props.sns_array.length ; i++){
        const data = this.props.sns_array[i];
  
        let title_slush = '';
        if(i > 0){
          title_slush = '/';
        }
        
        let imgObject = '';
        if(data === Types.login.facebook){
          imgObject = img_logo_facebook;
          sns_titles = sns_titles + title_slush + '페이스북';
  
        }else if(data === Types.login.google){
          imgObject = img_logo_google;
          sns_titles = sns_titles + title_slush + '구글';
        }else if(data === Types.login.kakao){
          imgObject = img_logo_kakao;
          sns_titles = sns_titles + title_slush + '카카오';
        }
  
        let img_dom = <div className={'logo_img_box'} key={i}>
                        <img className={'logo_img'} src={imgObject} />
                      </div>
  
        img_array.push(img_dom);
      }

      content_title = sns_titles+'으로 가입된 계정입니다.';

      content_sub = <div className={'logo_explain_text_box'}>
                      {sns_titles}으로 다시 로그인하시거나,<br/>
                      이메일로 로그인하기 위해서는 비밀번호를 설정 후 사용해주세요.
                    </div>
    }
    

    let successPopup = <></>;
    if(this.state.successPopup){
      successPopup = <Popup_resetSendMail email={this.props.email} closeCallback={() => {
        this.setState({
          successPopup: false
        })
      }}></Popup_resetSendMail>
    }

    return(
      <div className={'LoginKnowSNSPage'}>
        <div className={'logo_img_container'}>
          {img_array}
        </div>

        <div className={'logo_title_box'}>
          {content_title}
        </div>

        {content_sub}
        {/* <div className={'logo_explain_text_box'}> */}
          
          {/* {sns_titles}으로 다시 로그인하시거나,<br/> */}
          {/* 이메일로 로그인하기 위해서는 비밀번호를 설정 후 사용해주세요. */}
        {/* </div> */}
        
        <div className={'buttons_container'}>
          <Link className={'again_login_button'} to={RoutesTypes.login.home}>
            다시 로그인하기
          </Link>

          <button onClick={(e) => {this.onClickSendPassword(e)}} className={'password_set_button'}>
            비밀번호 설정하기
          </button>
        </div>

        {successPopup}
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

export default LoginKnowSNSPage;