'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import axios from './lib/Axios';
import Types from './Types';

import img_event_bnr from './res/img/img-event-bnr.png';

import Home_Thumb_list from './component/Home_Thumb_list';
import Home_Thumb_Tag from './component/Home_Thumb_Tag';

import Fan_Project_List from './component/Fan_Project_List';

import img_event_bg from './res/img/img-event-bg.svg';

//하단 캐러셀 테슷트
// import Carousel from './component/Carousel';
// import AliceCarousel from 'react-alice-carousel';
// import { Swiper, SwiperSlide } from "swiper/react";


class App_Fan_Event extends Component {

  constructor(props) {
    super(props);

    this.state = {
      // items: _item.concat(),
      playCreatorList: [],
      innerWidth: window.innerWidth,

      thumb_count: 1, //우선 0 이상으로 셋팅 해서 렌더 시켜야 카운트를 가져올 수 있음.
    }
    
  }

  componentDidMount(){
    // window.addEventListener('resize', this.updateDimensions);
    
    document.querySelector('.carousel_creator_container').style.display = 'block';

    var swiper = new Swiper('.swiper-container', {
      //centerInsufficientSlides: true,
      loop: true,
      slidesPerView: 9,
      spaceBetween: 0,
      
      autoplay: {
        delay: 2000,
        //disableOnInteraction: true,
      },
      
      breakpoints: {
        // when window width is <= 320px
        1750: {
          slidesPerView: 8,
          spaceBetween: 0
        },
        // when window width is <= 480px
        1550: {
          slidesPerView: 7,
          spaceBetween: 0
        },

        1350: {
          slidesPerView: 6,
          spaceBetween: 0
        },

        1150: {
          slidesPerView: 5,
          spaceBetween: 0
        },

        950: {
          slidesPerView: 4,
          spaceBetween: 0
        },

        750: {
          slidesPerView: 3,
          spaceBetween: 0
        },

        550: {
          slidesPerView: 2,
          spaceBetween: 0
        },
        // when window width is <= 640px
        350: {
          slidesPerView: 1,
          spaceBetween: 0
        }
      }
    });

    
  }
  componentWillUnmount(){
    // window.removeEventListener('resize', this.updateDimensions);
  }

  updateDimensions = () => {

    this.setState({
      innerWidth: window.innerWidth
    })
  }

  onClickGoMakeEvent = (e) => {
    e.preventDefault()

    window.location.href = '/blueprints/welcome';
  }

  render() {

    let thumb_list_dom = <></>;
    if(this.state.thumb_count > 0){
      thumb_list_dom = <div className={'thumb_carousel_box'}>
                        <div className={'thumb_tag_box'}>
                          <Home_Thumb_Tag thumb_tags={Types.thumb_tags.hot}></Home_Thumb_Tag>
                        </div>
                        <Home_Thumb_list result_count_callback={(count) => {
                          this.setState({
                            thumb_count: count
                          })
                        }} thumb_list_type={Types.thumb_list_type.fan_event_thumb}></Home_Thumb_list>
                      </div>
    }
    return (
      <div className={'App_Fan_Event'}>
        <div className={'top_banner_img_box'}>
          <img className={'top_banner_img'} src={img_event_bnr} />
        </div>
        <div className={'top_banner_container_box'}>
          <div className={'page_container top_banner_container'}>
            <div className={'top_banner_content_box'}>
              <div className={'top_banner_title_1'}>
                {`팬들에게 받은 사랑을 돌려주는\n가장 즐거운 방법!`}
              </div>
              <div className={'top_banner_title_2'}>
                {`오프라인 팬미팅부터 온라인 선물 나눔까지,\n크티와 함께 팬들이 만족하는 이벤트를 만들어보세요.`}
              </div>

              <button className={'top_banner_button'} onClick={(e) => {this.onClickGoMakeEvent(e)}}>
                👋 서비스 알아보기
              </button>
            </div>
          </div>
        </div>

        {thumb_list_dom}

        <div className={'page_container fan_project_list_box'}>
          <div className={'fan_project_list_label'}>
            지난 팬 이벤트
          </div>
          <Fan_Project_List></Fan_Project_List>
        </div>

        <div className={'event_make_banner_container'}>
          <div className={'event_make_banner_box'}>
            <div className={'event_make_banner_content_box'}>
              <div className={'event_make_banner_content_emoji'}>
                🙌
              </div>
              <div className={'event_make_banner_content_text'}>
                <span className={'event_make_banner_content_text_1'}>크리에이터라면 지금 바로 팬 이벤트를 개설하고</span><br/>
                <span className={'event_make_banner_content_text_2'}>팬들과 함께 즐거운 경험을 만들어보세요!</span>
              </div>
            </div>
            
            <button className={'event_make_banner_button'} onClick={(e) => {this.onClickGoMakeEvent(e)}}>
              이벤트 개설하기
            </button>
          </div>
        </div>

        <div className={'event_creators_container'}>
          <img className={'event_creators_effect_img_mobile'} src={img_event_bg} />
          <div className={'page_container event_creators_box'}>
            <img className={'event_creators_effect_img'} src={img_event_bg} />
            <div className={'event_creators_title_1'}>
              {`나의 최애를 눈앞에서 만나\n직접 대화하고 함께하는 소중한 순간!`}
            </div>
            <div className={'event_creators_title_2'}>
              {`이미 다양한 크리에이터들이 크티를 통해\n팬들과 만나 서로 잊지 못할 경험을 주고받았습니다.`}
            </div>
          </div>
        </div>
      </div>
    );
  }
}

let domContainer = document.querySelector('#react_app_fan_event_page');
ReactDOM.render(<App_Fan_Event />, domContainer);