'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Types from '../Types';

import ic_btn_add from '../res/img/btn-add.svg';

class StoreDoIt extends Component{

  constructor(props){
    super(props);

    this.state = {
      isCompliteStoreInfo: false, //현재 채널 정보 가져오는게 마지막
      isCompliteContactInfo: false,
      isCompliteDoitCheck: false,

      store_title: '',
      store_content: '',
      store_contact: '',
      store_email: '',
      store_channel_count: 0,

      account_name: '',
      account_number: '',
      account_bank: '',

      doit_list: []
    }
  };

  componentDidMount(){
    // console.log(this.props.store_id);
    // console.log(this.props.store_user_id);
    if(this.props.store_id === null){
      alert("스토어 ID가 없습니다");
      return;
    }

    this.requestStoreInfo();
    this.requestAccountInfo();
  };

  componentDidUpdate(){
    if(this.state.isCompliteDoitCheck){
      //하단에 do it 체크는 한번만 되야 한다.
      return;
    }

    if(this.state.isCompliteStoreInfo && 
      this.state.isCompliteContactInfo){
        this.setState({
          isCompliteDoitCheck: true
        }, () => {
          this.setDoItList();
        })
      }
  }

  setDoItList = () => {
    
    let isEmptyStoreInfo = false;
    let isEmptyContactInfo = false;

    //스토어 상점 정보
    if(this.state.store_title === null || this.state.store_title === ''){
      isEmptyStoreInfo = true;
    }
    else if(this.state.store_content === null || this.state.store_content === ''){
      isEmptyStoreInfo = true;
    }
    else if(this.state.store_channel_count === 0){
      isEmptyStoreInfo = true;
    }
    
    //연락/정산 정보
    if(this.state.store_contact === null || this.state.store_contact === ''){
      isEmptyContactInfo = true;
    }
    else if(this.state.store_email === null || this.state.store_email === ''){
      isEmptyContactInfo = true;
    }
    else if(this.state.account_name === null || this.state.account_name === ''){
      isEmptyContactInfo = true;
    }
    else if(this.state.account_bank === null || this.state.account_bank === ''){
      isEmptyContactInfo = true;
    }
    else if(this.state.account_number === null || this.state.account_number === ''){
      isEmptyContactInfo = true;
    }

    let _doit_list = [];
    if(isEmptyStoreInfo){
      _doit_list.push(Types.do_it.store_info);
    }

    if(isEmptyContactInfo){
      _doit_list.push(Types.do_it.store_contact_info);
    }

    this.setState({
      doit_list: _doit_list.concat()
    })
  }

  requestStoreInfo(){
    axios.post("/store/info/userid", {
      store_user_id: this.props.store_user_id
    }, (result) => {
      
      this.setState({
        store_title: result.data.title,
        store_content: result.data.content,
        store_email: result.data.email,
        store_contact: result.data.contact
      }, () => {
        this.requestStoreChannels();
      })
    }, (error) => {

    })
  }

  requestAccountInfo = () => {
    //manager/account/info
    axios.post("/store/manager/account/info", {
      store_id: this.props.store_id
    }, (result) => {
      this.setState({
        account_name: result.data.account_name,
        account_number: result.data.account_number,
        account_bank: result.data.account_bank,
        isCompliteContactInfo: true
      })
    }, (error) => {

    })
  }

  requestStoreChannels(){
    axios.post("/store/sns/channel/list", {
      store_user_id: this.props.store_user_id
    }, (result) => {
      this.setState({
        store_channel_count: result.list.length,
        isCompliteStoreInfo: true
      })
    }, (error) => {

    })
  }

  goTabMenu = (e) => {
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      baseURL = baseURLDom.value;
    }
    
    let hrefURL = baseURL+'/manager/store/?menu=TAB_STORE_INFO';
    const isAdmin = document.querySelector('#isAdmin').value;
    if(isAdmin){
      hrefURL = baseURL+'/admin/manager/store/'+this.props.store_id+'/?menu=TAB_STORE_INFO';
    }

    // const go_back_edit_page = document.querySelector('#go_back_edit_page').value;
    // if(go_back_edit_page){
    //   hrefURL = baseURL+'/item/store/'+this.state.item_id;
    // }
    
    window.location.href = hrefURL;
  }

  render(){
    if(this.state.doit_list.length === 0){
      return(<></>)
    }

    let doit_list_doms = [];
    for(let i = 0 ; i < this.state.doit_list.length ; i++){
      const data = this.state.doit_list[i];

      let doitItemDom = <></>;
      if(data === Types.do_it.store_info){
        doitItemDom = <div className={'doit_item'}>
                        <div>
                          🏠 안녕하세요! 상점 정보를 등록해볼까요?
                        </div>
                        <img src={ic_btn_add} />
                      </div>
      }
      else if(data === Types.do_it.store_contact_info){
        doitItemDom = <div className={'doit_item'}>
                        <div>
                          💳 잊지마세요! 연락처 및 정산 정보를 등록해볼까요?
                        </div>
                        <img src={ic_btn_add} />
                      </div>
      }

      let doitItemContentDom = <button key={i} onClick={(e) => {this.goTabMenu(e)}} className={'doit_item_box'}>
                                {doitItemDom}
                              </button>;

      doit_list_doms.push(doitItemContentDom);
    }

    return(
      <div className={'StoreDoIt'}>
        {doit_list_doms}
      </div>
    )
  }
};

StoreDoIt.defaultProps = {
  store_id: null
}


export default StoreDoIt;