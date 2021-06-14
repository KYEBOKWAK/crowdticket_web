'use strict';

import React, { Component } from 'react';
import Types from '../Types';

class ErrorMessageInputBox extends Component{

  constructor(props){
    super(props);

    this.state = {
      setErrorMessageType: null,
      errorMessage: '',
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
  };

  componentWillUnmount(){
    
  };

  setErrorMessageType = (type) => {
    this.setState({
      setErrorMessageType: type
    }, () => {
      this.onCheckErrorMessage();
    })
  }

  clear = () => {
    this.setState({
      setErrorMessageType: null,
      errorMessage: '',
    })
  }

  componentDidUpdate(prevProps, prevState){
    if(this.props.inputBoxRef === null){
      return;
    }

    if(this.props.inputBoxRef.getIsEmptyCheckErrorMessage()){
      this.onCheckErrorMessage();
      return;
    }

    if(this.props.defaultText !== prevProps.defaultText || this.props.compareText !== prevProps.compareText){
      this.onCheckErrorMessage();
    }
    
  }

  onCheckErrorMessage = () => {
    if(this.props.inputBoxRef === null){
      return;
    }

    let inputErrorMessageType = '';
    let errorMessage = '';

    if(this.props.isCompare){
      if(this.props.defaultText === '' && this.props.compareText === ''){
        inputErrorMessageType = Types.input_error_messages.empty;
      }
      else if(this.props.defaultText === '' && this.props.compareText !== ''){
        inputErrorMessageType = Types.input_error_messages.empty;
      }
      else if(this.props.compareText !== ''){
        if(this.props.defaultText !== this.props.compareText){
          inputErrorMessageType = Types.input_error_messages.password_same_check;
        }
      }

    }else{
      if(this.state.setErrorMessageType !== null){
        inputErrorMessageType = this.state.setErrorMessageType;
      }
      else if(this.props.defaultText === ''){
        inputErrorMessageType = Types.input_error_messages.empty;
      }
      else if(this.props.defaultText.length < 6){
        inputErrorMessageType = Types.input_error_messages.password_max_length;
      }
    }

    if(inputErrorMessageType === ''){
      errorMessage = '';
    }else{
      errorMessage = this.getErrorMessage(inputErrorMessageType);
    }

    this.setState({
      errorMessage: errorMessage,
      // setErrorMessageType: null
    }, () => {
      if(this.props.inputBoxRef === null){
        return;
      }

      if(this.state.errorMessage !== ''){
        if(!this.props.inputBoxRef.getError()){
          this.props.inputBoxRef.setError(true);
        }
        
      }else{
        if(this.props.inputBoxRef.getError()){
          this.props.inputBoxRef.setError(false);
        }        
      }

      if(this.props.inputBoxRef.getIsEmptyCheckErrorMessage()){
        this.props.inputBoxRef.setIsEmptyCheckErrorMessage(false);
      }
    })
  }

  /*
  onCheckErrorMessage = () => {
    if(this.props.inputBoxRef === null){
      return;
    }

    let inputErrorMessageType = '';
    let errorMessage = '';

    if(this.props.isCompare){
      if(this.props.defaultText === '' && this.props.compareText === ''){
        inputErrorMessageType = Types.input_error_messages.empty;
      }
      else if(this.props.defaultText === '' && this.props.compareText !== ''){
        inputErrorMessageType = Types.input_error_messages.empty;
      }
      else if(this.props.compareText !== ''){
        if(this.props.defaultText !== this.props.compareText){
          inputErrorMessageType = Types.input_error_messages.password_same_check;
        }
      }

    }else{
      if(this.props.defaultText === ''){
        inputErrorMessageType = Types.input_error_messages.empty;
      }
      else if(this.props.defaultText.length < 6){
        inputErrorMessageType = Types.input_error_messages.password_max_length;
      }
    }

    if(inputErrorMessageType === ''){
      errorMessage = '';
    }else{
      errorMessage = this.getErrorMessage(inputErrorMessageType);
    }

    this.setState({
      errorMessage: errorMessage
    }, () => {
      if(this.props.inputBoxRef === null){
        return;
      }

      if(this.state.errorMessage !== ''){
        if(!this.props.inputBoxRef.getError()){
          this.props.inputBoxRef.setError(true);
        }
        
      }else{
        if(this.props.inputBoxRef.getError()){
          this.props.inputBoxRef.setError(false);
        }        
      }

      if(this.props.inputBoxRef.getIsEmptyCheckErrorMessage()){
        this.props.inputBoxRef.setIsEmptyCheckErrorMessage(false);
      }
    })
  }
  */

  getErrorMessage = (type_input_error_message) => {
    const data = this.props.error_messages.find((value) => {
                    if(value.type === type_input_error_message){
                      return value;
                    }
                  })

    if(data === undefined){
      return '';
    }

    return data.message;
  }

  render(){
    let inputErrorDom = <></>;
    if(this.state.errorMessage !== ''){
      inputErrorDom = <div style={{fontSize: 12, color: '#fc5e7c', marginTop: 4}}>
                        {this.state.errorMessage}
                      </div>
    }

    return(
      <div className={'ErrorMessageInputBox'}>
        {inputErrorDom}
      </div>
    )
  }
};

ErrorMessageInputBox.defaultProps = {
  inputBoxRef: null,
  defaultText: '',
  compareText: '',
  isCompare: false,
  error_messages: []
}

export default ErrorMessageInputBox;