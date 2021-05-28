//박스가 나열되는 형태의 리스트(캐러셀 안들어감)
'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Home_Thumb_Container_Project_Item from '../component/Home_Thumb_Container_Project_Item';

const HOME_THUMB_CONTAINER_SHOW_LINE_COUNT = 4;
const REQUEST_ONCE_ITME = 8;
class Fan_Project_List extends Component{

  constructor(props){
    super(props);

    this.state = {
      event_title: '',
      items: [],
      items_count: 0,
      items_total_count: 0,
      hasMore: true,

      isRefreshing: true,
      isShowMoreButton: true,
    }
  };

  componentDidMount(){
    this.requestMoreData();
    // window.addEventListener('scroll', this.handleScroll);
  };

  

  makeItemList = (title, _list) => {
    let _event_title = title;

    let _rand_list = _list.concat();
    
    let lineCount = _rand_list.length / HOME_THUMB_CONTAINER_SHOW_LINE_COUNT;

    let index = 0;

    let _items = this.state.items.concat();
    let hasMore = true;
    
    if(_list.length < REQUEST_ONCE_ITME) {
      hasMore = false;
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
            target_id = data.project_id;
          }

          // const itemDom = <Home_Thumb_Container_Item key={k} store_item_id={target_id}></Home_Thumb_Container_Item>;

          let itemDom = <Home_Thumb_Container_Project_Item key={k} project_id={target_id}></Home_Thumb_Container_Project_Item>;          
          
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

    let isShowMoreButton = false;
    if(hasMore){
      isShowMoreButton = true;
    }

    this.setState({
      items: _items.concat(),
      items_count: this.state.items_count + index,
      hasMore: hasMore,
      isShowMoreButton: isShowMoreButton,
      isRefreshing: false
    })
  }

  requestProjectList = () => {
    axios.post("/main/any/projects", 
    {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items_count,
    }, (result) => {
      this.makeItemList('', result.list);
    }, (error) => {

    })
  }

  requestMoreData = () => {
    this.requestProjectList();
  }

  componentWillUnmount(){
    // window.removeEventListener('scroll', this.handleScroll);
  };

  componentDidUpdate(){
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

  // handleScroll = () => {

  //   let refresh_target_dom = document.querySelector('#refresh_target');
  //   // const navFakeBar = document.querySelector("#navbar_fake_dom");

  //   const { top, height } = refresh_target_dom.getBoundingClientRect();

  //   const windowHeight = window.innerHeight;

  //   if(top <= windowHeight){
  //     if(!this.state.isRefreshing && this.state.hasMore && !this.state.isShowMoreButton){
  //       // console.log(windowHeight);
  //       // console.log(top);
  //       this.setState({
  //         isRefreshing: true
  //       }, () => {
  //         this.requestMoreData();
  //       })
  //     }
  //   }
  // }

  render(){
    // let titleText = '';
    

    
    let moreButtonDom = <></>;
    if(this.state.isShowMoreButton) {
      moreButtonDom = <button 
                        onClick={() => {
                          this.setState({
                            isShowMoreButton: false,
                            isRefreshing: true
                          }, () => {
                            this.requestMoreData();
                          })
                        }} 
                        className={'more_button'}
                      >
                        더보기
                      </button>
    }

    return(
      <div className={'Fan_Project_List'}>
        <div className={'title_text'}>
          {this.state.event_title}
        </div>
        <div className={'list_container'}>
          {this.state.items}

          {moreButtonDom}
          <div id={'refresh_target'}>
          </div>
        </div>
      </div>
    )    
  }
};

Fan_Project_List.defaultProps = {
}

export default Fan_Project_List;