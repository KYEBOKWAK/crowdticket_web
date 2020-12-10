'use strict';

import React, { Component } from 'react';

import Types from '../Types';

import ic_exit_circle from '../res/img/ic-exit-circle.svg';

import ReactQuill from 'react-quill';
import axios from '../lib/Axios';

class Popup_complite extends Component{

  constructor(props){
    super(props);

    this.state = {
      title: '',
      text: ''
    }

    this.handleChange = this.handleChange.bind(this)
    //3.0.0
    // this.requestMoreData = this.requestMoreData.bind(this);
  };

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
      <div className={'Popup_complite'}>
        <div className={'popup_text_editor_title_container'}>
          <div className={'popup_text_editor_title_text'}>제목</div>
          <input className={'popup_text_editor_input_box'} type="text" name={'title'} placeholder={'제목을 입력해주세요.'} value={this.state.title} onChange={(e) => {this.onChangeInput(e)}}/>
        </div>
        <div className={'popup_container'}>
          <ReactQuill theme="snow"
                    className={'editor_quill_container'}
                    value={this.state.text}
                    onChange={this.handleChange}
                    placeholder={'고객에게 전달할 텍스트 상품을 입력해주세요.'}
                    modules={{
                      toolbar: [
                        // [{ 'header': [1, 2, false] }],
                        ['bold', 'italic', 'underline','strike'],
                        // ['link', 'image'],
                        // [{'list': 'ordered'}, {'list': 'bullet'}, {'indent': '-1'}, {'indent': '+1'}],
                      ],
                    }}
                    formats={[
                      // 'header',
                      'bold', 'italic', 'underline', 'strike',
                      // 'list', 'bullet', 'indent',
                      // 'link', 'image'
                    ]}>
          </ReactQuill>
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

Popup_complite.defaultProps = {
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

export default Popup_complite;