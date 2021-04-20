'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

class Name extends Component{

  constructor(props){
    super(props);

    this.state = {
      name: '',
      nick_name: '',
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestUserInfo();
  };

  requestUserInfo = () => {
    if(this.props.user_id === null || this.props.user_id === undefined){
      return;
    }

    axios.post('/any/info/userid', {
      target_user_id: this.props.user_id
    }, (result) => {
      this.setState({
        name: result.userInfo.name,
        nick_name: result.userInfo.nick_name
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){
    let name = this.props.name;
    if(this.props.show_name){
      name = this.props.name;
    }else{
      if(this.props.nick_name !== undefined && this.props.nick_name !== null && this.props.nick_name !== ''){
        name = this.props.nick_name;
      }
    }

    if(this.props.user_id !== null){
      if(this.props.show_name){
        name = this.state.name;
      }else{
        if(this.state.nick_name !== undefined && this.state.nick_name !== null && this.state.nick_name !== ''){
          name = this.state.nick_name;
        }
      }
    }
    
    return(
      <div className={'Name'}>
        <div style={this.props.style}>
          {name}
        </div>
      </div>
    )
  }
};

Name.defaultProps = {
  user_id: null,
  name: '',
  nick_name: '',
  style: {},
  show_name: false
}

export default Name;