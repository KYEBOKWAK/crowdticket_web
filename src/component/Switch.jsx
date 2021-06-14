'use strict';

import React, { Component } from 'react';

class Switch extends Component{

  constructor(props){
    super(props);

    this.state = {
      is_switch: this.props.is_switch
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  // static getDerivedStateFromProps(nextProps, prevState) {
    
  //   if(nextProps.default_value !== prevState.is_switch){
  //     return {
  //       is_switch: nextProps.default_value
  //     }
  //   }

  //   return null;
  // }

  componentDidMount(){    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  onClickSwitch = (e) => {
    e.preventDefault();

    let is_switch = this.state.is_switch;
    if(is_switch){
      is_switch = false;
    }else{
      is_switch = true;
    }

    this.setState({
      is_switch: is_switch
    }, () => {
      this.props.callbackSwitch(this.state.is_switch)
    })
  }

  render(){
    
    let switch_box_style = {
      width: '100%',
      height: '100%',
      borderRadius: 22,
      position: 'relative'
    }

    let switch_icon_style = {
      width: 24,
      height: 24,
      borderRadius: 50,
      position: 'absolute',
      backgroundColor: '#ffffff'
    }
    if(this.state.is_switch){
      switch_box_style = {
        ...switch_box_style,
        padding: '3px 3px 3px 21px',
        backgroundColor: '#00bfff'
      }
    }else{
      switch_box_style = {
        ...switch_box_style,
        padding: '3px 21px 3px 3px',
        backgroundColor: '#f4f4f4'
      }
    }

    let switch_icon = <div style={switch_icon_style}></div>;

    let switch_box = <div style={switch_box_style}>
      {switch_icon}
    </div>

    return(
      <button className={'Switch'} onClick={(e) => {this.onClickSwitch(e)}} style={{width: 48, height: 30}}>
        {switch_box}
      </button>
    )
  }
};

Switch.defaultProps = {
  is_switch: false,
  callbackSwitch: (is_switch) => {}
}

export default Switch;