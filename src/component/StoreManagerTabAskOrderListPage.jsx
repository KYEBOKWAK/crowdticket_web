'use strict';

import React, { Component } from 'react';

import StoreReceiptItem from '../component/StoreReceiptItem';
import axios from '../lib/Axios';

import cryingHamImg from '../res/img/icCryingHamGray.png';

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



class StoreManagerTabAskOrderListPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      listDom: []
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    console.log(this.props.store_id);

    axios.post("/store/orders/ask/list", {
      store_id: this.props.store_id
    }, (result) => {
      let _listDom = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        let listItemDom = <div key={data.store_order_id} className={'container_box'}>
                            <StoreReceiptItem 
                              store_order_id={data.store_order_id} 
                              isGoDetailButton={false}
                              isManager={true}
                            ></StoreReceiptItem>
                          </div>

        _listDom.push(listItemDom)
      }

      this.setState({
        listDom: _listDom.concat()
      })

    }, (error) => {

    })
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  render(){

    let contentDom = [];
    if(this.state.listDom.length === 0){
      contentDom = <div> 
                    <div className={'hamImg_container'}>
                      <img className={'hamImg'} src={cryingHamImg}/>
                      <div className={'no_contents_text'}>
                        요청된 콘텐츠가 없어요!
                      </div>
                    </div>
                    
                  </div>
    }else{
      contentDom = this.state.listDom.concat();
    }
    return(
      <div className={'StoreManagerTabAskOrderListPage'}>
        <div className={'tip_text'}>
          요청된 콘텐츠의 알림을 받으려면 [정산] 탭의 비상용 연락처와 이메일을 반드시 적어주세요.
        </div>
        {contentDom}
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
export default StoreManagerTabAskOrderListPage;