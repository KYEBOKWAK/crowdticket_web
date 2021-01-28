'use strict';

import React, { Component } from 'react';


import StoreHomeContentList from '../component/StoreHomeContentList';
import StoreHomeStoreList from '../component/StoreHomeStoreList';

// import ScrollBooster from 'scrollbooster';

import ScrollBooster from 'scrollbooster';
import axios from '../lib/Axios';

import store_home_title_img from '../res/img/main_store_title_img_1.svg';
import Types from '../Types';

//test
// import _axios from 'axios';
// import Popup_progress from '../component/Popup_progress';
//////

let isStoreHomeSliding = false;

class StoreHome extends Component {

  constructor(props) {
    super(props);
    this.state = { 
      storeThumbListComponent: <></>,
      items: [],
      galleryItems: [],

      testPercent: 0
    };
  }

  componentDidMount(){
    const pageKeyDom = document.querySelector('#app_page_key');
    if(pageKeyDom){
      console.log(pageKeyDom.value);
    }

    this.requestCreatorStore();

    this.setScrollAction();
  }

  setScrollAction(){
    const viewport = document.querySelector('.viewport');
    const content = document.querySelector('.scrollable-content');

    const sb = new ScrollBooster({
      viewport,
      content,
      bounce: true,
      textSelection: false,
      emulateScroll: true,
      onUpdate: (state) => {
        // state contains useful metrics: position, dragOffset, dragAngle, isDragging, isMoving, borderCollision
        // you can control scroll rendering manually without 'scrollMethod' option:
        content.style.transform = `translate(
          ${-state.position.x}px,
          0px
        )`;

        // content.style.transform = `translate(
        //   ${-state.position.x}px,
        //   ${-state.position.y}px
        // )`;
      },
      shouldScroll: (state, event) => {
        // disable scroll if clicked on button
        const isButton = event.target.nodeName.toLowerCase() === 'button';
        return !isButton;
      },
      onClick: (state, event, isTouchDevice) => {
        // prevent default link event
        const isLink = event.target.nodeName.toLowerCase() === 'link';
        if (isLink) {
          event.preventDefault();
        }
      }
    });

    // methods usage examples:
    sb.updateMetrics();
    // sb.scrollTo({ x: 100, y: 100 });
    sb.updateOptions({ emulateScroll: false });
    // sb.destroy();
  }

  pressStoreDetail(e, store_id, store_alias){
    e.preventDefault();

    if(isStoreHomeSliding){
      return;
    }

    // console.log('click!!!');
    // console.log(store_id);

    let url_tail = '';
    if(store_alias){
      url_tail = store_alias;
    }else{
      url_tail = store_id;
    }

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }
    
    let hrefURL = baseURL+'/store/'+url_tail;
    
    window.location.href = hrefURL;
  }

  storeItem(data){
    return <div key={data.id} className={'thumb_item_container'}>
                <button style={{backgroundColor: 'white', border: 0, outline: 'none'}} onClick={(e) => {this.pressStoreDetail(e, data.store_id, data.alias)}}>
                  <div className={'flex_layer flex_direction_column'}>
                    <img className={'thumb_item_img'} draggable='false' src={data.profile_photo_url}/>
                    <div className={'thumb_item_title'}>
                      {data.title}
                    </div>
                  </div>
                </button>
            </div>
  }

  requestCreatorStore(){
    axios.post('/store/any/list', {}, 
    (result) => {

      //test START
      /*
      console.log(result.list);
      let testlist = [];
      let index = 0;
      for(let i = 0 ; i < 3 ; i++){
        for(let j = 0 ; j < result.list.length ; j++){
          // let test = result.list[j];
          result.list[j].id = index;
          let test = result.list[j];
          // test.id = index;
          index++;

          console.log(test);
          testlist.push(test);
          
        }
      }

      console.log(testlist);

      const _galleryItems = testlist.map(item => this.storeItem(item));
      */
      //test END

      // 원본코드
      const _galleryItems = result.list.map(item => this.storeItem(item));
    
      this.setState({
        galleryItems: _galleryItems.concat()
      })
    }, (error) => {

    })
  }

  createStore(){
    alert("크리에이터 인증 구글폼으로 갑니다");
  }

  goStoreManagement(){

  }

  clickCreateStore(e){
    e.preventDefault();
    
    window.open('https://forms.gle/uAgxKCVZY523JKjZA');    
  }
  
  //
  render() {
  
    return (
      <div className={'StoreHomeComponent'}>
        <div className={'title_img_container'}>
          <img className={'title_img'} src={store_home_title_img} />
        </div>
        <div className={'paddingContainer shopThumbContainer'}>
          <div className={'thumb_title_label'}>
            크리에이터별 상점
          </div>
          <div className={'viewport'}>
            <div className={'scrollable-content'} style={{display: 'flex', flexDirection: 'row',}}>
              {this.state.galleryItems}
            </div>
            <div className={'blur_thumb_cover'}>
            </div>
          </div>
        </div>

        <div className={'paddingContainer'}>
          <button onClick={(e) => {this.clickCreateStore(e)}} className={'notice-bg'}>
            <div className={'notice_icon'}>
            ✍️
            </div>
            <div className={'notice_content'}>
              나의 모든 콘텐츠가 상품이 된다!<br/>
              크리에이터라면 지금 상점을 개설하세요!
            </div>
          </button>
        </div>        

        <div className={'contents_container flex_layer flex_direction_column paddingContainer conteint_mobile_full_size'}>
          <div className={'contents_list_title'}>현재 인기 콘텐츠</div>
          <StoreHomeContentList type={Types.store_home_item_list.POPUALER}></StoreHomeContentList>
        </div>

        <div className={'contents_container flex_layer flex_direction_column paddingContainer conteint_mobile_full_size'}>
          <div className={'contents_list_title'}>신규 업데이트 콘텐츠</div>
          <StoreHomeContentList type={Types.store_home_item_list.NEW_UPDATE}></StoreHomeContentList>
        </div>

        <div className={'contents_container flex_layer flex_direction_column paddingContainer conteint_mobile_full_size'}>
          <div className={'contents_list_title'} style={{marginBottom: 0}}>상점 별 콘텐츠</div>
          <div>
            <StoreHomeStoreList></StoreHomeStoreList>
          </div>
        </div>
      </div>
    );
  }
}

// StoreHome.defaultProps = {
//   people: [
//     // {firstName: 'Elson', lastName: 'Correia', info: {age: 24}},
//     // {firstName: 'John', lastName: 'Doe', info: {age: 18}},
//     // {firstName: 'Jane', lastName: 'Doe', info: {age: 34}},
//     // {firstName: 'Maria', lastName: 'Carvalho', info: {age: 22}},
//     // {firstName: 'Kelly', lastName: 'Correia', info:{age: 23}},
//     // {firstName: 'Don', lastName: 'Quichote', info: {age: 39}},
//     // {firstName: 'Marcus', lastName: 'Correia', info: {age: 0}},
//     // {firstName: 'Bruno', lastName: 'Gonzales', info: {age: 25}},
//     // {firstName: 'Alonzo', lastName: 'Correia', info: {age: 44}}
//   ]
// }

export default StoreHome;