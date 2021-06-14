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

class LoginSNSSetEmailPage extends Component{

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

    if(this.props.sns_email === undefined || this.props.sns_email === null || this.props.sns_email === ''){
      this.setState({
        isInit: true
      })
    }else{
      //이메일이 있으면 가입 되어 있는지 확인한다.
      axios.post('/user/any/check/email/sns/web', {
        email: this.props.sns_email,
      }, (result_email) => {
        if(result_email.id === null){
          //가입 고고
          this.setState({
            isInit: true
          })
        }else{
          // result_email.sns_array
          // stopLoadingPopup();
          if(result_email.sns_array.length === 0){
            alert(StrLib.getStr('s139', this.state.language_code));
            window.history.back();
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

          window.history.back();
          
          return;
        }
      }, (error_email) => {
        // stopLoadingPopup();
      })
    }
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
      _token: csrfToken,
      is_certification: true,
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

    const contact = this.PhoneConfirm_ref.getPhoneNumber();
    const country_code = this.PhoneConfirm_ref.getCountryCode();
    const advertising = this.PhoneConfirm_ref.getAdvertisingAgree();
    
    showLoadingNoContentPopup();

    if(this.props.sns_email === undefined || this.props.sns_email === null || this.props.sns_email === ''){
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
            'type' : this.props.sns_type,
            'contact' : contact,
            'country_code' : country_code,
            'advertising' : advertising
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
  
  /*
  onClickJoin = (e) => {
    e.preventDefault();

    if(!this.PhoneConfirm_ref.getIsCertification()){
      this.PhoneConfirm_ref.setErrorMessageType(Types.input_error_messages.is_confirm_phone);
      return;
    }

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

    const contact = this.PhoneConfirm_ref.getPhoneNumber();
    const country_code = this.PhoneConfirm_ref.getCountryCode();
    const advertising = this.PhoneConfirm_ref.getAdvertisingAgree();
    
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
  */

  render(){

    let hideScreen = <></>;
    if(!this.state.isInit){
      hideScreen = <div style={{backgroundColor: 'white', position: 'absolute', top: 0, left: 0, right: 0, bottom: 0, zIndex: 1}}></div>
    }

    let email_explain_dom = <></>;
    let email_input_warning_classname = '';
    if(this.state.email_explain_text !== ''){
      email_input_warning_classname = this.state.inputWarningClassName;
      email_explain_dom = <div className={'explain_warning_text'}>
                            {this.state.email_explain_text}
                          </div>
    }

    let emailInputDom = <></>;
    let PhoneConfirmDomStyle = {};
    if(this.props.sns_email === null){
      PhoneConfirmDomStyle = {
        marginTop: 16
      }
      emailInputDom = <div className={'input_box_container'}>
                        <div className={'input_label'}>
                          <Str strKey={'s58'} />
                        </div>
                        <input className={email_input_warning_classname} type="email" name={'email'} placeholder={StrLib.getStr('s112', this.state.language_code)} value={this.state.email} onBlur={(e) => {this.onChangeEmail(e)}} onChange={(e) => {this.onChangeEmail(e)}} />
                        {email_explain_dom}
                      </div>
    }else{
      PhoneConfirmDomStyle = {
        
      };
    }

    let PhoneConfirmDom = <div style={PhoneConfirmDomStyle} className={'input_box_container'}>
                            <div className={'input_label'} style={{marginBottom: 4}}>
                              <Str strKey={'s147'} />
                            </div>
                            <PhoneConfirm
                              ref={(ref) => {
                                this.PhoneConfirm_ref = ref;
                              }}
                              language_code={this.state.language_code}
                            ></PhoneConfirm>
                          </div>
    

    return(
      <div className={'LoginSNSSetEmailPage'}>
        <div className={'title_text'}>
          <Str strKey={'s136'} />
        </div>
        <div className={'content_text'}>
          <Str strKey={'s137'} />
        </div>

        {emailInputDom}
        {PhoneConfirmDom}
        {/* <div className={'input_box_container'}>
          <div className={'input_label'}>
            <Str strKey={'s58'} />
          </div>
          <input className={email_input_warning_classname} type="email" name={'email'} placeholder={StrLib.getStr('s112', this.state.language_code)} value={this.state.email} onBlur={(e) => {this.onChangeEmail(e)}} onChange={(e) => {this.onChangeEmail(e)}} />
          {email_explain_dom}
        </div> */}

        <button className={'reset_button'} onClick={(e) => {this.onClickJoin(e)}}>
          <Str strKey={'s138'} />
        </button>
        
        {hideScreen}
      </div>
    )
  }
};

export default LoginSNSSetEmailPage;