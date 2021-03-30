'use strict';

import React, { Component } from 'react';

import ReactLoading from 'react-loading';

import ic_exit_circle from '../res/img/ic-exit-circle.svg';
import ic_circle_download from '../res/img/ic-circle-download.svg';

import _axios from 'axios';
import Types from '../Types';


class CompletedFileDownloadButton extends Component{
  timerInterval = null;

  constructor(props){
    super(props);

    let apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_REAL;
    const app_type_key = document.querySelector('#g_app_type');
    if(app_type_key){
      if(app_type_key.value === 'local'){
        apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_local;
      }else if(app_type_key.value === 'qa'){
        apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_QA;
      }
    }

    this.state = {
      apiURL: apiURL,
      is_completed: false,
      state: Types.files_servers_state.INIT,
      files_servers_id: null,
      originalname: ''
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestFileCheckInServer();
  };

  componentWillUnmount(){
    this.stopCheckFileTimer();
  };

  componentDidUpdate(){
  }

  startCheckFileTimer = () => {
    if(this.timerInterval !== null){
      return;
    }

    this.stopCheckFileTimer();
    
    this.timerInterval = setInterval(() => {
      this.requestFileCheckInServer();
     }, 1000);
  }

  stopCheckFileTimer = () => {
    if(this.timerInterval === null){
      return;  
    }

    clearInterval(this.timerInterval);
    this.timerInterval = null;
  };

  requestFileCheckInServer = () => {
    if(this.props.files_download_id === null){
      return;
    }

    // let apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_REAL;
    // const app_type_key = document.querySelector('#g_app_type');
    // if(app_type_key){
    //   if(app_type_key.value === 'local'){
    //     apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_local;
    //   }else if(app_type_key.value === 'qa'){
    //     apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_QA;
    //   }
    // }

    _axios.post(this.state.apiURL+'/downloader/file/info', {
      data: {
        files_downloads_id: this.props.files_downloads_id,
      }
      // file_s3_key: this.props.file_s3_key,
      // originalname: this.props.originalname
    }).then((result) => {
      

      if(result.data.state === 'success'){
        const data = result.data.data;
        if(data.files_servers_id === null){
          this.requsetSetFileInServer();
        }else{

          if(data.state === Types.files_servers_state.DONE){
            this.stopCheckFileTimer();
          }else if(data.state === Types.files_servers_state.INIT){
            this.startCheckFileTimer();
          }else{
            this.stopCheckFileTimer();
          }

          this.setState({
            state: data.state,
            files_servers_id: data.files_servers_id,
            originalname: data.originalname
          })
        }
      }else{
        this.stopCheckFileTimer();
        alert(result.data.message);

        this.setState({
          state: Types.files_servers_state.ERROR,
          files_servers_id: null,
          originalname: ''
        })
        return;
      }
      
    }).catch((error) => {
      this.stopCheckFileTimer();
      alert('파일 정보 조회 에러');
    })
  }

  requsetSetFileInServer = () => {
    _axios.post(this.state.apiURL+'/downloader/set/file/info', {
      data: {
        files_downloads_id: this.props.files_downloads_id,
        file_s3_key: this.props.file_s3_key,
        originalname: this.props.originalname
      }
    }).then((result) => {
      if(result.data.state === 'success'){
        const data = result.data.data;
        this.setState({
          state: data.state,
          files_servers_id: data.files_servers_id,
          originalname: data.originalname
        })
      }else{
        alert(result.data.message);

        this.setState({
          state: Types.files_servers_state.ERROR,
          files_servers_id: null,
          originalname: ''
        })
      }
      
    }).catch((error) => {
      alert('파일 서버 셋팅 에러');
    })
  }

  onClickFileDownload = (e) => {
    e.preventDefault();
  }

  render(){
    if(this.state.state === Types.files_servers_state.ERROR){
      return (<></>)
    }
    else if(this.state.state !== Types.files_servers_state.DONE){
      return (
        <ReactLoading type={'spin'} color={'#00bfff'} height={20} width={20} />
      )
    } 

    // console.log(this.state.state);

    const encodeName = this.state.originalname;

    // const href = this.state.apiURL+'/downloader/get/file/'+this.state.files_servers_id+'/'+this.state.originalname;

    const href = this.state.apiURL+'/downloader/get/file/'+this.state.files_servers_id+'/'+encodeName;

    return(
      <a download={this.props.originalname} href={href} className={'CompletedFileDownloadButton'}>
        <img src={ic_circle_download} />
      </a>
    )
  }
};

CompletedFileDownloadButton.defaultProps = {
  files_downloads_id: null,
  file_s3_key: null,
  originalname: null
}

export default CompletedFileDownloadButton;