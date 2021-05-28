'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Types from '../Types';

// import AliceCarousel from 'react-alice-carousel';
import Home_Thumb_Popular_item from './Home_Thumb_Popular_item';
import Home_Thumb_Attention_Item from './Home_Thumb_Attention_Item';
import Home_Thumb_Stores_Item from './Home_Thumb_Stores_Item';

import Find_Result_Stores_item from './Find_Result_Stores_item';

import Thumb_Recommend_item from './Thumb_Recommend_item';

import Thumb_Project_Item from './Thumb_Project_Item';

import ic_left from '../res/img/ic-left.svg';
import ic_dis_left from '../res/img/ic-dis-left.svg';
import ic_right from '../res/img/ic-right.svg';
import ic_dis_right from '../res/img/ic-dis-right.svg';

import Carousel from './Carousel';

import Util from '../lib/Util';

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

      title_text: ''
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
    else if(this.props.thumb_list_type === Types.thumb_list_type.find_result_stores){
      this.requestFindResultStores();
    }
    else if(this.props.thumb_list_type === Types.thumb_list_type.find_no_result_recommend){
      this.requestNoResultRecommend();
    }else if(this.props.thumb_list_type === Types.thumb_list_type.fan_event_thumb){
      this.requsetThumbFanEvent();
    }
  };

  componentDidUpdate(prevProps, prevState){
  }

  requestNoResultRecommend = () => {

    ///any/search/no/recommend
    axios.post('/main/any/search/no/recommend', 
    {}, 
    (result) => {
      let _items = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        const itemDom = <Thumb_Recommend_item store_item_id={item_id}></Thumb_Recommend_item>
        // const itemDom = <Thumb_Recommend_item store_item_id={data.item_id}></Thumb_Recommend_item>
        _items.push(itemDom);
      }

      this.setState({
        items: _items.concat()
      })
    }, (error) => {

    })
  }

  requestFindResultStores = () => {
    axios.post('/main/any/search/stores', 
    {
      search_text: this.props.search_text
    }, 
    (result) => {
      // console.log(result);
      let _items = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        const itemDom = <Find_Result_Stores_item store_id={data.store_id}></Find_Result_Stores_item>;
        _items.push(itemDom);
      }

      this.setState({
        items: _items.concat()
      }, () => {
        this.props.search_result_count_callback(this.state.items.length)
      })
    }, (error) => {

    })
  }

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
      let _title_text = result.list[0].first_text;

      let _temp_list = [];
      for(let i = 1 ; i < result.list.length ; i++){
        const data = result.list[i];
        _temp_list.push(data);
      }

      let _rand_list = Util.getArrayRand(_temp_list);

      let _items = [];
      for(let i = 0 ; i < _rand_list.length ; i++){
        const data = _rand_list[i];
        const itemDom = <Home_Thumb_Popular_item store_item_id={data.target_id} thumb_img_url={data.thumb_img_url}></Home_Thumb_Popular_item>;
        _items.push(itemDom);
      }

      this.setState({
        items: _items.concat(),
        title_text: _title_text
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

  requsetThumbFanEvent = () => {
    axios.post("/main/any/thumbnails/fanevent/list", {
    }, (result) => {
      if(result.list.length === 0){
        this.props.result_count_callback(this.state.items.length);
        return;
      }

      let _title_text = result.list[0].first_text;

      let _temp_list = [];
      for(let i = 1 ; i < result.list.length ; i++){
        const data = result.list[i];
        _temp_list.push(data);
      }

      let _rand_list = Util.getArrayRand(_temp_list);

      let _items = [];
      for(let i = 0 ; i < _rand_list.length ; i++){
        const data = _rand_list[i];
        const itemDom = <Thumb_Project_Item project_id={data.target_id}></Thumb_Project_Item>;
        _items.push(itemDom);
      }

      this.setState({
        items: _items.concat(),
        title_text: _title_text
      }, () => {
        this.props.result_count_callback(this.state.items.length);
      })
    }, (error) => {

    })
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
    
    let labelText = '';
    let arrowButtonTop = 0;
    let arrowButtonLeftRight = 0;
    if(this.props.thumb_list_type === Types.thumb_list_type.popular){
      labelText = this.state.title_text;
      arrowButtonTop = 180;
      arrowButtonLeftRight = -39;
    }
    else if(this.props.thumb_list_type === Types.thumb_list_type.attention){
      labelText = '주목할 만한 크리에이터';
      arrowButtonTop = 170;
      arrowButtonLeftRight = -39;
    }
    else if(this.props.thumb_list_type === Types.thumb_list_type.stores){
      labelText = '크리에이터별 상점';
      arrowButtonTop = 85;
      arrowButtonLeftRight = -39;
    }
    else if(this.props.thumb_list_type === Types.thumb_list_type.find_result_stores){
      arrowButtonTop = 55;
      arrowButtonLeftRight = -36;
    }
    else if(this.props.thumb_list_type === Types.thumb_list_type.find_no_result_recommend){
      arrowButtonTop = 100;
      arrowButtonLeftRight = -30;
    }else if(this.props.thumb_list_type === Types.thumb_list_type.fan_event_thumb){
      labelText = this.state.title_text;
      arrowButtonTop = 180;
      arrowButtonLeftRight = -39;
    }

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

    let labelTextDom = <></>;
    if(labelText !== ''){
      labelTextDom = <div className={'label_text'}>
                      {labelText}
                    </div>
    }

    return(
      <div className={'Home_Thumb_list'}>
        {labelTextDom}
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

Home_Thumb_list.defaultProps = {
  thumb_list_type: Types.thumb_list_type.popular,
  pc_show_item_count: 4,
  search_text: '',
  search_result_count_callback: (count) => {},
  result_count_callback: (count) => {}
}

export default Home_Thumb_list;