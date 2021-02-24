'use strict';

import React, { Component } from 'react';

import axios from '../lib/Axios';

// import store_home_title_img from '../res/img/main_store_title_img_1.svg';
import Types from '../Types';

import Home_Thumb_list from '../component/Home_Thumb_list';
import Home_Thumb_Recommend_Creator_List from '../component/Home_Thumb_Recommend_Creator_List';

import Home_Thumb_Container_List from '../component/Home_Thumb_Container_List';

import Home_Thumb_Tag from '../component/Home_Thumb_Tag';

import ScrollBooster from 'scrollbooster';


class StoreHome extends Component {

  constructor(props) {
    super(props);
    this.state = {
      galleryItems: []
    };
  }

  componentDidMount(){

    this.requestCreatorStore();
    // const pageKeyDom = document.querySelector('#app_page_key');
    // if(pageKeyDom){
    //   console.log(pageKeyDom.value);
    // }
  }

  storeItem = (data) => {
    return <div key={data.id} className={'thumb_item_container'}>
                <button style={{backgroundColor: 'white', border: 0, outline: 'none'}} onClick={(e) => {this.pressStoreDetail(e, data.store_id, data.alias)}}>
                    <img className={'thumb_item_img'} draggable='false' src={data.profile_photo_url}/>
                    <div className={'thumb_item_title'}>
                      {data.title}
                    </div>
                </button>
            </div>
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

  setScrollAction = () => {
    console.log("sdfasdf");
    const viewport = document.querySelector('.StoreHome .viewport_a');
    const content = document.querySelector('.StoreHome .scrollable-content_a');

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

  clickCreateStore = (e) => {
    e.preventDefault();
    
    window.open('https://forms.gle/uAgxKCVZY523JKjZA');    
  }
  
  //
  render() {
  
    return (
      <div className={'StoreHome'}>
        <div className={'store_home_container'}>
          <div className={'thumb_container'}>
            <Home_Thumb_list thumb_list_type={Types.thumb_list_type.popular}></Home_Thumb_list>
          </div>
          <div className={'thumb_container'}>
            <Home_Thumb_Recommend_Creator_List></Home_Thumb_Recommend_Creator_List>
          </div>
        </div>

        <div className={'banner_container'}>
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
            <button onClick={(e) => {this.clickCreateStore(e)}} className={'banner_create_store_button'}>
              상점 개설하기
            </button>
          </div>
        </div>

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

        
        <div className={'store_home_container padding_container'} style={{position: 'relative'}}>
          <div className={'thumb_container'}>
            <div className={'viewport_a'}>
              <div className={'scrollable-content_a'} style={{display: 'flex', flexDirection: 'row',}}>
                {this.state.galleryItems}
              </div>
              <div className={'blur_thumb_cover'}>
              </div>
            </div>
            {/* <Home_Thumb_list thumb_list_type={Types.thumb_list_type.stores} pc_show_item_count={12}></Home_Thumb_list> */}
          </div>
        </div>

      </div>
    );
  }
}

export default StoreHome;