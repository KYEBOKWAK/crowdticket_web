'use strict';

import React, { Component } from 'react';

import PhoneInput from 'react-phone-input-2';

import ic_dropdown from '../res/img/ic-dropdown.svg';


import InputBox from './InputBox';
import ErrorMessageInputBox from './ErrorMessageInputBox';
import Types from '../Types';
import axios from '../lib/Axios';

import Util from '../lib/Util';

import ic_check_checked from '../res/img/check-checked.svg';
import ic_check_unchecked from '../res/img/check-unchecked.svg';

import { ToastContainer, toast } from 'react-toastify';

import ic_info_success from '../res/img/ic-info-success.svg';
import ic_info_error from '../res/img/ic-info-error.svg';

import Str from '../component/Str';
import StrLib from '../lib/StrLib';

class PhoneConfirm extends Component{

  input_phone_ref = null;
  input_confirm_ref = null;

  waitTimerInterval = null;

  input_phone_error_ref = null;
  input_confirm_check_error_message_ref = null;

  constructor(props){
    super(props);

    let sendConfirmButtonDisabled = true;
    if(this.props.default_contact !== ''){
      sendConfirmButtonDisabled = false;
    }

    this.state = {
      countryCode: '82',
      number: this.props.default_contact,
      number_input_is_disabled: false,

      confirm_number: '',
      isConfirmBox: false,

      sendConfirmButtonDisabled: sendConfirmButtonDisabled,
      sendConfirmCheckButtonDisbaled: true,

      waitSec: 0,

      type_confirm_input_error_message: null,

      is_certification: false,

      is_advertising_Agree: false,

      // input_phone_ref: null

      isInit: false,
      isSetDefaultContact: false
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.setState({
      isInit: true
    })
  };

  getPhoneNumber = () => {
    return this.state.number;
  }

  getCountryCode = () => {
    return this.state.countryCode;
  }

  getIsCertification = () => {
    return this.state.is_certification;
  }

  getAdvertisingAgree = () => {
    return this.state.is_advertising_Agree;
  }

  setErrorMessageType = (type) => {
    this.input_phone_error_ref.setErrorMessageType(type);
  }

  componentWillUnmount(){
    this.stopWaitTimer();

    this.input_phone_ref = null;
    this.input_confirm_ref = null;

    this.input_phone_error_ref = null;
    this.input_confirm_check_error_message_ref = null;
  };

  componentDidUpdate(prevProps, prevState){
    if(!this.state.isSetDefaultContact && this.props.default_contact !== prevProps.default_contact){
      console.log('dfasdf');
      let sendConfirmButtonDisabled = true;
      if(this.props.default_contact !== ''){
        sendConfirmButtonDisabled = false;
      }

      this.setState({
        isSetDefaultContact: true,
        sendConfirmButtonDisabled: sendConfirmButtonDisabled,
        number: this.props.default_contact
      })
    }
  }

  setWaitSec = () => {
    let waitTimer = this.state.waitSec;
    waitTimer--;

    if(waitTimer <= 0){
      this.stopWaitTimer();

      this.setState({
        waitSec: 0,
        sendConfirmCheckButtonDisbaled: true,
        type_confirm_input_error_message: Types.input_error_messages.confirm_expire
      }, () => {
        // type_confirm_input_error_message
        this.input_confirm_check_error_message_ref.setErrorMessageType(Types.input_error_messages.confirm_expire);
      })

      return;
    }else{
      this.setState({
        waitSec: waitTimer
      });
    }
  }

  startWaitTimer = () => {
    this.waitTimerInterval = setInterval(() => {

      this.setWaitSec();
     }, 1000);
  }

  stopWaitTimer = () => {
    clearInterval(this.waitTimerInterval);
    this.waitTimerInterval = null;
  };

  onChangeNumber = (text) => {
    let sendConfirmButtonDisabled = true;
    if(text.length > 0){
      sendConfirmButtonDisabled = false;
    }
    this.setState(
    {
      number: text,
      sendConfirmButtonDisabled: sendConfirmButtonDisabled
    }, () => {
      this.input_phone_error_ref.setErrorMessageType(null);
    })
  }

  onChangeConfirmNumber = (text) => {
    let sendConfirmCheckButtonDisbaled = true;
    if(text.length >= 6){
      sendConfirmCheckButtonDisbaled = false;
    }

    let type_confirm_input_error_message = null;
    if(this.state.waitSec === 0){
      type_confirm_input_error_message = Types.input_error_messages.confirm_expire
      sendConfirmCheckButtonDisbaled = true;
    }

    this.setState(
    {
      confirm_number: text,
      sendConfirmCheckButtonDisbaled: sendConfirmCheckButtonDisbaled,
      type_confirm_input_error_message: type_confirm_input_error_message
    })
  }

  onClickSendConfirmNumber = (e) => {
    axios.post("/any/call/certify/number", {
      contact: this.state.number,
      countryCode: this.state.countryCode
    }, (result) => {
      // console.log(result);

      this.setState({
        isConfirmBox: true,
        waitSec: result.waitSec,
        type_confirm_input_error_message: null,
        confirm_number: '',
        number_input_is_disabled: true
      }, () => {

        this.input_confirm_ref.clear();
        this.input_confirm_check_error_message_ref.clear();

        this.setWaitSec();
        this.startWaitTimer();

        toast.success(<div className={'Toastify__toast--success-text'}> <img style={{marginRight: 8}} src={ic_info_success}/>인증 번호가 전송되었습니다.</div>, {
          position: "top-center",
          autoClose: 3000,
          hideProgressBar: true,
          closeOnClick: true,
          pauseOnHover: true,
          draggable: true,
          progress: undefined,
          });
      })
    }, (error) => {

    })
  }

  onClickConfirmCheck = (e) => {
    e.preventDefault();

    if(this.state.waitSec === 0){
      // alert('인증 번호가 만료되었습니다. 인증번호를 다시 전송 해주세요.');
      toast.success(<div className={'Toastify__toast--error-text'}> <img style={{marginRight: 8}} src={ic_info_error}/>인증 번호가 만료되었습니다. 인증번호를 다시 전송 해주세요.</div>, {
        position: "top-center",
        autoClose: 3000,
        hideProgressBar: true,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: undefined,
        });
      return;
    }

    if(this.state.confirm_number.length < 6){
      // alert('인증 번호 6자리를 입력해주세요.');
      toast.success(<div className={'Toastify__toast--error-text'}> <img style={{marginRight: 8}} src={ic_info_error}/>인증 번호 6자리를 입력해주세요.</div>, {
        position: "top-center",
        autoClose: 3000,
        hideProgressBar: true,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: undefined,
        });
      return;
    }

    axios.post("/any/call/certify/confirm", {
      contact: this.state.number,
      certify_number: this.state.confirm_number
    }, (result) => {
      // console.log(result);

      if(this.props.user_id === undefined || this.props.user_id === null){
        this.successConfirm();
      }else{
        axios.post("/user/any/certification", {
          _user_id: this.props.user_id,
          contact: this.state.number,
          country_code: this.state.countryCode
        }, (result) => {
          this.successConfirm();
        }, (error) => {

        })
      }

      
    }, (error) => {

    })
  }

  successConfirm = () => {
    this.stopWaitTimer();
    this.setState({
      is_certification: true,
      sendConfirmButtonDisabled: true,
      sendConfirmCheckButtonDisbaled: true,
    }, () => {

      this.props.callback_confirm_complete(this.state.number);

      this.input_phone_ref.setDisabled(true);
      // this.state.input_phone_ref.setDisabled(true);
      this.input_confirm_ref.setDisabled(true);

      toast.success(<div className={'Toastify__toast--success-text'}> <img style={{marginRight: 8}} src={ic_info_success}/>인증이 완료되었습니다.</div>, {
        position: "top-center",
        autoClose: 3000,
        hideProgressBar: true,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: undefined,
        });
    })
  }

  onClickAgree = (e) => {
    e.preventDefault();

    let is_advertising_Agree = this.state.is_advertising_Agree;
    if(is_advertising_Agree){
      is_advertising_Agree = false;
    }else{
      is_advertising_Agree = true;
    }

    this.setState({
      is_advertising_Agree: is_advertising_Agree
    })
  }

  render(){
    let confirm_input_dom = <></>;

    let confirm_button_text = StrLib.getStr('s157', this.props.language_code);
    let is_disabled = false;
    if(this.state.is_certification){
      confirm_button_text = StrLib.getStr('s154', this.props.language_code);
      is_disabled = true;
    }

    let confirmSendButtonClassName = 'number_send_confirm_button';
    if(this.state.isConfirmBox){
      let counterStyle = {}
      confirmSendButtonClassName = 'number_send_confirm_button number_send_confirm_button_bg_white';
      if(this.state.waitSec === 0){
        counterStyle = {
          color: '#fc5e7c'
        }
      }

      confirm_input_dom = <div>
                            <div className={'number_label'}>
                              {/* 인증 번호 */}
                              <Str strKey={'s152'} />
                            </div>
                            <div className={'number_input_container'}>
                              <div className={'confirm_number_container'}>
                                <InputBox
                                  ref={(ref) => {
                                    this.input_confirm_ref = ref;
                                  }}
                                  default_text={this.state.confirm_number}
                                  type={'numeric'}
                                  name={'confirm_number'}
                                  // placeholder={'인증 번호 6자리'}
                                  placeholder={StrLib.getStr('s153', this.props.language_code)}

                                  styleProps={{
                                    width: '100%',
                                    height: 44,
                                    borderTopRightRadius: 0,
                                    borderBottomRightRadius: 0
                                  }}
                                  maxLength={6}
                                  callback_set_text={(text) => {
                                    this.onChangeConfirmNumber(text);
                                  }}
                                ></InputBox>
                                <div style={counterStyle} className={'confirm_number_counter'}>
                                  {Util.getWaitTimer(this.state.waitSec)}
                                </div>
                              </div>
                              {/* <button disabled={this.state.sendConfirmCheckButtonDisbaled} className={'number_send_confirm_button'}> */}
                              <button onClick={(e) => {this.onClickConfirmCheck(e)}} disabled={this.state.sendConfirmCheckButtonDisbaled} className={'number_send_confirm_button'}>
                                {confirm_button_text}
                              </button>
                            </div>

                            <div className={'input_error_box'}>          
                              <ErrorMessageInputBox
                                  ref={(ref) => {
                                    this.input_confirm_check_error_message_ref = ref;
                                  }}
                                  defaultText={this.state.confirm_number} 
                                  inputBoxRef={this.input_confirm_ref}
                                  // setErrorMessage={this.state.type_confirm_input_error_message}
                                  error_messages={[
                                    {
                                      type: Types.input_error_messages.empty,
                                      message: '인증 번호를 입력해주세요.'
                                    },
                                    {
                                      type: Types.input_error_messages.confirm_expire,
                                      message: '인증 번호가 만료되었습니다. 다시 인증해주세요.'
                                    }
                                  ]}
                                >
                              </ErrorMessageInputBox>
                            </div>
                          </div>
    }

    let checkImg = ic_check_unchecked;
    if(this.state.is_advertising_Agree){
      checkImg = ic_check_checked;
    }

    let agree_check_dom = <></>;

    if(this.props.is_advertising){
      agree_check_dom = <button onClick={(e) => {this.onClickAgree(e)}} className={'agree_advertising_container'}>
                          <img src={checkImg} />
                          <div className={'agree_advertising_text_container'}>
                            <div className={'agree_advertising_text'}>
                              <Str strKey={'s150'} />
                            </div>
                            <div className={'agree_advertising_tip_text'}>
                              <span className={'agree_advertising_tip_box'}>Tip</span>
                              {/* 알림 동의 시 쏟아지는 혜택 정보! 놓치지마세요! */}
                              <Str strKey={'s151'} />
                            </div>
                          </div>
                        </button>
    }

    let only_pay_explain = <></>;
    if(this.props.is_only_pay_explain){
      only_pay_explain = <div className={'only_pay_explain'}>
                          <Str strKey={'s161'} />
                        </div>
    }

    let containerClassName = 'country_input_container';
    if(this.props.is_modify_page){
      containerClassName = 'country_input_container is_modify_page_container';
    }
    return(
      <div className={'PhoneConfirm'}>
        <div className={containerClassName}>
          <PhoneInput
            disabled={is_disabled}
            country={'kr'}
            value={this.state.countryCode}
            onChange={(countryCode) => {this.setState({ 
              countryCode: countryCode
            })}}
          />
          <img className={'country_input_drop_down_img'} src={ic_dropdown} />
        </div>

        <div className={'number_input_container'}>
          <InputBox
            ref={(ref) => {
              this.input_phone_ref = ref;
              // this.setState({
              //   input_phone_ref: ref
              // })
            }}
            default_text={this.state.number}
            type={'numeric'}
            name={'phone'}
            placeholder={StrLib.getStr('s148', this.props.language_code)}

            styleProps={{
              width: '100%',
              height: 44,
              borderTopRightRadius: 0,
              borderBottomRightRadius: 0
            }}
            is_disabled={this.state.number_input_is_disabled}
            callback_set_text={(text) => {
              this.onChangeNumber(text);
              // this.setState({
              //   number: text
              // })
            }}
          ></InputBox>
          <button disabled={this.state.sendConfirmButtonDisabled} onClick={(e) => {this.onClickSendConfirmNumber(e)}} className={confirmSendButtonClassName}>
            <Str strKey={'s149'} />
          </button>
        </div>

        <div className={'input_error_box'}>          
          <ErrorMessageInputBox 
              ref={(ref) => {
                this.input_phone_error_ref = ref;
              }}
              defaultText={this.state.number} 
              inputBoxRef={this.input_phone_ref}
              // inputBoxRef={this.state.input_phone_ref}
              error_messages={[
                {
                  type: Types.input_error_messages.empty,
                  message: StrLib.getStr('s155', this.props.language_code)
                },
                {
                  type: Types.input_error_messages.is_confirm_phone,
                  message: StrLib.getStr('s156', this.props.language_code)
                }
              ]}
            >
          </ErrorMessageInputBox>
        </div>
        
        {confirm_input_dom}
        
        {only_pay_explain}
        {agree_check_dom}

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

PhoneConfirm.defaultProps = {
  language_code: 'kr',
  default_contact: '',
  user_id: null,
  is_advertising: true,
  is_modify_page: false,
  is_only_pay_explain: false,
  callback_confirm_complete: (contact) => {}
}

export default PhoneConfirm;