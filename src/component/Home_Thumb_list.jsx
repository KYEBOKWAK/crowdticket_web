'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Types from '../Types';

// import AliceCarousel from 'react-alice-carousel';
import Home_Thumb_Popular_item from './Home_Thumb_Popular_item';
import Home_Thumb_Attention_Item from './Home_Thumb_Attention_Item';
import Home_Thumb_Stores_Item from './Home_Thumb_Stores_Item';

import ic_left from '../res/img/ic-left.svg';
import ic_dis_left from '../res/img/ic-dis-left.svg';
import ic_right from '../res/img/ic-right.svg';
import ic_dis_right from '../res/img/ic-dis-right.svg';

import Carousel from './Carousel';

const SLIDE_BUTTON_SHOW_SIZE = 1270;  //css 의 사이즈와 동일해야함.
class Home_Thumb_list extends Component{

  Carousel = React.createRef();
  constructor(props){
    super(props);

    this.state = {
      list: [],
      items: [],

      innerWidth: 0,

      isNextSlideDisabled: false,
      isPrevSlideDisabled: true,
    }
  };

  componentDidMount(){
    if(this.props.thumb_list_type === Types.thumb_list_type.popular){
      this.requestThumbPopularList();
    }
    else if(this.props.thumb_list_type === Types.thumb_list_type.attention){
      this.requestThumbAttentionList();
    }
    else if(this.props.thumb_list_type === Types.thumb_list_type.stores){
      this.requestCreatorStore();
    }
  };

  requestCreatorStore = () => {
    axios.post('/store/any/list', {}, 
    (result) => {
      // 원본코드
      let _items = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        const itemDom = <Home_Thumb_Stores_Item store_id={data.store_id}></Home_Thumb_Stores_Item>
        _items.push(itemDom);
      }

      this.setState({
        items: _items.concat()
      })
    }, (error) => {

    })
  }

  requestThumbPopularList = () => {
    axios.post("/main/any/thumbnails/popular/list", {
      thumbnails_type: Types.thumbnails.store_item_popular
    }, (result) => {
      // console.log(result);

      let _items = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        const itemDom = <Home_Thumb_Popular_item store_item_id={data.target_id} thumb_img_url={data.thumb_img_url}></Home_Thumb_Popular_item>;
        _items.push(itemDom);
      }

      this.setState({
        items: _items.concat()
      })
    }, (error) => {

    })
  }

  requestThumbAttentionList = () => {
    axios.post("/main/any/thumbnails/attention/list", {}, 
    (result) => {
      // console.log(result);

      let _items = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        const itemDom = <Home_Thumb_Attention_Item store_id={data.store_id}></Home_Thumb_Attention_Item>;
        _items.push(itemDom);
      }

      this.setState({
        items: _items.concat()
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){
    this.Carousel = null;
  };

  componentDidUpdate(){
    // console.log('dfdf');
  }

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
    
    let labelText = '';
    let arrowButtonTop = 0;
    if(this.props.thumb_list_type === Types.thumb_list_type.popular){
      labelText = '오늘의 인기 콘텐츠';
      arrowButtonTop = 180;
    }
    else if(this.props.thumb_list_type === Types.thumb_list_type.attention){
      labelText = '주목할 만한 크리에이터';
      arrowButtonTop = 170;
    }
    else if(this.props.thumb_list_type === Types.thumb_list_type.stores){
      labelText = '크리에이터별 상점';
      arrowButtonTop = 85;
    }

    return(
      <div className={'Home_Thumb_list'}>
        <div className={'label_text'}>
          {labelText}
        </div>
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

          <div className={'prev_button_container'} style={{top: arrowButtonTop}}>
            <button onClick={(e) => {this.onClickPrev(e)}}>
              <img src={_ic_left}/>
            </button>
          </div>
          <div className={'next_button_container'} style={{top: arrowButtonTop}}>
            <button onClick={(e) => {this.onClickNext(e)}}>
              <img src={_ic_right}/>
            </button>
          </div>
      </div>
    )
  }
};

Home_Thumb_list.defaultProps = {
  thumb_list_type: Types.thumb_list_type.popular,
  pc_show_item_count: 4
}

export default Home_Thumb_list;