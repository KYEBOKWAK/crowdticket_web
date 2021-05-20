'use strict';

import React, { Component } from 'react';

import axios from '../lib/Axios';

import _axios from 'axios';

import Types from '../Types';


import Popup_progress from '../component/Popup_progress';

import ic_btn_file_upload from '../res/img/btn-file-upload.svg';
import ic_clip from '../res/img/ic-clip.svg';

import ic_exit_circle from '../res/img/ic-exit-circle.svg';
// import ic_circle_download from '../res/img/ic-circle-download.svg';

import CompletedFileDownloadButton from '../component/CompletedFileDownloadButton';

import Util from '../lib/Util';

import {isMobile} from 'react-device-detect';

import Str from '../component/Str';

class CompletedFileUpLoader extends Component{
  fileInputRef = React.createRef();

  constructor(props){
    super(props);

    this.state = {
      files: [],
      isFileUploading: false,
      progressType: Types.progress.uploader,
      uploading_progress: 0,

      down_expired_at: '',
      is_down_expired: false,

      // isRequestFile: false,

      addFileIDs: []  //추가된 파일
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  componentDidMount(){
    if(this.props.store_item_id === null || this.props.store_item_id === undefined){
      return;
    }

    this.requestFilesData();

    if(!this.props.isUploader){
      this.requestDownloadIsExpired();
      this.requestDownloadExpireTime();
    }
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  isRefresh = () => {
    this.requestFilesData();
  }

  requestDownloadIsExpired = () => {
    if(this.props.store_order_id === null){
      return;
    }

    axios.post('/store/expired/download/valid', {
      store_order_id: this.props.store_order_id
    }, (result) => {
      this.setState({
        is_down_expired: result.data.isExpired
      })
      
    }, (error) => {

    })
    
  }

  requestDownloadExpireTime = () => {
    if(this.props.store_order_id === null){
      return;
    }

    axios.post('/store/expired/download', {
      store_order_id: this.props.store_order_id
    }, (result) => {
      this.setState({
        down_expired_at: result.data.down_expired_at
      })
      
    }, (error) => {

    })
  }

  requestFilesData = () => {
    if(this.props.store_item_id === null || this.props.store_item_id === undefined){
      return;
    }

    axios.post('/store/file/download/list', {
      store_item_id: this.props.store_item_id,
      file_upload_target_type: this.props.file_upload_target_type
    }, (result) => {
      let _files = [];
      // let _show_images = [];

      if(result.list.length === 0){
        // this.setScrollAction();
        this.props.noDataCallback(true);
        return;
      }

      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];

        const size_convert = Util.convertBytes(Number(data.size));
        const reData = {
          key: i,
          id: data.id,
          file: {
            // type: data.mimetype,
            name: data.originalname
          },
          originalname: data.originalname,
          size: data.size,
          size_convert: size_convert,
          downloadURL: data.url,
          file_s3_key: data.file_s3_key
        }

        _files.push(reData);
      }

      this.setState({
        files: _files.concat(),
      })
    }, (error) => {

    })
  }
  
  getData = () => {
    return this.state.files;
  }

  setFiles_DownloadIDData = (store_item_id, successCallback, errorCallback) => {
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

    axios.post("/store/file/set/downloadfiles/itemid", {
      store_item_id: store_item_id,
      filesInsertID: filesInsertID.concat()
    }, (result_files) => {
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
    data.append('file_size', _files[_files.length-1].size);
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
      _axios.post(`${apiURL}/uploader/files/array/files`, data, options).then((res) => {
        // console.log(res.data.result.list);
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

  importClick(e){
    e.preventDefault();

    if(this.state.files.length >= this.props.MAX_FILES_COUNT){
      alert(`파일은 최대 ${this.props.MAX_FILES_COUNT}개만 가능합니다`);
      return;
    }
    this.fileInputRef.click();
  }

  uploadFile = ({target: {files}}) => {
    ///////
    if(this.props.store_user_id === null){
      alert('유저 정보가 없습니다. 새로고침 후 다시 이용해주세요');
      return;
    }

    const file = files[0];

    if(file.size === 0){
      alert("에러: 파일 사이즈가 0 입니다.");
      return;
    }

    if(isMobile && Util.isLargeFile(file.size)){
      alert("2기가 이상 파일은 pc에서 업로드해주세요");
      return;
    }

    const _files = this.state.files.concat();

    let _originalName = Util.regExp(file.name);
    // _originalName = _originalName.normalize('NFC');

    const sameNameFileIndex = _files.findIndex((value) => {return value.originalname === _originalName});
    // console.log(sameNameFileIndex);
    if(sameNameFileIndex >= 0){
      alert('같은 이름의 파일이 있습니다. 다른 파일을 업로드 해주세요');
      return;
    }
    // const _show_images = this.state.show_images.concat();

    let index = _files.length+1;//0개면 기본 1셋팅
    if(_files.length > 0){
      index = _files[_files.length - 1].key + 1;
    }

    // const size_mb = (String)(file.size / CONVERT_MB);
    const size = (String)(file.size);

    const data = {
      key: index,
      id: null,
      file: file,
      size: size,
      size_convert: Util.convertBytes(file.size),
      downloadURL: '',
      file_s3_key: '',
      originalname: _originalName
    }

    _files.push(data);
    
    this.setState({
      files: _files.concat(),
    }, () => {
      this.uploadFiles(this.props.store_user_id, this.props.file_upload_target_type, (res) => {
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
          
        })            
      }, () => {

      })
    })
  }

  downloadFile = (downloadURL, file_name, id) => {
    // const download_a_tag_dom = document.querySelector('.'+this.getDownloadATagClassName(id));
    // download_a_tag_dom.click();
    
  }

  onClickDownloadFileButton = (e, key, id, downloadURL) => {
    if(downloadURL === null || downloadURL === ''){
      this.removeItem(e, key, id);
    }
  }

  removeItem = (e, key, id) => {
    e.preventDefault();

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
        target_type: this.props.file_upload_target_type
      }).then((res) => {
        
        axios.post("/store/file/download/delete", {
          files_downloads_id: id
        }, (result) => {
          this.deleteImage(key);
        }, (error) => {

        })
        
      }).catch((error) => {
        
      })
    }
    
    return;
    
  }

  deleteImage = (key) => {
    // let _show_images = this.state.show_images.concat();
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
    

    // let thumbImageIndex = _show_images.findIndex((value) => {return value.key === key});
    // if(thumbImageIndex >= 0){
    //   _show_images.splice(thumbImageIndex, 1);
    // }

    _files.splice(fileIndex, 1);
    

    this.setState({
      files: _files.concat(),
      // show_images: _show_images.concat(),

      addFileIDs: _addFileIDs.concat()
    })
  }


  onInputClick = (event) => {
    event.target.value = ''
  }

  getDownloadATagClassName = (id) => {
    return 'Complieted_File_Download_A_'+id;
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
      )
    }

