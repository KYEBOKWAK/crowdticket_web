'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

class Tag_Thumb_Item extends Component{
  isUnmount = false;
  constructor(props){
    super(props);

    this.state = {
      eventList: [],
      list: []
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestETCTagList();
    this.requestEventTagList();
  };

  requestETCTagList = () => {
    if(this.props.item_id === null){
      return;
    }

    axios.post("/tag/any/etc", {
      item_id: this.props.item_id
    }, (result) => {
      if(this.isUnmount){
        return;
      }

      this.setState({
        list: result.list.concat()
      })
    }, (error) => {

    })
  }

  requestEventTagList = () => {
    if(this.props.item_id === null){
      return;
    }

    axios.post("/tag/any/event", {
      item_id: this.props.item_id
    }, (result) => {
      if(this.isUnmount){
        return;
      }

      this.setState({
        eventList: result.list.concat()
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){
    this.isUnmount = true;
  };

  componentDidUpdate(){
  }

  render(){
    let eventTagDoms = [];
    let tagDoms = [];
    for(let i = 0 ; i < this.state.list.length ; i++){
      const data = this.state.list[i];
      // console.log(data);
      const tagDom = <div key={i} className={'tag_box'} style={{backgroundColor: data.bg_color}}>
                      {data.title}
                    </div>
      tagDoms.push(tagDom);
    }

    for(let i = 0 ; i < this.state.eventList.length ; i++){
      const data = this.state.eventList[i];
      // console.log(data);
      const tagDom = <div key={i} className={'tag_box'} style={{backgroundColor: data.bg_color}}>
                      {data.title}
                    </div>
      eventTagDoms.push(tagDom);
    }
    return(
      <div className={'Tag_Thumb_Item'}>
        <div className={'tag_box_container'}>
          {eventTagDoms}
          {tagDoms}
        </div>
      </div>
    )
  }
};

Tag_Thumb_Item.defaultProps = {
  item_id: null
}

export default Tag_Thumb_Item;