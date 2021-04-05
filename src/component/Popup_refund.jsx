'use strict';

import React, { Component, createRef } from 'react';

import Types from '../Types';

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
    ScrollLock();
  };

  componentWillUnmount(){
    ScrollUnLock();
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

    let text = '';
    if(this.props.item_type_contents === Types.contents.completed){
      text = `• 디지털 콘텐츠 특성상 콘텐츠를 받은 이후에는 단순 불만족 또는 변심으로 인한 환불이 불가능하니 유의해주세요.

      • 해당 콘텐츠상품은 구매 완료 시점으로부터 60일 동안 횟수 제한없이 콘텐츠를 다운로드 받아 사용할 수 있습니다.
      
      • 즉시 다운로드 콘텐츠는 결제 이후 취소 및 환불이 불가능합니다. 단, 다운로드 받은 파일에 문제가 있는 경우 7일 이내에 고객센터 문의를 해주시면 처리해드립니다.
      
      • 콘텐츠상점을 통해 제공받은 모든 콘텐츠는 상품 설명에 별도로 명시되지 않은 이상 구매자가 크티 플랫폼 밖에서 상업적으로 이용할 수 없습니다.`
    }
    else {
      text = `• 디지털 콘텐츠 특성상 콘텐츠를 받은 이후에는 단순 불만족 또는 변심으로 인한 환불이 불가능하니 유의해주세요.

      • 해당 콘텐츠상품은 콘텐츠 제작 전 크리에이터의 주문 승인이 필요하며 크리에이터의 정책 또는 의사에 따라 주문이 반려될 수 있습니다.
      
      • 주문 날짜로부터 7일 안에 승인이 안되거나 반려될 경우 결제 금액은 전액 환불됩니다.
      
      • 주문이 승인되기 전에는 구매자에 의한 주문 취소 및 환불이 가능합니다.
      
      • 크리에이터가 주문을 승인한 이후에는 취소 및 환불이 불가능합니다. 단, 주문 날짜로부터 14일 경과 후에도 콘텐츠를 제공받지 못한 경우에는 요청 시 주문 취소 후 결제 금액을 전액 환불해드립니다.
      
      • 콘텐츠상점을 통해 제공받은 모든 콘텐츠는 상품 설명에 별도로 명시되지 않은 이상 구매자가 크티 플랫폼 밖에서 상업적으로 이용할 수 없습니다.`
    }
    return(
      <div className={'Popup_refund'}>
        <div className={'text_container'}>
          <div className={'title_text'}>
            크티 콘텐츠 취소/환불 규정
          </div>

          <div className={'refund_content_container'}>
           {text}
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
  item_type_contents: Types.contents.customized
}

export default Popup_refund;