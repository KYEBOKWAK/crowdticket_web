'use strict';

import React, { Component } from 'react';
import Storage from '../lib/Storage';
import * as storageType from '../StorageKeys';
import language from '../res/json/language/language.json';

class Str extends Component{

  constructor(props){
    super(props);

    this.state = {
     text: ''
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.setText();
  };

  componentWillUnmount(){
  };

  componentDidUpdate(prevProps, prevState){
    if(this.props.strKey !== prevProps.strKey){
      this.setText();
    }
  }

  setText = () => {
    Storage.load(storageType.LANGUAGE_CODE, (result) => {
      let language_code = 'kr';
      if(result.value){
        language_code = result.value;      
      }else{
        //값이 없음 
      }
 
      const stringKey = this.props.strKey;
      let text = stringKey;
 
      if(stringKey === ''){
       text = '##EMPTY##';
      }
      else if(language[stringKey] === undefined){
       text = stringKey;
      }else if(language[stringKey][language_code] === undefined || language[stringKey][language_code] === null){
       text = stringKey;
      }else{
        if(language[stringKey][language_code] === '##EMPTY##'){
          text = '';  
        }else{
          text = language[stringKey][language_code];
        }
      }
 
     //  console.log(text);
 
      const test = text.indexOf('\\n');
      if(test >= 0){
       text = text.replace("\\n", "\n");
       text = text.replace("\\", "");
       // console.log(text);
      }
      
      this.setState({
       text: text
      })
    })
  }

  render(){
    return(
      <span>
       {/* {this.state.text} */}
       {this.state.text}
      </span>
    )
  }
};

Str.defaultProps = {
 strKey: ''
}

export default Str;