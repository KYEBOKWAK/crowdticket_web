//박스가 나열되는 형태의 리스트(캐러셀 안들어감)
'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Home_Thumb_Product_Label from '../component/Home_Thumb_Product_Label';

import Profile from '../component/Profile';
import Name from '../component/Name';
import Types from '../Types';

import Util from '../lib/Util';

const IMAGE_THUMB_WIDTH = 276;
const IMAGE_THUMB_HEIGHT = 207;
class Home_Thumb_Container_Item extends Component{
  constructor(props){
    super(props);

    this.state = {
      store_user_id: null,
      user_name: '',
      nick_name: '',


      item_img_url: '',
      item_title: '',
      item_price: 0,

      show_image_width: 0,
      show_image_height: 0,

      ori_show_image_width: 0,
      ori_show_image_height: 0,


      img_wrapper_width: 0,
      img_wrapper_height: 0,

      item_width: 0,

      isThumbResize: false
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){    
    window.addEventListener('resize', this.updateDimensions);
    this.requestItemInfo();
  };

  requestItemInfo = () => {
    if(this.props.store_item_id === null){
      return;
    }

    axios.post('/store/any/item/info', {
      store_item_id: this.props.store_item_id
    }, (result) => {
      const data = result.data;

      this.setState({
        store_user_id: data.store_user_id,

        item_title: data.title,
        item_price: data.price,
        product_category_type: data.product_category_type,

        item_img_url: data.img_url,

        user_name: data.user_name,
        nick_name: data.nick_name
      }, () => {  
        this.updateDimensions();
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){  
    window.removeEventListener('resize', this.updateDimensions);    
  };

  setItemWidth = () => {
    let window_width = window.innerWidth;
    var inner_window_width = document.body.clientWidth;

    let side_gap = 0;
    let item_gap = 0;
    if(window_width <= Types.width.tablet){
      side_gap = 24;  //양 사이드 갭
      item_gap = 17;  //row_items_gap css
    }
    else if(window_width <= Types.width.pc){
      side_gap = 40;  //양 사이드 갭
      item_gap = 24;  //row_items_gap css
    }

    // console.log((inner_window_width - side_gap - side_gap - item_gap));

    let item_width = (inner_window_width - side_gap - side_gap - item_gap) / 2;

    const height = item_width * 0.75;// 4:3 비율로 높이를 가져온다.
    this.setState({
      item_width: item_width,

      img_wrapper_width: item_width,
      img_wrapper_height: height
    }, () => {
      this.onImgLoad({
        target: {
          naturalWidth: this.state.ori_show_image_width,
          naturalHeight: this.state.ori_show_image_height
        }
      })
    })
    
  }

  updateDimensions = () => {

    if(window.innerWidth <= Types.width.pc){
      this.setItemWidth();
    }else{
      this.setState({
        item_width: IMAGE_THUMB_WIDTH,
        img_wrapper_width: IMAGE_THUMB_WIDTH,
        img_wrapper_height: IMAGE_THUMB_HEIGHT
      }, () => {
        this.onImgLoad({
          target: {
            naturalWidth: this.state.ori_show_image_width,
            naturalHeight: this.state.ori_show_image_height
          }
        })
      })
    }
  }

  componentDidUpdate(){
  }

  onImgLoad = (img) => {
    
    let show_image_width = img.target.naturalWidth;
    let show_image_height = img.target.naturalHeight;
    
    //가로로 긴 이미지인가?
    //세로가 긴 이미지는 width 만 맞추면 height는 자동 맞춰짐

    const ratio = this.state.item_width / img.target.naturalHeight;

    const imgReSizeWidth = img.target.naturalWidth * ratio;
    const imgReSizeHeight = img.target.naturalHeight * ratio;

    
    show_image_width = imgReSizeWidth,
    show_image_height = imgReSizeHeight

    if(show_image_width < this.state.item_width){
      //결과가 wrapper width 보다 작으면 걍 width를 꽉 채운다
      show_image_width = '100%';
      show_image_height = 'auto';
    }

    this.setState({
      show_image_width: show_image_width,
      show_image_height: show_image_height,

      ori_show_image_width: img.target.naturalWidth,
      ori_show_image_height: img.target.naturalHeight
    })
  }

  onClickGoItem = (e) => {
    e.preventDefault()

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }
    
    let hrefURL = baseURL+'/item/store/'+this.props.store_item_id;
    
    window.location.href = hrefURL;
  }

  render(){
    if(this.state.store_user_id === null){
      return (
        <div className={'Home_Thumb_Container_Item'}>
          <div className={'item_container'}>
            
          </div>
        </div>
      )
    }

    let imageStyle = {}
    // if(this.state.show_image_width > 0 || this.state.show_image_width !== ''){
    if(this.state.show_image_width){
      imageStyle = {
        width:this.state.show_image_width,
        height: this.state.show_image_height,
      }
    }

    let imageWrapperStyle = {}
    if(this.state.item_width > 0){
      imageWrapperStyle = {
        width: this.state.item_width,
        height: this.state.img_wrapper_height
      }
    }

    return(
      <div className={'Home_Thumb_Container_Item'} style={{width: this.state.item_width}}>
        <button onClick={(e) => {this.onClickGoItem(e)}} className={'item_container'}>
          <div className={'item_img_wrapper'} style={imageWrapperStyle}>
            <img className={'item_img'} style={imageStyle} onLoad={(img) => {this.onImgLoad(img)}} src={this.state.item_img_url} />
          </div>
          
          <div className={'item_bottom_container'}>
            <Profile user_id={this.state.store_user_id} circleSize={32} isEdit={false}></Profile>
            <div className={'item_contents_container'}>
              <div className={'item_contents_title text-ellipsize-2'}>
                {this.state.item_title}
              </div>
              <div className={'item_contents_name'}>
                <Name style={{fontSize: 12, color: '#999999'}} name={this.state.user_name} nick_name={this.state.nick_name}></Name>
              </div>

              <div className={'item_contents_price_container'}>
                <div className={'item_contents_price'}>
                  {Util.getNumberWithCommas(this.state.item_price)}원
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

export default Home_Thumb_Container_Item;