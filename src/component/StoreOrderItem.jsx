'use strict';

import React, { Component } from 'react';

import Util from '../lib/Util';

const IMAGE_FILE_WIDTH = 80;

class StoreOrderItem extends Component{

  constructor(props){
    super(props);

    this.state = {
      show_image_width: 0,
      show_image_height: 0,
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    // this.requestStoreContents();
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){ 
  }

  onImgLoad = (img) => {
    let show_image_width = img.target.offsetWidth;
    let show_image_height = img.target.offsetHeight;
    
    //가로로 긴 이미지인가?
    //세로가 긴 이미지는 width 만 맞추면 height는 자동 맞춰짐
    if(img.target.offsetWidth > img.target.offsetHeight){
      //가로가 긴 이미지
      //세로 비율을 찾는다
      let ratio = IMAGE_FILE_WIDTH / img.target.offsetHeight;      

      const imgReSizeWidth = img.target.offsetWidth * ratio;
      const imgReSizeHeight = img.target.offsetHeight * ratio;

      
      show_image_width = imgReSizeWidth,
      show_image_height = imgReSizeHeight
      
    }

    this.setState({
      show_image_width: show_image_width,
      show_image_height: show_image_height
    })
  }

  itemClick(e){
    e.preventDefault();
    
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    let goURL = baseURL + '/item/store/' + this.props.store_item_id;

    window.location.href = goURL;
  }

  render(){

    let imgWarpperStyle = {
      width: IMAGE_FILE_WIDTH,
      height: IMAGE_FILE_WIDTH
    }

    let inItemImgStyle = {};
    if(this.state.show_image_width > 0){
      inItemImgStyle = {
        width: this.state.show_image_width,
        height: this.state.show_image_height
      }
    }

    return(
      <div className={'StoreOrderItem'}>
        
        <div className={'flex_layer flex_direction_row'}>
            <div style={imgWarpperStyle} className={'item_img_wrapper'}>
              <img style={inItemImgStyle} onLoad={(img) => {this.onImgLoad(img)}} className={'item_img'} src={this.props.thumbUrl}/>
            </div>
            <div className={'item_content_container'}>
              <div className={'item_name'}>{this.props.store_title}</div>
              <div className={'item_title'}>{this.props.title}</div>
              <div className={'item_price'}>{Util.getNumberWithCommas(this.props.price)}원</div>
            </div>
        </div>
        
        <div className={'item_under_line'}>
        </div>
      </div>
    )
  }
};

StoreOrderItem.defaultProps = {
  id: -1,
  store_item_id: -1,
  store_title: '',
  thumbUrl: '',
  name: '',
  title: '',
  price: 0
}

export default StoreOrderItem;