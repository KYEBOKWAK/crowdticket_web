'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';
import Types from '../Types';

class ReviewWritePage extends Component {
  constructor(props) {
    super(props);
    this.state = {
      comment_id: null,
      store_id: null,
      commentValue: '',
      alias: null,
      comment_write_state: null,
      maxLength: 1000,
      myID: null,
      user_id: null
    };

    this.handleChange = this.handleChange.bind(this);
  }

  componentDidMount(){

    const myID = Number(document.querySelector('#myId').value);
    if(myID === 0){
      //ID값이 0이면 로그인 안함.
      alert('로그인 후 이용해주세요');
      window.history.back();
      return;
      
    }else{
      // this.requestLoginToken(myID, true);
      
    }

    const pageKeyDom = document.querySelector('#app_page_key');
    if(pageKeyDom){
      console.log(pageKeyDom.value);
    }

    const store_id_dom = document.querySelector('#store_id');
    let _store_id = 0;
    if(store_id_dom){
      // console.log(store_id_dom.value);
      _store_id = Number(store_id_dom.value);
    }

    const comment_id_dom = document.querySelector('#comment_id');
    let _comment_id = null;
    if(comment_id_dom){
      // console.log(store_id_dom.value);
      _comment_id = Number(comment_id_dom.value);
    }

    const comment_write_state_dom = document.querySelector('#comment_write_state');
    let comment_write_state = Types.comment.commentState.write;
    if(comment_write_state_dom){
      comment_write_state = comment_write_state_dom.value;
    }

    // history.pushState(null, null, location.href);
    // window.onpopstate = function(event) {
    //     history.go(1);
    // };
    
    this.setState({
      store_id: _store_id,
      comment_id: _comment_id,
      comment_write_state: comment_write_state,
      myID: myID
    }, function(){
      this.requestAlias()

      if(this.state.comment_write_state === Types.comment.commentState.edit){
        this.requestCommentInfo();
      }
    });

    

  }

  requestCommentInfo(){
    axios.post("/comments/detail", {
      comment_id: this.state.comment_id
    }, (result) => {

      if(this.state.comment_write_state === Types.comment.commentState.edit){
        if(result.user_id !== this.state.myID){
          alert("작성자만 수정 가능합니다.");
          window.history.back();
          return;
        }
      }

      this.setState({
        commentValue: result.contents
      })
    }, (error) => {

    })
  }

  requestAlias(){
    axios.post("/store/any/info/alias", {
      store_id: this.state.store_id
    }, (result) => {
      // console.log(result);
      this.setState({
        alias: result.alias
      })
    }, (error) => {

    })
  }

  goBackStore(){
    let url_tail = '';
    if(this.state.alias){
      url_tail = this.state.alias;
    }else{
      url_tail = this.state.store_id;
    }

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      baseURL = baseURLDom.value;
    }
    
    let hrefURL = baseURL+'/store/'+url_tail+'?menu=MENU_STATE_REVIEW';
    
    window.location.href = hrefURL;
  }

  clickAddReview(e){
    e.preventDefault();

    if(this.state.comment_write_state === Types.comment.commentState.write){
      let _data = {
        commentType: Types.comment.commentType.store,
        target_id: this.state.store_id,
        comment_value: this.state.commentValue
      }
      
      // console.log(_data);
  
      axios.post("/comments/add", {
        ..._data 
      }, (result) => {
        alert('작성 완료!');
        this.goBackStore();
  
      }, (error) => {
  
      })
    }else if(this.state.comment_write_state === Types.comment.commentState.edit){
      axios.post("/comments/edit", {
        comment_value: this.state.commentValue,
        comment_id: this.state.comment_id
      }, (result) => {
        alert('수정 완료!');
        this.goBackStore();
      }, (error) => {
        
      })
    }


  }

  handleChange(event) {
    this.setState({commentValue: event.target.value});
  }

  render() {
    if(!this.state.store_id){
      return <></>;
    }

    let titleText = '';
    let buttonText = '';
    if(this.state.comment_write_state === Types.comment.commentState.write){
      titleText = '리뷰작성';
      buttonText = '리뷰등록';
    }else{
      titleText = '리뷰수정';
      buttonText = '리뷰수정';
    }

    return (
      <div className={'ReviewWritePage'}>
        <div className={'titleText'}>
          {titleText}
        </div>

        
        <div className={'titleLabelText'}>
          {titleText}
        </div>
        
        <textarea className={'textArea'} value={this.state.commentValue} onChange={this.handleChange} maxLength={this.state.maxLength} placeholder={"콘텐츠 후기 및 크리에이터를 위한 감사 인사를 남겨보세요!"}></textarea>

        <div className={'nowCount'}>
          {this.state.commentValue.length}/{this.state.maxLength}
        </div>

        <button className={'reviewButton'} onClick={(e) => { this.clickAddReview(e) }}>{buttonText}</button>
        
        
      </div>
    );
  }
}

ReviewWritePage.defaultProps = {
}

export default ReviewWritePage;