'use strict';

import React, { Component } from 'react';
// import Types from '../Types';

import ic_eye_on from '../res/img/ic-eye-on.svg';
import ic_eye_off from '../res/img/ic-eye-off.svg';

class InputBox extends Component{

  constructor(props){
    super(props);

    this.state = {
      text: this.props.default_text,
      isShowPassword: false,

      isError: false,

      isBlur: false,

      //마우스를 클릭 후 아무것도 입력 안했을때 체크 하기 위함
      isEmptyCheckErrorMessage: false
      // input_box_error_classname: ''
    }
  };

  shouldComponentUpdate(nextProps, nextState) {
    // console.log(nextProps);
    if(nextState !== this.state){
      return true;
    }
    return false;
  }

  componentDidMount(){
    if(this.props.name === ''){
      console.error('InputBox 의 name을 정해줘야 합니다.');
      return;
    }
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  getErrorMessage = (type_input_error_message) => {
    const data = this.props.error_messages.find((value) => {
                    if(value.type === type_input_error_message){
                      return value;
                    }
                  })

    if(data === undefined){
      return '';
    }

    return data.message;
  }

  onChangeText = (e) => {
    this.setState({
      text: e.target.value,
    }, () => {
      this.props.callback_set_text(this.state.text);
    });
  }

  onChangeTextBlur = (e) => {
    this.setState({
      text: e.target.value,
      isBlur: true,
      isEmptyCheckErrorMessage: true
    }, () => {
      this.props.callback_set_text(this.state.text);
    });
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

  setError = (isError) => {
    this.setState({
      isError: isError
    })
  }

  getError = () => {
    return this.state.isError;
  }

  getIsBlur = () => {
    return this.state.isBlur;
  }

  getIsEmptyCheckErrorMessage = () => {
    return this.state.isEmptyCheckErrorMessage
  }

  setIsEmptyCheckErrorMessage = (isCheckOff) => {
    this.setState({
      isEmptyCheckErrorMessage: isCheckOff
    })
  }

  onFocusInput = (e) => {
    this.setState({
      isBlur: false
    })
  }

  render(){
    let inputClassName = '';
    let inputErrorClassName = '';

    if(this.state.isError){
      inputErrorClassName = 'input_error';
    }

    let show_password_img = '';
    let inputType = this.props.type;
    if(this.state.isShowPassword){
      show_password_img = ic_eye_on;
      inputType = 'text';
    }else{
      show_password_img = ic_eye_off;
    }

    let password_show_icon_dom = <></>;
    if(this.props.type === 'password'){
      inputClassName = `${inputErrorClassName} input_password`;

      password_show_icon_dom =  <button 
                                  onClick={(e) => {this.onClickShowPassword(e)}} 
                                  className={'password_show_button'}
                                >
                                  <img src={show_password_img} />
                                </button>
    }else{
      inputClassName = `${inputErrorClassName}`;
    }

    return(
      <div className={'InputBox'}>
        <input style={{width: '100%', height: 44}} className={inputClassName} type={inputType} name={this.props.name} placeholder={this.props.placeholder} value={this.state.text} onFocus={(e) => {this.onFocusInput(e)}} onChange={(e) => {this.onChangeText(e)}} onBlur={(e) => {this.onChangeTextBlur(e)}} />

        {password_show_icon_dom}
      </div>
    )
  }
};

InputBox.defaultProps = {
  type: 'text',
  name: '',
  placeholder: '',
  default_text: '',
  callback_set_text: (text) => {}
}

export default InputBox;