'use strict';

import React, { Component } from 'react';
import _axios from 'axios';
import Util from '../lib/Util';
import axios from '../lib/Axios';

import InputBox from '../component/InputBox';
import ErrorMessageInputBox from '../component/ErrorMessageInputBox';
import Types from '../Types';

import LoginForgetEmailPage from '../pages/LoginForgetEmailPage';

//이건 로그인 후 비번 수정 페이지
class PasswordResetPage extends Component{

  password_ref = null;
  new_password_ref = null;
  new_password_confirmation = null;
  constructor(props){
    super(props);

    this.state = {
      email: '',
      password: '',
      new_password: '',
      new_password_confirmation: '',

      is_password_reset_page: false
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    axios.post('/user/info', {}, 
    (result) => {
      const data = result.userInfo;
      this.setState({
        email: data.email,
      })
    }, (error) => {

    })
  };

  componentWillUnmount(){
    this.password_ref = null;
    this.new_password_ref = null;
    this.new_password_confirmation = null;
  };

  componentDidUpdate(){
  }

  onClickBackbutton = (e) => {
    e.preventDefault();
    window.history.back();
  }

  onClickResetPassword = (e) => {
    e.preventDefault();

    axios.post('/user/update/password', {
      password_now: this.state.password,
      password_new: this.state.new_password,
      password_new_check: this.state.new_password_confirmation
    }, (result) => {
      swal("변경 완료", "", "success");
    }, (error) => {

    })
  }

  render(){
    if(this.state.is_password_reset_page){
      return (
        <LoginForgetEmailPage email={this.state.email}></LoginForgetEmailPage>
      )
    }


    return(
      <div className={'PasswordResetPage'}>

        <div className={'page_label_text'}>
          비밀번호 변경
        </div>
        <div className={'content_container'}>
          <div className={'input_label'}>
            현재 비밀번호
          </div>

          <InputBox
            ref={(ref) => {
              this.password_ref = ref;
            }}
            default_text={this.state.password}
            type={'password'}
            name={'password'}
            placeholder={'현재 비밀번호를 입력해주세요.'}
            
            callback_set_text={(text) => {
              this.setState({
                password: text
              })
            }}
          ></InputBox>

          <ErrorMessageInputBox 
              defaultText={this.state.password} 
              inputBoxRef={this.password_ref}
              error_messages={[
                {
                  type: Types.input_error_messages.empty,
                  message: '현재 비밀번호를 입력해주세요.'
                },
                {
                  type: Types.input_error_messages.password_max_length,
                  message: '비밀번호는 6자리 이상 입력해주세요.'
                }
              ]}
            >
          </ErrorMessageInputBox>

          <button className={'password_forget_text'} onClick={(e) => {
            e.preventDefault();

            if(this.state.email === ''){
              alert('이메일 정보가 없습니다. 새로고침 후 다시 시도해주세요');
              return;
            }

            this.setState({
              is_password_reset_page: true
            })
          }}>
            <u>비밀번호를 잊으셨나요?</u>
          </button>

          <div className={'new_password_container'}>
            <div className={'input_label'}>
              새로운 비밀번호
            </div>

            <InputBox
              ref={(ref) => {
                this.new_password_ref = ref;
              }}
              default_text={this.state.new_password}
              type={'password'}
              name={'new_password'}
              placeholder={'새로운 비밀번호를 입력해주세요.'}
              
              callback_set_text={(text) => {
                this.setState({
                  new_password: text
                })
              }}
            ></InputBox>

            <ErrorMessageInputBox 
                defaultText={this.state.new_password}
                inputBoxRef={this.new_password_ref}
                error_messages={[
                  {
                    type: Types.input_error_messages.empty,
                    message: '새로운 비밀번호를 입력해주세요'
                  },
                  {
                    type: Types.input_error_messages.password_max_length,
                    message: '비밀번호는 6자리 이상 입력해주세요.'
                  }
                ]}
              >
            </ErrorMessageInputBox>

            <div className={'input_label'} style={{marginTop: 16}}>
              비밀번호 확인
            </div>

            
            <InputBox
              ref={(ref) => {
                this.new_password_confirmation_ref = ref;
              }}
              default_text={this.state.new_password_confirmation}
              type={'password'}
              name={'new_password_confirmation'}
              placeholder={'비밀번호를 한 번 더 입력해주세요.'}
              
              callback_set_text={(text) => {
                this.setState({
                  new_password_confirmation: text
                })
              }}
            ></InputBox>

            <ErrorMessageInputBox 
                defaultText={this.state.new_password_confirmation}
                compareText={this.state.new_password}
                isCompare={true}
                inputBoxRef={this.new_password_confirmation_ref}
                error_messages={[
                  {
                    type: Types.input_error_messages.empty,
                    message: '비밀번호 확인을 입력해주세요.'
                  },
                  {
                    type: Types.input_error_messages.password_max_length,
                    message: '비밀번호는 6자리 이상 입력해주세요.'
                  },
                  {
                    type: Types.input_error_messages.password_same_check,
                    message: '비밀번호가 다릅니다.'
                  }
                ]}
              >
            </ErrorMessageInputBox>
          </div>

          <div className={'buttons_container'}>
            <button onClick={(e) => {this.onClickBackbutton(e)}} className={'button_cancel'}>
              취소
            </button>
            <div style={{width: 8}}>
            </div>
            <button onClick={(e) => {this.onClickResetPassword(e)}} className={'button_change_password'}>
              비밀번호 변경하기
            </button>
          </div>

          
        </div>
      </div>
    )
  }
};

PasswordResetPage.defaultProps = {
}

export default PasswordResetPage;