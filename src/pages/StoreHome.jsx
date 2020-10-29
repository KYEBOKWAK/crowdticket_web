'use strict';

import React, { Component } from 'react';


// import '../res/css/StoreHome.css';


import StoreHomeContentList from '../component/StoreHomeContentList';

// import ScrollBooster from 'scrollbooster';

import ScrollBooster from 'scrollbooster';
import axios from '../lib/Axios';

let isStoreHomeSliding = false;

class StoreHome extends Component {

  constructor(props) {
    super(props);
    this.state = { 
      storeThumbListComponent: <></>,
      items: [],
      galleryItems: []
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
    window.open('https://forms.gle/xoEg8z6pa1Hm2UGW9')
  }

  //
  render() {
  
    return (
      <div className={'StoreHomeComponent'}>
        <div className={'paddingContainer'}>
          <button onClick={(e) => {this.clickCreateStore(e)}} className={'notice-bg'}>
            <div className={'notice_icon'}>
            ✍️
            </div>
            <div className={'notice_content'}>
              크리에이터 인증하고 컨텐츠 상점
              개설해보세요!
            </div>
          </button>
        </div>        

        <div className={'paddingContainer shopThumbContainer'}>
          <div className={'thumb_title_label'}>
            크리에이터별 상점
          </div>
          <div className={'viewport'}>
            <div className={'scrollable-content'} style={{display: 'flex', flexDirection: 'row',}}>
              {this.state.galleryItems}
            </div>
          </div>
        </div>
        <div className={'contents_container flex_layer flex_direction_column'}>
          <div className={'contents_list_title'}>콘텐츠 리스트(테스트)</div>
          <StoreHomeContentList></StoreHomeContentList>
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