'use strict';

import React, { Component, createRef } from 'react';

import StoreReceiptItem from '../component/StoreReceiptItem';

import Types from '../Types';

// import ic_exit_circle from '../res/img/ic-exit-circle.svg';


class Popup_StoreReceiptItem extends Component{
  // _quill = null;

  constructor(props){
    super(props);

    this.state = {
    }
  };

  componentDidMount(){ 
  };

  componentWillUnmount(){
  };

  componentDidUpdate(){
    
  }

  onClickExit = (e) => {
    e.preventDefault();

    // let targetElement = document.querySelector('#react_root');
    // enableBodyScroll(targetElement);

    this.props.closeCallback();
  }

  render(){    
    return(
      <div className={'Popup_StoreReceiptItem'}>
        <div className={'text_container'}>
          <div className={'refund_content_container'}>
          <StoreReceiptItem 
            store_order_id={this.props.store_order_id} 
            isGoDetailButton={false}
            isManager={true}
          ></StoreReceiptItem>
          </div>

          <div className={'button_container'}>
            <button onClick={(e) => {this.onClickExit(e)}} className={'button_close'}>
              닫기
            </button>
          </div>
        </div>
        
      </div>
    )
  }
};

Popup_StoreReceiptItem.defaultProps = {
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

export default Popup_StoreReceiptItem;