    let file_show_list = [];
    let file_show_list_dom = <></>;
    for(let i = 0 ; i < this.state.files.length ; i++){
      const data = this.state.files[i];
      let bottomDom = <></>;
      
      if(!this.state.is_down_expired){

        // let buttonIconImg = ic_circle_download;
        if(data.downloadURL === null || data.downloadURL === ''){
          bottomDom = <button className={'circle_button'} onClick={(e) => {this.onClickDownloadFileButton(e, data.key, data.id, data.downloadURL)}}>
                        <img src={ic_exit_circle} />
                      </button>
        }else{
          bottomDom = <CompletedFileDownloadButton files_downloads_id={data.id} file_s3_key={data.file_s3_key} originalname={data.originalname}></CompletedFileDownloadButton>
        }

        // bottomDom = <button className={'circle_button'} onClick={(e) => {this.onClickDownloadFileButton(e, data.key, data.id, data.downloadURL, data.file_s3_key, data.file.name, Number(data.size))}}>
        //             <img src={buttonIconImg} />
        //           </button>
      }
      
      
      let file_show_item = <></>;
      if(this.props.isUploader){
        file_show_item = <div key={i} className={'item_container'}>
                          <div className={'item_contents_container'}>
                            <div className={'item_file_image'}>
                              <img src={ic_clip} />
                            </div>
                            <div className={'item_file_name text-ellipsize'}>
                              {data.originalname}
                            </div>
                            <div className={'item_file_size'}>
                              {data.size_convert}
                            </div>
                          </div>
                          
                          {bottomDom}
                        </div>
      }else{
        file_show_item = <div key={i} className={'item_container item_container_downloader'}>
                          <div className={'item_contents_container'}>
                            <div className={'item_file_image'}>
                              <img src={ic_clip} />
                            </div>
                            <div className={'item_file_name text-ellipsize'}>
                              {data.originalname}
                            </div>
                            <div className={'item_file_size'}>
                              {data.size_convert}
                            </div>
                          </div>
                          
                          {bottomDom}
                        </div>
      }
      

      file_show_list.push(file_show_item);
    }

