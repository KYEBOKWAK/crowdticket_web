'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import axios from './lib/Axios';

import ic_pop_close from './res/img/ic-pop-close.svg';

import Cookies from 'universal-cookie';
import Types from './Types';

const TOP_BANNER_COOKIE_NAME = 'cr_top_banner';
class App_Top_Banner extends Component{

  constructor(props){
    super(props);

    this.state = {
      backgroundColor: 'white',
      icon_image_url: '',
      icon_image_size: 24,
      contents: '',
      contents_color: 'black',
      isShow: false,
      top_banner_type: Types.top_banner.none,

      link_url: ''
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    

    const cookies = new Cookies();
    let cookiesName = TOP_BANNER_COOKIE_NAME;
    let top_banner_cookies = cookies.get(cookiesName);
    if(top_banner_cookies === undefined){
      this.requestTopBannerInfo();
    }    
  };

  requestTopBannerInfo = () => {
    axios.post("/event/any/banner/top/info", {}, 
    (result) => {
      const data = result.data;
      if(data === null){
        this.setState({
          isShow: false
        })
      }else{
        this.setState({
          contents: data.contents,
          contents_color: data.contents_color,
          backgroundColor: data.background_color,
          top_banner_type: data.type,
          isShow: true,

          icon_image_size: data.icon_img_size,
          icon_image_url: data.icon_img_url,
          link_url: data.link_url
        })
      }    
    }, (error) => {

    })
    
  }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  closeBanner = (callback_success) => {
    const cookies = new Cookies();

    let cookiesName = TOP_BANNER_COOKIE_NAME;
    var today = new Date();
    var nextDay = new Date(today);
    nextDay.setHours(today.getHours() + 24);

    cookies.set(cookiesName, '0', 
    { 
      path: '/',
      expires: nextDay
    });

    this.setState({
      isShow: false
    }, () => {
      callback_success();
    })
  }

  onClickBanner = (e) => {
    e.preventDefault();

    if(this.state.top_banner_type === Types.top_banner.kakao_channel){
      Kakao.Channel.addChannel({
        channelPublicId: '_JUxkxjM'
      });
    }else{
      window.location.href = this.state.link_url
    }
  }

  onClickClose = (e) => {
    e.preventDefault();


    this.closeBanner(() => {});
    

    /*
    const cookies = new Cookies();

    let cookiesName = 'cr_top_banner';

    let top_banner_cookies = cookies.get(cookiesName);
    if(top_banner_cookies === undefined){
      var today = new Date();

      var nextDay = new Date(today);
      nextDay.setMinutes(today.getMinutes() + 60);

      cookies.set(cookiesName, '0', 
      { 
        path: '/',
        expires: nextDay
      });
    }
    */

  }

  render(){
    if(!this.state.isShow){
      return (<></>)
    }

    let backgroundStyle = {
      backgroundColor: this.state.backgroundColor
    }

    let contentsStyle = {}
    // let contentsDom = <></>;

    let image_icon_dom = <></>;
    if(this.state.icon_image_url === undefined || this.state.icon_image_url === null || this.state.icon_image_url === ''){
      //이미지 없음.
      image_icon_dom = <></>;
      
      contentsStyle = {
        marginLeft: 0
      }
    }else{
      contentsStyle = {
        marginLeft: 6
      }

      const imageSize = this.state.icon_image_size;
      image_icon_dom = <img style={{width: imageSize, height: imageSize}} src={this.state.icon_image_url} />
    }
    

    return(
      <div className={'App_Top_Banner'}>
        <div className={'background_container'} style={backgroundStyle}>
          <div className={'contents_container'}>

            <button onClick={(e) => {this.onClickBanner(e)}} className={'contents_box'}>
              {image_icon_dom}
              <div style={contentsStyle} className={'contents_text'}>
                {this.state.contents}
              </div>
            </button>

            <button onClick={(e) => {this.onClickClose(e)}} className={'close_button'}>
              <img src={ic_pop_close} />
            </button>
          </div>
        </div>
      </div>
    )
  }
};

let domContainer = document.querySelector('#react_top_banner');
ReactDOM.render(<App_Top_Banner />, domContainer);