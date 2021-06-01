'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import axios from './lib/Axios';
import Types from './Types';

// import img_event_bnr from './res/img/img-event-bnr.png';

// import Home_Thumb_list from './component/Home_Thumb_list';
// import Home_Thumb_Tag from './component/Home_Thumb_Tag';

// import Fan_Project_List from './component/Fan_Project_List';

// import img_event_bg from './res/img/img-event-bg.svg';

//하단 캐러셀 테슷트
// import Carousel from './component/Carousel';
// import AliceCarousel from 'react-alice-carousel';
// import { Swiper, SwiperSlide } from "swiper/react";

import Magazine_List_Item from './component/Magazine_List_Item';

const HOME_THUMB_CONTAINER_SHOW_LINE_COUNT = 4;

class App_Magazine extends Component {

  constructor(props) {
    super(props);

    this.state = {
      items: []
    }
    
  }

  componentDidMount(){
    this.requestMagazineList();

    $("#go_write_magazine").click(function(){
      window.location.href = $("#base_url").val() + "/magazine/write"
   });

   let writeMagazineDom = document.querySelector("#go_write_magazine");
   if(writeMagazineDom){
    writeMagazineDom.addEventListener("click", this.onClickGoWriteMagazine);
   }
  }

  componentWillUnmount(){
    let writeMagazineDom = document.querySelector("#go_write_magazine");
    if(writeMagazineDom){
      writeMagazineDom.removeEventListener("click", this.onClickGoWriteMagazine);
    }
  }

  onClickGoWriteMagazine = () => {
    window.location.href = "/magazine/write";
  }

  requestMagazineList = () => {
    axios.post("/magazine/any/list", {}, 
    (result) => {
      this.makeItemList(result.list);
    }, (error) => {

    })
  }

  makeItemList = (_list) => {
    // let _event_title = title;

    let _rand_list = _list.concat();
    
    let lineCount = _rand_list.length / HOME_THUMB_CONTAINER_SHOW_LINE_COUNT;

    let index = 0;

    let _items = this.state.items.concat();
    let hasMore = false;
    
    // if(_list.length < REQUEST_ONCE_ITME) {
    //   hasMore = false;
    // }
    

    let marginTopZeroStyle = {
      marginTop: 0
    }
    for(let i = 0 ; i < lineCount ; i++){
      let columnItems = [];
      let isOverCount = false;
      for(let j = 0 ; j < 2 ; j++){
        //1줄에 4개 모바일일 경우 2개씩 쪼개야 하기 때문에 쪼개서 flex 한다.(모바일일때 2개 flex 유지, pc 일때 4개 flex 유지)
        let rowItems = [];

        for(let k = 0 ; k < 2 ; k++){
          let target_id = null;
          let subtitle = '';
          let thumb_img_url = '';
          let title = '';

          if(index >= _rand_list.length){
            if(k === 0){
              //두개중 한개만 비어있는 경우가 있음
              isOverCount = true;
            }
          }else{
            const data = _rand_list[index];
            target_id = data.id;
            subtitle = data.subtitle;
            thumb_img_url = data.thumb_img_url;
            title = data.title;
          }

          // const itemDom = <Home_Thumb_Container_Item key={k} store_item_id={target_id}></Home_Thumb_Container_Item>;

          let itemDom = <Magazine_List_Item key={k} magazine_id={target_id} subtitle={subtitle} thumb_img_url={thumb_img_url} title={title}></Magazine_List_Item>;          
          
          rowItems.push(itemDom);

          if(k === 0){
            rowItems.push(<div key={k+'_gap'} className={'row_items_gap'}></div>)
          }

          index++;
        }

        let itemContainerStyle = {}
        if(isOverCount){
          itemContainerStyle = {
            ...marginTopZeroStyle
          }
        }

        const itemContainerDom = <div style={itemContainerStyle} key={j} className={'row_items_container'}>
                                  {rowItems}
                                </div>

        columnItems.push(itemContainerDom);

        if(j === 0){
          columnItems.push(<div key={j+'_gap'} className={'column_items_gap'}></div>);
        }
      }

      let columnStyle = {}
      if(i === 0){
        columnStyle = {
          marginTop: 0
        }
      }
      const itemColumnsDom = <div key={this.state.items.length+'_'+i} className={'column_items_container'} style={columnStyle}>
                              {columnItems}
                            </div>

      _items.push(itemColumnsDom);
    }

    // let isShowMoreButton = false;
    // if(hasMore){
    //   isShowMoreButton = true;
    // }

    this.setState({
      items: _items.concat(),
      // items_count: this.state.items_count + index,
      // hasMore: hasMore,
      // isShowMoreButton: isShowMoreButton,
      // isRefreshing: false
    })
  }

  render() {

    return (
      <div className={'App_Magazine'}>
        <div className={'page_container'}>
          <div className={'banner_box'}>
            <div className={'banner_icon'}>
              📮
            </div>
            <div className={'banner_content'}>
              {`크티의 모든 소식을 한 눈에!\n크티 매거진에서는 크티의 다양한 소식을 알려드립니다.`}
            </div>
          </div>
          <div className={'list_container'}>
            {this.state.items}
          </div>
        </div>
      </div>
    );
  }
}

let domContainer = document.querySelector('#react_app_magazine_page');
ReactDOM.render(<App_Magazine />, domContainer);