'use strict';

import React, { Component } from 'react';


import {
  Link
} from "react-router-dom";

//img-sign-mail.svg
import ic_img_sign_mail from '../res/img/img-sign-mail.svg';

import ic_img_sign_google from '../res/img/img-sign-google.svg';
import ic_img_sign_kakao from '../res/img/img-sign-kakao.svg';
import ic_img_sign_facebook from '../res/img/img-sign-facebook.png';

import RoutesTypes from '../Routes_types';

import Login from '../lib/Login';
import Util from '../lib/Util';
import _axios from 'axios';
import axios from '../lib/Axios';

class LoginStartPage extends Component{

  auth2 = null;

  constructor(props){
    super(props);

    this.state = {
    }
  };

  componentDidMount(){
    this.facebookLibInit();
    this.googleLibInit();
  };

  facebookLibInit = () => {
    let facebook_app_id = process.env.REACT_APP_FACEBOOK_ID_REAL;
    let facebook_app_ver = process.env.REACT_APP_FACEBOOK_VER_REAL;
    const app_type_key = document.querySelector('#g_app_type');
    if(app_type_key){
      if(app_type_key.value === 'local'){
        facebook_app_id = process.env.REACT_APP_FACEBOOK_ID_LOCAL;
        facebook_app_ver = process.env.REACT_APP_FACEBOOK_VER_LOCAL;
      }else if(app_type_key.value === 'qa'){
        facebook_app_id = process.env.REACT_APP_FACEBOOK_ID_QA;
        facebook_app_ver = process.env.REACT_APP_FACEBOOK_VER_QA;
      }
    }

    window.fbAsyncInit = function() {
      FB.init({
        appId      : facebook_app_id,
        cookie     : true,  // enable cookies to allow the server to access
                            // the session
        xfbml      : true,  // parse social plugins on this page
        version    : facebook_app_ver // use graph api version 2.8
      });
  
      FB.getLoginStatus(function(response) {
          //console.error(response);
      });
  
    };
  
    // Load the SDK asynchronously
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  }

  googleLibInit = () => {
    setTimeout( () => {
      let google_app_id = process.env.REACT_APP_GOOGLE_ID_REAL;
      
      const app_type_key = document.querySelector('#g_app_type');
      if(app_type_key){
        if(app_type_key.value === 'local'){
          google_app_id = process.env.REACT_APP_GOOGLE_ID_LOCAL;
        }else if(app_type_key.value === 'qa'){
          google_app_id = process.env.REACT_APP_GOOGLE_ID_QA;
        }
      }

      gapi.load('auth2', () => {
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        this.auth2 = gapi.auth2.init({
          client_id: google_app_id,
          cookiepolicy: 'single_host_origin',
          // Request scopes in addition to 'profile' and 'email'
          //scope: 'additional_scope'
        });
        
        var userAgent = window.navigator.userAgent;
        var isKakao = userAgent.indexOf('KAKAOTALK');
        if(isKakao > 0)
        {
          // alert('카카오톡 브라우저에선 구글 로그인이 불가능합니다.');
          return;
        }else{
          this.attachSignin(document.getElementById('login_social_google_react_button'));
        }
        
          // attachSignin(document.getElementsByClassName('login_social_google_react_button'));
      });
    }, 100);
  }

