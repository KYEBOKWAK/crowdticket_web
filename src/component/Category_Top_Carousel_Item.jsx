'use strict';

import React, { Component } from 'react';
// import axios from '../lib/Axios';

class Category_Top_Carousel_Item extends Component{

  COORDS = {
    xDown: null,
    xUp: null
  }

  constructor(props){
    super(props);

    this.state = {
    }
  };

  componentDidMount(){
    
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  handleOnMouseDown = (e) => {
    e.preventDefault()
    this.COORDS.xUp = null
    this.COORDS.xDown = null
    
    this.COORDS.xDown = e.clientX
  }
  
  handleMouseUp = (e) => {
    e.preventDefault()
    this.COORDS.xUp = e.clientX
  }

  onClickGoStore = (e) => {
    // e.preventDefault();

    if (this.COORDS.xDown !== this.COORDS.xUp) {
      e.preventDefault()
    } else {
      let goURL = '/category/'+this.props.top_id;

      window.location.href = goURL;
    }
  }

  render(){
    let itemClassName = 'item_box';
    if(this.props.isSelect){
      itemClassName = 'item_box item_select';
    }

    return(
      <div className={'Category_Top_Carousel_Item'}>
        <div className={itemClassName}>         

          <button onDragStart={(e) => {e.preventDefault();}} onMouseDown={(e) => {this.handleOnMouseDown(e)}}
            onMouseUp={(e) => {this.handleMouseUp(e)}} onClick={(e) => {this.onClickGoStore(e)}} className={'item_button_box'}>
            {this.props.title}
          </button>
        </div>
      </div>
    )
  }
};

//thumb_img_url
Category_Top_Carousel_Item.defaultProps = {
  top_id: null,
  title: '',
  isSelect: false
}

export default Category_Top_Carousel_Item;