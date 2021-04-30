//박스가 나열되는 형태의 리스트(캐러셀 안들어감)
'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Util from '../lib/Util';

import Profile from '../component/Profile';

import Types from '../Types';

// import InfiniteScroll from 'react-infinite-scroll-component';

const HOME_THUMB_CONTAINER_SHOW_LINE_COUNT = 6;
const REQUEST_ONCE_ITME = 15;
class Category_Creator_List extends Component{
  isUnmount = false;

  constructor(props){
    super(props);

    this.state = {
      items: [],
      datas: [],
      items_count: 0,
      items_total_count: 0,
      hasMore: true,

      isRefreshing: true,
      // isShowMoreButton: true,

      category_top_id: this.props.category_top_id,
      category_sub_ids: [],

      user_profile_size: 100,

      creator_sort_select_type: this.props.creator_sort_select_type
    }
  };

  static getDerivedStateFromProps(nextProps, prevState) {
    // console.log(this.props);
    // console.log(nextProps);
    // if(prevState.my_like_type === nextProps.redux_like_type && prevState.my_target_id === nextProps.redux_target_id){
    //   return {
    //     heartCount: nextProps.redux_like_count,
    //     isSelected: nextProps.redux_is_select
    //   }
    // }

    if(prevState.category_sub_ids.length !== nextProps.category_sub_ids.length || 
      prevState.creator_sort_select_type !== nextProps.creator_sort_select_type){
      return {
        items: [],
        datas: [],
        items_count: 0,
        isRefreshing: true,
        category_sub_ids: nextProps.category_sub_ids.concat(),
        creator_sort_select_type: nextProps.creator_sort_select_type
      }
    }

    return null;
  }

  componentDidMount(){
    this.requestMoreData();

    
    window.addEventListener('scroll', this.handleScroll);
  };

  componentDidUpdate(prevProps, prevState){

    if(this.state.category_sub_ids.length !== prevState.category_sub_ids.length ||
      this.state.creator_sort_select_type !== prevState.creator_sort_select_type){
      this.requestMoreData();
    }
    // console.log(this.state.items_count);

    // if(this.state.items_count < this.state.items_total_count) {
    //   if(!this.state.isShowMoreButton){
    //     this.setState({
    //       isShowMoreButton: true
    //     })
    //   }
    // }else{
    //   if(this.state.isShowMoreButton){
    //     this.setState({
    //       isShowMoreButton: false
    //     })
    //   }
    // }
  }

  handleScroll = () => {
    let refresh_target_dom = document.querySelector('#refresh_target_creator_list');

    const { top, height } = refresh_target_dom.getBoundingClientRect();

    const windowHeight = window.innerHeight;

    if(top <= windowHeight){
      if(!this.state.isRefreshing && this.state.hasMore){
        // console.log(windowHeight);
        // console.log(top);
        this.setState({
          isRefreshing: true
        }, () => {
          console.log('리프레시!!!')
          this.requestMoreData();
        })
      }
    }
  }

