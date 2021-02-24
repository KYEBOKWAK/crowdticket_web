'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Name from '../component/Name';
import Profile from '../component/Profile';

import Util from '../lib/Util';
import Types from '../Types';

const HOME_THUMB_STORE_USER_PROFILE_SIZE = 60;
const HOME_THUMB_STORE_USER_PROFILE_SIZE_MOBILE = 48;

class Home_Thumb_Stores_Item extends Component{

  COORDS = {
    xDown: null,
    xUp: null
  }

  constructor(props){
    super(props);

    this.state = {
      store_user_id: null,
      store_title: '',
      alias: '',

      // thumb_img_url: '',

      // item_title: '',
      // item_price: 0,
      // item_img_url: '',
      // item_id: null,

      user_profile_size: HOME_THUMB_STORE_USER_PROFILE_SIZE
    }
  };

  componentDidMount(){
    window.addEventListener('resize', this.updateDimensions);
    // this.requestItemInfo();
    this.requestStoreInfo();
    // this.requestFirstItemInfo();
  };

  requestStoreInfo = () => {
    axios.post("/store/any/detail/info", {
      store_id: this.props.store_id
    }, (result) => {
      this.setState({
        store_user_id: result.data.store_user_id,
        store_title: result.data.title,
        alias: result.data.alias
      }, () => {
        this.updateDimensions();
      }) 

    }, (error) => {

    })
  }

  componentWillUnmount(){
    window.removeEventListener('resize', this.updateDimensions);
  };

  componentDidUpdate(){
  }

  updateDimensions = () => {

    if(window.innerWidth >= Types.width.pc){
      if(this.state.user_profile_size !== HOME_THUMB_STORE_USER_PROFILE_SIZE){
        this.setState({
          user_profile_size: HOME_THUMB_STORE_USER_PROFILE_SIZE
        })
      }
    }
    else if(window.innerWidth >= Types.width.tablet){
      if(this.state.user_profile_size !== HOME_THUMB_STORE_USER_PROFILE_SIZE){
        this.setState({
          user_profile_size: HOME_THUMB_STORE_USER_PROFILE_SIZE
        })
      }
    }
    else{
      if(this.state.user_profile_size !== HOME_THUMB_STORE_USER_PROFILE_SIZE_MOBILE){
        this.setState({
          user_profile_size: HOME_THUMB_STORE_USER_PROFILE_SIZE_MOBILE
        })
      }
    }
    // this.setState({
    //   innerWidth: window.innerWidth
    // })
  }

  onClickItem = (e) => {
    // e.preventDefault();
    if (this.COORDS.xDown !== this.COORDS.xUp) {
      e.preventDefault()
      // console.log('drag')
    } else {
      // console.log('click')
      let baseURL = 'https://crowdticket.kr'
      const baseURLDom = document.querySelector('#base_url');
      if(baseURLDom){
        baseURL = baseURLDom.value;
      }

      let goURL = baseURL + '/item/store/' + this.props.store_item_id;
      window.location.href = goURL;
    }   
  }

  handleOnMouseDown = (e) => {
    e.preventDefault()
    this.COORDS.xUp = null
    this.COORDS.xDown = null
    
    this.COORDS.xDown = e.clientX
  }
  
  handleMouseUp = (e) => {
    e.preventDefault()
    this.COORDS.xUp = e.clientX
  }

  onClickGoStore = (e) => {
    // e.preventDefault();

    if (this.COORDS.xDown !== this.COORDS.xUp) {
      e.preventDefault()
    } else {
      let baseURL = 'https://crowdticket.kr'
      const baseURLDom = document.querySelector('#base_url');
      if(baseURLDom){
        baseURL = baseURLDom.value;
      }

      if(this.state.alias === null || this.state.alias === ''){
        return;
      }
      const alias = this.state.alias;

      let goTail = alias;

      if(!alias){
        goTail = this.props.store_id;
      }

      let goURL = baseURL + '/store/'+goTail;

      window.location.href = goURL;
    }
  }

  render(){
    if(this.state.store_user_id === null){
      return (
        <div className={'Home_Thumb_Stores_Item'}>
          <div className={'item_box'}>
          </div>
        </div>
      )
    }

    return(
      <div className={'Home_Thumb_Stores_Item'}>
        <button onDragStart={(e) => {e.preventDefault();}} onMouseDown={(e) => {this.handleOnMouseDown(e)}}
            onMouseUp={(e) => {this.handleMouseUp(e)}} onClick={(e) => {this.onClickGoStore(e)}} className={'item_box'}>
          <Profile user_id={this.state.store_user_id} circleSize={this.state.user_profile_size} isEdit={false}></Profile>

          <div className={'item_title_text text-ellipsize'}>
            {this.state.store_title}
          </div>

          {/* <button onDragStart={(e) => {e.preventDefault();}} onMouseDown={(e) => {this.handleOnMouseDown(e)}}
            onMouseUp={(e) => {this.handleMouseUp(e)}} onClick={(e) => {this.onClickGoStore(e)}} className={'item_button_box'}>
            상점 가기
          </button> */}
        </button>
      </div>
    )
  }
};

//thumb_img_url
Home_Thumb_Stores_Item.defaultProps = {
}

export default Home_Thumb_Stores_Item;