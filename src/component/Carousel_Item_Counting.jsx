'use strict';

import React, { Component } from 'react';

import CountUp from '../component/CountUp';
import axios from '../lib/Axios';

class Carousel_Item_Counting extends Component{

  countUpStoresRef = null;
  countUpItemsRef = null;

  isUnmount = false;
  constructor(props){
    super(props);

    this.state = {
      isSetStoreCount: false,
      isSetItemCount: false,
      storeCount: 0,
      itemsCount: 0
    }

    this.props.init();
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestStoresCountInfo();
    this.requestItemsCountInfo();
  };

  componentWillUnmount(){
    this.isUnmount = true;
    this.countUpStoresRef = null;
    this.countUpItemsRef = null;
  };

  componentDidUpdate(){
  }

  reStartCountUp = () => {
    if(this.countUpStoresRef === null || this.countUpItemsRef === null){
      return;
    }

    this.countUpStoresRef.countUpReStart();
    this.countUpItemsRef.countUpReStart();
  }

  requestStoresCountInfo = () => {
    axios.post("/main/any/stores/count", {} , 
    (result) => {
      if(this.isUnmount){
        return
      }

      this.setState({
        isSetStoreCount: true,
        storeCount: result.data.store_count
      })
    }, (error) => {

    })
  }

  requestItemsCountInfo = () => {
    axios.post("/main/any/items/count", {} , 
    (result) => {
      if(this.isUnmount){
        return
      }

      this.setState({
        isSetItemCount: true,
        itemsCount: result.data.item_count
      })
    }, (error) => {

    })
  }

  render(){

    if(this.state.isSetItemCount === false || this.state.isSetStoreCount === false){
      return (<></>);
    }

    return(
      <div className={'Carousel_Item_Counting'}>
        <div className={'counting_box'}>
          <div className={'counting_count_text'}>
            <CountUp 
              ref={(ref) => {
                this.countUpStoresRef = ref;
              }}
              end={this.state.storeCount}
              duration={3}
            ></CountUp>
          </div>
            
          <div className={'counting_label_text'}>
            명의 크리에이터가
          </div>
        </div>

        <div className={'counting_box'}>
          <div className={'counting_count_text'}>
            <CountUp 
              ref={(ref) => {
                this.countUpItemsRef = ref;
              }}
              end={this.state.itemsCount}
              duration={3}
            ></CountUp>
          </div>
          <div className={'counting_label_text'}>
            개의 콘텐츠 판매 중
          </div>
        </div>

        
      </div>
    )
  }
};

export default Carousel_Item_Counting;