'use strict';

import React, { Component } from 'react';


import ic_close from '../res/img/ic-close.svg';

import ic_radio_pressed from '../res/img/radio-pressed.svg';
import ic_radio_unpressed from '../res/img/radio-unpressed.svg';

import Types from '../Types';

const MENU_CONTENTS = 'MENU_CONTENTS';
const MENU_CREATOR = 'MENU_CREATOR';

class Popup_category_sort extends Component{
  // _quill = null;

  constructor(props){
    super(props);

    let contents_sort_datas = [
      {
        type: Types.sort_category.SORT_POPULAR,
        text: '인기순'
      },
      {
        type: Types.sort_category.SORT_NEW,
        text: '최신순'
      },
      {
        type: Types.sort_category.SORT_PRICE_HIGH,
        text: '높은 가격 순'
      },
      {
        type: Types.sort_category.SORT_PRICE_LOW,
        text: '낮은 가격 순'
      }
    ]

    let creator_sort_datas = [
      {
        type: Types.sort_category.SORT_POPULAR,
        text: '인기순'
      },
      {
        type: Types.sort_category.SORT_NEW,
        text: '최신순'
      },
      {
        type: Types.sort_category.SORT_NAME_HIGH,
        text: '이름 오름차순'
      },
      {
        type: Types.sort_category.SORT_NAME_LOW,
        text: '이름 내림차순'
      }
    ]

    let sort_datas = [];
    if(this.props.menu_type === MENU_CONTENTS){
      sort_datas = contents_sort_datas.concat()
    }else{
      sort_datas = creator_sort_datas.concat()
    }

    this.state = {
      // contents_filter_datas: contents_filter_datas.concat(),
      contents_filter_datas: [],
      select_sort_type: this.props.default_select_sort_type, 
      sort_datas: sort_datas.concat()
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
    let rowLineDom = [];

    for(let i = 0 ; i < this.state.sort_datas.length ; i++){

      const data = this.state.sort_datas[i];

      let checkImg = ic_radio_unpressed;
      if(this.state.select_sort_type === data.type){
        checkImg = ic_radio_pressed;
      }

      let containerStyle = {}
      if(i === 0){
        containerStyle = {
          marginTop: 0
        }
      }

      let rowItemDom = <button key={i} style={containerStyle} onClick={(e) => {this.onClickCheckItem(e, data.type, data.text)}} className={'check_button'}>
                          <img src={checkImg} />
                          <div className={'check_button_text'}>
                            {data.text}
                          </div>
                        </button>

      rowLineDom.push(rowItemDom);
    }
    // for(let i = 0 ; i < lineCount ; i++){
    //   let rowItems = [];
    //   for(let j = 0 ; j < 2 ; j++){
    //     if(index >= this.state.contents_filter_datas.length){
    //       break;
    //     }
    //     const data = this.state.contents_filter_datas[index];
        
    //     let checkImg = ic_check_unchecked;
    //     if(data.isSelect){
    //       checkImg = ic_check_checked
    //     }

    //     let _index = index;
    //     let rowItemDom = <button key={j} onClick={(e) => {this.onClickCheckItem(e, _index)}} className={'check_button'}>
    //                         <img src={checkImg} />
    //                         <div className={'check_button_text'}>
    //                           {data.text}
    //                         </div>
    //                       </button>

    //     rowItems.push(rowItemDom);

    //     index++
    //   }

    //   let containerStyle = {}
    //   if(i === 0){
    //     containerStyle = {
    //       marginTop: 0
    //     }
    //   }

    //   let lineDom = <div key={i} style={containerStyle} className={'check_button_container'}>
    //                   {rowItems}
    //                 </div>

    //   rowLineDom.push(lineDom)
    // }

    return(
      <div className={'Popup_category_sort'}>
        <div className={'bg_container'}>
          <div className={'title_text'}>
            정렬
          </div>
          <div className={'check_container'}>
            {rowLineDom}
          </div>

          
          <button onClick={(e) => {this.onClickExit(e)}} className={'button_close'}>
            <img src={ic_close} />
          </button>
        </div>
      </div>
    )
  }
};

Popup_category_sort.defaultProps = {
  menu_type: MENU_CONTENTS
}

export default Popup_category_sort;