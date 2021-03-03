//박스가 나열되는 형태의 리스트(캐러셀 안들어감)
'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Util from '../lib/Util';

import Home_Thumb_Container_Item from '../component/Home_Thumb_Container_Item';
import Home_Thumb_Container_Project_Item from '../component/Home_Thumb_Container_Project_Item';

import Types from '../Types';
import Home_Thumb_Tag from '../component/Home_Thumb_Tag';

// import InfiniteScroll from 'react-infinite-scroll-component';

const HOME_THUMB_CONTAINER_SHOW_LINE_COUNT = 4;
const REQUEST_ONCE_ITME = 8;
class Home_Thumb_Container_List extends Component{

  constructor(props){
    super(props);

    this.state = {
      event_title: '',
      items: [],
      items_count: 0,
      items_total_count: 0,
      hasMore: true,

      isRefreshing: true,

      // isMoreMode: false
      isShowMoreButton: true
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    if(this.props.type === Types.thumb_list_type.event){
      this.requestEventThumbList();
    }
    else if(this.props.type === Types.thumb_list_type.live_update){
      this.requestLiveUpdateList();
    }
    else if(this.props.isMore){
      this.requestMoreData();

      this.requestItemTotalCount();
    }

    if(this.props.isMore){
      window.addEventListener('scroll', this.handleScroll);
    }
    

    // else if(this.props.type === Types.thumb_list_type.find_result_items){
    //   // this.requestSearchResult();
    //   this.requestMoreData();
    // }
    // else if(this.props.type === Types.thumb_list_type.find_result_projects){
    //   // this.requestSearchProject();
    //   this.requestMoreData();
    // }
  };

  makeItemList = (title, _list) => {
    let _event_title = title;

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
            itemDom = <Home_Thumb_Container_Project_Item key={k} project_id={target_id}></Home_Thumb_Container_Project_Item>
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

    // console.log(this.state.items_count);
    if(this.props.type === Types.thumb_list_type.find_result_items ||
      this.props.type === Types.thumb_list_type.find_result_projects){
      this.setState({
        items: _items.concat(),
        items_count: this.state.items_count + index,
        hasMore: hasMore
      }, () => {
        this.setState({
          isRefreshing: false
        })
      })
    }
    else{
      this.setState({
        event_title: _event_title,
        items: _items.concat()
      })
    }
  }

  requestSearchProject = () => {
    axios.post("/main/any/search/projects", 
    {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items_count,

      search_text: this.props.search_text
    }, (result) => {
      this.makeItemList('', result.list);
    }, (error) => {

    })
  }

  requestSearchResult = () => {
    axios.post("/main/any/search/items", 
    {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items_count,

      search_text: this.props.search_text
    },
    (result) => {
      this.makeItemList('', result.list);
    }, (error) => {

    })
  }

  requestLiveUpdateList = () => {
    axios.post("/main/any/thumbnails/updates/list", {},
    (result) => {
      this.makeItemList('실시간 업데이트 콘텐츠', result.list);
    }, (error) => {

    })
  }

  requestEventThumbList = () => {
    axios.post("/main/any/thumbnails/event/list", {}, 
    (result) => {
      // console.log(result);
      let _event_title = result.list[0].first_text;
      this.makeItemList(_event_title, result.list);
    }, (error) => {

    })
  }

  requestItemTotalCount = () => {
    let requestURL = '';
    if(this.props.type === Types.thumb_list_type.find_result_items){
      requestURL = '/main/any/search/items/count';
    }
    else if(this.props.type === Types.thumb_list_type.find_result_projects){
      requestURL = '/main/any/search/projects/count';
    }

    axios.post(requestURL, {
      search_text: this.props.search_text
    }, (result) => {
      const data = result.data;

      let isShowMoreButton = false;
      if(data.count > REQUEST_ONCE_ITME) {
        isShowMoreButton = true;
      }
      this.setState({
        items_total_count: data.count,
        isShowMoreButton: isShowMoreButton
      }, () => {
        this.props.search_result_count_callback(this.state.items_total_count);
      })
    }, (error) => {

    })
  }

  requestMoreData = () => {
    if(this.props.type === Types.thumb_list_type.find_result_items){
      this.requestSearchResult();
    }
    else if(this.props.type === Types.thumb_list_type.find_result_projects){
      this.requestSearchProject();
    }
  }

  componentWillUnmount(){
    if(this.props.isMore){
      window.removeEventListener('scroll', this.handleScroll);
    }
  };

  componentDidUpdate(){
  }

  handleScroll = () => {
    let refresh_target_dom = document.querySelector('#refresh_target_'+this.props.type);
    // const navFakeBar = document.querySelector("#navbar_fake_dom");

    const { top, height } = refresh_target_dom.getBoundingClientRect();

    const windowHeight = window.innerHeight;

    if(top <= windowHeight){
      if(!this.state.isRefreshing && this.state.hasMore && !this.state.isShowMoreButton){
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

  render(){

    // let titleText = '';
    let labelDom = <></>;
    if(this.props.type === Types.thumb_list_type.live_update){
      labelDom = <div className={'label_box'}>
                  <Home_Thumb_Tag thumb_tags={Types.thumb_tags.live_update}></Home_Thumb_Tag>
                </div>
    }

    if(this.props.isMore){

      let moreButtonDom = <></>;
      if(this.state.isShowMoreButton){
        moreButtonDom = <button 
                          onClick={() => {
                            this.setState({
                              isShowMoreButton: false
                            })
                          }} 
                          className={'more_button'}
                        >
                          더보기
                        </button>
      }
      return(
        <div className={'Home_Thumb_Container_List'}>
          {labelDom}
          <div className={'title_text'}>
            {this.state.event_title}
          </div>
          <div className={'list_container'}>
            {this.state.items}

            {moreButtonDom}
            <div id={'refresh_target_'+this.props.type}>
            </div>
          </div>
        </div>
      )
    }else{
      return(
        <div className={'Home_Thumb_Container_List'}>
          {labelDom}
          <div className={'title_text'}>
            {this.state.event_title}
          </div>
          <div className={'list_container'}>
            {this.state.items}
          </div>
        </div>
      )
    }

    
  }
};

Home_Thumb_Container_List.defaultProps = {
  type: Types.thumb_list_type.event,
  search_text: '',
  search_result_count_callback: (count) => {},
  isMore: false
}

export default Home_Thumb_Container_List;