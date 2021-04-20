'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import default_user_img from '../res/img/default-user-image.png';
import ic_camera_fill from '../res/img/ic-camera-fill.svg';

import ic_btn_profile_edit from '../res/img/btn-profile-edit.svg';

import imageCompression from 'browser-image-compression';
import ImageCroper from '../component/ImageCroper';

import Types from '../Types';

import _axios from 'axios';

class Profile extends Component{

  fileInputRef = React.createRef();

  constructor(props){
    super(props);

    this.state = {
      profile_photo_url: '',
      show_image_width: 0,
      show_image_height: 0,

      temp_image: '',
      imageBinary: '',
      isShowImageCroper: false
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestUserInfo();
  };

  onImgLoad = (img) => {
    let show_image_width = img.target.offsetWidth;
    let show_image_height = img.target.offsetHeight;
    
    //가로로 긴 이미지인가?
    //세로가 긴 이미지는 width 만 맞추면 height는 자동 맞춰짐
    if(img.target.offsetWidth > img.target.offsetHeight){
      //가로가 긴 이미지
      //세로 비율을 찾는다
      // const ratio = IMAGE_FILE_WIDTH / img.target.offsetHeight;
      const ratio = this.props.circleSize / img.target.offsetHeight;

      const imgReSizeWidth = img.target.offsetWidth * ratio;
      const imgReSizeHeight = img.target.offsetHeight * ratio;

      
      show_image_width = imgReSizeWidth,
      show_image_height = imgReSizeHeight

      // console.log("adfdsf");
      
    }else{
      show_image_width = '100%';
      show_image_height = 'auto';
    }

    this.setState({
      show_image_width: show_image_width,
      show_image_height: show_image_height
    })
  }

  requestUserInfo = () => {
    if(this.props.user_id === null){
      return;
    }


    axios.post('/user/any/info/userid', {
      target_user_id: this.props.user_id
    }, (result) => {
      const userInfo = result.userInfo;

      this.setState({
        profile_photo_url: userInfo.profile_photo_url
      })

    }, (error) => {

    })
  }

  componentWillUnmount(){
    this.fileInputRef = null;
  };

  componentDidUpdate(){
  }

  clickPhotoAdd(e){
    e.preventDefault();

    this.fileInputRef.click();
  }

  onInputClick = (event) => {
    event.target.value = ''
  }

  handleImageUpload = (event) => {
 
    var imageFile = event.target.files[0];

    // let contentType = imageFile.type;
   
    var options = {
      maxSizeMB: 2,
      maxWidthOrHeight: 1920,
      useWebWorker: true,

      onProgress: (value) => {
        let _value = value;
        if(value === 100){
          _value = 0
        }

        this.setState({
          img_compress_progress: _value
        })
      } 
    }

    imageCompression(imageFile, options)
      .then( (compressedFile) => {

        var reader = new FileReader();
        reader.onload = (e) => {
          const imagePreview = e.target.result;

          this.setState({
            temp_image: imagePreview,
            isShowImageCroper: true
          })
        };

        reader.readAsDataURL(compressedFile);
      })
      .catch( (error) => {
        alert(error.message);
        return;
        // console.log(error.message);
      });
  }

  setThumbImage = (imageData) => {
    var reader = new FileReader();
      reader.onload = (e) => {
        const imagePreview = e.target.result;

        this.setState({
          profile_photo_url: imagePreview,
          temp_image: '',
          imageBinary: imageData,
          // contentType: contentType,
          isChangeImg: true,

          show_image_width: 0,
          show_image_height: 0,

          isShowImageCroper: false
        })
      };

    reader.readAsDataURL(imageData);
  }

  uploadProfileImage = (target_id, _target_type, successCallback, errorCallback) => {

    if(this.state.imageBinary === ''){
      successCallback();
      return;
    }

    if(!_target_type){
      return;
    }

    let target_type = Types.file_upload_target_type.user;

    const file = this.state.imageBinary;
    let data = new FormData();
    data.append('target_id', target_id);
    data.append('target_type', target_type);

    data.append("blob", file, file.name);
    
    // return;
    
    const options = {
      header: { "content-type": "multipart/form-data" },
      // onUploadProgress: (progressEvent) => {
      //   const {loaded, total} = progressEvent;
      //   let percent = Math.floor( (loaded * 100) / total);
      //   // console.log(`${loaded}kb of ${total}kb | ${percent}%`);
      //   this.setState({
      //     uploading_progress: percent
      //   })
      // }
    }
    
    let apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_REAL;
    const app_type_key = document.querySelector('#g_app_type');
    if(app_type_key){
      if(app_type_key.value === 'local'){
        apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_local;
      }else if(app_type_key.value === 'qa'){
        apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_QA;
      }
    }

    _axios.post(`${apiURL}/uploader/files/profile/img`, data, options).then((res) => {
      successCallback();
    }).catch((error) => {
      alert("프로필 이미지 저장 에러");
      errorCallback();
    })
  }

  render(){

    let photoImg = this.state.profile_photo_url;
    if(photoImg === undefined || photoImg === null || photoImg === ''){
      photoImg = default_user_img;
    }

    let profile_wrapper_style = {
      width: this.props.circleSize,
      height: this.props.circleSize
    }

    let profile_img_style = {};
    if(this.state.show_image_width !== 0){
      profile_img_style = {
        width: this.state.show_image_width,
        height: this.state.show_image_height
      }
    }

    let camera_icon = <></>;
    let isButtonDisable = true;
    if(this.props.isEdit){
      isButtonDisable = false;

      if(this.props.isBlackCameraIcon){
        camera_icon = <div className={'ic_camera_box'} style={{width: 32, height: 32}}>
                        <img src={ic_btn_profile_edit} />
                      </div>
      }else{
        camera_icon = <div className={'ic_camera_box'}>
                        <img className={'ic_camera_img'} src={ic_camera_fill} />
                      </div>
      }
      
    }

    let imageCroperDom = <></>;
    if(this.state.isShowImageCroper){
      imageCroperDom = <ImageCroper 
                        image={this.state.temp_image}
                        callbackExit={() => {
                          this.setState({
                            temp_image: '',
                            isShowImageCroper: false
                          })
                        }}
                        callbackConfirm={(imageData) => {
                          // this.setImageCompress(imageData);
                          this.setThumbImage(imageData);
                        }}>
                        </ImageCroper>
    }

    let buttonDom = <></>;
    if(isButtonDisable){
      buttonDom = <div className={'profile_button'}>
                    <div style={profile_wrapper_style} className={'profile_img_wrapper'}>
                      <img 
                      onDragStart={(e) => {e.preventDefault()}}
                      style={profile_img_style} 
                      onLoad={(img) => {this.onImgLoad(img)}} 
                      src={photoImg} 
                      className={'profile_img'} 
                      onError={(e) => 
                        {
                          this.setState({profile_photo_url: ''})
                        }} />
                    </div>

                    {camera_icon}
                  </div>
    }else{
      buttonDom = <button className={'profile_button'} onClick={(e) => {this.clickPhotoAdd(e)}} disabled={isButtonDisable}>
                    <div style={profile_wrapper_style} className={'profile_img_wrapper'}>
                      <img 
                      onDragStart={(e) => {e.preventDefault()}}
                      style={profile_img_style} 
                      onLoad={(img) => {this.onImgLoad(img)}} 
                      src={photoImg} 
                      className={'profile_img'} 
                      onError={(e) => 
                        {
                          this.setState({profile_photo_url: ''})
                        }} />
                    </div>

                    {camera_icon}
                  </button>
    }
    

    return(
      <div className={'Profile'}>
        <input onClick={this.onInputClick} accept={'image/*'} ref={(ref) => {this.fileInputRef = ref}} type="file" onChange={this.handleImageUpload} style={{display: 'none'}}/>
        {buttonDom}
        {imageCroperDom}
      </div>
    )
  }
};

Profile.defaultProps = {
  user_id: null,
  circleSize: 80,
  isEdit: false,
  isBlackCameraIcon: false

  // successUploadCallback: () => {},
  // errorUploadCallback: () => {},
}

export default Profile;