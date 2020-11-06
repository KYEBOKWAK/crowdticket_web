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


const INPUT_STORE_MANAGER_TITLE = 'INPUT_STORE_MANAGER_TITLE';
const INPUT_STORE_MANAGER_CONTACT = 'INPUT_STORE_MANAGER_CONTACT';
const INPUT_STORE_MANAGER_EMAIL = 'INPUT_STORE_MANAGER_EMAIL';
const INPUT_STORE_MANAGER_CONTENT = 'INPUT_STORE_MANAGER_CONTENT';

class StoreManagerTabStoreInfoPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      myID: null,
      store_id: null,

      title: '',
      contact: '',
      email: '',
      content: '',
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestStoreInfo();
    // const myID = Number(document.querySelector('#myId').value);
    // if(myID === 0){
    //   alert('로그인을 해주세요');
    //   return;
    // }else{
    //   // this.requestLoginToken(myID, true);
    //   this.setState({
    //     myID: myID
    //   }, () => {
    //     this.requestStoreInfo();
    //   })
    // }
  };

  componentWillUnmount(){
  };

  componentDidUpdate(){
  }

  requestStoreInfo(){
    axios.post("/store/info/userid", {

    }, (result) => {
      
      this.setState({
        store_id: result.data.store_id,
        title: result.data.title,
        contact: result.data.contact,
        email: result.data.email,
        content: result.data.content
      })
    }, (error) => {

    })
  }

  onChangeInput(e, type) {
    e.preventDefault();

    if(type === INPUT_STORE_MANAGER_TITLE){
      this.setState({
        title: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_CONTACT){
      this.setState({
        contact: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_EMAIL){
      this.setState({
        email: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_CONTENT){
      this.setState({
        content: e.target.value
      })
    }
  }

  onClickSave(e){
    e.preventDefault();

    showLoadingPopup('저장중입니다..');
    axios.post('/store/save/info', {
      store_id: this.state.store_id,
      title: this.state.title,
      contact: this.state.contact,
      email: this.state.email,
      content: this.state.content
    }, (result) => {
      stopLoadingPopup();
      swal("저장 성공!", "", "success");
    }, (error) => {
      stopLoadingPopup();
    })
  }

  render(){
    return(
      <div className={'StoreManagerTabStoreInfoPage'}>
        <div className={'input_label'}>상점명</div>
        <input className={'input_box'} type="text" name={'title'} placeholder={'상점명을 입력해주세요.'} value={this.state.title} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_TITLE)}}/>

        <div className={'input_label'}>상점 연락처</div>
        <input className={'input_box'} type="text" name={'contact'} placeholder={'-없이 입력해주세요.'} value={this.state.contact} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_CONTACT)}}/>

        <div className={'input_label'}>상점 이메일</div>
        <input className={'input_box'} type="text" name={'email'} placeholder={'상점 이메일을 입력해주세요.'} value={this.state.email} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_EMAIL)}}/>

        <div className={'input_label'}>상점 소개글</div>
        <textarea className={'textarea_box'} value={this.state.content} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_CONTENT)}} maxLength={255} placeholder={"상점 소개글을 입력해주세요"}></textarea>

        <button className={'save_button'} onClick={(e) => {this.onClickSave(e)}}>
          저장하기
        </button>
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
export default StoreManagerTabStoreInfoPage;