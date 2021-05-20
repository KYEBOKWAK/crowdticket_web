'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import ScrollBooster from 'scrollbooster';

import Util from '../lib/Util';

//store_id, item_id

import Storage from '../lib/Storage';
import * as storageType from '../StorageKeys';

class StoreOtherItems extends Component{
  
  constructor(props){
    super(props);

    this.state = {
      otherItemDoms: [],
      language_code: 'kr'
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    Storage.load(storageType.LANGUAGE_CODE, (result) => {
      let language_code = 'kr';
      if(result.value){
        language_code = result.value;      
      }else{
        //값이 없음 
      }

      this.setState({
        language_code: language_code
      }, () => {
        this.requestOtherItems();
      })
    })
  };

  setScrollAction = () => {
    const viewport = document.querySelector('.StoreOtherItems .viewport');
    const content = document.querySelector('.StoreOtherItems .scrollable-content');

    const sb = new ScrollBooster({
      viewport,
      content,
      bounce: true,
      textSelection: false,
      emulateScroll: true,
      onUpdate: (state) => {
        // state contains useful metrics: position, dragOffset, dragAngle, isDragging, isMoving, borderCollision
        // you can control scroll rendering manually without 'scrollMethod' option:
        content.style.transform = `translate(
          ${-state.position.x}px,
          0px
        )`;

        // content.style.transform = `translate(
        //   ${-state.position.x}px,
        //   ${-state.position.y}px
        // )`;
      },
      shouldScroll: (state, event) => {
        // disable scroll if clicked on button
        const isButton = event.target.nodeName.toLowerCase() === 'button';
        return !isButton;
      },
      onClick: (state, event, isTouchDevice) => {
        // prevent default link event
        const isLink = event.target.nodeName.toLowerCase() === 'link';
        if (isLink) {
          event.preventDefault();
        }
      }
    });

    // methods usage examples:
    sb.updateMetrics();
    // sb.scrollTo({ x: 100, y: 100 });
    sb.updateOptions({ emulateScroll: false });
    // sb.destroy();
  }

  pressItemDetail(e, item_id){
    e.preventDefault();

    
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }
    
    let hrefURL = baseURL+'/item/store/'+item_id;
    
    window.location.href = hrefURL;
  }

  storeItem = (data) => {
    return <div key={data.id} className={'thumb_item_container'}>
                <button style={{backgroundColor: 'white', border: 0, outline: 'none'}} onClick={(e) => {this.pressItemDetail(e, data.id)}}>
                  <div className={'flex_layer flex_direction_column'}>
                    <img className={'thumb_item_img'} draggable='false' src={data.img_url}/>
                    <div className={'thumb_item_title text-ellipsize-2'}>
                      {data.title}
                    </div>

                    <div className={'price_text'}>
                      {Util.getPriceCurrency(data.price, data.price_USD, data.currency_code)}
                    </div>
                  </div>
                </button>
            </div>
  }

  requestOtherItems = () => {
    axios.post("/store/any/item/other/get", {
      store_id: this.props.store_id,
      item_id: this.props.item_id,
      language_code: this.state.language_code
    }, (result) => {

      // result.list = [];
      if(result.list.length === 0){
        this.props.isHideCallback(true);
        return;
      }

      const _otherItemDoms = result.list.map(item => this.storeItem(item));
    
      this.setState({
        otherItemDoms: _otherItemDoms.concat()
      }, () => {
        this.setScrollAction();
      })

    }, (error) => {

    })
  }

  componentWillUnmount(){
    
  };

  render(){
    return(
      <div className={'StoreOtherItems'}>
        <div className={'viewport'}>
          <div className={'scrollable-content'} style={{display: 'flex', flexDirection: 'row',}}>
            {this.state.otherItemDoms}
          </div>
          <div className={'blur_thumb_cover'}>
          </div>
        </div>
      </div>
    )
  }
};

export default StoreOtherItems;