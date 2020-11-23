'use strict';

import React, { Component } from 'react';

import Util from '../lib/Util';

import moment from 'moment';
import axios from '../lib/Axios';
import { shallowEqual } from 'react-redux';


class StoreReviewItem extends Component{

  constructor(props){
    super(props);

    this.state = {
      myID: null
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    // this.requestStoreContents();
    // console.log(this.props.user_id);
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

  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){ 
  }

  clickEdit(e){
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    let goURL = baseURL + '/review/store/' + this.props.store_id + '/edit/' + this.props.id;

    window.location.href = goURL;
  }

  clickDelete(e){
    e.preventDefault();

    swal("리뷰를 삭제 하시겠습니까?", {
      buttons: {
        nosave: {
          text: "아니오",
          value: "notsave",
        },
        save: {
          text: "예",
          value: "delete",
        },
      },
    })
    .then((value) => {
      switch (value) {
        case "delete":
        {
          axios.post("/comments/remove", {
            comment_id: this.props.id
          }, (result) => {
            alert('삭제 완료!');
            window.location.reload();
            return;
          }, (error) => {
      
          })
        }
        break;
      }
    });    
  }

  render(){
    let isWriter = false;

    let writerDom = <></>;
    if(this.state.myID && this.state.myID === this.props.user_id){
      writerDom = <div className={'commentsEditContainer'}>
                    <button onClick={(e) => {this.clickEdit(e)}}>
                      수정
                    </button>
                    <div style={{paddingLeft: 5, paddingRight: 5}}>
                    ·
                    </div>
                    <button onClick={(e) => {this.clickDelete(e)}}>
                      삭제
                    </button>
                  </div>
    }

    
    let _name = this.props.nick_name;
    if(this.props.nick_name === ''){
      _name = this.props.name;
    }
    return(
      <>
      <div className={'StoreReviewItem'}>
        <div className={'user_thumb_img_container'}>
          <img className={'user_thumb_img'} src={this.props.profile_photo_url}/>
        </div>
        <div className={'contentContainer'}>
          <div className={'name'}>
            {_name}
          </div>
          <div className={'created_at_text'}>
            {moment(this.props.created_at).format('YYYY-MM-DD')}
          </div>
          <div className={'contentText'}>
            {this.props.content}
          </div>
          {writerDom}
        </div>
      </div>
      <div className={'item_under_line'} style={{marginTop: 16}}>
      </div>
      </>
    )
  }
};

StoreReviewItem.defaultProps = {
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

export default StoreReviewItem;