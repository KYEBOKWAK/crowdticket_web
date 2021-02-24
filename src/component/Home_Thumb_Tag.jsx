'use strict';

import React, { Component } from 'react';

import Types from '../Types';


class Home_Thumb_Tag extends Component{

  constructor(props){
    super(props);

    this.state = {
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){
    let box_style = {

    }

    let text = '';
    if(this.props.thumb_tags === Types.thumb_tags.trend){
      text = '👍 요즘 대세';
    }
    else if(this.props.thumb_tags === Types.thumb_tags.attention){
      text = '👀 여기 주목!';
    }
    else if(this.props.thumb_tags === Types.thumb_tags.live_update){
      text = '신규 콘텐츠';
      box_style = {
        backgroundColor: '#fc5e7c'
      }
    }
    return(
      <div className='Home_Thumb_Tag'>
        <div className={'Home_Thumb_Tag_box'} style={box_style}>
          {text}
        </div>
      </div>
    )
  }
};

Home_Thumb_Tag.defaultProps = {
  thumb_tags: Types.thumb_tags.trend
}

export default Home_Thumb_Tag;