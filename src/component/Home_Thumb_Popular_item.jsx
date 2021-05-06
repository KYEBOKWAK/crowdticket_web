'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Name from '../component/Name';
import Profile from '../component/Profile';

import Home_Thumb_Product_Label from '../component/Home_Thumb_Product_Label';

import Util from '../lib/Util';
import Types from '../Types';

class Home_Thumb_Popular_item extends Component{

  COORDS = {
    xDown: null,
    xUp: null
  }

  constructor(props){
    super(props);

    this.state = {
      store_user_id: null,

      thumb_img_url: '',

      item_title: '',
      item_price: 0,
      item_price_usd: 0,
      currency_code: Types.currency_code.Won,
      product_category_type: null,

      user_name: '',
      nick_name: '',
    }
  };

  componentDidMount(){
    this.requestItemInfo();
  };

  requestItemInfo = () => {
    axios.post('/store/any/item/info', {
      store_item_id: this.props.store_item_id
    }, (result) => {
      const data = result.data;

      let ask_play_time = data.ask_play_time;
      if(ask_play_time === null){
        ask_play_time = '';
      }

      // console.log(data);

      let _thumb_img_url = this.props.thumb_img_url;
      if(_thumb_img_url === null || _thumb_img_url === ''){
        _thumb_img_url = data.img_url;
      }

      this.setState({
        store_user_id: data.store_user_id,
        
        thumb_img_url: _thumb_img_url,
        item_title: data.title,

        user_name: data.user_name,
        nick_name: data.nick_name,

        item_price: data.price,

        product_category_type: data.product_category_type,

        item_price_usd: data.price_USD,
        currency_code: data.currency_code
      })
    }, (error) => {

    })
  }

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

  render(){
    if(this.state.store_user_id === null){
      return (
        <div className={'Home_Thumb_Popular_item'}>
          <div className={'item_box'}>
          </div>
        </div>
      )
    }

    return(
      <div className={'Home_Thumb_Popular_item'}>
        <button onDragStart={(e) => {e.preventDefault();}} onMouseDown={(e) => {this.handleOnMouseDown(e)}}
            onMouseUp={(e) => {this.handleMouseUp(e)}} onClick={(e) => {this.onClickItem(e)}} className={'item_box'}>
          <img onDragStart={(e) => {e.preventDefault()}} className={'item_img'} src={this.state.thumb_img_url} />
          <div className={'item_content_container'}>
            <Profile user_id={this.state.store_user_id} circleSize={32} isEdit={false}></Profile>
            <div className={'item_content'}>
              <div className={'item_title text-ellipsize-2'}>
                {this.state.item_title}
              </div>
              <div className={'user_name'}>
                <Name style={{fontSize: 12, color: '#999999'}} name={this.state.user_name} nick_name={this.state.nick_name}></Name>
              </div>
              <div className={'price_container'}>
                <div className={'thumb_item_price'}>
                  {Util.getPriceCurrency(this.state.item_price, this.state.item_price_usd, this.state.currency_code)}
                </div>
                <div className={'thumb_item_label'}>
                  <Home_Thumb_Product_Label product_category_type={this.state.product_category_type}></Home_Thumb_Product_Label>
                </div>
              </div>
            </div>
          </div>
        </button>
      </div>
    )
  }
};

//thumb_img_url
Home_Thumb_Popular_item.defaultProps = {
  thumb_img_url: ''
}

export default Home_Thumb_Popular_item;