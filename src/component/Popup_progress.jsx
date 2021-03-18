'use strict';

import React, { Component } from 'react';

import Types from '../Types';
import ProgressBar from '@ramonak/react-progress-bar';


class Popup_progress extends Component{
  constructor(props){
    super(props);

    this.state = {
      
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  componentDidMount(){
    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
    
  }

  render(){
    let text = ''
    if(this.props.type === Types.progress.uploader){
      text = `파일 업로드 중입니다.
      해당 창을 나가면 오류가 발생합니다.
      잠시만 기다려주세요.`
    }else{
      text = `파일을 다운로드 중입니다.
      잠시만 기다려주세요.`
    }
    return(
      <div className={'Popup_progress'}>
        <div className={'popup_container'}>
          <div className={'content_container'}>
          {text}
          </div>
          
          <ProgressBar completed={this.props.progress} bgcolor={'#00bfff'}/>
        </div>
      </div>
    )
  }
};

Popup_progress.defaultProps = {
  progress: 0,
  type: Types.progress.uploader
  // state: Types.file_upload_state.NONE,
  // id: -1,
  // store_item_id: -1,
  // thumbUrl: '',
  // name: '',
  // title: '',
  // price: 0
}

export default Popup_progress;