'use strict';

import React, { Component, createRef } from 'react';

import Types from '../Types';

import ic_exit_circle from '../res/img/ic-exit-circle.svg';

// import ReactQuill from 'react-quill';
import axios from '../lib/Axios';

import Quill from 'quill';

class Popup_text_editor extends Component{
  _quill = null;

  constructor(props){
    super(props);

    this.state = {
      title: '',
      text: '',

      quill_height: this.getQuillHeight()
    }

    this.handleChange = this.handleChange.bind(this)
    //3.0.0
    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  getQuillHeight = () => {
    return window.innerHeight - 240;//36은 하단의 버튼 container 높이임
  }

  componentDidMount(){
    this.requestProductText();

    this._quill = new Quill('.quill_container', {
      theme: 'snow',
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline','strike'],
        ],
      },
      formats:[
        'bold', 'italic', 'underline', 'strike',
      ]
    });

    this._quill.on("text-change", (delta, oldDelta, source) => {
      // QuillChange(quill.root.innerHTML);
      // console.log(quill.root.innerHTML);
      this.handleChange(this._quill.root.innerHTML);
    });

    window.addEventListener('resize', this.updateSize);

    ScrollLock();
  };

  updateSize = () => {
    // setSize([window.innerWidth, window.innerHeight]);
    // console.log(window.innerHeight);

    this.setState({
      quill_height: this.getQuillHeight()
    })
  }

  componentWillUnmount(){
    this._quill = null;
    ScrollUnLock();
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
        if(this._quill){
          this._quill.root.innerHTML = this.state.text
        }
      })
    }, (error) => {

    })
  }

  handleChange(value) {
    this.setState({ text: value });
  }

  onClickSave = (e) => {
    e.preventDefault();

    if(!this.props.store_order_id){
      alert("주문 ID 정보가 없습니다.");
      return;
    }

    axios.post("/store/product/text/save", {
      store_order_id: this.props.store_order_id,
      product_text: this.state.text,
      product_title_text: this.state.title
    }, (result) => {
      swal("저장완료", '', 'success');
    }, (error) => {

    })
  }

  onClickExit = (e) => {
    e.preventDefault();

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
      <div className={'Popup_text_editor'}>
        <div className={'popup_text_editor_title_container'}>
          <div className={'popup_text_editor_title_text'}>제목</div>
          <input className={'popup_text_editor_input_box'} type="text" name={'title'} placeholder={'제목을 입력해주세요.'} value={this.state.title} onChange={(e) => {this.onChangeInput(e)}}/>
        </div>

        <div className={'quill_container'} style={{height: this.state.quill_height}}>
        </div>       

        <div className={'button_container'}>
          <button onClick={(e) => {this.onClickExit(e)}} className={'button_close'}>
            닫기
          </button>
          <button onClick={(e) => {this.onClickSave(e)}} className={'button_save'}>
            저장
          </button>
        </div>
      </div>
    )
  }
};

Popup_text_editor.defaultProps = {
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

export default Popup_text_editor;