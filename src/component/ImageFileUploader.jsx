'use strict';

import React, { Component } from 'react';

import axios from '../lib/Axios';
import Util from '../lib/Util';

import _axios from 'axios';

import Types from '../Types';

import ic_photo_up_img from '../res/img/ic-photo-up.svg';
import ic_file_up_img from '../res/img/ic-file-up.svg';

import ic_file_icon_img from '../res/img/ic-file-icon.png';

import ic_exit_circle from '../res/img/ic-exit-circle.svg';

import ic_file_download_img from '../res/img/ic-file-download-icon.svg';

import ScrollBooster from 'scrollbooster';

import Popup_progress from '../component/Popup_progress';
import Popup_image_preview from '../component/Popup_image_preview';

class ImageFileUploader extends Component{
  fileInputRef = React.createRef();

  constructor(props){
    super(props);

    this.state = {
      files: [],
      show_images: [],
      isInitScrollAction: false,

      isFileUploading: false,
      uploading_progress: 0,

      previewURL: '',
      isPreview: false,

      MAX_FILES_COUNT: 5,

      isRequestFile: false,

      // isInitScrollAction: false,

      addFileIDs: []  //추가된 파일
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  componentDidMount(){
    if(this.props.store_item_id === null || this.props.store_item_id === undefined){
      return;
    }

    
    // this.requestFilesData();
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
    if(this.props.store_item_id === null || this.props.store_item_id === undefined){
      return;
    }

    
    if(!this.state.isRequestFile){
      this.setState({
        isRequestFile: true
      }, () => {
        this.requestFilesData();
      })
    }

    
    if(!this.state.isInitScrollAction){
      this.setState({
        isInitScrollAction: true
      }, () => {
        this.setScrollAction();
      })
    }
    
    
    
  }

  requestFilesData = () => {
    if(this.props.store_item_id === null || this.props.store_item_id === undefined){
      return;
    }

    axios.post('/store/file/item/list', {
      store_item_id: this.props.store_item_id,
      file_upload_target_type: this.props.file_upload_target_type
    }, (result) => {
      let _files = [];
      let _show_images = [];

      if(result.list.length === 0){
        // this.setScrollAction();
        this.props.noDataCallback(true);
        return;
      }

      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        const reData = {
          key: i,
          id: data.id,
          file: {
            type: data.mimetype,
            name: data.originalname
          },
          downloadURL: data.url
        }

        _files.push(reData);

        const isImage = data.mimetype.indexOf('image');
        if(isImage >= 0){
          const imageData = {
            key: i,
            image: data.url
          }

          _show_images.push(imageData);
        }
      }

      this.setState({
        files: _files.concat(),
        show_images: _show_images.concat(),
      }, () => {
        // this.setScrollAction();
      })
    }, (error) => {

    })
  }
  
  getData = () => {
    return this.state.files;
  }

  setItems_imgsData = (successCallback, errorCallback) => {
    let _addFileIDs = this.state.addFileIDs.concat();
    if(_addFileIDs.length === 0){
      successCallback();
      return;
    }

    let filesInsertID = [];
    for(let i = 0 ; i < this.state.addFileIDs.length ; i++){
      const data = this.state.addFileIDs[i];
      let _data = {
        file_id: data.id
      }
      
      filesInsertID.push(_data);
    }

    axios.post("/store/file/set/itemsimgs/itemid", {
      store_item_id: this.props.store_item_id,
      filesInsertID: filesInsertID.concat()
    }, (result_files) => {
      console.log(result_files);
      successCallback();
    }, (error_files) => {
      errorCallback();
    })
  }

  uploadFiles = (target_id, target_type, successCallback, errorCallback) => {
    if(!target_type){
      return;
    }

    let _files = this.state.files.concat();
    if(_files.length === 0){
      successCallback({
        list: []
      });
      return;
    }


    let data = new FormData();
    data.append('target_id', target_id);
    data.append('target_type', target_type);
    // data.append('file', _files[0].file);

    data.append('file', _files[_files.length-1].file);

    // for(let i = 0 ; i < _files.length ; i++){
    //   data.append('file', _files[i].file);
    // }
    
    const options = {
      header: { "content-type": "multipart/form-data" },
      onUploadProgress: (progressEvent) => {
        const {loaded, total} = progressEvent;
        let percent = Math.floor( (loaded * 100) / total);
        // console.log(`${loaded}kb of ${total}kb | ${percent}%`);
        this.setState({
          uploading_progress: percent
        })
      }
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

    this.setState({
      isFileUploading: true
    }, () => {
      _axios.post(`${apiURL}/uploader/files/array/img`, data, options).then((res) => {
        // console.log(res);
        this.setState({
          isFileUploading: false,
          uploading_progress: 0
        }, () => {
          successCallback({
            list: res.data.result.list
          });
        })
      }).catch((error) => {
        this.setState({
          isFileUploading: false,
          uploading_progress: 0
        }, () => {
          errorCallback();
        })
      })
    })
  }

  setScrollAction(){
    let viewport = document.querySelector('.ImageFileUploader .viewport');
    let content = document.querySelector('.ImageFileUploader .scrollable-content');

    /*
    if(this.props.store_item_id === null || this.props.store_item_id === undefined){
      viewport = document.querySelector('.ImageFileUploader .viewport');
      content = document.querySelector('.ImageFileUploader .scrollable-content');
    }else{
      if(this.props.isUploader){
        viewport = document.querySelector('.ImageFileUploader .viewport_uploader_'+this.props.store_item_id);
        content = document.querySelector('.ImageFileUploader .scrollable-content-uploader-'+this.props.store_item_id);
      }else{
        viewport = document.querySelector(`.ImageFileUploader .viewport_${this.props.file_upload_target_type}_${this.props.store_item_id}`);
        content = document.querySelector(`.ImageFileUploader .scrollable-content-${this.props.file_upload_target_type}-${this.props.store_item_id}`);
      }
    }
    */

    if(viewport === null){
      return;
    }

    const sb = new ScrollBooster({
      viewport,
      content,
      bounce: true,
      textSelection: false,
      emulateScroll: true,
      onUpdate: (state) => {
        // state contains useful metrics: position, dragOffset, dragAngle, isDragging, isMoving, borderCollision
        // you can control scroll rendering manually without 'scrollMethod' option:
        content.style.transform = `translate(
          ${-state.position.x}px,
          0px
        )`;

        // content.style.transform = `translate(
        //   ${-state.position.x}px,
        //   ${-state.position.y}px
        // )`;
      },
      shouldScroll: (state, event) => {
        // disable scroll if clicked on button
        const isButton = event.target.nodeName.toLowerCase() === 'button';
        return !isButton;
      },
      onClick: (state, event, isTouchDevice) => {
        // prevent default link event
        const isLink = event.target.nodeName.toLowerCase() === 'link';
        if (isLink) {
          event.preventDefault();
        }
      }
    });

    // methods usage examples:
    sb.updateMetrics();
    // sb.scrollTo({ x: 100, y: 100 });
    sb.updateOptions({ emulateScroll: false });
    // sb.destroy();
  }

  importClick(e){
    e.preventDefault();

    if(this.state.files.length >= this.state.MAX_FILES_COUNT){
      alert(`파일은 최대 ${this.state.MAX_FILES_COUNT}개만 가능합니다`);
      return;
    }
    this.fileInputRef.click();
  }

  uploadFile = ({target: {files}}) => {
    // console.log(files)

    const file = files[0];

    const _files = this.state.files.concat();
    const _show_images = this.state.show_images.concat();

    let index = _files.length+1;//0개면 기본 1셋팅
    if(_files.length > 0){
      index = _files[_files.length - 1].key + 1;
    }

    const data = {
      key: index,
      id: null,
      file: file,
      downloadURL: ''
    }

    _files.push(data);


    const isImage = file.type.indexOf('image');
    if(isImage >= 0){
      // centerImage
      var reader = new FileReader();
      reader.onload = (e) => {
        const imagePreview = e.target.result;

        const imgData = {
          key: index,
          image: e.target.result
        }
        
        _show_images.push(imgData);

        this.setState({
          files: _files.concat(),
          show_images: _show_images.concat()
        }, () => {
          this.uploadFiles(this.props.store_user_id, Types.file_upload_target_type.items_images, (res) => {
            let _addFileIDs = this.state.addFileIDs.concat();

            let __files = this.state.files.concat();

            const fileIndex = __files.findIndex((value) => { return value.key === index });
            if(fileIndex < 0 || fileIndex >= __files.length){
              alert("파일 index 범위 오류");
              return;
            }

            const data = res.list[0];

            const dataIds = {
              key: index,
              id: data.insertId
            }
            
            __files[fileIndex].id = data.insertId;
            _addFileIDs.push(dataIds);

            this.setState({
              addFileIDs: _addFileIDs.concat(),
              files: __files.concat()
            }, () => {
              // console.log(this.state.files);
              // console.log(this.state.addFileIDs);
            })
            
            // console.log(data.list);
            
          }, () => {

          })
        })
      };
      reader.readAsDataURL(file);
    }

    /*
    const file = files[0];

    const _files = this.state.files.concat();
    const _show_images = this.state.show_images.concat();

    let index = _files.length+1;//0개면 기본 1셋팅
    if(_files.length > 0){
      index = _files[_files.length - 1].key + 1;
    }

    const data = {
      key: index,
      id: null,
      file: file,
      downloadURL: ''
    }

    _files.push(data);


    const isImage = file.type.indexOf('image');
    if(isImage >= 0){
      // centerImage
      var reader = new FileReader();
      reader.onload = (e) => {
        const imagePreview = e.target.result;

        const imgData = {
          key: index,
          image: e.target.result
        }
        
        _show_images.push(imgData);

        this.setState({
          files: _files.concat(),
          show_images: _show_images.concat()
        })
      };
      reader.readAsDataURL(file);
    }
    // else{
    //   this.setState({
    //     files: _files.concat()
    //   })
    // }

    */
  }

  removeItem = (e, key, id) => {
    e.preventDefault();

    console.log(id);

    if(id === null){
      this.deleteImage(key);
    }else{
      let apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_REAL;
      const app_type_key = document.querySelector('#g_app_type');
      if(app_type_key){
        if(app_type_key.value === 'local'){
          apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_local;
        }else if(app_type_key.value === 'qa'){
          apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_QA;
        }
      }

      _axios.post(`${apiURL}/uploader/delete/file`, {
        target_id: id,
        target_type: Types.file_upload_target_type.items_images
      }).then((res) => {
        
        axios.post("/store/file/item/delete", {
          items_img_id: id
        }, (result) => {
          this.deleteImage(key);
        }, (error) => {

        })
        
      }).catch((error) => {
        
      })
    }
    
    return;
    

    /*
    let _show_images = this.state.show_images.concat();
    let _files = this.state.files.concat();

    let fileIndex = _files.findIndex((value) => {return value.key === key});
    if(fileIndex < 0){
      alert("파일 삭제 에러. 새로고침 후 이용해주세요.");
      return;
    }

    let thumbImageIndex = _show_images.findIndex((value) => {return value.key === key});
    if(thumbImageIndex >= 0){
      _show_images.splice(thumbImageIndex, 1);
    }

    _files.splice(fileIndex, 1);

    this.setState({
      files: _files.concat(),
      show_images: _show_images.concat()
    })
    */
  }

  deleteImage = (key) => {
    let _show_images = this.state.show_images.concat();
    let _files = this.state.files.concat();
    let _addFileIDs = this.state.addFileIDs.concat();

    let fileIndex = _files.findIndex((value) => {return value.key === key});
    if(fileIndex < 0){
      alert("파일 삭제 에러. 새로고침 후 이용해주세요.");
      return;
    }

    if(_addFileIDs.length > 0){
      let addFileIdIndex = _addFileIDs.findIndex((value) => {return value.key === key});
      if(addFileIdIndex >= 0){
        _addFileIDs.splice(addFileIdIndex, 1);
      }
    }
    

    let thumbImageIndex = _show_images.findIndex((value) => {return value.key === key});
    if(thumbImageIndex >= 0){
      _show_images.splice(thumbImageIndex, 1);
    }

    _files.splice(fileIndex, 1);
    

    this.setState({
      files: _files.concat(),
      show_images: _show_images.concat(),

      addFileIDs: _addFileIDs.concat()
    })
  }

  onPressImagePreview = (e, previewURL) => {
    e.preventDefault();
    
    this.setState({
      previewURL: previewURL,
      isPreview: true
    })

  }

  callbackClosePreviewPopup = () => {
    this.setState({
      previewURL: '',
      isPreview: false
    })
  }

  onInputClick = (event) => {
    event.target.value = ''
  }

  render(){
    // if(this.props.state === Types.file_upload_state.NONE){
    //   return (
    //     <></>
    //   )
    // }

    if(!this.props.isUploader && this.state.files.length === 0){
      return (
        <></>
        // <div style={{color: '#808080'}}>파일이 없습니다.</div>
      )
    }
    
    const  buttonImgSrc = ic_photo_up_img;
    const  inputAccept = 'image/*';
    

    let file_show_list = [];
    for(let i = 0 ; i < this.state.files.length ; i++){
      const data = this.state.files[i];

      // console.log(data);

      let centerImageDom = <></>;
      const isImage = data.file.type.indexOf('image');
      if(isImage >= 0){
        const imageData = this.state.show_images.find((value) => {
          return data.key === value.key;
        })

        if(imageData){
          centerImageDom = <button onClick={(e) => {this.onPressImagePreview(e, imageData.image)}}>
                            <img className={'preview_img'} src={imageData.image} />
                          </button>
        }
      }else{
        centerImageDom = <div className={'file_icon_img_container'}>
                          <img className={'file_icon_img'} src={ic_file_icon_img} />
                          <div className={'file_name'}>
                            {data.file.name}
                          </div>
                        </div>
      }

      let bottomDom = <></>;
      if(this.props.isUploader){
        bottomDom = <button className={'circle_button'} onClick={(e) => {this.removeItem(e, data.key, data.id)}}>
                      <img src={ic_exit_circle} />
                    </button>
      }
      // else{
      //   bottomDom = <div className={'download_text'}>
      //                 <a href={data.downloadURL} download={data.file.name}>
      //                   <img src={ic_file_download_img} />
      //                 </a>
      //               </div>
      // }

      let file_show_item = <div key={i} className={'preview_box_container'}>
                            <div className={'preview_box'}>
                              {centerImageDom}
                            </div>
                            {bottomDom}
                            {/* <button className={'circle_button'} onClick={(e) => {
                              this.removeItem(e, data.key)
                            }}>
                              <img src={ic_exit_circle} />
                            </button> */}
                          </div>
      

      file_show_list.push(file_show_item);
    }

    let fileUploadingPopup = <></>;
    if(this.state.isFileUploading){
      fileUploadingPopup = <Popup_progress progress={this.state.uploading_progress}></Popup_progress>;
    }

    let popupPreviewPopup = <></>;
    if(this.state.isPreview){
      popupPreviewPopup = <Popup_image_preview closeCallback={this.callbackClosePreviewPopup} previewURL={this.state.previewURL}></Popup_image_preview>
    }

    let uploadButtonDom = <></>;
    let containerStyle = {};
    let viewPortStyle = {
      justifyContent: 'flex-start'
    };
    
    if(this.props.isUploader){
      uploadButtonDom = <div className={'button_wrapper'}>
                          <button className={'button_container'} onClick={(e) => {this.importClick(e)}}>
                            <img src={buttonImgSrc} />
                          </button>
                          <div className={'file_count_text'}>
                            {this.state.files.length}/{this.state.MAX_FILES_COUNT}
                          </div>
                        </div>;

    }else{
      containerStyle = {
        marginTop: 0
      }

      // viewPortStyle = {
      //   justifyContent: 'flex-start'
      // }
    }

    let viewportClassName = '';
    let scrollContentClassname = ''
    // if(this.props.store_item_id){
    if(this.props.store_item_id){
      if(this.props.isUploader){
        viewportClassName = 'viewport viewport_uploader_'+this.props.store_item_id;
        scrollContentClassname = 'scrollable-content scrollable-content-uploader-'+this.props.store_item_id;
      }else{
        viewportClassName = `viewport viewport_${this.props.file_upload_target_type}_${this.props.store_item_id}`;
        scrollContentClassname = `scrollable-content scrollable-content-${this.props.file_upload_target_type}-${this.props.store_item_id}`;
        
      }
    }else{
      viewportClassName = 'viewport';
      scrollContentClassname = 'scrollable-content';
    }

    let blur_thumb_cover_dom = <></>;
    if(this.props.isListEndBlurCover){
      blur_thumb_cover_dom = <div className={'blur_thumb_cover'}></div>
    }

    let optionTitleTextDom = <></>;
    if(this.props.isOptionTitleText){
      optionTitleTextDom = <div className={'option_font_text'}>
                            옵션*
                          </div>
    }
    
    return(
      <div className={'ImageFileUploader'}>
        <input onClick={this.onInputClick} accept={inputAccept} ref={(ref) => {this.fileInputRef = ref}} type="file" className={'input_order_file_upload'} onChange={this.uploadFile} style={{display: 'none'}}/>
          <div className={'file_uploader_container_wrapper'}>
          {optionTitleTextDom}
          <div className={'file_uploader_container'} style={containerStyle}>
            {uploadButtonDom}
            <div className={'viewport_container'}>
              <div className={viewportClassName} style={viewPortStyle}>
                <div className={scrollContentClassname} style={{display: 'flex', flexDirection: 'row',}}>
                  {file_show_list}
                </div>
                {blur_thumb_cover_dom}
              </div>
            </div>
          </div>

          {fileUploadingPopup}
          {popupPreviewPopup}
        </div>
        
      </div>
    )
  }
};

ImageFileUploader.defaultProps = {
  // state: Types.file_upload_state.NONE,

  file_upload_target_type: Types.file_upload_target_type.items_images,
  isUploader: true,
  store_item_id: null,

  isListEndBlurCover: true,

  isOptionTitleText: false,

  noDataCallback: (isNoData) => {}
  // id: -1,
  // store_item_id: -1,
  // thumbUrl: '',
  // name: '',
  // title: '',
  // price: 0
}

export default ImageFileUploader;