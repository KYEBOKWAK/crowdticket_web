'use strict';

import React, { Component } from 'react';

import axios from '../lib/Axios';

// import store_home_title_img from '../res/img/main_store_title_img_1.svg';
import Types from '../Types';

import Home_Thumb_list from '../component/Home_Thumb_list';
import Home_Thumb_Recommend_Creator_List from '../component/Home_Thumb_Recommend_Creator_List';

import Home_Thumb_Container_List from '../component/Home_Thumb_Container_List';

import Home_Thumb_Tag from '../component/Home_Thumb_Tag';


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