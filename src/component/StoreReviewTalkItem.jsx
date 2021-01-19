'use strict';

import React, { Component } from 'react';

import axios from '../lib/Axios';
import Types from '../Types';
import Util from '../lib/Util';

class StoreReviewTalkItem extends Component{

  constructor(props){
    super(props);

    this.state = {
      store_title: '',
      store_user_profile_photo_url: '',
      product_answer: null,

      
      order_user_real_name: '',
      order_user_profile_photo_url: '',

      comment_contents: '',

      order_user_id: null,
    }
  };

  componentDidMount(){
    this.requestOrderInfo();
    this.requestAnswerComment();
  };

  requestOrderInfo(){
    axios.post('/orders/any/store/info', {
      store_order_id: this.props.store_order_id
    }, (result) => {
      const data = {
        ...result.data
      }

      this.setState({
        store_item_id: data.item_id,
        order_user_id: data.order_user_id,
        product_answer: data.product_answer
      }, () => {
        this.requestItemInfo();
        this.requestOrderUserInfo();
      })
    }, (error) => {

    })
  }

  requestOrderUserInfo = () => {
    if(this.state.order_user_id === null){
      return;
    }
    axios.post("/user/any/info/userid", {
      target_user_id: this.state.order_user_id
    }, (result) => {
      const userInfo = result.userInfo;

      const name = Util.getUserName(userInfo);
      this.setState({
        order_user_real_name: name,
        order_user_profile_photo_url: userInfo.profile_photo_url
      })
    }, (error) => {

    })
  }

  requestItemInfo(){
    axios.post('/store/any/item/info', {
      store_item_id: this.state.store_item_id
    }, (result) => {
      const data = result.data;
      this.setState({
        item_title: data.title,
        item_price: data.price,
        item_content: data.content,
        item_thumb_img_url: data.img_url,
        // total_price: data.price,
        store_id: data.store_id,
        item_nick_name: data.nick_name,

        store_title: data.store_title,

        item_product_state: data.product_state,
        item_file_upload_state: data.file_upload_state,

        store_user_profile_photo_url: data.profile_photo_url
      }, () => {
        if(this.state.item_product_state === Types.product_state.ONE_TO_ONE &&
          this.state.state === Types.order.ORDER_STATE_APP_STORE_READY){
            this.setState({
              state_string: '승인 완료(진행 준비)'
            })
        }
      })
    }, (error) => {

    })
  }

  requestAnswerComment = () => {
    axios.post("/comments/any/second/get", {
      second_target_id: this.props.store_order_id,
      second_target_type: Types.comment.secondTargetType.store_order
    }, (result) => {
      this.setState({
        // comment_id: result.comment_id,
        comment_contents: result.contents
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  //store_user_profile_photo_url
  // store_title
  // product_answer

  //order_user_real_name
  //comment_contents
  //order_user_profile_photo_url
  render(){

    let product_answer_dom = <></>;
    let review_dom = <></>;

    let openProductTextView = <></>;

    // store_manager_answer
    if(this.state.product_answer !== null && this.state.product_answer !== ''){
      //크리에이터 구매 답변
      product_answer_dom =  <div className={'product_answer_wrapper'}>
                              {/* <div className={'under_line'}>
                              </div> */}
                              <div className={'product_answer_container'}>
                                <img className={'product_answer_img'} src={this.state.store_user_profile_photo_url} />
                                <div className={'product_answer_content_container'}>
                                  <div className={'product_answer_name'}>
                                    {this.state.store_title}
                                  </div>
                                  <div className={'product_answer_content'}>
                                    {this.state.product_answer}
                                  </div>
                                </div>
                              </div>
                            </div>
    }

    if(this.state.comment_contents !== ''){
      review_dom = <div className={'product_answer_wrapper'}>
                    <div className={'product_answer_container review_container'}>
                      <div className={'product_answer_content_container review_answer_content_container'}>
                        <div className={'product_answer_name review_answer_name'}>
                          {this.state.order_user_real_name}
                        </div>
                        <div className={'product_answer_content'}>
                        {this.state.comment_contents}
                        </div>
                      </div>
                      <img className={'product_answer_img'} src={this.state.order_user_profile_photo_url} />
                    </div>
                  </div>
    }
      
    

    return(
      <div className={'StoreReviewTalkItem'}>
        {product_answer_dom}
        {review_dom}
      </div>
    )
  }
};

export default StoreReviewTalkItem;