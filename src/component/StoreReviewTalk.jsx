'use strict';

import React, { Component } from 'react';

import StoreReviewTalkItem from '../component/StoreReviewTalkItem';

import AliceCarousel from 'react-alice-carousel';

import ic_left_slider_button from '../res/img/ic-left-slider-button.svg';
import ic_right_slider_button from '../res/img/ic-right-slider-button.svg';

import axios from '../lib/Axios';

class StoreReviewTalk extends Component{

  Carousel = React.createRef();

  constructor(props){
    super(props);

    this.state = {
      datas: [],
      items: [],

      show_item_title: ''
    }
  };

  componentDidMount(){
    this.requestReviewTalk();
  };

  requestReviewTalk = () => {
    axios.post("/store/any/order/review/get", {
      store_id: this.props.store_id
    }, (result) => {
      // if(result.list.length === 0){
      //   this.props.isHideCallback(true)
      // }

      let _datas = [];
      let _items = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = {
          ...result.list[i]
        }

        _datas.push(data);
        _items.push(<StoreReviewTalkItem onDragStart={(e) => e.preventDefault()} store_order_id={data.id}></StoreReviewTalkItem>)
      }

      this.setState({
        show_item_title: _datas[0].title,
        datas: _datas.concat(),
        items: _items.concat()
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  onClickLeft = (e) => {
    e.preventDefault();
    this.Carousel.slidePrev()
  }

  onClickRight = (e) => {
    e.preventDefault();
    this.Carousel.slideNext()
  }

  render(){
    if(this.state.datas.length === 0){
      return (
        <div className={'StoreReviewTalk'}>
          <div className={'no_data_text'}>
            {`이 콘텐츠 상품의\n`}
            <span className={'no_data_text_point_color'}>첫 구매자</span>
            {`가 되어주세요!`}
          </div>
        </div>
      )
    }
    return(
      <div className={'StoreReviewTalk'}>
        <div className={'title_label_text'}>
          상품명
        </div>
        <div className={'title_text'}>
          {this.state.show_item_title}
        </div>

        <div className={'under_line'}>
        </div>

        <div style={{position: 'relative'}}>
          <AliceCarousel 
          ref={(el) => (this.Carousel = el)} 
          infinite={true} mouseTracking 
          items={this.state.items}
          onSlideChanged={(item) => {

            const _show_item_title = this.state.datas[item.slide];
            this.setState({
              show_item_title: _show_item_title.title
            })
            // item.slide
          }}
          />

          <div className={'carousel_buttons_container'}>
            <button onClick={(e) => {this.onClickLeft(e)}}>
              <img src={ic_left_slider_button} />
            </button>
            <button onClick={(e) => {this.onClickRight(e)}}>
              <img src={ic_right_slider_button} />
            </button>
          </div>
        </div>
        
      </div>
    )
  }
};

export default StoreReviewTalk;