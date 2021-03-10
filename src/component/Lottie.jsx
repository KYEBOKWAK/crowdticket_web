'use strict';

import React, { Component } from 'react';

import lottie_web from 'lottie-web';
import Types from '../Types';

//로티 json 파일은 s3에 올리려면 엑세스 권한을 변경해야 하기 때문에 웹서버에 올린다.
//현제 로티는 배너에서만 쓴다.. 혹시 다른데서 쓸꺼면.. 다시 하나 만들장.. 비율땜에 그럼
class Lottie extends Component{
  ref = null;
  constructor(props){
    super(props);

    this.state = {
      height: 'auto'
    }
  };

  componentDidMount(){
    if(this.props.url === undefined || this.props.url === null || this.props.url === ''){
      return;
    }

    lottie_web.loadAnimation({
      container: this.ref,
      renderer: "svg",
      loop: true,
      autoplay: true,
      path: this.props.url
    });

    this.updateDimensions();
  };

  componentWillUnmount(){
  };

  updateDimensions = () => {
    let _height = this.ref.clientWidth * 0.343511; //배너 이미지 비율 1048 * 360
    this.setState({
      height: _height
    })
  };

  componentDidUpdate(){
  }

  render(){
    return(
      <div style={{width: '100%', height: this.state.height}} ref={(_ref) => {this.ref = _ref}}>
      </div>
    )
  }
};

export default Lottie;