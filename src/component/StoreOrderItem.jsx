'use strict';

import React, { Component } from 'react';

import Util from '../lib/Util';


class StoreOrderItem extends Component{

  constructor(props){
    super(props);

    this.state = {
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    // this.requestStoreContents();
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){ 
  }

  itemClick(e){
    e.preventDefault();
    
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    let goURL = baseURL + '/item/store/' + this.props.store_item_id;

    window.location.href = goURL;
  }

  render(){
    return(
      <div className={'StoreOrderItem'}>
        
        <div className={'flex_layer flex_direction_row'}>
            <div className={'item_img_wrapper'}>
              <img className={'item_img'} src={this.props.thumbUrl}/>
            </div>
            <div className={'item_content_container'}>
              <div className={'item_name'}>{this.props.name}</div>
              <div className={'item_title'}>{this.props.title}</div>
              <div className={'item_price'}>{Util.getNumberWithCommas(this.props.price)}원</div>
            </div>
        </div>
        
        <div className={'item_under_line'}>
        </div>
      </div>
    )
  }
};

// props 로 넣어줄 스토어 상태값
// const mapStateToProps = (state) => {
//   // console.log(state);
//   return {
//     // pageViewKeys: state.page.pageViewKeys.concat()
//   }
// };

// const mapDispatchToProps = (dispatch) => {
//   return {
//     // handleAddPageViewKey: (pageKey: string, data: any) => {
//     //   dispatch(actions.addPageViewKey(pageKey, data));
//     // },
//     // handleAddToastMessage: (toastType:number, message: string, data: any) => {
//     //   dispatch(actions.addToastMessage(toastType, message, data));
//     // }
//   }
// };

StoreOrderItem.defaultProps = {
  id: -1,
  store_item_id: -1,
  thumbUrl: '',
  name: '',
  title: '',
  price: 0
}


// export default connect(mapStateToProps, mapDispatchToProps)(Templite);
export default StoreOrderItem;