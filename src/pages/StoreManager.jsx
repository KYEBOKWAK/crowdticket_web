'use strict';

import React, { Component } from 'react';

import StoreManagerTabStoreInfoPage from '../component/StoreManagerTabStoreInfoPage';
import StoreManagerTabItemPage from '../component/StoreManagerTabItemPage';
import StoreManagerTabOrderListPage from '../component/StoreManagerTabOrderListPage';

import StoreManagerTabTestPage from '../component/StoreManagerTabTestPage';

const TAB_STORE_INFO = 'TAB_STORE_INFO';
const TAB_ITEM_MANAGER = 'TAB_ITEM_MANAGER';
const TAB_ORDER_LIST = 'TAB_ORDER_LIST';
const TAB_ASK_LIST = 'TAB_ASK_LIST';
const TAB_REVIEW_LIST = 'TAB_REVIEW_LIST';

const tabInfo = [
  {
    key: TAB_STORE_INFO,
    name: '상점정보',
  },
  {
    key: TAB_ITEM_MANAGER,
    name: '상품관리',
  },
  {
    key: TAB_ORDER_LIST,
    name: '판매내역',
  },
  {
    key: TAB_ASK_LIST,
    name: '요청된 컨텐츠',
  },
  {
    key: TAB_REVIEW_LIST,
    name: '리뷰',
  }
]
class StoreManager extends Component {
  constructor(props) {
    super(props);
    this.state = { 
      isLogin: false,
      title: '상점관리',
      selectTabKey: TAB_STORE_INFO
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
      this.setState({
        isLogin: true
      })
    }

    // this.test();
  }

  test(){
    console.log("adfsadf??");
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
      underLine = <div style={{width: '100%', height: 2, backgroundColor: 'blue'}}></div>
     }
     const tabNameDom = <div key={i}>
                          <button style={{paddingLeft: 20, paddingRight: 20}} onClick={(e) => {this.clickMenu(e, data.key)}}>
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
    }else{

      
      return (
        <>  
          <div>{this.state.title}</div>

          {this.getMenuDom()}
          {this.getContentPage()}
        </>
      );
    }
  }
}

// StoreHome.defaultProps = {
//   color: 'red'
// }

export default StoreManager;