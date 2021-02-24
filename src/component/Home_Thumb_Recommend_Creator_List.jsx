'use strict';

import React, { Component } from 'react';

import ScrollBooster from 'scrollbooster';
import axios from '../lib/Axios';

import Profile from '../component/Profile';
// import Name from '../component/Name';

import ic_list_review from '../res/img/ic-list-review.svg';
import ic_list_view from '../res/img/ic-list-view.svg';

import Types from '../Types';

import Home_Thumb_Tag from '../component/Home_Thumb_Tag';

const HOME_THUMB_RECOMMEND_USER_PROFILE_SIZE_PC = 100;
const HOME_THUMB_RECOMMEND_USER_PROFILE_SIZE_TABLET = 90;
const HOME_THUMB_RECOMMEND_USER_PROFILE_SIZE_MOBILE = 80;
class Home_Thumb_Recommend_Creator_List extends Component{

  scrollBooster = null;
  constructor(props){
    super(props);

    this.state = {
      innerWidth: 0,
      user_profile_size: HOME_THUMB_RECOMMEND_USER_PROFILE_SIZE_PC,
      items: []
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  setScrollAction = () => {
    const viewport = document.querySelector('.Home_Thumb_Recommend_Creator_List .viewport');
    const content = document.querySelector('.Home_Thumb_Recommend_Creator_List .scrollable-content');

    this.scrollBooster = new ScrollBooster({
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
    this.scrollBooster.updateMetrics();
    // sb.scrollTo({ x: 100, y: 100 });
    this.scrollBooster.updateOptions({ emulateScroll: false });
    // sb.destroy();
  }

  destroyScrollAction = () => {
    if(this.scrollBooster !== null){
      this.scrollBooster.destroy();
      this.scrollBooster = null;
    }
  }

  componentDidMount(){
    this.requestRecommandCreator();

    window.addEventListener('resize', this.updateDimensions);
    // this.updateDimensions();
  };

  componentWillUnmount(){
    window.removeEventListener('resize', this.updateDimensions);
    this.scrollBooster = null;
  };

  updateDimensions = () => {

    if(window.innerWidth >= Types.width.pc){
      this.destroyScrollAction();
    }else{
      if(this.scrollBooster === null){
        this.setScrollAction();
      }
    }

    if(window.innerWidth >= Types.width.pc){
      if(this.state.user_profile_size !== HOME_THUMB_RECOMMEND_USER_PROFILE_SIZE_PC){
        this.setState({
          user_profile_size: HOME_THUMB_RECOMMEND_USER_PROFILE_SIZE_PC
        })
      }
    }
    else if(window.innerWidth >= Types.width.tablet){
      if(this.state.user_profile_size !== HOME_THUMB_RECOMMEND_USER_PROFILE_SIZE_TABLET){
        this.setState({
          user_profile_size: HOME_THUMB_RECOMMEND_USER_PROFILE_SIZE_TABLET
        })
      }
    }
    else{
      if(this.state.user_profile_size !== HOME_THUMB_RECOMMEND_USER_PROFILE_SIZE_MOBILE){
        this.setState({
          user_profile_size: HOME_THUMB_RECOMMEND_USER_PROFILE_SIZE_MOBILE
        })
      }
    }
    // this.setState({
    //   innerWidth: window.innerWidth
    // })
  }

  onClickGoStore = (e, url) => {
    e.preventDefault();

    window.location.href = url;
  }

  requestRecommandCreator = () => {
    axios.post("/main/any/recommand/creator", {}, 
    (result) => {

      let baseURL = 'https://crowdticket.kr'
      const baseURLDom = document.querySelector('#base_url');
      if(baseURLDom){
        baseURL = baseURLDom.value;
      }

      let _items = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];

        const alias = data.alias;

        let goTail = alias;

        if(!alias){
          goTail = this.state.store_id;
        }

        let goURL = baseURL + '/store/'+goTail;

        const recommandDom = <div key={i} className={'item_box'}>
                              <Profile user_id={data.store_user_id} circleSize={this.state.user_profile_size} isEdit={false}></Profile>
                              <div className={'item_best_label_box'}>
                                Best
                              </div>

                              <div className={'item_title_text'}>
                                {data.store_title}
                              </div>

                              <div className={'item_info_container'}>
                                <div className={'item_review_count_container'}>
                                  <img src={ic_list_review} />
                                  <div className={'item_review_count'}>
                                    {data.comment_count}
                                  </div>
                                </div>
                                <div className={'item_view_count_container'}>
                                  <img src={ic_list_view} />
                                  <div className={'item_view_count'}>
                                    {data.view_count}
                                  </div>
                                </div>
                              </div>

                              <button onClick={(e) => {this.onClickGoStore(e, goURL)}} className={'item_button_box'}>
                                상점 가기
                              </button>
                            </div>;

        _items.push(recommandDom);
      }

      this.setState({
        items: _items.concat()
      }, () => {
        this.updateDimensions();
      })
    }, (error) => {

    })
  }

  componentDidUpdate(){
  }

  render(){
    return(
      <div className={'Home_Thumb_Recommend_Creator_List'}>
        <div className={'Home_Thumb_Tag_container'}>
          <Home_Thumb_Tag thumb_tags={Types.thumb_tags.trend}></Home_Thumb_Tag>
        </div>
        <div className={'label_text'}>
          요즘 나 빼고 다 아는 크리에이터
        </div>
        <div className={'list_container'}>
          <div className={'viewport'}>
            <div className={'scrollable-content'} style={{display: 'flex', flexDirection: 'row',}}>
              {this.state.items}
            </div>
            <div className={'blur_thumb_cover'}>
            </div>
          </div>
        </div>
      </div>
    )
  }
};

export default Home_Thumb_Recommend_Creator_List;