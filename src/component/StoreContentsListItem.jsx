'use strict';

import React, { Component } from 'react';

import Util from '../lib/Util';

import Types from '../Types';

import imgDropDownUp from '../res/img/ic-dropdown-line-up.svg';
import imgDropDownDown from '../res/img/ic-dropdown-line-down.svg';

import ic_badge_download from '../res/img/badge-download.svg';

const IMAGE_FILE_WIDTH = 80;
const IMAGE_FILE_WIDTH_IN_ITEM = 63;
class StoreContentsListItem extends Component{

  constructor(props){
    super(props);

    this.state = {
      show_image_width: 0,
      show_image_height: 0,
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
      // if(!this.props.store_alias || this.props.store_alias === ''){
      //   goURL = baseURL + '/store/' + this.props.store_id;
      // }else{
      //   goURL = baseURL + '/store/' + this.props.store_alias;
      // }

      goURL = baseURL + '/item/store/' + this.props.store_item_id;
      
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

  onImgLoad = (img) => {
    let show_image_width = img.target.offsetWidth;
    let show_image_height = img.target.offsetHeight;
    
    //가로로 긴 이미지인가?
    //세로가 긴 이미지는 width 만 맞추면 height는 자동 맞춰짐
    if(img.target.offsetWidth > img.target.offsetHeight){
      //가로가 긴 이미지
      //세로 비율을 찾는다
      let ratio = IMAGE_FILE_WIDTH / img.target.offsetHeight;

      if(this.props.type === Types.store_home_item_list.IN_ITEM){
        ratio = IMAGE_FILE_WIDTH_IN_ITEM / img.target.offsetHeight;
      }
      

      const imgReSizeWidth = img.target.offsetWidth * ratio;
      const imgReSizeHeight = img.target.offsetHeight * ratio;

      
      show_image_width = imgReSizeWidth,
      show_image_height = imgReSizeHeight
      
    }

    this.setState({
      show_image_width: show_image_width,
      show_image_height: show_image_height
    })
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
    let imgWarpperStyle = {
      width: IMAGE_FILE_WIDTH,
      height: IMAGE_FILE_WIDTH
    }
    // let imgWarpperClassName = 'item_img_wrapper';
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

      imgWarpperStyle = {
        width: IMAGE_FILE_WIDTH_IN_ITEM,
        height: IMAGE_FILE_WIDTH_IN_ITEM
      }

      // inItemImgStyle = {
      //   width: 63,
      //   height: 63
      // }

      // imgWarpperClassName = '';
    }else{
      nick_name_dom = <div className={'item_name'}>{this.props.store_title}<span style={{marginLeft: 8}}>{this.getStateShow(this.props.state)}</span></div>;
    }

    if(this.state.show_image_width > 0){
      inItemImgStyle = {
        width: this.state.show_image_width,
        height: this.state.show_image_height
      }
    }

    let badge_dom = <></>;
    if(this.props.type_contents === Types.contents.completed){
      badge_dom = <span className={'badge_img'}>
                    <img src={ic_badge_download} />
                  </span>
    }
    

    return(
      <>
        <div className={'StoreContentsListItem'} style={inItemContainerStyle}>
          <a onClick={(e) => {this.itemClick(e)}}>
            <div className={'flex_layer flex_direction_row'}>
                <div style={imgWarpperStyle} className={'item_img_wrapper'}>
                  <img className={'item_img'} src={this.props.thumbUrl} onLoad={(img) => {this.onImgLoad(img)}} style={inItemImgStyle}/>
                </div>
                <div className={'item_content_container'} style={inItemContentContainerStyle}>
                  {nick_name_dom}
                  <div className={'item_title'}>
                    {this.props.title}{badge_dom}
                  </div>
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
  type_contents: Types.contents.customized,//여기 아이템에 뱃지 넣어야함..
  reOrderCallback: (index, item_id, reorder_type) => {},
  deleteItemCallback: (item_id, item_title) => {}
}


export default StoreContentsListItem;