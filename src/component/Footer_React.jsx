'use strict';

import React, { Component } from 'react';

import Types from '../Types';

import ic_logo from '../res/img/logo-ct.svg';

import ic_footer_facebook from '../res/img/ic-footer-facebook.svg';
import ic_footer_instagram from '../res/img/ic-footer-instagram.svg';
import ic_footer_naver from '../res/img/ic-footer-naver.svg';
import ic_footer_youtube from '../res/img/ic-footer-youtube.svg';

import Str from '../component/Str';

import SelectBoxLanguage from '../component/SelectBoxLanguage';

import Storage from '../lib/Storage';
import * as storageType from '../StorageKeys';

const FOOTER_LINK_TYPE_STORE = 'FOOTER_LINK_TYPE_STORE';
const FOOTER_LINK_TYPE_EVENT = 'FOOTER_LINK_TYPE_EVENT';
const FOOTER_LINK_TYPE_MAGAZINE = 'FOOTER_LINK_TYPE_MAGAZINE';

const FOOTER_LINK_TYPE_CREATE_STORE = 'FOOTER_LINK_TYPE_CREATE_STORE';
const FOOTER_LINK_TYPE_HELP_CENTER = 'FOOTER_LINK_TYPE_HELP_CENTER';

const FOOTER_LINK_SNS_FACEBOOK = 'FOOTER_LINK_SNS_FACEBOOK';
const FOOTER_LINK_SNS_INSTA = 'FOOTER_LINK_SNS_INSTA';
const FOOTER_LINK_SNS_YOTUBE = 'FOOTER_LINK_SNS_YOTUBE';
const FOOTER_LINK_SNS_NAVER = 'FOOTER_LINK_SNS_NAVER';

const FOOTER_LINK_TYPE_TERM = 'FOOTER_LINK_TYPE_TERM';
const FOOTER_LINK_TYPE_PRIVACY = 'FOOTER_LINK_TYPE_PRIVACY';

class Footer_React extends Component{

  constructor(props){
    super(props);

    this.state = {
      innerWidth: 0,
      language_code: 'kr'
    }
  };

  componentDidMount(){
    window.addEventListener('resize', this.updateDimensions);
    this.updateDimensions();

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
    window.removeEventListener('resize', this.updateDimensions);
  };

  updateDimensions = () => {

    this.setState({
      innerWidth: window.innerWidth
    })
  }

  componentDidUpdate(){
  }

  onClickLink = (e, type, openType='link') => {
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    if(type === FOOTER_LINK_TYPE_STORE){
      baseURL = baseURL + '/store/';
    }
    else if(type === FOOTER_LINK_TYPE_EVENT){
      baseURL = baseURL + '/projects';
    }
    else if(type === FOOTER_LINK_TYPE_MAGAZINE){
      baseURL = baseURL + '/magazine';
    }
    else if(type === FOOTER_LINK_TYPE_CREATE_STORE){
      baseURL = 'https://forms.gle/vRiirC1mdfgUbZLt5';
    }
    else if(type === FOOTER_LINK_TYPE_HELP_CENTER){
      baseURL = 'https://www.notion.so/crowdticket/bd04ecd76ae840a0b32feed12fd10d57';
    }
    else if(type === FOOTER_LINK_SNS_FACEBOOK){
      baseURL = 'https://www.facebook.com/crowdticket/';
    }
    else if(type === FOOTER_LINK_SNS_INSTA){
      baseURL = 'https://www.instagram.com/k.haem/';
    }
    else if(type === FOOTER_LINK_SNS_YOTUBE){
      baseURL = 'https://www.youtube.com/channel/UCrZuTkc1H8w7d2nLoRE-e5g';
    }
    else if(type === FOOTER_LINK_SNS_NAVER){
      baseURL = 'https://blog.naver.com/crowdticket';
    }
    else if(type === FOOTER_LINK_TYPE_TERM){
      baseURL = baseURL + '/terms';
    }
    else if(type === FOOTER_LINK_TYPE_PRIVACY){
      baseURL = baseURL + '/privacy';
    }

    if(openType === 'link'){
      window.location.href = baseURL;
    }else{
      window.open(baseURL);
    }
  }

  onClickQuestion = (e) => {
    e.preventDefault();

    plusFriendChat();
  }

