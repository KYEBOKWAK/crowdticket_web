'use strict';

import React, { Component } from 'react';

import Util from '../lib/Util';

import moment_timezone from 'moment-timezone';
import axios from '../lib/Axios';

import default_user_img from '../res/img/default-user-image.png';
import Types from '../Types';


class StoreItemDetailReviewItem extends Component{

  constructor(props){
    super(props);

    this.state = {
      myID: null,
      item_id: null,
      item_title: '',
      item_state: null
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestItemInfoByOrderId();
    // this.requestStoreContents();
    // console.log(this.props.user_id);
    /*
    const myID = Number(document.querySelector('#myId').value);
    if(myID === 0){
      //ID값이 0이면 로그인 안함.
      // alert("유저 ID가 없습니다.");
      

    }else{
      // this.requestLoginToken(myID, true);
      this.setState({
        myID: myID
      })
    }
    */

  };

  requestItemInfoByOrderId = () => {
    if(this.props.store_order_id === undefined || this.props.store_order_id === null){
      return;
    }

    axios.post("/orders/any/item/info", {
      store_order_id: this.props.store_order_id
    }, (result) => {

      this.setState({
        item_id: result.data.id,
        item_title: result.data.title,
        item_state: result.data.state
      })
      // console.log(this.props.store_order_id);
      // console.log(result);
      
    }, (error) => {

    })
  }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){ 
  }

  onClickGoButton = (e) => {
    e.preventDefault();

    if(this.state.item_state === Types.item_state.SALE_STOP){
      alert("판매가 중지된 상품입니다.");
      return;
    }else if(this.state.item_state === Types.item_state.SALE_LIMIT){
      alert("품절된 상품입니다.");
      return;
    }

    if(this.state.item_id === null){
      return;
    }

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }
    
    let hrefURL = baseURL+'/item/store/'+this.state.item_id;
    
    window.location.href = hrefURL;
  }

  render(){    
    let _name = this.props.nick_name;
    if(this.props.nick_name === ''){
      _name = this.props.name;
    }

    let user_img = this.props.profile_photo_url;
    if(!this.props.profile_photo_url || this.props.profile_photo_url === ''){
      user_img = default_user_img;
    }

    //판매중, 비공개
    let buyGoButtonDom = <></>;
    if(this.state.item_id !== null){
      buyGoButtonDom = <button onClick={(e) => {this.onClickGoButton(e)}} className={'item_title_box'}>
                          <div className={'text-ellipsize'}>
                            {this.state.item_title}
                          </div>
                          <span className={'item_title_tail_point'}>구매</span>
                        </button>
                      
    }

    return(
      <div className={'StoreItemDetailReviewItem'}>
        <div className={'review_item_container'}>
          <div className={'user_thumb_img_container'}>
            <img className={'user_thumb_img'} src={user_img}/>
          </div>
          <div className={'contentContainer'}>
            <div className={'name'}>
              {_name}
            </div>
            <div className={'created_at_text'}>
              {/* {moment_timezone(this.props.created_at).format('YYYY-MM-DD HH:mm:ss')} */}
              {Util.timeBefore(moment_timezone(this.props.created_at).format('YYYY-MM-DD HH:mm:ss'))}
            </div>
          </div>
        </div>

        <div className={'contentText'}>
          {this.props.content}
        </div>

        {buyGoButtonDom}
        {/* <button onClick={(e) => {this.onClickGoButton(e)}} className={'item_title_box'}>
          <div className={'text-ellipsize'}>
            {this.state.item_title}
          </div>
          <span className={'item_title_tail_point'}>구매</span>
        </button> */}

        <div className={'item_under_line'}>
        </div>
      </div>
    )
  }
};

StoreItemDetailReviewItem.defaultProps = {
  id: -1,
  store_id: null,
  // thumbUrl: '',
  name: '',
  nick_name: '',
  // title: '',
  content: '',

  profile_photo_url: '',
  created_at: '',
  user_id: null
  // price: 0
}

export default StoreItemDetailReviewItem;