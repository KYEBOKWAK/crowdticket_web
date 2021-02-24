//박스가 나열되는 형태의 리스트(캐러셀 안들어감)
'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Util from '../lib/Util';

import Home_Thumb_Container_Item from '../component/Home_Thumb_Container_Item';

import Types from '../Types';
import Home_Thumb_Tag from '../component/Home_Thumb_Tag';

const HOME_THUMB_CONTAINER_SHOW_LINE_COUNT = 4;
class Home_Thumb_Container_List extends Component{

  constructor(props){
    super(props);

    this.state = {
      event_title: '',
      items: []
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
          if(index >= _rand_list.length){
            if(k === 0){
              //두개중 한개만 비어있는 경우가 있음
              isOverCount = true;
            }
            
            const itemDom = <Home_Thumb_Container_Item key={k} store_item_id={null}></Home_Thumb_Container_Item>;
            rowItems.push(itemDom);
          }else{
            const data = _rand_list[index];
            const itemDom = <Home_Thumb_Container_Item key={k} store_item_id={data.item_id}></Home_Thumb_Container_Item>;
            rowItems.push(itemDom);
          }

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

      const itemColumnsDom = <div key={i} className={'column_items_container'}>
                              {columnItems}
                            </div>

      _items.push(itemColumnsDom);
    }

    this.setState({
      event_title: _event_title,
      items: _items.concat()
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
      /*
      let _event_title = result.list[0].first_text;

      let _temp_list = [];
      for(let i = 1 ; i < result.list.length ; i++){
        const data = result.list[i];
        _temp_list.push(data);
      }

      let _rand_list = Util.getArrayRand(_temp_list);

      
      let lineCount = _rand_list.length / HOME_THUMB_CONTAINER_SHOW_LINE_COUNT;

      let index = 0;
      let _items = [];

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
            if(index >= _rand_list.length){
              if(k === 0){
                //두개중 한개만 비어있는 경우가 있음
                isOverCount = true;
              }
              
              const itemDom = <Home_Thumb_Container_Item key={k} store_item_id={null}></Home_Thumb_Container_Item>;
              rowItems.push(itemDom);
            }else{
              const data = _rand_list[index];
              const itemDom = <Home_Thumb_Container_Item key={k} store_item_id={data.item_id}></Home_Thumb_Container_Item>;
              rowItems.push(itemDom);
            }

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

        const itemColumnsDom = <div key={i} className={'column_items_container'}>
                                {columnItems}
                              </div>

        _items.push(itemColumnsDom);
      }

      this.setState({
        event_title: _event_title,
        items: _items.concat()
      })
      */
    }, (error) => {

    })
  }

  /*
  requestEventThumbList = () => {
    axios.post("/main/any/thumbnails/event/list", {}, 
    (result) => {
      // console.log(result);

      let _event_title = result.list[0].first_text;

      let _temp_list = [];
      for(let i = 1 ; i < result.list.length ; i++){
        const data = result.list[i];
        _temp_list.push(data);
      }

      let _rand_list = Util.getArrayRand(_temp_list);

      
      let lineCount = _rand_list.length / HOME_THUMB_CONTAINER_SHOW_LINE_COUNT;

      let index = 0;
      let _items = [];
      let isEnd = false;
      for(let i = 0 ; i < lineCount ; i++){
        let columnItems = [];  
        for(let j = 0 ; j < 2 ; j++){
          //1줄에 4개 모바일일 경우 2개씩 쪼개야 하기 때문에 쪼개서 flex 한다.(모바일일때 2개 flex 유지, pc 일때 4개 flex 유지)
          let rowItems = [];
          for(let k = 0 ; k < 2 ; k++){
            if(index >= _rand_list.length){
              const itemDom = <Home_Thumb_Container_Item key={k} store_item_id={null}></Home_Thumb_Container_Item>;
              rowItems.push(itemDom);
            }else{
              const data = _rand_list[index];
              const itemDom = <Home_Thumb_Container_Item key={k} store_item_id={data.item_id}></Home_Thumb_Container_Item>;
              rowItems.push(itemDom);
            }

            index++;
          }

          

          const itemContainerDom = <div key={j} className={'row_items_container'}>
                                    {rowItems}
                                  </div>

          columnItems.push(itemContainerDom);  
        }

        const itemColumnsDom = <div key={i} className={'column_items_container'}>
                                {columnItems}
                              </div>

        _items.push(itemColumnsDom);
      }

      this.setState({
        event_title: _event_title,
        items: _items.concat()
      })
    }, (error) => {

    })
  }
  */

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){

    // let titleText = '';
    let labelDom = <></>;
    if(this.props.type === Types.thumb_list_type.live_update){
      labelDom = <div className={'label_box'}>
                  <Home_Thumb_Tag thumb_tags={Types.thumb_tags.live_update}></Home_Thumb_Tag>
                </div>
    }

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
};

Home_Thumb_Container_List.defaultProps = {
  type: Types.thumb_list_type.event
}

export default Home_Thumb_Container_List;