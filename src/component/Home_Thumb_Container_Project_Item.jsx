//박스가 나열되는 형태의 리스트(캐러셀 안들어감)
'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Types from '../Types';

// import moment_timezone from 'moment-timezone';
import Util from '../lib/Util';
import { instanceOf } from 'prop-types';

// import Util from '../lib/Util';

const IMAGE_THUMB_WIDTH = 276;
const IMAGE_THUMB_HEIGHT = 276;
class Home_Thumb_Container_Project_Item extends Component{
  constructor(props){
    super(props);

    this.state = {
      user_id: null,

      poster_url: '',
      poster_renew_url: '',
      title: '',
      description: '',
      temporary_date: '',
      city_name: '',
      project_type: '',
      alias: '',
      ticket_date: '',
      funding_closing_at: '',

      show_image_width: 0,
      show_image_height: 0,

      ori_show_image_width: 0,
      ori_show_image_height: 0,


      img_wrapper_width: 0,
      img_wrapper_height: 0,

      item_width: 0,

      isThumbResize: false,

      show_blur_image_width: 0,
      show_blur_image_height: 0,
      isShowBlurImage: true,

      isHaveTicketShowDate: false
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    window.addEventListener('resize', this.updateDimensions);

    this.requestProjectInfo();
    this.requestShowDate();
  };

  requestProjectInfo = () => {
    if(this.props.project_id === null){
      return;
    }

    axios.post('/projects/any/info', {
      project_id: this.props.project_id
    }, (result) => {
      const data = result.data;

      // console.log(data);
      let _project_type = '';
      if(data.project_type === 'artist'){
        _project_type = '아티스트';
      }
      else if(data.project_type === 'creator'){
        _project_type = '크리에이터';
      }
      else if(data.project_type === 'culture'){
        _project_type = '문화';
      }
      else{
        _project_type = '아티스트';
      }

      this.setState({
        user_id: data.user_id,
        poster_url: data.poster_url,
        poster_renew_url: data.poster_renew_url,
        title: data.title,
        description: data.description,

        project_type: _project_type,
        city_name: data.city_name,
        alias: data.alias,
        funding_closing_at: data.funding_closing_at,

        temporary_date: data.temporary_date
      }, () => {
        this.updateDimensions()
      })

      // console.log(result);
    }, (error) => {

    })
  }

  requestShowDate = () => {
    if(this.props.project_id === null){
      return;
    }

    axios.post('/projects/any/ticket/showdate', {
      project_id: this.props.project_id
    }, (result) => {
      // console.log(result);
      if(result.list.length === 0){
        return this.setState({
          isHaveTicketShowDate: false
        })
      }

      if(result.list[0].show_date === '0000-00-00 00:00:00'){
        return this.setState({
          isHaveTicketShowDate: false
        })
      }

      let ticket_date = Util.getTicketShowDate(result.list[0].show_date, result.list[result.list.length - 1].show_date);

      this.setState({
        ticket_date: ticket_date,
        isHaveTicketShowDate: true
      })
      // start_date_moment

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

    // const height = item_width * 0.75;// 4:3 비율로 높이를 가져온다.
    const height = item_width * 1;// 4:3 비율로 높이를 가져온다.
    this.setState({
      item_width: item_width,

      img_wrapper_width: item_width,
      img_wrapper_height: height
    }, () => {
      this.onFrontImgLoad({
        target: {
          naturalWidth: this.state.ori_show_image_width,
          naturalHeight: this.state.ori_show_image_height
        }
      })

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
        this.onFrontImgLoad({
          target: {
            naturalWidth: this.state.ori_show_image_width,
            naturalHeight: this.state.ori_show_image_height
          }
        })

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

  //배경
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

    // if(show_image_width < this.state.item_width){
    //   //결과가 wrapper width 보다 작으면 걍 width를 꽉 채운다
    //   show_image_width = '100%';
    //   show_image_height = 'auto';
    // }

    if(show_image_width <= show_image_height){
      return this.setState({
        show_blur_image_width: show_image_width,
        show_blur_image_height: show_image_height,
        isShowBlurImage: false
      })
    }else{
      this.setState({
        show_blur_image_width: show_image_width,
        show_blur_image_height: show_image_height,
        isShowBlurImage: true
        
      })
    }    
  }

  onFrontImgLoad = (img) => {
    
    let show_image_width = img.target.naturalWidth;
    let show_image_height = img.target.naturalHeight;
    
    //가로로 긴 이미지인가?
    //세로가 긴 이미지는 width 만 맞추면 height는 자동 맞춰짐


    show_image_width = '100%';
    show_image_height = 'auto';
    // const ratio = this.state.item_width / img.target.naturalHeight;

    // const imgReSizeWidth = img.target.naturalWidth * ratio;
    // const imgReSizeHeight = img.target.naturalHeight * ratio;

    
    // show_image_width = imgReSizeWidth,
    // show_image_height = imgReSizeHeight

    // if(show_image_width < this.state.item_width){
    //   //결과가 wrapper width 보다 작으면 걍 width를 꽉 채운다
    //   show_image_width = '100%';
    //   show_image_height = 'auto';
    // }

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

    let urlTail = '';
    if(this.state.alias === null || this.state.alias === ''){
      urlTail = this.props.project_id;
    }else{
      urlTail = this.state.alias;
    }
    
    let hrefURL = baseURL+'/projects/'+urlTail;
    
    window.location.href = hrefURL;
  }

  render(){
    if(this.state.user_id === null){
      return (
        <div className={'Home_Thumb_Container_Project_Item'}>
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

    let imgSrc = this.state.poster_renew_url;
    if(imgSrc === null || imgSrc === ''){
      imgSrc = this.state.poster_url;
    }

    if(imgSrc === null || imgSrc === ''){
      imgSrc = '';
    }

    let blurImageDom = <></>;
    if(this.state.isShowBlurImage){

      let imeageBlurStyle = {}
      if(this.state.show_blur_image_width){
        imeageBlurStyle = {
          width: this.state.show_blur_image_width,
          height: this.state.show_blur_image_height
        }
      }

      blurImageDom = <div className={'item_img_wrapper_blur'} style={imageWrapperStyle} >
                      <img className={'item_img_blur'} style={imeageBlurStyle} onLoad={(img) => {this.onImgLoad(img)}} src={imgSrc} />
                    </div>
    }

    let show_date = '';
    if(this.state.temporary_date !== null && this.state.temporary_date !== '') {
      show_date = this.state.temporary_date;
    }else if(!this.state.isHaveTicketShowDate){
      show_date = Util.getTicketShowDate(this.state.funding_closing_at, null); 
    }else{
      show_date = this.state.ticket_date;
    }

    let textClassName = 'project_title_text text-ellipsize';
    if(window.innerWidth <= 768){
      textClassName = 'project_title_text text-ellipsize-2';
    }

    return(
      <div className={'Home_Thumb_Container_Project_Item'} style={{width: this.state.item_width}}>
        <button onClick={(e) => {this.onClickGoItem(e)}} className={'item_container'}>
          {blurImageDom}
          <div className={'item_img_wrapper'} style={imageWrapperStyle}>
            <img className={'item_img'} style={imageStyle} onLoad={(img) => {this.onFrontImgLoad(img)}} src={imgSrc} />
          </div>
          
          <div className={'item_bottom_container'}>
            <div className={'project_description_text text-ellipsize'}>
              {this.state.description}
            </div>
            <div className={textClassName}>
              {this.state.title}
            </div>
            <div className={'project_contents_bottom_container'}>
              <div className={'project_show_date_container'}>
                <div className={'project_show_date'}>
                  {show_date}
                </div>
                <div className={'project_contents_city_name'}>
                  {this.state.city_name}
                </div>
              </div>
              <div className={'project_contents_type_box'}>
                {this.state.project_type}
              </div>
            </div>
          </div>
        </button>
        
      </div>
    )
  }
};

export default Home_Thumb_Container_Project_Item;