    let containerStyle = {}
    if(!this.props.isUploader){
      containerStyle = {
        marginTop: 0
      }
    }

    if(file_show_list.length > 0){
      file_show_list_dom = <div style={containerStyle} className={'file_list_container'}>
                            {file_show_list}
                          </div>
    }


    let fileUploadingPopup = <></>;
    if(this.state.isFileUploading){
      fileUploadingPopup = <Popup_progress type={this.state.progressType} progress={this.state.uploading_progress}></Popup_progress>;
    }

    let uploadButtonDom = <></>;
    let downloadExpireExplainDom = <></>;
    if(this.props.isUploader){
      let noticeContainerStyle = {
        marginTop: 0
      };

      let buttonDom = <></>
      if(this.props.isShowUploaderButton){
        buttonDom = <div className={'add_button_container'}>
                      <button onClick={(e) => {this.importClick(e)}}>
                        <img src={ic_btn_file_upload} />
                      </button>
                      <div className={'file_count_text'}>
                        {this.state.files.length}/{this.props.MAX_FILES_COUNT}
                      </div>
                    </div>
        noticeContainerStyle = {}
      }
      uploadButtonDom = <div className={'uploader_button_container'}>
                          {buttonDom}
                          <div className={'uploader_notice_container'} style={noticeContainerStyle}>
                            <div>
                              ∙파일 용량이 너무 크면 구매자가 다운로드를 하기 어려울 수 있으니 유의해주세요.
                            </div>
                            <div>
                              ∙등록하는 콘텐츠가 타인의 저작권 또는 초상권을 침해하지 않도록 유의해주세요.
                            </div>
                            <div>
                              ∙등록된 콘텐츠 파일은 수정 및 삭제가 불가하니 유의해주세요.
                            </div>
                          </div>
                        </div>

    }else{
      downloadExpireExplainDom = <div className={'download_expire_explain_container'}>
                                  {/* {`구매한 콘텐츠는 60일간 다운받을 수 있습니다. [기간 만료: ${this.state.down_expired_at}]\n모바일의 경우 다운로드 중 데이터 추가 요금이 부과될 수 있으니 Wi-Fi 연결을 권장합니다.\n파일 다운로드는 PC 사용을 권장합니다.`} */}
                                  <div>
                                    <Str strKey={'s81'} />{this.state.down_expired_at}]
                                  </div>
                                  <div>
                                    <Str strKey={'s82'} />
                                  </div>
                                </div>
      
    }
    
    return(
      <div className={'CompletedFileUpLoader'}>
        <input onClick={this.onInputClick} ref={(ref) => {this.fileInputRef = ref}} type="file" className={'input_order_file_upload'} onChange={this.uploadFile} style={{display: 'none'}}/>
        
        {file_show_list_dom}
        {downloadExpireExplainDom}
        {uploadButtonDom}
          
        {fileUploadingPopup}
      </div>
    )
  }
};

CompletedFileUpLoader.defaultProps = {
  // state: Types.file_upload_state.NONE,

  store_user_id: null,
  store_order_id: null,
  file_upload_target_type: Types.file_upload_target_type.download_file,
  isUploader: true,
  isShowUploaderButton: true,
  store_item_id: null,
  MAX_FILES_COUNT: 5,

  noDataCallback: (isNoData) => {}
}

export default CompletedFileUpLoader;