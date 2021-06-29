'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import _axios from 'axios';

class App_File_Download_Temp_Page extends Component{

  constructor(props){
    super(props);

    this.state = {
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){    
    const url = new URL(window.location.href);
    const urlParams = url.searchParams;
    const filedownloadtoken = urlParams.get('token');
    const user_id = urlParams.get('user_id');

    let apiDownloadURL = process.env.REACT_APP_DOWNLOAD_API_SERVER_REAL;
    const app_type_key = document.querySelector('#g_app_type');
    if(app_type_key){
      if(app_type_key.value === 'local'){
        apiDownloadURL = process.env.REACT_APP_DOWNLOAD_API_SERVER_local;
        // apiDownloadURL = 'http://172.30.1.1:8080';
      }else if(app_type_key.value === 'qa'){
        apiDownloadURL = process.env.REACT_APP_DOWNLOAD_API_SERVER_QA;
      }
    }

    _axios.post(`${apiDownloadURL}/downloader/get/file/info/token`, {
      filedownloadtoken: filedownloadtoken
    }).then((res) => {
      // console.log(res);
      const data = res.data;
      if(data.state === 'error'){
        alert(data.message);
        return;
      }

      const filename = data.originalname;

      const downloadLink = `${apiDownloadURL}/downloader/get/custom/file/${filename}?token=${filedownloadtoken}&user_id=${user_id}`;
      
      const link = document.createElement('a');
      link.href = downloadLink;
      link.download=filename;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }).catch((error) => {
      
    })
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){
    return(
      <div className={'App_File_Download_Temp_Page'}>
      </div>
    )
  }
};

let domContainer = document.querySelector('#react_app_file_download_temp_page');
ReactDOM.render(<App_File_Download_Temp_Page />, domContainer);