  makeItemList = (_list) => {
    let _rand_list = _list.concat();

    let lineCount = _rand_list.length / HOME_THUMB_CONTAINER_SHOW_LINE_COUNT;

    let index = 0;

    let _items = [];
    let hasMore = true;
    if(this.props.isMore){
      _items = this.state.items.concat();

      if(_list.length < REQUEST_ONCE_ITME) {
        hasMore = false;
      }
    }else{
      _items = [];
    }

    let marginTopZeroStyle = {
      marginTop: 0
    }
    

    // for(let i = 0 ; i < lineCount ; i++){
    //   for(let j = 0 ; j < HOME_THUMB_CONTAINER_SHOW_LINE_COUNT ; j++){
    //     let itemDom = <></>;

    //     let keyIndex = _items.length + 1;
    //     if(index >= _rand_list.length){
    //       itemDom = <div key={keyIndex} className={'item_box'}>
                      
    //                 </div>
    //     }else{
    //       const data = _rand_list[index];
    //       itemDom = <div key={keyIndex} className={'item_box'}>
    //                   <Profile user_id={data.user_id} circleSize={this.state.user_profile_size} isEdit={false}></Profile>
    //                 </div>
    //     }

    //     _items.push(itemDom);

    //     index++;
    //   }
    // }
    for(let i = 0 ; i < _rand_list.length ; i++){
      const data = _rand_list[i];
      let itemDom = <div key={data.store_id} className={'item_box'}>
                      <Profile user_id={data.user_id} circleSize={this.state.user_profile_size} isEdit={false}></Profile>
                    </div>

      _items.push(itemDom);
    }
    /*
    for(let i = 0 ; i < lineCount ; i++){
      
      let rowItems = [];
      for(let j = 0 ; j < 2 ; j++){
        let user_id = null;

        if(index >= _rand_list.length){
          break;
          // if(j === 0){
          //   //두개중 한개만 비어있는 경우가 있음
          //   isOverCount = true;
          // }
        }else{
          const data = _rand_list[index];
          user_id = data.user_id;
        }

        let itemDom = <></>;
        if(user_id !== null){
          itemDom = <div key={j}>
                      <Profile user_id={user_id} circleSize={this.state.user_profile_size} isEdit={false}></Profile>
                    </div>
        }

        rowItems.push(itemDom);

        index++;
      }

      let columnItems = <div key={index} className={'row_items_container'}>
                          {rowItems}
                        </div>

      _items.push(columnItems);
    }
    */

    
    this.setState({
      items: _items.concat(),
      // items_count: this.state.items_count + index,
      items_count: _items.length,
      hasMore: hasMore,
      isRefreshing: false
    })
  }

  requestSearchResult = () => {
    
  }

  requestCategoryList = () => {
    axios.post("/category/any/store/list", 
    {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items_count,

      category_top_item_id: this.props.category_top_id,
      category_sub_item_ids: this.state.category_sub_ids.concat(),

      creator_sort_select_type: this.state.creator_sort_select_type
      // search_text: this.props.search_text
    },
    (result) => {
      if(this.isUnmount){
        return;
      }

      // console.log(result);
      let hasMore = true;
      if(result.list.length < REQUEST_ONCE_ITME) {
        hasMore = false;
      }

      let datas = this.state.datas.concat();
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        datas.push(data);
      }

      this.setState({
        datas: datas.concat(),
        items_count: datas.length,
        hasMore: hasMore,
        isRefreshing: false
      })
      
      // this.makeItemList(result.list);
    }, (error) => {

    })
  }

  requestMoreData = () => {
    this.requestCategoryList();
  }

  componentWillUnmount(){
    this.isUnmount = true;
    window.removeEventListener('scroll', this.handleScroll);
  };

  onClickGoStore = (e, store_id, alias) => {
    e.preventDefault();

    let store_tail = alias;
    if(alias === undefined || alias === null || alias === ''){
      store_tail = store_id;
    }

    window.location.href = '/store/'+store_tail;
  }

  render(){

    let _items = [];
    let index = 0;
    let lineCount = this.state.datas.length / HOME_THUMB_CONTAINER_SHOW_LINE_COUNT;
    for(let i = 0 ; i < lineCount ; i++){
      for(let j = 0 ; j < HOME_THUMB_CONTAINER_SHOW_LINE_COUNT ; j++){
        let itemDom = <></>;

        let keyIndex = index;
        if(index >= this.state.datas.length){
          itemDom = <div key={keyIndex} className={'item_box'}>
                      
                    </div>
        }else{
          const data = this.state.datas[index];
          itemDom = <div key={keyIndex} className={'item_box'}>
                      <Profile user_id={data.user_id} circleSize={this.state.user_profile_size} isEdit={false}></Profile>

                      <div className={'item_title text-ellipsize'}>
                        {data.title}
                      </div>

                      <button onClick={(e) => {this.onClickGoStore(e, data.store_id, data.alias)}} className={'item_button'}>
                        상점가기
                      </button>
                    </div>
        }

        _items.push(itemDom);

        index++;
      }
    }

    
    return(
      <div className={'Category_Creator_List'}>
        <div className={'list_container'}>
          {/* {this.state.items} */}
          {_items}
        </div>
        <div id={'refresh_target_creator_list'}>
        </div>
      </div>
    )    
  }
};

Category_Creator_List.defaultProps = {
  // type: Types.thumb_list_type.category_result,
  isMore: false,
  // isMoreAuto: false,

  category_top_id: 0,
  category_sub_ids: []
}

export default Category_Creator_List;