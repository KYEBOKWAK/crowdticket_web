'use strict';

import React, { Component } from 'react';
import _axios from 'axios';
import axios from '../lib/Axios';
import Util from '../lib/Util';

import Popup_resetSendMail from '../component/Popup_resetSendMail';

import Str from '../component/Str';

import StrLib from '../lib/StrLib';
import Storage from '../lib/Storage';
import * as storageType from '../StorageKeys';

class LoginForgetEmailPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      email: this.props.email,
      successPopup: false,

      inputWarningClassName: 'input_warning',
      email_explain_text: '',
      language_code: 'kr'
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

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

  onChangeEmail = (e) => {

    let email_explain_text = '';
    if(e.target.value === ''){
      email_explain_text = StrLib.getStr('s112', this.state.language_code);
    }else{
      if(!Util.isCheckEmailValid(e.target.value)){
        email_explain_text = StrLib.getStr('s108', this.state.language_code);
      }
    }

    this.setState({
      email: e.target.value,
      email_explain_text: email_explain_text
    });
  }

  onClickSendPassword = (e) => {
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

    axios.post('/user/any/email/check/web', {
      email: this.state.email,
    }, (result_email) => {
      var csrfToken = Util.getMeta("csrf-token");
      _axios.post(Util.getBaseURL('/password/email'), {
        email: this.state.email,
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
    }, (error_email) => {
      stopLoadingPopup();
    })
  }

  render(){

    let successPopup = <></>;
    if(this.state.successPopup){
      successPopup = <Popup_resetSendMail email={this.state.email} closeCallback={() => {
        this.setState({
          successPopup: false
        })
      }}></Popup_resetSendMail>
    }

    let email_explain_dom = <></>;
    let email_input_warning_classname = '';
    if(this.state.email_explain_text !== ''){
      email_input_warning_classname = this.state.inputWarningClassName;
      email_explain_dom = <div className={'explain_warning_text'}>
                            {this.state.email_explain_text}
                          </div>
    }

    return(
      <div className={'LoginForgetEmailPage'}>
        <div className={'title_text'}>
          {/* 비밀번호를 잊으셨나요? */}
          <Str strKey={'s110'} />
        </div>
        <div className={'content_text'}>
          {/* 가입하신 이메일 주소를 입력하시면,<br/>
          비밀번호를 재설정할 수 있는 링크를 이메일로 전송해드립니다.<br/> */}
          <Str strKey={'s111'} />
        </div>

        <div className={'input_box_container'}>
          <div className={'input_label'}>
            {/* 이메일 */}
            <Str strKey={'s58'} />
          </div>
          <input className={email_input_warning_classname} type="email" name={'email'} placeholder={StrLib.getStr('s112', this.state.language_code)} value={this.state.email} onBlur={(e) => {this.onChangeEmail(e)}} onChange={(e) => {this.onChangeEmail(e)}} />
          {email_explain_dom}
        </div>

        <button className={'reset_button'} onClick={(e) => {this.onClickSendPassword(e)}}>
          {/* 비밀번호 재설정하기 */}
          <Str strKey={'s113'} />
        </button>
        
        {successPopup}
      </div>
    )
  }
};

LoginForgetEmailPage.defaultProps = {
  email: ''
}

export default LoginForgetEmailPage;