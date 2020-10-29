'use strict';

import React, { Component } from 'react';

import StoreReceiptItem from '../component/StoreReceiptItem';
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



class StoreOrderComplitePage extends Component{

  constructor(props){
    super(props);

    this.state = {
      store_order_id: null
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    const storeOrderIDDom = document.querySelector('#store_order_id');
    if(storeOrderIDDom){
      console.log(storeOrderIDDom.value);

      this.setState({
        store_order_id: Number(storeOrderIDDom.value)
      }, function(){
        //아이템 정보 가져오기
      })
    }
    
    // store_order_id
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){

    let storeReceiptItemDom = <></>;
    if(this.state.store_order_id){
      storeReceiptItemDom = <StoreReceiptItem store_order_id={this.state.store_order_id}></StoreReceiptItem>
    }

    return(
      <div className={"StoreOrderComplitePage"}>
        <div className={'label_title_text'}>
          주문 완료
        </div>
        <div className={"container_box"}>
          <div className={"how_ask_text"}>
            🤔 컨텐츠는 어떻게 받아 볼 수 있나요?
          </div>
          <div className={"under_line"}>
          </div>
          <div className={"how_answer_text"}>
            크티가 입력해주신 연락처를 통해 오픈 카톡방으로 컨텐츠를 전달드려요. :)
          </div>
        </div>

        <div className={'receipt_label_text'}>
          주문내역
        </div>

        <div className={'container_box'}>
          {storeReceiptItemDom}
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

// export default connect(mapStateToProps, mapDispatchToProps)(StoreItemDetailPage);
export default StoreOrderComplitePage;