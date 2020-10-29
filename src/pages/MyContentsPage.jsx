'use strict';

import React, { Component } from 'react';

import StoreReceiptItem from '../component/StoreReceiptItem';
import Util from '../lib/Util';
import axios from '../lib/Axios';

// import { scale, verticalScale, moderateScale } from 'react-native-size-matters';
// import FontWeights from '@lib/fontWeights';

// import * as appKeys from '~/AppKeys';
// import Util from '@lib/Util';
// import * as GlobalKeys from '~/GlobalKeys';

//redux START
// import * as actions from '@actions/index';
// import { connect } from 'react-redux';
//redux END
// import Colors from '@lib/colors';
// import Types from '~/Types';



class MyContentsPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      myID: null,
      order_datas: [],
      orders_item_doms: []
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    const myID = Number(document.querySelector('#myId').value);
    if(myID === 0){
      //ID값이 0이면 로그인 안함.
      // alert("유저 ID가 없습니다.");
      

    }else{
      // this.requestLoginToken(myID, true);
      this.setState({
        myID: myID
      }, () => {
        this.requestMyStoreOrder();
      })
    }

    // <StoreReceiptItem store_order_id={this.state.store_order_id} isGoDetailButton={false}></StoreReceiptItem>

    // <div className={'container_box'}>
    //       {storeReceiptItemDom}
    //     </div>
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  requestMyStoreOrder(){
    axios.post("/orders/store/item/list", {}, 
    (result) => {
      console.log(result);
      this.setState({
        order_datas: result.list.concat()
      }, () => {
        this.setOrderItem();
      })
    }, (error) => {

    })
  }

  setOrderItem(){
    // console.log(this.state.order_datas);
    let _orders_item_doms = [];
    for(let i = 0 ; i < this.state.order_datas.length ; i++){
      const data = this.state.order_datas[i];
      let domObject = <div key={data.store_order_id} className={'container_box'}>
                        <StoreReceiptItem store_order_id={data.store_order_id} isGoDetailButton={true}></StoreReceiptItem>
                      </div>
      _orders_item_doms.push(domObject);
    }

    this.setState({
      orders_item_doms: _orders_item_doms.concat()
    })
  }

  render(){
    if(!this.state.myID){
      return (
        <></>
      )
    }

    return(
      <div className={'MyContentsPage'}>
        <div className={'myContentsTitle'}>
          나의 콘텐츠
        </div>
        
        {this.state.orders_item_doms}
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

// export default connect(mapStateToProps, mapDispatchToProps)(StoreItemDetailPage);
export default MyContentsPage;