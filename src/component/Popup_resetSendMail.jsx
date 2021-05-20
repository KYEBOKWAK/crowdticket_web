'use strict';

import React, { Component, createRef } from 'react';

// import Quill from 'quill';

import ic_close from '../res/img/ic-close.svg';

import Str from '../component/Str';

class Popup_resetSendMail extends Component{
  // _quill = null;

  constructor(props){
    super(props);

    this.state = {
    }
  };

  componentDidMount(){
    ScrollLock();
  };

  componentWillUnmount(){
    ScrollUnLock();
  };

  componentDidUpdate(){
    
  }

  onClickExit = (e) => {
    e.preventDefault();

    // let targetElement = document.querySelector('#react_root');
    // enableBodyScroll(targetElement);

    this.props.closeCallback();
  }

  render(){

    return(
      <div className={'Popup_resetSendMail'}>
        <div className={'bg_container'}>
          <div className={'title_text'}>
            {/* 비밀번호 설정 링크 전송 완료! */}
            <Str strKey={'s120'} />
          </div>
          <div className={'content_text'}>
            {/* 가입하신 이메일로 비밀번호 설정 링크가 전송되었습니다.<br/>
            해당 이메일을 통해 로그인 해주세요. */}
            <Str strKey={'s121'} />
          </div>

          <div className={'email_box'}>
            <Str strKey={'s122'} />{this.props.email}
          </div>
          <button onClick={(e) => {this.onClickExit(e)}} className={'button_close'}>
            <img src={ic_close} />
          </button>
          
        </div>
        
      </div>
    )
  }
};

Popup_resetSendMail.defaultProps = {
  email: ''
}

export default Popup_resetSendMail;