'use strict';

import React, { Component } from 'react';


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

import axios from '../lib/Axios';

import StoreContentsListItem from '../component/StoreContentsListItem';
import plusImg from '../res/img/ic-gnb-plus.svg';
import changeImg from '../res/img/ic-change-gray.svg';
import checkImg from '../res/img/ic-check-bold.svg'

import Types from '../Types';

class StoreManagerTabItemPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      itemOrderDatas: [],
      itemOriOrderDatas: [],
      itemDatas: [],
      state_re_order: Types.store_manager_state_order.NONE
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestItemList();
  };

  componentDidUpdate(prevProps, prevState, snapshot) {
  }

  componentWillUnmount(){

    // 
    
  };

  clickAddItem(e){
    e.preventDefault();
    
    let baseURL = ''
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    // let goURL = baseURL + 'store/'+this.props.store_id+'/item/addpage';
    let goURL = baseURL + '/store/item/addpage';

    window.location.href = goURL;

  }

  requestItemList(){
    axios.post('/store/item/list/all', {
      store_id: this.props.store_id
    }, 
    (result) => {
      // console.log(result.list);

      let itemOrderDatas = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        let orderData = {
          key: data.id,
          item_id: data.id,
          order_number: data.order_number
        }

        itemOrderDatas.push(orderData);
      }

      this.setState({
        itemDatas: result.list.concat(),
        itemOrderDatas: itemOrderDatas.concat(),
        itemOriOrderDatas: itemOrderDatas.concat()
      })
      // console.log(result);
    }, (error) => {

    })
  }

  changeReOrderState(){
    let reOrderState = this.state.state_re_order;
    if(reOrderState === Types.store_manager_state_order.NONE){
      reOrderState = Types.store_manager_state_order.REORDER
    }else{
      reOrderState = Types.store_manager_state_order.NONE
    }

    this.setState({
      state_re_order: reOrderState
    })
  }
  clickReOrder(e){
    e.preventDefault();

    this.changeReOrderState();
  }

  clickCancel(e){
    e.preventDefault();

    this.setState({
      itemOrderDatas: this.state.itemOriOrderDatas.concat()
    }, () => {
      this.changeReOrderState();
    })
  }

  clickOkOrder(e){
    e.preventDefault();

    axios.post("/store/item/list/order/set", {
      item_order_datas: this.state.itemOrderDatas.concat()
    }, (result) => {
      swal("변경 성공!", "", "success").then(() => {
        this.setState({
          state_re_order: Types.store_manager_state_order.NONE,
          itemOriOrderDatas: this.state.itemOrderDatas.concat()
        })
      });
    }, (error) => {

    })
  }

  reOrderCallback(index, item_id, reorder_type){
    // console.log(index + ' // ' + item_id + reorder_type);
    let _itemOrderData = this.state.itemOrderDatas.concat();

    const myIdx = index;
    let targetIdx = index;

    if(reorder_type === Types.reorder_type.UP){
      targetIdx--;

      if(targetIdx < 0){
        return;
      }

      let myData = _itemOrderData[myIdx];
      let targetData = _itemOrderData[targetIdx];
      
      _itemOrderData[myIdx] = targetData;
      _itemOrderData[targetIdx] = myData;
    }else{
      targetIdx++;

      if(targetIdx >= this.state.itemOrderDatas.length){
        return
      }

      let myData = _itemOrderData[myIdx];
      let targetData = _itemOrderData[targetIdx];
      
      _itemOrderData[myIdx] = targetData;
      _itemOrderData[targetIdx] = myData;
    }

    const my_order_number = _itemOrderData[myIdx].order_number;
    const target_order_number = _itemOrderData[targetIdx].order_number;

    _itemOrderData[myIdx].order_number = target_order_number;
    _itemOrderData[targetIdx].order_number = my_order_number;

    this.setState({
      itemOrderDatas: _itemOrderData.concat()
    })
  }

  deleteItem(item_id, title){
    // console.log(item_id + title);
    swal(title + " 상품을 삭제 하시겠습니까? (판매가 된 경우는 삭제가 불가능합니다. 수정에서 판매중지 기능을 이용해주세요.)", {
      buttons: {
        nosave: {
          text: "아니오",
          value: "notsave",
        },
        save: {
          text: "예",
          value: "ok",
        },
      },
    })
    .then((value) => {
      switch (value) {
        case "ok":
        {
          this.requsetDeleteItem(item_id);
        }
        break;
      }
    });
  }

  requsetDeleteItem(item_id){

    showLoadingPopup('삭제중입니다..');

    axios.post("/uploader/delete/img", {
      type: Types.save_img.item,
      target_id: item_id
    }, (result_img) => {
      axios.post("/store/item/delete", {
        item_id: item_id
      }, (result) => {
        stopLoadingPopup();
        swal("삭제 성공!", '', 'success')
        .then((value) => {
          this.requestItemList()
        });
      }, (error) => {
        stopLoadingPopup();
      })
    }, (error) => {
      stopLoadingPopup();
    })

    
  }

  render(){
    let itemListDom = [];
    for(let i = 0 ; i < this.state.itemOrderDatas.length ; i++){
      const orderData = this.state.itemOrderDatas[i];
      const data = this.state.itemDatas.find((value) => {
        if(orderData.item_id === value.id){
          return value;
        }
      })

      if(!data){
        continue;
      }

      const itemDom = <div key={data.id} className={'item_box'}>
                        <StoreContentsListItem state={data.state} store_id={this.state.store_id} id={data.id} store_item_id={data.id} thumbUrl={data.img_url} name={data.nick_name} title={data.title} price={data.price} isManager={true} state_re_order={this.state.state_re_order} reOrderCallback={(index, item_id, reorder_type) => {this.reOrderCallback(index, item_id, reorder_type)}} index={i} deleteItemCallback={(item_id, title) => {this.deleteItem(item_id, title)}}></StoreContentsListItem>
                      </div>

      itemListDom.push(itemDom);
    }
    /*
    for(let i = 0 ; i < this.state.itemDatas.length ; i++){
      const data = this.state.itemDatas[i];
      const itemDom = <div key={data.id} className={'item_box'}>
                        <StoreContentsListItem store_id={this.state.store_id} id={data.id} store_item_id={data.id} thumbUrl={data.img_url} name={data.nick_name} title={data.title} price={data.price} isManager={true} state_re_order={this.state.state_re_order} reOrderCallback={(index, item_id, reorder_type) => {this.reOrderCallback(index, item_id, reorder_type)}} index={i}></StoreContentsListItem>
                      </div>

      itemListDom.push(itemDom);
    }
    */

    let reOrderButtonContainer = <></>;
    if(this.state.state_re_order === Types.store_manager_state_order.NONE){
      reOrderButtonContainer = <div className={'sort_item_button_container'}>
                                  <button className={'sort_item_button'} onClick={(e) => {this.clickReOrder(e)}}>
                                    <img src={changeImg} />
                                    <span className={'sort_item_button_text'}>
                                      상품 순서변경
                                    </span>
                                  </button>
                                </div>

    }else if(this.state.state_re_order === Types.store_manager_state_order.REORDER){
      reOrderButtonContainer = <div className={'sort_item_button_container'}>
                                  <button className={'sort_cancel_button'} onClick={(e) => {this.clickCancel(e)}}>
                                    취소
                                  </button>
                                  <div style={{width: 8}}></div>
                                  <button className={'sort_ok_button'} onClick={(e) => {this.clickOkOrder(e)}}>
                                    <img src={checkImg} />
                                    <span className={'sort_ok_button_text'}>
                                      순서변경 적용
                                    </span>
                                  </button>
                                </div>
    }
    
    return(
      <div className={'StoreManagerTabItemPage'}>
        <button className={'add_item_button'} onClick={(e) => {this.clickAddItem(e)}}>
          <img src={plusImg} />
          <span className={'add_item_button_text'}>
            상품 추가하기
          </span>
        </button>

        {reOrderButtonContainer}

        <div ref={ref => {
            this.list = ref;
          }}
          className="list">
          {itemListDom}
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
export default StoreManagerTabItemPage;