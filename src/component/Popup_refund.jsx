'use strict';

import React, { Component, createRef } from 'react';

import Types from '../Types';

import ic_exit_circle from '../res/img/ic-exit-circle.svg';



// import Quill from 'quill';

class Popup_refund extends Component{
  // _quill = null;

  constructor(props){
    super(props);

    this.state = {
      // quill_height: this.getQuillHeight()
    }

    // this.handleChange = this.handleChange.bind(this)
    //3.0.0
    // this.requestMoreData = this.requestMoreData.bind(this);
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
      <div className={'Popup_refund'}>
        <div className={'text_container'}>
          <div className={'title_text'}>
            크티 콘텐츠 취소/환불 규정
          </div>

          <div className={'refund_content_container'}>
           {
           `- 모든 콘텐츠 주문은 크리에이터의 승인이 필요합니다.

           - 크리에이터의 의사에 따라 콘텐츠 주문이 반려될 수 있습니다.

           - 주문 날짜로부터 7일 안에 승인이 안되거나 반려될 경우 결제 금액은 전액 환불됩니다.
           
           - 주문이 승인되기 전에는 구매자에 의한 주문 취소 및 환불이 가능합니다.

           - 크리에이터가 주문을 승인한 이후에는 취소 및 환불이 불가능합니다. 단, 주문 날짜로부터 14일이 경과했는데도 콘텐츠를 제공받지 못한 경우에는 구매자 요청 시 주문 취소 후 결제 금액을 전액 환불해드립니다.

           - 디지털 콘텐츠 특성 상 콘텐츠를 제공 받은 이후에는 단순 불만족 또는 변심으로 인한 환불이 불가능하니 유의해주세요.

           - 크티에서 판매되는 모든 콘텐츠는 상품 설명에 별도로 명시되지 않은 이상 구매자가 크티 플랫폼 밖에서 상업적으로 이용할 수 없습니다.
           `
           }
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

Popup_refund.defaultProps = {
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

export default Popup_refund;