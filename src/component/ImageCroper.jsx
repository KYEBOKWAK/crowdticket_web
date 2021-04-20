'use strict';

import React, { Component } from 'react';

import Cropper from 'react-easy-crop';

import getCroppedImg from '../lib/cropImage';

import Util from '../lib/Util';

class ImageCroper extends Component{

  canvas = {}

  constructor(props){
    super(props);

    this.state = {
      // image: '',
      crop: { x: 0, y: 0 },
      zoom: 1,
      aspect: 1 / 1,

      imageData: '',
      croppedAreaPixels: {}
    }
  };

  componentDidMount(){
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  onCropChange = (crop) => {
    // console.log(crop);
    this.setState({ crop })
  }
 
  onCropComplete = (croppedArea, croppedAreaPixels) => {
    this.setState({
      croppedAreaPixels: croppedAreaPixels
    })
    /*
    const storagePromise = new Promise((resolve, reject) => {

      const croppedImage = getCroppedImg(
        this.props.image,
        croppedAreaPixels,
        0
      )

      resolve(croppedImage);
    });

    storagePromise.then((value) => {
      this.setState({
        imageData: value
      })
    }).catch((error) => {
      // console.log(error);
      alert(error);
    });
    */
  }
 
  onZoomChange = (zoom) => {
    this.setState({ zoom })
  }

  onClickConfirm = (e) => {
    e.preventDefault();

    const storagePromise = new Promise((resolve, reject) => {

      const croppedImage = getCroppedImg(
        this.props.image,
        this.state.croppedAreaPixels,
        0
      )

      resolve(croppedImage);
    });

    storagePromise.then((value) => {
      const fileData = Util.dataURLtoFile(value, 'thumb_img.jpg');

      this.props.callbackConfirm(fileData);
    }).catch((error) => {
      // console.log(error);
      alert(error);
    });
  }

  onClickExit = (e) => {
    e.preventDefault();

    this.props.callbackExit();
  }

  render(){

    const { image, croppedAreaPixels, crop, zoom, aspect } = this.state;
    
    return(
      <div className={'ImageCroper'}>
        <Cropper
          image={this.props.image}
          crop={this.state.crop}
          zoom={this.state.zoom}
          aspect={this.state.aspect}
          onCropChange={this.onCropChange}
          onCropComplete={this.onCropComplete}
          onZoomChange={this.onZoomChange}
          disableAutomaticStylesInjection={false}
        />

        <div className={'button_container'}>
          <button className={'button_close'} onClick={(e) => {this.onClickExit(e)}}>닫기</button>
          <button className={'button_set'} onClick={(e) => {this.onClickConfirm(e)}}>확인</button>
        </div>
      </div>
    )
  }
};

export default ImageCroper;