  attachSignin = (element) => {
    // var userAgent = window.navigator.userAgent;
    // var isKakao = userAgent.indexOf('KAKAOTALK');
    // //alert(isKakao);
    // if(isKakao > 0)
    // {
    //   alert('카카오톡 브라우저에선 구글 로그인이 불가능합니다.');
    //   return;
    // }

    this.auth2.attachClickHandler(element, {},
    (googleUser) => {
      const socialId = googleUser.getBasicProfile().getId();
      const socialName = googleUser.getBasicProfile().getName();
      const socialEmail = googleUser.getBasicProfile().getEmail();
      const socialPhotoUrl = googleUser.getBasicProfile().getImageUrl();;

      //console.error(socialId + socialName + socialEmail + " | " + socialPhotoUrl);

      this.requestSNSLogin({
        'id' : socialId,
        'name' : socialName,
        'email' : socialEmail,
        'profile_photo_url' : socialPhotoUrl,
        'type' : 'GOOGLE'
      });

    }, (error) => {
      //alert(JSON.stringify(error, undefined, 2));
    });
  }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  fbStatusChangeCallback = (response) => {
    console.log(response);
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
  
      const url = '/me?fields=id,name,email';
      FB.api(url, (responseMe) => {

        const socialId = responseMe.id;
        const socialName = responseMe.name;
        const socialEmail = responseMe.email;
        const socialPhotoUrl = "https://graph.facebook.com/"+socialId+"/picture?type=normal";
  
        if(socialEmail === undefined || socialEmail === null || socialEmail === ''){
          //email이 없을때 //가입되어 있는지 확인한다.

          axios.post('/user/any/check/snsid', {
            sns_id: socialId,
            sns_type : 'FACEBOOK'
          }, (result_user) => {
            if(result_user.id === null){
              this.props.callbackNoEmail({
                'id' : socialId,
                'name' : socialName,
                'email' : null,
                'profile_photo_url' : socialPhotoUrl,
                'type' : 'FACEBOOK'
              })
            }else{
              this.requestSNSLogin({
                'id' : socialId,
                'name' : socialName,
                'email' : socialEmail,
                'profile_photo_url' : socialPhotoUrl,
                'type' : 'FACEBOOK'
              });
            }
          }, (error_user) => {

          })
          
        }else{
          this.requestSNSLogin({
            'id' : socialId,
            'name' : socialName,
            'email' : socialEmail,
            'profile_photo_url' : socialPhotoUrl,
            'type' : 'FACEBOOK'
          });
        } 
      });
  
    } else {
      // The person is not logged into your app or we are unable to tell.
      FB.login((response) => {
        if (response.status === 'connected') {
          this.fbStatusChangeCallback(response);
        }
      }, {scope: 'id,name,email'});
    }
  }

  onClickKakaoLogin = (e) => {
    e.preventDefault();

    Kakao.Auth.login({
      success: (authObj) => {
        Kakao.API.request({
          url: '/v2/user/me',
          success: (res) => {
            let profile_photo_url = res.kakao_account.profile.thumbnail_image_url;
            if(profile_photo_url === undefined){
              profile_photo_url = null;
            }

            let name = res.kakao_account.profile.nickname;
            if(name === undefined){
              name = '';
            }

            if(!res.kakao_account.has_email || res.kakao_account.email === undefined || res.kakao_account.email === null || res.kakao_account.email === ''){
              //email이 없을때
              axios.post('/user/any/check/snsid', {
                sns_id: res.id,
                sns_type : 'KAKAO'
              }, (result_user) => {
                if(result_user.id === null){
                  this.props.callbackNoEmail({
                    'id' : res.id,
                    'name' : name,
                    'email' : null,
                    'profile_photo_url' : profile_photo_url,
                    'type' : 'KAKAO'
                  })
                }else{
                  this.requestSNSLogin({
                    'id' : res.id,
                    'name' : name,
                    'email' : res.kakao_account.email,
                    'profile_photo_url' : profile_photo_url,
                    'type' : 'KAKAO'
                  });
                }
              }, (error_user) => {
    
              })

            }else{
              this.requestSNSLogin({
                'id' : res.id,
                'name' : name,
                'email' : res.kakao_account.email,
                'profile_photo_url' : profile_photo_url,
                'type' : 'KAKAO'
              });
            }
          },
          fail: (error) => {
            alert(
              'login success, but failed to request user information: ' +
                JSON.stringify(error)
            )
          },
        })
      },
      fail: function(err) {
        alert(JSON.stringify(err))
      },
    })
  }

  onClickGoogleLogin = (e) => {
    e.preventDefault();
    var userAgent = window.navigator.userAgent;
    var isKakao = userAgent.indexOf('KAKAOTALK');
    if(isKakao > 0)
    {
      alert('카카오톡 브라우저에선 구글 로그인이 불가능합니다.');
      return;
    }
  }

  requestSNSLogin = (data) => {  

    showLoadingNoContentPopup();

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

  onClickFacebookLogin = (e) => {
    e.preventDefault();

    // startFacebookLogin();
    FB.getLoginStatus( (response) => {
      this.fbStatusChangeCallback(response);
    });
  }

  render(){

    return(
      <div className={'LoginStartPage'}>
        <div className={'title_text'}>
          반갑습니다!<br/>
          지금 크티를 시작해볼까요?
        </div>
        <div className={'sns_buttons_container'}>
          <div>
            <button className={'sns_buttons sns_kakao_button'} onClick={(e) => {this.onClickKakaoLogin(e)}}>
              <img className={'sns_kakao_img'} src={ic_img_sign_kakao} />
              <div className={'sns_text'}>
                카카오로 빠르게 시작하기
              </div>
            </button>
          </div>
          <div>
            <button className={'sns_buttons sns_google_button'} id={'login_social_google_react_button'} onClick={(e) => {this.onClickGoogleLogin(e)}}>
              <img className={'sns_google_img'} src={ic_img_sign_google} />
              <div className={'sns_text'}>
                구글로 빠르게 시작하기
              </div>
            </button>
          </div>
          <div>
            <button className={'sns_buttons sns_facebook_button'} onClick={(e) => {this.onClickFacebookLogin(e)}}>
              <img className={'sns_facebook_img'} src={ic_img_sign_facebook} />
              <div className={'sns_text'}>
                페이스북으로 빠르게 시작하기
              </div>
            </button>
          </div>
          <Link className={'sns_buttons sns_email_button'} to={RoutesTypes.login.email}>
            <img className={'sns_email_img'} src={ic_img_sign_mail} />
            <div className={'sns_text'}>
              이메일로 시작하기
            </div>
          </Link>
        </div>
        
        <div className={'term_container'}>
          <span className={'term_text'}><a href='/terms' target='_blank'><u>이용약관</u></a></span>과 <span className={'term_text'}><a href='/join_agree' target='_blank'><u>개인정보 수집이용</u></a></span> 내용을 확인하였으며, 이에 동의합니다.
        </div>
      </div>
    )
  }
};

export default LoginStartPage;