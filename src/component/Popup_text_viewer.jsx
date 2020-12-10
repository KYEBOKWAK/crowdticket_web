'use strict';

import React, { Component, createRef } from 'react';

import Types from '../Types';

import ic_exit_circle from '../res/img/ic-exit-circle.svg';

import axios from '../lib/Axios';

import ReactHtmlParser, { processNodes, convertNodeToElement, htmlparser2 } from 'react-html-parser';

// import Quill from 'quill';

class Popup_text_viewer extends Component{
  // _quill = null;

  constructor(props){
    super(props);

    this.state = {
      title: '',
      text: '',

      // quill_height: this.getQuillHeight()
    }

    // this.handleChange = this.handleChange.bind(this)
    //3.0.0
    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  // getQuillHeight = () => {
  //   return window.innerHeight - 240;//36은 하단의 버튼 container 높이임
  // }

  componentDidMount(){
    this.requestProductText();
  };

  componentWillUnmount(){
  };

  componentDidUpdate(){
    
  }

  requestProductText = () => {
    if(!this.props.store_order_id){
      alert("주문 ID 정보가 없습니다.");
      return;
    }

    axios.post("/store/product/text/get", {
      store_order_id: this.props.store_order_id
    }, (result) => {

      let _product_text = result.product_text;
      let _product_title_text = result.product_title_text;

      if(_product_text === null){
        _product_text = '';
      }

      if(_product_title_text === null){
        _product_title_text = '';
      }

      this.setState({
        text: _product_text,
        title: _product_title_text
      }, () => {
        // if(this._quill){
        //   this._quill.root.innerHTML = this.state.text
        // }
      })
    }, (error) => {

    })
  }

  handleChange(value) {
    this.setState({ text: value });
  }

  onClickExit = (e) => {
    e.preventDefault();

    // let targetElement = document.querySelector('#react_root');
    // enableBodyScroll(targetElement);

    this.props.closeCallback();
  }

  onChangeInput(e){
    e.preventDefault();

    this.setState({
      title: e.target.value
    })
  }

  render(){    
    return(
      <div className={'Popup_text_viewer'}>
        <div className={'text_container'}>
          {ReactHtmlParser(this.state.text)}
        </div>
        <div className={'button_container'}>
          <button onClick={(e) => {this.onClickExit(e)}} className={'button_close'}>
            닫기
          </button>
        </div>
      </div>
    )
  }
};

Popup_text_viewer.defaultProps = {
  // store_order_id: null
  // previewURL: ''
  // state: Types.file_upload_state.NONE,
  // id: -1,
  // store_item_id: -1,
  // thumbUrl: '',
  // name: '',
  // title: '',
  // price: 0
}

export default Popup_text_viewer;