//박스가 나열되는 형태의 리스트(캐러셀 안들어감)
'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Util from '../lib/Util';

import Home_Thumb_Container_Item from '../component/Home_Thumb_Container_Item';

import Types from '../Types';

// import InfiniteScroll from 'react-infinite-scroll-component';

const HOME_THUMB_CONTAINER_SHOW_LINE_COUNT = 4;
const REQUEST_ONCE_ITME = 16;

class Category_Result_List extends Component{

  isUnmount = false;
  constructor(props){
    super(props);

    this.state = {
      items: [],
      items_count: 0,
      items_total_count: 0,
      hasMore: true,

      isRefreshing: true,
      // isShowMoreButton: true,

      category_top_id: this.props.category_top_id,
      category_sub_ids: [],

      contents_filter_selects: this.props.contents_filter_selects.concat(),
      contents_sort_select_type: this.props.contents_sort_select_type
    }
  };

  static getDerivedStateFromProps(nextProps, prevState) {
    
    if(prevState.category_sub_ids.length !== nextProps.category_sub_ids.length || 
      !Util.arrayEquals(prevState.contents_filter_selects, nextProps.contents_filter_selects) || 
      prevState.contents_sort_select_type !== nextProps.contents_sort_select_type){
      return {
        items: [],
        items_count: 0,
        isRefreshing: true,
        category_sub_ids: nextProps.category_sub_ids.concat(),
        contents_filter_selects: nextProps.contents_filter_selects.concat(),
        contents_sort_select_type: nextProps.contents_sort_select_type
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
      !Util.arrayEquals(this.state.contents_filter_selects, prevState.contents_filter_selects) || 
      this.state.contents_sort_select_type !== prevState.contents_sort_select_type){
        this.requestMoreData();
    }

    // if(this.state.category_sub_ids.length !== prevState.category_sub_ids.length || 
    //   this.state.contents_filter_selects.length !== prevState.contents_filter_selects.length || 
    //   this.state.contents_sort_select_type !== prevState.contents_sort_select_type){
    //     this.requestMoreData();
    // }
  }

  handleScroll = () => {
    let refresh_target_dom = document.querySelector('#refresh_target_'+this.props.type);
    if(refresh_target_dom){
      const { top, height } = refresh_target_dom.getBoundingClientRect();

      const windowHeight = window.innerHeight;

      if(top <= windowHeight){
        if(!this.state.isRefreshing && this.state.hasMore){
          // console.log(windowHeight);
          // console.log(top);
          this.setState({
            isRefreshing: true
          }, () => {
            this.requestMoreData();
          })
        }
      }
    } 
  }

  makeItemList = (_list) => {
    let _rand_list = [];
    if(this.props.type === Types.thumb_list_type.event){

      let _temp_list = [];
      for(let i = 1 ; i < _list.length ; i++){
        const data = _list[i];
        _temp_list.push(data);
      }

      _rand_list = Util.getArrayRand(_temp_list);
    }else{
      _rand_list = _list.concat()
    }

    
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
    for(let i = 0 ; i < lineCount ; i++){
      let columnItems = [];
      let isOverCount = false;
      for(let j = 0 ; j < 2 ; j++){
        //1줄에 4개 모바일일 경우 2개씩 쪼개야 하기 때문에 쪼개서 flex 한다.(모바일일때 2개 flex 유지, pc 일때 4개 flex 유지)
        let rowItems = [];

        for(let k = 0 ; k < 2 ; k++){
          let target_id = null;

          if(index >= _rand_list.length){
            if(k === 0){
              //두개중 한개만 비어있는 경우가 있음
              isOverCount = true;
            }
          }else{
            const data = _rand_list[index];

            if(this.props.type === Types.thumb_list_type.find_result_projects){
              target_id = data.project_id;
            }else{
              target_id = data.item_id;
            }
          }

          // const itemDom = <Home_Thumb_Container_Item key={k} store_item_id={target_id}></Home_Thumb_Container_Item>;

          let itemDom = <></>;
          if(this.props.type === Types.thumb_list_type.find_result_projects){
            
          }
          else{
            itemDom = <Home_Thumb_Container_Item key={k} store_item_id={target_id}>
                      </Home_Thumb_Container_Item>;
          }
          
          rowItems.push(itemDom);

          if(k === 0){
            rowItems.push(<div key={k+'_gap'} className={'row_items_gap'}></div>)
          }

          index++;
        }

        let itemContainerStyle = {}
        if(isOverCount){
          itemContainerStyle = {
            ...marginTopZeroStyle
          }
        }

        const itemContainerDom = <div style={itemContainerStyle} key={j} className={'row_items_container'}>
                                  {rowItems}
                                </div>

        columnItems.push(itemContainerDom);

        if(j === 0){
          columnItems.push(<div key={j+'_gap'} className={'column_items_gap'}></div>);
        }
      }

      const itemColumnsDom = <div key={this.state.items.length+'_'+i} className={'column_items_container'}>
                              {columnItems}
                            </div>

      _items.push(itemColumnsDom);
    }

    
    this.setState({
      items: _items.concat(),
      items_count: this.state.items_count + index,
      hasMore: hasMore,
      isRefreshing: false
    })
  }

  requestSearchResult = () => {
    
  }

  isTotalEtcSub = () => {
    const category_sub_ids_data = this.state.category_sub_ids.find((value) => {
      if(value === Types.category_total_etc_id){
        return value;
      }
    })

    if(category_sub_ids_data === undefined){
      return false;
    }else{
      return true;
    }
  }

  requestCategoryList = () => {
    let category_sub_ids = this.state.category_sub_ids.concat();
    if(this.isTotalEtcSub()){
      for(let i = 0 ; i < this.props.ETC_LISTS.length ; i++){
        const data = this.props.ETC_LISTS[i];
        category_sub_ids.push(data);
      }
    }

    axios.post("/category/any/items/list", 
    {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items_count,

      category_top_item_id: this.props.category_top_id,
      category_sub_item_ids: category_sub_ids.concat(),

      contents_filter_selects: this.state.contents_filter_selects.concat(),
      contents_sort_select_type: this.state.contents_sort_select_type
    },
    (result) => {
      if(this.isUnmount){
        return;
      }

      this.makeItemList(result.list);
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

  render(){
    if(this.state.items.length === 0){
      return(
        <div className={'Category_Result_List'}>
          <div className={'no_list_container'}>
            <div>
              필터 검색 결과가 없습니다.
            </div>
          </div>
        </div>
      )

    }else{
      return(
        <div className={'Category_Result_List'}>
          <div className={'list_container'}>
            {this.state.items}
            <div id={'refresh_target_'+this.props.type}>
            </div>
          </div>
        </div>
      )    
    }
    
  }
};

Category_Result_List.defaultProps = {
  type: Types.thumb_list_type.category_result,
  isMore: false,
  // isMoreAuto: false,

  category_top_id: 0,
  category_sub_ids: [],

  // contents_sort_select: 
}

export default Category_Result_List;