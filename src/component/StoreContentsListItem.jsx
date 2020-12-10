'use strict';

import React, { Component } from 'react';

import Util from '../lib/Util';

import Types from '../Types';

import imgDropDownUp from '../res/img/ic-dropdown-line-up.svg';
import imgDropDownDown from '../res/img/ic-dropdown-line-down.svg';

class StoreContentsListItem extends Component{

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

    if(!this.props.isLink){
      return;
    }
    
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    let goURL = '';
    if(this.props.isHomeList){
      if(!this.props.store_alias || this.props.store_alias === ''){
        goURL = baseURL + '/store/' + this.props.store_id;
      }else{
        goURL = baseURL + '/store/' + this.props.store_alias;
      }
      
    }else {
      goURL = baseURL + '/item/store/' + this.props.store_item_id;
    }

    

    window.location.href = goURL;
  }

  clickReOrderUp(e){
    this.props.reOrderCallback(this.props.index, this.props.store_item_id, Types.reorder_type.UP);
  }

  clickReOrderDown(e){
    this.props.reOrderCallback(this.props.index, this.props.store_item_id, Types.reorder_type.DOWN);
  }

  clickDelete(e){
    e.preventDefault();

    // deleteItemCallback: (item_id, item_title)
    this.props.deleteItemCallback(this.props.store_item_id, this.props.title);
  }

  clickEdit(e){
    e.preventDefault();

    let baseURL = ''
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    
    let goURL = baseURL + '/store/item/'+this.props.store_item_id+'/editpage';
    const isAdmin = document.querySelector('#isAdmin').value;
    if(isAdmin){
      //여기에 store_id가 undefind임...
      goURL = baseURL + '/admin/manager/store/'+this.props.store_id+'/item/'+this.props.store_item_id+'/editpage';
    }
    // console.log(goURL);
    window.location.href = goURL;
  }

  getStateShow(item_state){
    if(item_state === Types.item_state.SALE){
      return '';
    }
    else if(item_state === Types.item_state.SALE_LIMIT){
      return '(품절)';
    }
    else if(item_state === Types.item_state.SALE_PAUSE){
      return '(판매 일시중지)';
    }
    else{
      return '(판매중단 및 비공개)'
    }
  }

  render(){
    let itemUnderLine = <></>;
    if(this.props.isHomeList){
      itemUnderLine = <div className={'item_under_line'}></div>
    }

    let managerButtonContainer = <></>;
    let managerReOrderContainer = <></>;
    if(this.props.isManager){
      managerButtonContainer = <div className={'manager_buttons_container'}>
                                <button className={'manager_edit_button'} onClick={(e) => {this.clickEdit(e)}}>
                                  수정
                                </button>
                                <div className={'manager_between'}>
                                </div>
                                <button className={'manager_delete_button'} onClick={(e) => {this.clickDelete(e)}}>
                                  삭제
                                </button>
                              </div>

      if(this.props.state_re_order === Types.store_manager_state_order.REORDER){
        managerReOrderContainer = <div className={'manager_reorder_container'}>
                                    <button className={'manager_reorder_up_button'} onClick={(e) => {this.clickReOrderUp(e)}}>
                                      <img src={imgDropDownUp} />
                                      <span className={'manager_reorder_button_text'}>
                                        위로
                                      </span>
                                    </button>
                                    <div style={{width: 1, height: 24, opacity: 0.2, backgroundColor: '#ffffff'}}></div>
                                    <button className={'manager_reorder_down_button'} onClick={(e) => {this.clickReOrderDown(e)}}>
                                      <img src={imgDropDownDown} />
                                      <span className={'manager_reorder_button_text'}>
                                        아래로
                                      </span>
                                    </button>
                                  </div>
      }
    }

    let nick_name_dom = <></>;
    let inItemContentContainerStyle = {};
    let inItemContainerStyle = {};
    let inItemImgStyle = {};
    let imgWarpperClassName = 'item_img_wrapper';
    if(this.props.type === Types.store_home_item_list.IN_ITEM){
      inItemContentContainerStyle = {
        display: 'flex',
        flexDirection: 'column',
        justifyContent: 'center'
      }

      inItemContainerStyle = {
        backgroundColor: 'white',
        borderRadius: 20,
        padding: 15,
        marginTop: 10
      }

      inItemImgStyle = {
        width: 63,
        height: 63
      }

      imgWarpperClassName = '';
    }else{
      nick_name_dom = <div className={'item_name'}>{this.props.store_title}<span style={{marginLeft: 8}}>{this.getStateShow(this.props.state)}</span></div>;
    }

    return(
      <>
        <div className={'StoreContentsListItem'} style={inItemContainerStyle}>
          <a onClick={(e) => {this.itemClick(e)}}>
            <div className={'flex_layer flex_direction_row'}>
                <div className={imgWarpperClassName}>
                  <img className={'item_img'} src={this.props.thumbUrl} style={inItemImgStyle}/>
                </div>
                <div className={'item_content_container'} style={inItemContentContainerStyle}>
                  {/* <div className={'item_name'}>{this.props.name}<span style={{marginLeft: 8}}>{this.getStateShow(this.props.state)}</span></div> */}
                  {nick_name_dom}
                  <div className={'item_title'}>{this.props.title}</div>
                  <div className={'item_price'}>{Util.getNumberWithCommas(this.props.price)}원
                  </div>
                </div>
            </div>
          </a>

          {managerButtonContainer}
          {managerReOrderContainer}
        </div>
        {itemUnderLine}
      </>
      
    )
  }
};

StoreContentsListItem.defaultProps = {
  id: -1,
  index: -1,  //array 에 셋팅될때 index
  store_item_id: -1,
  store_title: '',
  thumbUrl: '',
  name: '',
  title: '',
  price: 0,
  isHomeList: false,
  store_alias: '',
  isManager: false,
  state_re_order: Types.store_manager_state_order.NONE,
  state: 0,
  type: Types.store_home_item_list.POPUALER,
  isLink: true,
  reOrderCallback: (index, item_id, reorder_type) => {},
  deleteItemCallback: (item_id, item_title) => {}
}


export default StoreContentsListItem;