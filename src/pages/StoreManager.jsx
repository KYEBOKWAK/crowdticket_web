'use strict';

import React, { Component } from 'react';

import StoreManagerTabStoreInfoPage from '../component/StoreManagerTabStoreInfoPage';
import StoreManagerTabItemPage from '../component/StoreManagerTabItemPage';
import StoreManagerTabOrderListPage from '../component/StoreManagerTabOrderListPage';

import StoreManagerTabTestPage from '../component/StoreManagerTabTestPage';
import StoreManagerTabAskOrderListPage from '../component/StoreManagerTabAskOrderListPage';
import axios from '../lib/Axios';

const TAB_STORE_INFO = 'TAB_STORE_INFO';
const TAB_ITEM_MANAGER = 'TAB_ITEM_MANAGER';
const TAB_ORDER_LIST = 'TAB_ORDER_LIST';
const TAB_ASK_LIST = 'TAB_ASK_LIST';
const TAB_REVIEW_LIST = 'TAB_REVIEW_LIST';

const tabInfo = [
  // {
  //   key: TAB_STORE_INFO,
  //   name: '상점정보',
  // },
  // {
  //   key: TAB_ITEM_MANAGER,
  //   name: '상품관리',
  // },
  // {
  //   key: TAB_ORDER_LIST,
  //   name: '판매내역',
  // },
  {
    key: TAB_ASK_LIST,
    name: '요청된 콘텐츠',
  },
  // {
  //   key: TAB_REVIEW_LIST,
  //   name: '리뷰',
  // }
]
class StoreManager extends Component {
  constructor(props) {
    super(props);
    this.state = { 
      isLogin: false,
      title: '상점관리',
      selectTabKey: TAB_ASK_LIST,

      store_id: null,
      nick_name: ''
    };
  }

  componentDidMount(){
    // history.pushState(null, null, location.href);
    // window.onpopstate = function(event) {
    //   console.log("sdfsdfasdf");
    //   history.go(1);
    // };
    // const pageKeyDom = document.querySelector('#app_page_key');
    // if(pageKeyDom){
    //   console.log(pageKeyDom.value);
    // }

    // console.log(isLogin());
    
    if(!isLogin())
    {
      // loginPopup(null, null);
      loginPopup(() => {
        if(isLogin()){
          this.setState({
            isLogin: true
          }, function(){
            swal.close();
            window.location.reload();
          })
        }
      }, null);
      return;
    }else{
      // this.setState({
      //   isLogin: true
      // })
    }
    

    const myID = Number(document.querySelector('#myId').value);
    if(myID === 0){
      //ID값이 0이면 로그인 안함.
      alert("관리자만 접근 가능합니다.");
    }else{
      // this.requestLoginToken(myID);
      // store.dispatch(actions.setUserID(myID));

      axios.post("/store/info/userid", {}, 
      (result) => {
        this.setState({
          nick_name: result.data.nick_name,
          store_id: result.data.store_id,
          isLogin: true
        }, () => {
          this.requestOrderList();
        })
      }, (error) => {

      })
    }



    // this.test();
  }

  requestOrderList(){

  }

  goStoreManagement(){

  }

  clickMenu(e, key){
    e.preventDefault();

    console.log(key);
    this.setState({
      selectTabKey: key
    })
  }

  getMenuDom(){

    let menuArray = [];
    for(let i = 0 ; i < tabInfo.length ; i++){
     const data = tabInfo[i];
     let underLine = <></>;

     if(this.state.selectTabKey === data.key){
      underLine = <div style={{width: 4, height: 4, backgroundColor: '#00bfff', marginTop: 9}}></div>
     }
     const tabNameDom = <div className={'menuContainer'} key={i}>
                          <button className={'menu_temp_select'} onClick={(e) => {this.clickMenu(e, data.key)}}>
                            <div>{data.name}</div>
                          </button>
                          {underLine}
                        </div>
     menuArray.push(tabNameDom);
    }

    return <div style={{display: 'flex', flexDirection: 'row', justifyContent: 'center'}}>
            {menuArray}
          </div>
  }

  getContentPage(){
    let contentPage = <></>;
    if(this.state.selectTabKey === TAB_STORE_INFO){
      contentPage = <StoreManagerTabStoreInfoPage></StoreManagerTabStoreInfoPage>;
    }
    else if(this.state.selectTabKey === TAB_ITEM_MANAGER){
      contentPage = <StoreManagerTabItemPage></StoreManagerTabItemPage>;
    }
    else if(this.state.selectTabKey === TAB_ORDER_LIST){
      contentPage = <StoreManagerTabOrderListPage></StoreManagerTabOrderListPage>;
    }
    else if(this.state.selectTabKey === TAB_ASK_LIST){
      contentPage = <StoreManagerTabAskOrderListPage store_id={this.state.store_id}></StoreManagerTabAskOrderListPage>;
    }
    else{
      contentPage = <StoreManagerTabTestPage></StoreManagerTabTestPage>;
    }

    return contentPage;
  }

  render() {
    if(!this.state.isLogin){
      //로그인 안됐을때 접근시
      return (
        <>
          관리자만 입장 가능합니다. 로그인 후 접속해주세요.
        </>
      )
    }
  
    return (
      <div className={'StoreManager'}>
        <div className={'topContainer'}>
          <div className={'title_text'}>
            {this.state.nick_name} 상점 관리
          </div>
        </div>

        <div className={'contentsContainer'}>
          {this.getMenuDom()}
          {this.getContentPage()}
        </div>
      </div>
    );    
  }
}

// StoreHome.defaultProps = {
//   color: 'red'
// }

export default StoreManager;