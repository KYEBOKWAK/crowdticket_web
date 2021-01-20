'use strict';

import React, { Component } from 'react';

import Types from '../Types';

import ic_exit_circle from '../res/img/ic-exit-circle.svg';

class Popup_image_preview extends Component{

  constructor(props){
    super(props);

    this.state = {
      container_width: '80%',
      isChangeWidth: false
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  componentDidMount(){
    
  };

  componentWillUnmount(){
  };

  componentDidUpdate(){
    
  }

  onClickExit = (e) => {
    e.preventDefault();

    this.props.closeCallback();
  }

  onImgLoad = (img) => {

    if(window.innerHeight <= img.target.offsetHeight){
      if(!this.state.isChangeWidth){
        this.setState({
          container_width: '50%',
          isChangeWidth: true
        })
      }
    }
    // width: img.target.offsetWidth,
    //   height: img.target.offsetHeight
  }

  render(){    
    return(
      <div className={'Popup_image_preview'}>
        <div style={{width: this.state.container_width}} className={'popup_container'}>
          <img onLoad={(img) => {this.onImgLoad(img)}} className={'img'} src={this.props.previewURL} />
          <button className={'exitButton'} onClick={(e) => {this.onClickExit(e)}}>
            <img className={'exitImage'} src={ic_exit_circle} />
          </button>
        </div>
      </div>
    )
  }
};

Popup_image_preview.defaultProps = {
  previewURL: ''
  // state: Types.file_upload_state.NONE,
  // id: -1,
  // store_item_id: -1,
  // thumbUrl: '',
  // name: '',
  // title: '',
  // price: 0
}

export default Popup_image_preview;