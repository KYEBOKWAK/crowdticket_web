'use strict';

import React, { Component } from 'react';

// import Quill from 'quill';

import ic_close from '../res/img/ic-close.svg';

import ic_check_checked from '../res/img/check-checked.svg';
import ic_check_unchecked from '../res/img/check-unchecked.svg';

class Popup_category_filter extends Component{
  // _quill = null;

  constructor(props){
    super(props);

    let contents_filter_datas = [
      {
        type: 'video',
        text: '영상',
        isSelect: false,
      },
      {
        type: 'sound',
        text: '음원',
        isSelect: false,
      },
      {
        type: 'image',
        text: '이미지',
        isSelect: false,
      },
      {
        type: 'text',
        text: '텍스트',
        isSelect: false,
      },
      {
        type: 'live',
        text: '실시간',
        isSelect: false,
      },
      {
        type: 'etc',
        text: '기타',
        isSelect: false,
      },
      {
        type: 'download',
        text: '즉시 다운로드',
        isSelect: false,
      },
    ]

    for(let i = 0 ; i < contents_filter_datas.length ; i++){
      const data = contents_filter_datas[i];
      const selectData = this.props.selectedList.find((value) => {
                            if(value.type === data.type){
                              return value
                            }
                          });
      if(selectData !== undefined){
        contents_filter_datas[i].isSelect = true;
      }
    }
    this.state = {
      contents_filter_datas: contents_filter_datas.concat(),
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

  onClickCheckItem = (e, index) => {
    e.preventDefault();

    let contents_filter_datas = this.state.contents_filter_datas.concat();
    const data = contents_filter_datas[index];
    if(data.isSelect){
      contents_filter_datas[index].isSelect = false;
    }else{
      contents_filter_datas[index].isSelect = true;
    }

    this.setState({
      contents_filter_datas: contents_filter_datas.concat()
    })
  }

  onClickReset = (e) => {
    e.preventDefault();

    let contents_filter_datas = this.state.contents_filter_datas.concat();

    for(let i = 0 ; i < contents_filter_datas.length ; i++){
      contents_filter_datas[i].isSelect = false;
    }

    this.setState({
      contents_filter_datas: contents_filter_datas.concat()
    })
  }

  onClickSelect = (e) => {
    e.preventDefault();

    let contents_filter_datas = this.state.contents_filter_datas.concat();
    let callbackSelectDatas = [];

    for(let i = 0 ; i < contents_filter_datas.length ; i++){
      const data = contents_filter_datas[i];
      if(data.isSelect){
        callbackSelectDatas.push(data);
      }
    }

    this.props.selectCallback(callbackSelectDatas);
  }

  render(){
    //2개씩 라인이 몇개 나오는지 확인
    let lineCount = this.state.contents_filter_datas.length / 2;
    // console.log(lineCount);

    let index = 0;

    let rowLineDom = [];
    for(let i = 0 ; i < lineCount ; i++){
      let rowItems = [];
      for(let j = 0 ; j < 2 ; j++){
        if(index >= this.state.contents_filter_datas.length){
          break;
        }
        const data = this.state.contents_filter_datas[index];
        
        let checkImg = ic_check_unchecked;
        if(data.isSelect){
          checkImg = ic_check_checked
        }

        let _index = index;
        let rowItemDom = <button key={j} onClick={(e) => {this.onClickCheckItem(e, _index)}} className={'check_button'}>
                            <img src={checkImg} />
                            <div className={'check_button_text'}>
                              {data.text}
                            </div>
                          </button>

        rowItems.push(rowItemDom);

        index++
      }

      let containerStyle = {}
      if(i === 0){
        containerStyle = {
          marginTop: 0
        }
      }

      let lineDom = <div key={i} style={containerStyle} className={'check_button_container'}>
                      {rowItems}
                    </div>

      rowLineDom.push(lineDom)
    }

    return(
      <div className={'Popup_category_filter'}>
        <div className={'bg_container'}>
          <div className={'title_text'}>
            콘텐츠 유형
          </div>
          <div className={'check_container'}>
            {rowLineDom}
          </div>

          <div className={'button_container'}>
            <button className={'clear_button'} onClick={(e) => {this.onClickReset(e)}}>
              초기화
            </button>
            <div className={'button_gap'}></div>
            <button className={'save_button'} onClick={(e) => {this.onClickSelect(e)}}>
              저장
            </button>
          </div>
          <button onClick={(e) => {this.onClickExit(e)}} className={'button_close'}>
            <img src={ic_close} />
          </button>
        </div>
      </div>
    )
  }
};

Popup_category_filter.defaultProps = {
  selectedList: []
}

export default Popup_category_filter;