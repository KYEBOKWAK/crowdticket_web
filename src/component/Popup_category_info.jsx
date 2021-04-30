'use strict';

import React, { Component } from 'react';


import ic_close from '../res/img/ic-close.svg';

class Popup_category_info extends Component{
  // _quill = null;

  constructor(props){
    super(props);

    this.state = {
      list: [
        {
          title: '🎨  만들어드려요',
          explain: '크리에이터의 주요 콘텐츠를 팬의 요청에 따라 만들어주는 콘텐츠상품입니다.'
        },
        {
          title: '🔈  소통해요',
          explain: '크리에이터와 소통하고 싶은 팬들을 위한 콘텐츠상품입니다.'
        },
        {
          title: '✏️  알려드려요',
          explain: '강의/피드백/추천 등 크리에이터에게 정보를 전달받는 콘텐츠상품입니다.'
        },
        {
          title: '✌️  같이 해요',
          explain: '크리에이터의 콘텐츠에 참여하고 싶은 팬들을 위한 콘텐츠상품입니다.'
        },
        {
          title: '🥳  만나요',
          explain: '크리에이터가 오프라인에서 팬과 직접 만나서 진행하는 콘텐츠상품입니다.'
        },
        {
          title: '📢  홍보해드려요',
          explain: '크리에이터와 비즈니스를 하고 싶은 분들을 위한 콘텐츠상품입니다.'
        },
        {
          title: '💾  바로 즐겨요',
          explain: '크리에이터의 디지털 콘텐츠를 바로 다운로드해서 이용할 수 있는 콘텐츠상품입니다.'
        },
      ]      
    }
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

  onClickCheckItem = (e, sort_type, text) => {
    e.preventDefault();

    this.setState({
      select_sort_type: sort_type
    }, () => {
      this.props.selectCallback(this.state.select_sort_type, text);
    })
  }

  render(){
    //2개씩 라인이 몇개 나오는지 확인
    // console.log(lineCount);
    let listDom = [];

    for(let i = 0 ; i < this.state.list.length ; i++){

      const data = this.state.list[i];
      let containerStyle = {}
      if(i === 0){
        containerStyle = {
          marginTop: 0
        }
      }

      let rowItemDom = <div key={i} style={containerStyle} className={'item_box'}>
                        <div className={'item_title'}>
                          {data.title}
                        </div>
                        <div className={'item_explain'}>
                          {data.explain}
                        </div>
                      </div>

      listDom.push(rowItemDom);
    }

    return(
      <div className={'Popup_category_info'}>
        <div className={'bg_container'}>
          <div className={'title_text'}>
            카테고리
          </div>
          <div className={'scroll_box list_container'}>
            {listDom}
          </div>

          
          <button onClick={(e) => {this.onClickExit(e)}} className={'button_close'}>
            <img src={ic_close} />
          </button>
        </div>
      </div>
    )
  }
};

Popup_category_info.defaultProps = {
}

export default Popup_category_info;