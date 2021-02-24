'use strict';

import React, { Component } from 'react';


import Types from '../Types';


import ic_label_video from '../res/img/ic-label-video.svg';
import ic_label_image from '../res/img/ic-label-image.svg';
import ic_label_text from '../res/img/ic-label-text.svg';
import ic_label_live from '../res/img/ic-label-live.svg';
import ic_label_music from '../res/img/ic-label-music.svg';

class Home_Thumb_Product_Label extends Component{

  constructor(props){
    super(props);

    this.state = {
      thum_icon_img: '',
      text: '',

      product_categorys: [
        {
          type: 'video',
          text: '영상',
          thum_icon_img: ic_label_video
        },
        {
          type: 'image',
          text: '이미지',
          thum_icon_img: ic_label_image
        },
        {
          type: 'text',
          text: '텍스트',
          thum_icon_img: ic_label_text
        },
        {
          type: 'live',
          text: '실시간',
          thum_icon_img: ic_label_live
        },
        {
          type: 'sound',
          text: '음성',
          thum_icon_img: ic_label_music
        },
        {
          type: 'etc',
          text: '기타',
          thum_icon_img: ic_label_text
        },
      ],
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    if(this.props.product_category_type === undefined || this.props.product_category_type === null){
      return;
    }

    const productData = this.state.product_categorys.find((value) => {return value.type === this.props.product_category_type});
    if(productData === undefined){
      return;
    }

    this.setState({
      thum_icon_img: productData.thum_icon_img,
      text: productData.text
    })
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){
    return(
      <div className={'Home_Thumb_Product_Label'}>
        <img src={this.state.thum_icon_img} />
        <div className={'product_label_text'}>
          {this.state.text} 콘텐츠
        </div>
      </div>
    )
  }
};

export default Home_Thumb_Product_Label;