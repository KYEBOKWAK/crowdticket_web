'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Util from '../lib/Util';
import Types from '../Types';

class Thumb_Project_Item extends Component{

  COORDS = {
    xDown: null,
    xUp: null
  }

  constructor(props){
    super(props);

    this.state = {
      user_id: null,

      project_id: null,
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

      isHaveTicketShowDate: false,
    }
  };

  componentDidMount(){
    // window.addEventListener('resize', this.updateDimensions);

    this.requestProjectInfo();
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
        project_id: data.project_id,
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
        // this.updateDimensions()
      })

      // console.log(result);
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

      if(this.state.project_id === null){
        alert('project ID 에러! 새로고침 후 다시 이용 부탁드립니다');
        return;
      }

      let urlTail = this.state.alias;
      if(urlTail === undefined || urlTail === null || urlTail === ''){
        urlTail = this.state.project_id
      }

      window.location.href = '/projects/'+urlTail;
    }   
  }

  handleOnMouseDown = (e) => {
    e.preventDefault();
    console.log(this.props.project_id);
    this.COORDS.xUp = null
    this.COORDS.xDown = null
    
    this.COORDS.xDown = e.clientX
  }
  
  handleMouseUp = (e) => {
    e.preventDefault()
    this.COORDS.xUp = e.clientX
  }

  onImgLoad = (img) => {
    
    let show_image_width = img.target.naturalWidth;
    let show_image_height = img.target.naturalHeight;

    
    //가로로 긴 이미지인가?
    //세로가 긴 이미지는 width 만 맞추면 height는 자동 맞춰짐

    if(show_image_width <= show_image_height){
      return this.setState({
        isShowBlurImage: false
      })
    }else{
      this.setState({
        isShowBlurImage: true
      })
    }    
  }

  render(){
    if(this.state.user_id === null){
      return (
        <div className={'Thumb_Project_Item'}>
          <div className={'item_box'}>
          </div>
        </div>
      )
    }

    let imgSrc = this.state.poster_renew_url;
    if(imgSrc === null || imgSrc === ''){
      imgSrc = this.state.poster_url;
    }

    if(imgSrc === null || imgSrc === ''){
      imgSrc = '';
    }

    let show_date = '';
    if(this.state.temporary_date !== null && this.state.temporary_date !== '') {
      show_date = this.state.temporary_date;
    }else if(!this.state.isHaveTicketShowDate){
      show_date = Util.getTicketShowDate(this.state.funding_closing_at, null); 
    }else{
      show_date = this.state.ticket_date;
    }

    let blurImageDom = <></>;
    if(this.state.isShowBlurImage){
      blurImageDom = <div className={'item_img_wrapper_blur'} >
                      <img className={'item_img_blur'} src={imgSrc} />
                    </div>
    }

    return(
      <div className={'Thumb_Project_Item'}>
        <button onDragStart={(e) => {e.preventDefault();}} onMouseDown={(e) => {this.handleOnMouseDown(e)}}
            onMouseUp={(e) => {this.handleMouseUp(e)}} onClick={(e) => {this.onClickItem(e)}} className={'item_box'}>
          {blurImageDom}
          <div className={'img_box'}>
            <img onDragStart={(e) => {e.preventDefault()}} className={'item_img'} onLoad={(img) => {this.onImgLoad(img)}} src={imgSrc} />
          </div>
          <div className={'item_content_container'}>
            <div className={'project_description_text text-ellipsize'}>
              {this.state.description}
            </div>
            <div className={'project_title_text'}>
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

//thumb_img_url
Thumb_Project_Item.defaultProps = {
  thumb_img_url: ''
}

export default Thumb_Project_Item;