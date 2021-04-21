'use strict';

import React, { Component } from 'react';

import ic_check_checked from '../res/img/check-checked.svg';
import ic_check_unchecked from '../res/img/check-unchecked.svg';

import SelectBox from '../component/SelectBox';

import Types from '../Types';

import axios from '../lib/Axios';

//Types에 10번이 자유 입력
const WITHDRAWAL_TYPE_FREE_TYPE = 10;

class WithdrawalPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      isAgree: false,

      withdrawal_select_value: null,
      withdrawal_reason: ''
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  onClickAgree = (e) => {
    e.preventDefault();

    let isAgree = this.state.isAgree;
    if(isAgree){
      isAgree = false;
    }else{
      isAgree = true;
    }

    this.setState({
      isAgree: isAgree
    })
  }

  onClickBack = (e) => {
    e.preventDefault();

    window.history.back();
  }

  onClickLeave = (e) => {
    e.preventDefault();

    if(!this.state.isAgree){
      alert('탈퇴 유의사항을 체크해주세요');
      return;
    }

    if(this.state.withdrawal_reason === ''){
      alert('탈퇴 사유를 선택해주세요');
      return;
    }

    swal("정말 크티를 떠나시겠어요?ㅠㅠ", {
      buttons: {
        save: {
          text: "예",
          value: "yes",
        },
        nosave: {
          text: "아니오",
          value: "notsave",
        }
      },
    })
    .then((value) => {
      switch (value) {
        case "yes":
        {
          this.requestLeave();
        }
        break;
      }
    });

    
  }

  requestLeave = () => {
    showLoadingNoContentPopup();

    axios.post("/user/withdrawal", {
      reason: this.state.withdrawal_reason
    }, (result) => {
      stopLoadingPopup();

      swal('탈퇴가 완료됐습니다. 크티를 이용해주셔서 감사합니다.', '', 'success').then(() => {
        logout();
      })
    }, (error) => {
      stopLoadingPopup();
    })
  }

  onChangeTextArea = (e) => {
    this.setState({
      withdrawal_reason: e.target.value,
    });
  }

  render(){    
    let checkImg = ic_check_unchecked;
    if(this.state.isAgree){
      checkImg = ic_check_checked;
    }

    let agree_check_dom = <button onClick={(e) => {this.onClickAgree(e)}} className={'complited_type_agree_container'}>
                            <img src={checkImg} />
                            <div className={'complited_type_agree_text'}>
                              상기 회원 탈퇴 유의사항을 확인하였으며 동의합니다.
                            </div>
                          </button>

    let reason_text_area = <></>;
    if(this.state.withdrawal_select_value === WITHDRAWAL_TYPE_FREE_TYPE){
      reason_text_area = <textarea maxLength={255} className={'reason_textarea'} type="text" name={'drawal_reason'} placeholder={'회원님의 탈퇴 사유는 무엇인가요? 편하고 솔직하게 말씀해주세요.'} value={this.state.withdrawal_reason} onChange={(e) => {this.onChangeTextArea(e)}}/>
    }

    return(
      <div className={'WithdrawalPage'}>
        <div className={'page_title'}>
          정말로 크티를 떠나시나요?
        </div>
        <div className={'withdrawal_contents_box'}>
          <div className={'withdrawal_contents_title'}>
            회원 탈퇴 전, 꼭 읽어주세요!
          </div>

          <div className={'withdrawal_contents_text_box'}>
            <div className={'withdrawal_contents_text_title'} style={{marginTop: 0}}>
              • 회원탈퇴 시 해당 계정의 회원 데이터 및 서비스 사용 기록이 영구적으로 삭제되며 구매한 콘텐츠는 확인할 수 없게 됩니다.
            </div>
            <div className={'withdrawal_contents_text_title'}>
              • 단, 소비자보호에 관한 법률 및 국세기본법, 법인세법에 의거하여 거래내역 및 증빙서류와 관련된 정보, 계약 또는 청약철회 등에 관한 기록, 대금결제 및 재화 등의 공급에 관한 기록, 소비자의 불만 또는 분쟁처리에 관한 기록 등은 최대 5년간 보관되며 해당 기록은 법률에 의한 보유 목적 외에 다른 목적으로는 이용되지 않습니다.
            </div>
            <div className={'withdrawal_contents_text_title'}>
              • 서비스 내에서 입력한 댓글 등의 게시물은 회원탈퇴 후에 삭제되지 않습니다. 탈퇴한 작성자의 정보는 표시되지 않으나 게시물 삭제를 원하시는 경우에는 탈퇴 신청 전에 처리해주세요.
            </div>
            <div className={'withdrawal_contents_text_title'}>
              • 탈퇴 처리 후에는 기존 이메일 주소로 재가입이 가능합니다. 그러나 기존 계정의 기록은 남지 않습니다.
            </div>
          </div>
        </div>

        {agree_check_dom}

        <div className={'ask_container'}>
          <div className={'ask_container_title'}>
            크티를 떠나시기 전에...
          </div>
          <div className={'ask_container_content'}>
            크티를 떠나는 이유를 알려주세요.<br/>
            여러분의 소중한 의견을 반영하여 더 좋은 서비스로 다시 만나뵙겠습니다.
          </div>
        </div>

        <div className={'ask_select_box'}>
          <SelectBox
            default_value={this.state.withdrawal_select_value}
            null_show_value={'탈퇴 사유'}
            list={Types.withdrawal}
            callbackChangeSelect={(value) => {
              const selectValue = Number(value);
              
              let withdrawal_reason = '';
              const withdrawalData = Types.withdrawal.find((value) => {
                                        if(value.value === selectValue){
                                          return value;
                                        }
                                      });

              if(withdrawalData !== undefined){
                withdrawal_reason = withdrawalData.show_value;
              }
              
              if(selectValue === WITHDRAWAL_TYPE_FREE_TYPE){
                withdrawal_reason = '';
              }
              this.setState({
                withdrawal_select_value: Number(value),
                withdrawal_reason: withdrawal_reason
              })
            }}
          ></SelectBox>
        </div>

        {reason_text_area}

        <div className={'leave_buttons_container'}>
          <button onClick={(e) => {this.onClickLeave(e)}} className={'leave_button'}>
            크티 떠나기
          </button>
          <div style={{width: 8}}>
          </div>
          <button onClick={(e) => {this.onClickBack(e)}} className={'back_button'}>
            크티 계속하기
          </button>
        </div>
      </div>
    )
  }
};

export default WithdrawalPage;