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

// import language from '../res/json/language/language.json';
// import StrLib from '../lib/StrLib';

class StoreHome extends Component {

  constructor(props) {
    super(props);
    this.state = {
      category_top_list: []
    };
  }

  componentDidMount(){

    this.requestCreatorStore();

    // this.requestTopCategoryList();
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

  requestTopCategoryList = () => {
    axios.post('/category/any/top/list', {}, 
    (result) => {
      this.setState({
        category_top_list: result.list.concat()
      })
    }, (error) => {

    })
  }

  clickCreateStore = (e) => {
    e.preventDefault();
    
    window.open('https://forms.gle/vRiirC1mdfgUbZLt5');
  }

  onClickCategoryLink = (e, id) => {
    e.preventDefault();

    window.location.href = '/category/'+id;
  }

  testOnclickDownload = (e) => {
    e.preventDefault();

    fetch('https://download.crowdticket.kr:3000/downloader/get/file/468/%ED%95%98%EC%B9%B4%EC%86%8C_%EC%8A%A4%ED%8B%B0%EC%BB%A4.png', {
      method: 'GET',
      headers: {
        'Content-Type': 'image/png',
      },
    })
    .then((response) => response.blob())
    .then((blob) => {
      // Create blob link to download
      const url = window.URL.createObjectURL(
        new Blob([blob]),
      );
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute(
        'download',
        `%ED%95%98%EC%B9%B4%EC%86%8C_%EC%8A%A4%ED%8B%B0%EC%BB%A4.png`,
      );

      // Append to html link element page
      document.body.appendChild(link);

      // Start download
      link.click();

      // Clean up and remove the link
      link.parentNode.removeChild(link);
    });

    /*
    _axios({
      url: 'https://download.crowdticket.kr:3000/downloader/get/file/468/%ED%95%98%EC%B9%B4%EC%86%8C_%EC%8A%A4%ED%8B%B0%EC%BB%A4.png', //your url
      method: 'GET',
      // responseType: 'blob', // important
    }).then((response) => {
       const url = window.URL.createObjectURL(new Blob([response.data]));
       const link = document.createElement('a');
       link.href = url;
       link.setAttribute('download', '하카소_스티커.png'); //or any other extension
       document.body.appendChild(link);
       link.click();
    });
    */
  }

  render() {
    
    let category_top_list_dom = <></>;

    // let category_line_count = Types.category_top.length / 4
    let category_index = 0;
    let isEnd = false;
    let category_line_box = [];
    for(let i = 0 ; i < 2 ; i++){
      let category_item_box = []; //item 2개 묶음

      for(let j = 0 ; j < 2 ; j++){
        let category_items = [];

        for(let k = 0 ; k < 2 ; k++){
          
          const data = Types.category_top[category_index];

          const category_item_object = <button key={k} onClick={(e) => {this.onClickCategoryLink(e, data.id)}} className={'category_top_button'}>
                                        {data.show_value}
                                      </button>
          
          category_items.push(category_item_object);

          if(k === 0){
            const item_gap = <div key={'gap_'+k} className={'category_item_gap'}></div>
            category_items.push(item_gap);
          }

          category_index++;

          if(category_index > Types.category_top.length - 1){
            isEnd = true;
            break;
          }
        }

        let category_item_box_dom = <div key={j} className={'category_top_item_box'}>
                                      {category_items}
                                    </div>

        category_item_box.push(category_item_box_dom);

        if(isEnd){
          break;
        }
      }

      let category_line_box_dom = <div key={i} className={'category_top_item_line_box'}>
                                    {category_item_box}
                                  </div>

      category_line_box.push(category_line_box_dom);

      if(isEnd){
        break;
      }
    }

    category_top_list_dom = <div>
                              {category_line_box}
                            </div>
    
    
    return (
      <div className={'StoreHome'}>
        <Home_Top_Banner></Home_Top_Banner>

        {/* <a href="http://172.30.1.1:8080/downloader/get/file/121/2_3_1.jpg">다운로드 테슷트</a> */}
        {/* <a href={"https://download.crowdticket.kr:3000/downloader/get/file/468/%ED%95%98%EC%B9%B4%EC%86%8C_%EC%8A%A4%ED%8B%B0%EC%BB%A4.png"}>다운로드 테슷트</a> */}

        <button onClick={(e) => {this.testOnclickDownload(e)}}>함수형 다운로드 테슷트</button>

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
            <div className={'category_top_label'}>
              카테고리
              {/* {StrLib.getString('s2')} */}
            </div>

            <div className={'category_top_container'}>
              {category_top_list_dom}
            </div>
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