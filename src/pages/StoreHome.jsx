'use strict';

import React, { Component } from 'react';

import axios from '../lib/Axios';

// import store_home_title_img from '../res/img/main_store_title_img_1.svg';
import Types from '../Types';

import Home_Thumb_list from '../component/Home_Thumb_list';
import Home_Thumb_Recommend_Creator_List from '../component/Home_Thumb_Recommend_Creator_List';

import Home_Thumb_Container_List from '../component/Home_Thumb_Container_List';

import Home_Thumb_Tag from '../component/Home_Thumb_Tag';

import Home_Top_Banner from '../component/Home_Top_Banner';

import _axios from 'axios';

import { browserName, browserVersion, engineName, engineVersion, getUA } from 'react-device-detect';

class StoreHome extends Component {

  constructor(props) {
    super(props);
    this.state = {
    };
  }

  componentDidMount(){

    this.requestCreatorStore();
    // const pageKeyDom = document.querySelector('#app_page_key');
    // if(pageKeyDom){
    //   console.log(pageKeyDom.value);
    // }

    //test//
    
    ////////
  }

  requestCreatorStore = () => {
    axios.post('/store/any/list', {}, 
    (result) => {

      // 원본코드
      const _galleryItems = result.list.map(item => this.storeItem(item));
    
      this.setState({
        galleryItems: _galleryItems.concat()
      }, () => {
        this.setScrollAction();
      })
    }, (error) => {

    })
  }

  clickCreateStore = (e) => {
    e.preventDefault();
    
    window.open('https://forms.gle/vRiirC1mdfgUbZLt5');
  }

  downloadtest = (e) => {
    e.preventDefault();

    let apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_REAL;
    const app_type_key = document.querySelector('#g_app_type');
    if(app_type_key){
      if(app_type_key.value === 'local'){
        apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_local;
      }else if(app_type_key.value === 'qa'){
        apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_QA;
      }
    }

    

    _axios.post(apiURL+'/downloader/set/file', {}).then((result) => {
      console.log(result);
    }).catch((error) => {
      console.log(error);
    })
  }

  // coreTest = (e) => {
  //   e.preventDefault();

  //   let apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_REAL;
  //   const app_type_key = document.querySelector('#g_app_type');
  //   if(app_type_key){
  //     if(app_type_key.value === 'local'){
  //       apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_local;
  //     }else if(app_type_key.value === 'qa'){
  //       apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_QA;
  //     }
  //   }
  //   _axios.post(apiURL+'/downloader/file/info', {
  //     data: {
  //       files_downloads_id: 77
  //     }
  //   }).then((result) => {
  //     console.log(result);
  //   }).catch((error) => {
  //     console.log(error);
  //     alert('정상적인 접근이 아닙니다');
  //   })
  // }

  render() {

    
    return (
      <div className={'StoreHome'}>
        <Home_Top_Banner></Home_Top_Banner>
        {/* <button onClick={(e) => {this.coreTest(e)}}>core 테스트</button> */}
        {/* <a download href={'http://192.168.200.152:3100/downloader/test'}>다운로드</a> */}
        {/* <a download={'안녕.mp4'} href={'http://192.168.200.152:3100/static/%EC%95%88%EB%85%95.mp4'}>다다다운</a> */}
        {/* <a download={'안녕.mp4'} href={'http://192.168.200.152:3100/static/zip파일.zip'}>다다다운</a> */}
        {/* <button onClick={(e) => {this.downloadtest(e)}}>
          파일 셋팅
        </button> */}
        {/* <div style={{marginTop: 10}}>
          <a download={''} href={'http://172.30.1.1:3100/downloader/atest/인천광역시 특수형태근로종사자 프리랜서 등 신청 서식.hwp'}>한글깨짐테슷트</a>
        </div> */}
        

        {/* <div>{browserName}</div>
        <div>{browserVersion}</div>
        <div>{engineName}</div>
        <div>{engineVersion}</div>
        <div>{getUA}</div> */}

        
        {/* <a download={'안녕.mp4'} href={'http://192.168.200.152:3100/downloader/atest/%EC%95%88%EB%85%95.mp4'}>다다다운</a> */}
        <div className={'store_home_container'}>
          <div className={'thumb_container'}>
            <Home_Thumb_list thumb_list_type={Types.thumb_list_type.popular}></Home_Thumb_list>
          </div>
          <div className={'thumb_container'}>
            <Home_Thumb_Recommend_Creator_List></Home_Thumb_Recommend_Creator_List>
          </div>
        </div>

        <button onClick={(e) => {this.clickCreateStore(e)}} className={'banner_container'}>
          <div className={'banner_box'}>
            <div className={'banner_icon'}>
              ✍️
            </div>
            <div className={'banner_content_container'}>
              <div className={'banner_content_top'}>
                나의 모든 콘텐츠가 상품이 된다!
              </div>
              <div className={'banner_content_bottom'}>
                크리에이터라면 지금 상점을 개설하세요!
              </div>
            </div>
            <div className={'banner_create_store_button'}>
              상점 개설하기
            </div>
          </div>
        </button>

        <div className={'store_home_container'}>
          <div className={'thumb_container'}>
            <div className={'thumb_tag_attention_container'}>
              <Home_Thumb_Tag thumb_tags={Types.thumb_tags.attention}></Home_Thumb_Tag>
            </div>
            <Home_Thumb_list thumb_list_type={Types.thumb_list_type.attention}></Home_Thumb_list>
          </div>
        </div>

        <div className={'store_home_container padding_container'}>
          <div className={'thumb_container'}>
            <Home_Thumb_Container_List type={Types.thumb_list_type.event}></Home_Thumb_Container_List>
          </div>
        </div>

        <div className={'store_home_container padding_container'}>
          <div className={'thumb_container'}>
            <Home_Thumb_Container_List type={Types.thumb_list_type.live_update}></Home_Thumb_Container_List>
          </div>
        </div>
      </div>
    );
  }
}

export default StoreHome;