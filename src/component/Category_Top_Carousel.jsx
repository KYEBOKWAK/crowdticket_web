'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Types from '../Types';

import ic_left from '../res/img/ic-left.svg';
import ic_dis_left from '../res/img/ic-dis-left.svg';
import ic_right from '../res/img/ic-right.svg';
import ic_dis_right from '../res/img/ic-dis-right.svg';

import Carousel from './Carousel';

import Util from '../lib/Util';

import Category_Top_Carousel_Item from '../component/Category_Top_Carousel_Item';

const SLIDE_BUTTON_SHOW_SIZE = 1270;  //css 의 사이즈와 동일해야함.
class Category_Top_Carousel extends Component{

  Carousel = React.createRef();
  constructor(props){
    super(props);

    let items = [];
    for(let i = 0 ; i < Types.category_top.length ; i++){
      const data = Types.category_top[i];

      let isSelect = false;
      if(data.id === this.props.category_top_item_id){
        isSelect = true;
      }

      items.push(<Category_Top_Carousel_Item top_id={data.id} title={data.show_value} isSelect={isSelect}></Category_Top_Carousel_Item>);
    }

    this.state = {
      items: items.concat(),

      innerWidth: 0,

      isNextSlideDisabled: false,
      isPrevSlideDisabled: true,

      title_text: ''
    }
  };

  componentDidMount(){
    
  };

  componentDidUpdate(prevProps, prevState){
  }

  componentWillUnmount(){
    this.Carousel = null;
  };

  onClickPrev = (e) => {
    e.preventDefault();
    this.Carousel.onClickPrev(e);
  }

  onClickNext = (e) => {
    e.preventDefault();
    this.Carousel.onClickNext(e);
  }

  render(){
    if(this.state.items.length === 0){
      return (<></>);
    }

    let _ic_left = ic_left;
    let _ic_right = ic_right;
    if(this.state.isPrevSlideDisabled){
      _ic_left = ic_dis_left;
    }

    if(this.state.isNextSlideDisabled){
      _ic_right = ic_dis_right;
    }
    
    let arrowButtonTop = 20;
    let arrowButtonLeftRight = -45;

    let leftButtonDom = <></>;
    let rightButtonDom = <></>;
    if(this.props.pc_show_item_count < this.state.items.length){
      leftButtonDom = <div className={'prev_button_container'} style={{top: arrowButtonTop, left: arrowButtonLeftRight}}>
                        <button onClick={(e) => {this.onClickPrev(e)}}>
                          <img src={_ic_left}/>
                        </button>
                      </div>;

      rightButtonDom = <div className={'next_button_container'} style={{top: arrowButtonTop, right: arrowButtonLeftRight}}>
                        <button onClick={(e) => {this.onClickNext(e)}}>
                          <img src={_ic_right}/>
                        </button>
                      </div>
    }

    return(
      <div className={'Category_Top_Carousel'}>
        <Carousel 
          ref={(el) => (this.Carousel = el)} 
          items={this.state.items} 
          pc_show_item_count={this.props.pc_show_item_count}
          onSlideChanged={(isNextSlideDisabled, isPrevSlideDisabled) => {
            this.setState({
              isNextSlideDisabled: isNextSlideDisabled,
              isPrevSlideDisabled: isPrevSlideDisabled
            })
          }}></Carousel>

          {leftButtonDom}
          {rightButtonDom}
      </div>
    )
  }
};

Category_Top_Carousel.defaultProps = {
  pc_show_item_count: 6,
  category_top_item_id: null
}

export default Category_Top_Carousel;