'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Profile from '../component/Profile';

const HOME_THUMB_ATTENTION_USER_PROFILE_SIZE = 60;

class Find_Result_Stores_item extends Component{

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

      item_title: '',
      item_price: 0,
      item_img_url: '',
      item_id: null,

      user_profile_size: HOME_THUMB_ATTENTION_USER_PROFILE_SIZE
    }
  };

  componentDidMount(){
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
      }) 

    }, (error) => {

    })
  }

  // requestFirstItemInfo = () => {
  //   axios.post("/store/any/item/info/first", {
  //     store_id: this.props.store_id
  //   }, (result) => {
  //     const data = result.data;
  //     this.setState({
  //       item_title: data.title,
  //       item_price: data.price,
  //       item_img_url: data.img_url,
  //       item_id: data.id
  //     })
  //   })
  // }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
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

  onClickGoItemPage = (e) => {
    if (this.COORDS.xDown !== this.COORDS.xUp) {
      e.preventDefault();
    } else {
      let baseURL = 'https://crowdticket.kr'
      const baseURLDom = document.querySelector('#base_url');
      if(baseURLDom){
        baseURL = baseURLDom.value;
      }

      if(this.state.item_id === null || this.state.item_id === ''){
        return;
      }

      let goURL = baseURL + '/item/store/'+this.state.item_id;

      window.location.href = goURL;
    }
  }

  render(){
    if(this.state.store_user_id === null){
      return (
        <div className={'Find_Result_Stores_item'}>
          <div className={'item_box'}>
          </div>
        </div>
      )
    }

    return(
      <div className={'Find_Result_Stores_item'}>
        <div className={'item_box'}>
          <Profile user_id={this.state.store_user_id} circleSize={this.state.user_profile_size} isEdit={false}></Profile>

          <div className={'item_title_text text-ellipsize'}>
            {this.state.store_title}
          </div>

          <button onDragStart={(e) => {e.preventDefault();}} onMouseDown={(e) => {this.handleOnMouseDown(e)}}
            onMouseUp={(e) => {this.handleMouseUp(e)}} onClick={(e) => {this.onClickGoStore(e)}} className={'item_button_box'}>
            상점 가기
          </button>
        </div>
      </div>
    )
  }
};

//thumb_img_url
Find_Result_Stores_item.defaultProps = {
}

export default Find_Result_Stores_item;