  render(){
    // console.log(this.state.innerWidth);

    let logo_dom = <div className={'logo_container'}>
                    <img src={ic_logo} />
                    <div className={'select_box_lang'}>
                      <SelectBoxLanguage 
                        default_value={this.state.language_code}
                        null_show_value={'언어를 선택해주세요.'}
                        list={[
                          {
                            value: 'kr',
                            show_value: '한국어'
                          },
                          {
                            value: 'en',
                            show_value: 'English'
                          }
                        ]}
                        callbackChangeSelect={(value) => {
                          let language_code = value;
                          if(value === null){
                            language_code = 'kr'
                          }

                          this.setState({
                            language_code: language_code
                          }, () => {
                            // console.log(window.location.href);
                            Storage.save(storageType.LANGUAGE_CODE, this.state.language_code, (result) => {

                              const url = window.location.href;
                              const urlIndex = url.indexOf('/language/en');
                              if(urlIndex > 0){
                                const reUrl = url.split('/language/en');
                                window.location.href = reUrl[0];
                              }else{
                                window.location.reload();
                              }
                            });
                          })
                        }}
                      ></SelectBoxLanguage>
                    </div>
                  </div>;

    let service_center_dom = <div className={'service_container'}>
                              <div className={'title_label'}>
                                고객센터
                              </div>
                              <button onClick={(e) => {this.onClickQuestion(e)}} className={'question_button'}>
                                문의하기
                              </button>
                              <div className={'contact_time_text'}>
                                오전 10시 ~ 오후 7시 (주말, 공휴일 제외)
                              </div>
                              <div className={'contact_container'}>
                                <div className={'contact_text'}>
                                  KAKAO: @크라우드티켓
                                </div>
                                <div className={'contact_text'}>
                                  T: 070-8819-4308
                                </div>
                                <div className={'contact_text'}>
                                  E: contact@crowdticket.kr
                                </div>
                              </div>
                            </div>;

    let logo_pc = <></>;
    let logo_tablet = <></>;

    let service_center_pc = <></>;
    let service_center_tablet = <></>;
    if(this.state.innerWidth > Types.width.pc){
      service_center_pc = service_center_dom;
      logo_pc = logo_dom;
    }else if(this.state.innerWidth <= Types.width.pc){
      service_center_tablet = service_center_dom;
      logo_tablet = logo_dom;
    }

    return(
      <div className={'Footer_React'}>
        <div className={'footer_line'}>
        </div>
        
        <div className={'container_wrapper'}>
          {logo_tablet}
          <div className={'first_container'}>
            {logo_pc}
            <div className={'first_column_container'}>
              <div className={'title_label'}>
                크티
              </div>
              <button onClick={(e) => {this.onClickLink(e, FOOTER_LINK_TYPE_STORE)}} className={'title_text'}>
                {/* 콘텐츠상점 */}
                <Str strKey={'s12'}/>
              </button>
              
              <button onClick={(e) => {this.onClickLink(e, FOOTER_LINK_TYPE_EVENT)}} className={'title_text'}>
                {/* 팬 이벤트 */}
                <Str strKey={'s2'}/>
              </button>
              <button style={{marginBottom: 0}} onClick={(e) => {this.onClickLink(e, FOOTER_LINK_TYPE_MAGAZINE)}} className={'title_text'}>
                {/* 매거진 */}
                <Str strKey={'s3'}/>
              </button>
            </div>

            <div className={'second_column_container'}>
              <div className={'title_label'}>
                크리에이터
              </div>
              <button onClick={(e) => {this.onClickLink(e, FOOTER_LINK_TYPE_CREATE_STORE, 'new')}} className={'title_text'}>
                상점 개설하기
              </button>
              <button onClick={(e) => {this.onClickLink(e, FOOTER_LINK_TYPE_HELP_CENTER, 'new')}} className={'title_text'}>
                도움말
              </button>
            </div>

            {service_center_pc}
          </div>
        </div>
        

        {service_center_tablet}

        <div className={'second_container'}>
          <div className={'logo_container'}>
            <button onClick={(e) => {this.onClickLink(e, FOOTER_LINK_SNS_FACEBOOK, 'new')}} className={'icon_button'}>
              <img src={ic_footer_facebook} />
            </button>
            <button onClick={(e) => {this.onClickLink(e, FOOTER_LINK_SNS_INSTA, 'new')}} className={'icon_button'}>
              <img src={ic_footer_instagram} />
            </button>
            <button onClick={(e) => {this.onClickLink(e, FOOTER_LINK_SNS_YOTUBE, 'new')}} className={'icon_button'}>
              <img src={ic_footer_youtube} />
            </button>
            <button onClick={(e) => {this.onClickLink(e, FOOTER_LINK_SNS_NAVER, 'new')}} className={'icon_button'}>
              <img src={ic_footer_naver} />
            </button>
          </div>

          <div className={'term_privacy_container'}>
            <div className={'term_container'}>
              <button onClick={(e) => {this.onClickLink(e, FOOTER_LINK_TYPE_TERM, 'new')}} className={'term_text term_privacy_text'}>
                이용약관
              </button>
              <button onClick={(e) => {this.onClickLink(e, FOOTER_LINK_TYPE_PRIVACY, 'new')}} className={'term_privacy_text'}>
                개인정보취급방침
              </button>
            </div>
            <div className={'company_info_text'}>
              (주)나인에이엠 대표: 신효준 | 서울시 마포구 독막로 331 마스터즈타워 2501호 | 사업자 등록번호: 407 81 31606 | 통신판매업신고: 2017-서울동대문-1218 | 크티는 본 플랫폼에서 발생하는 크리에이터 서비스의 당사자가 아닙니다. 제공되는 콘텐츠와 이벤트에 대한 전반적인 책임은 상점 운영자와 이벤트를 진행하는 주체에 있습니다. 크티팀은 상점과 이벤트 참여에 관련된 편리하고 공정한 온라인 솔루션을 제공할 수 있도록 항상 최선을 다하겠습니다.
            </div>
          </div>
        </div>
      </div>
    )
  }
};

export default Footer_React;