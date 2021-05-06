'use strict';

import React, { Component } from 'react';

import Util from '../lib/Util';

import Types from '../Types';

import moment_timezone from 'moment-timezone';
import ic_more from '../res/img/ic-more.svg';

import Popup_StoreReceiptItem from '../component/Popup_StoreReceiptItem';

const IMAGE_FILE_WIDTH = 40;
const IMAGE_FILE_M_WIDTH = 20;
class StoreManagerHome_newOrderItem extends Component{

  constructor(props){
    super(props);

    let isMobile = true;
    let item_width = IMAGE_FILE_M_WIDTH;
    if(window.innerWidth >= 520){
      isMobile = false;
      item_width = IMAGE_FILE_WIDTH;
    }

    this.state = {
      show_image_width: 0,
      show_image_height: 0,
      ori_show_image_width: 0,
      ori_show_image_height: 0,

      isMobile: isMobile,

      item_width: item_width,

      isShowOrderDetailPopup: false
    }
  };

  componentDidMount(){
    window.addEventListener('resize', this.updateDimensions);
  };

  componentWillUnmount(){
    window.removeEventListener('resize', this.updateDimensions);
  };

  componentDidUpdate(){ 
  }

  updateDimensions = () => {

    if(window.innerWidth >= 520){
      if(this.state.isMobile){
        this.setState({
          isMobile: false,
          item_width: IMAGE_FILE_WIDTH
        }, () => {
          this.onImgLoad({
            target: {
              offsetWidth: this.state.show_image_width,
              offsetHeight: this.state.show_image_height
            }
          })
        })
      }
    }else{
      if(!this.state.isMobile){
        this.setState({
          isMobile: true,
          item_width: IMAGE_FILE_M_WIDTH
        }, () => {
          this.onImgLoad({
            target: {
              offsetWidth: this.state.show_image_width,
              offsetHeight: this.state.show_image_height
            }
          })
        })
      }
    }
  }

  clickEdit(e){
    /*
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
    
    window.open(goURL)
    */
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
    let show_image_width = img.target.naturalWidth;
    let show_image_height = img.target.naturalHeight;
    
    //가로로 긴 이미지인가?
    //세로가 긴 이미지는 width 만 맞추면 height는 자동 맞춰짐
    if(show_image_width < this.state.item_width){
      //520사이즈보다 작으면 확대 해야 한다
      show_image_width = '100%';
      show_image_height = 'auto';
    }
    else if(img.target.naturalWidth >= img.target.naturalHeight){
      //가로가 긴 이미지
      //세로 비율을 찾는다

      const ratio = this.state.item_width / img.target.naturalHeight;

      const imgReSizeWidth = img.target.naturalWidth * ratio;
      const imgReSizeHeight = img.target.naturalHeight * ratio;

      
      show_image_width = imgReSizeWidth,
      show_image_height = imgReSizeHeight
    }else if(img.target.naturalWidth < img.target.naturalHeight){
      //세로로 긴거
      show_image_width = '100%';
      show_image_height = 'auto';
    }

    this.setState({
      show_image_width: show_image_width,
      show_image_height: show_image_height,

      ori_show_image_width: img.target.naturalWidth,
      ori_show_image_height: img.target.naturalHeight
    })
  }

  onClickGoItemDetail = (e) => {
    e.preventDefault();

    /*
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    baseURL = baseURL + '/item/store/'+ this.props.store_item_id;

    window.open(baseURL);
    */
  }

  onClickOrderItem = (e) => {
    this.setState({
      isShowOrderDetailPopup: true
    })
  }

  render(){
    let nick_name_dom = <></>;
    
    let inItemImgStyle = {};
    let imgWarpperStyle = {
      width: this.state.item_width,
      height: this.state.item_width
    }

    nick_name_dom = <div className={'item_name'}>{this.props.store_title}<span style={{marginLeft: 8}}>{this.getStateShow(this.props.state)}</span></div>;
    
    if(this.state.show_image_width > 0){
      inItemImgStyle = {
        width: this.state.show_image_width,
        height: this.state.show_image_height
      }
    }

    let orderDetailPopupDom = <></>;
    if(this.state.isShowOrderDetailPopup){
      orderDetailPopupDom = <Popup_StoreReceiptItem 
                            closeCallback={() => 
                            {
                              this.props.callbackRefreshItems();
                              this.setState({isShowOrderDetailPopup: false})
                            }} 
                            store_order_id={this.props.store_order_id}
                            >
                              
                            </Popup_StoreReceiptItem>;
    }

    return(
      <div className={'StoreManagerHome_newOrderItem'}>
        <button onClick={(e) => {this.onClickOrderItem(e)}} className={'new_order_item_button'}>
          <div className={'date_text'}>
            {moment_timezone(this.props.created_at).format('YYYY.MM.DD')}
            <img className={'ic_more_img'} src={ic_more} />
          </div>
          <div className={'item_container'}>
            <div style={imgWarpperStyle} className={'item_img_wrapper'}>
              <img className={'item_img'} src={this.props.img_url} onLoad={(img) => {this.onImgLoad(img)}} style={inItemImgStyle}/>
            </div>
            <div className={'new_order_item_content_container'}>
              <div className={'item_content_box'}>
                <div className={'new_order_item_title text-ellipsize'}>{this.props.item_title}</div>
                <div className={'new_order_item_price'}>{Util.getPriceCurrency(this.props.price, this.props.price_USD, this.props.currency_code)}</div>
              </div>
            </div>
          </div>
        </button>
        {orderDetailPopupDom}
      </div>
      
    )
  }
};

StoreManagerHome_newOrderItem.defaultProps = {
  // id: -1,   //store_item_id와 동일한 id임
  // store_id: -1,
  // store_item_id: -1,
  store_order_id: -1,
  // store_title: '',
  img_url: '',
  item_title: '',
  price: 0,
  created_at: '',

  price_USD: 0,
  currency_code: Types.currency_code.Won
  // state: 0,
  // isLink: false,
}


export default StoreManagerHome_newOrderItem;