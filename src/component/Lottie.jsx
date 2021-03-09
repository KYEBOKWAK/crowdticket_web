'use strict';

import React, { Component } from 'react';

import lottie_web from 'lottie-web';

//로티 json 파일은 s3에 올리려면 엑세스 권한을 변경해야 하기 때문에 웹서버에 올린다.
class Lottie extends Component{
  ref = null;
  constructor(props){
    super(props);

    this.state = {
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
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){
    return(
      <div style={{width: '100%'}} ref={(_ref) => {this.ref = _ref}}>
      </div>
    )
  }
};

export default Lottie;