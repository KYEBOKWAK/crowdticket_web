'use strict';

import React, { Component } from 'react';

import StoreManagerTabStoreInfoPage from '../component/StoreManagerTabStoreInfoPage';
import StoreManagerTabItemPage from '../component/StoreManagerTabItemPage';
import StoreManagerTabOrderListPage from '../component/StoreManagerTabOrderListPage';
import StoreManagerTabAccountPage from '../component/StoreManagerTabAccountPage';

import StoreManagerTabTestPage from '../component/StoreManagerTabTestPage';
import StoreManagerTabAskOrderListPage from '../component/StoreManagerTabAskOrderListPage';
import axios from '../lib/Axios';

import ScrollBooster from 'scrollbooster';

const TAB_STORE_INFO = 'TAB_STORE_INFO';
const TAB_ITEM_MANAGER = 'TAB_ITEM_MANAGER';
const TAB_ORDER_LIST = 'TAB_ORDER_LIST';
const TAB_ASK_LIST = 'TAB_ASK_LIST';
const TAB_REVIEW_LIST = 'TAB_REVIEW_LIST';
const TAB_STORE_ACCOUNT = 'TAB_STORE_ACCOUNT';

const tabInfo = [
  {
    key: TAB_ASK_LIST,
    name: '요청된 콘텐츠',
  },
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
    key: TAB_STORE_ACCOUNT,
    name: '정산'
  }
]

/*
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
    name: '요청된 콘텐츠',
  },
  // {
  //   key: TAB_REVIEW_LIST,
  //   name: '리뷰',
  // },
  {
    key: TAB_STORE_ACCOUNT,
    name: '정산'
  }
]
*/
class StoreManager extends Component {
  sb = null;
  constructor(props) {
    super(props);
    this.state = { 
      isLogin: false,
      title: '상점관리',
      selectTabKey: TAB_ASK_LIST,

      store_id: null,
      store_user_id: null,
      nick_name: '',

      isMenuScroll: true,

      alias: ''
    };

    this.updateDimensions = this.updateDimensions.bind(this);
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

      let _menuState = this.state.selectTabKey;
      const store_manager_tabmenu_dom = document.querySelector('#store_manager_tabmenu');
      if(store_manager_tabmenu_dom){
        // console.log(store_alias_dom.value);
        if(store_manager_tabmenu_dom.value){
          _menuState = store_manager_tabmenu_dom.value;
        }
      }

      axios.post("/store/info/userid", {}, 
      (result) => {
        this.setState({
          store_user_id: myID,
          nick_name: result.data.nick_name,
          store_id: result.data.store_id,
          isLogin: true,
          selectTabKey: _menuState,
          alias: result.data.alias
        }, () => {
          this.requestOrderList();
          this.initScrollBooster();
        })
      }, (error) => {

      })
    }

    window.addEventListener('resize', this.updateDimensions);
  }

  initScrollBooster(){
    if(window.innerWidth > 520){
      this.setState({
        isMenuScroll: false
      })
    }else{
      this.setState({
        isMenuScroll: true
      }, () => {
        this.setScrollAction();
      })
    }
  }

  updateDimensions(){
    if(window.innerWidth > 520){
      //pc
      if(this.state.isMenuScroll){
        console.log("ischenge false");
        this.setState({
          isMenuScroll: false
        }, () => {
          this.scrollBoosterDestory();
        })
      }
    }else{
      //mobile
      
      if(!this.state.isMenuScroll){
        console.log("ischenge true");
        this.setState({
          isMenuScroll: true
        }, () => {
          this.setScrollAction();
        })
      }
    }
  }

  scrollBoosterDestory(){
    this.sb.destroy();
    this.sb = null;
  }

  componentWillUnmount(){
    scrollBoosterDestory();
  }

  setScrollAction(){
    if(this.sb !== null){
      return;
    }

    const viewport = document.querySelector('.viewport');
    const content = document.querySelector('.scrollable-content');

    this.sb = new ScrollBooster({
      viewport,
      content,
      bounce: true,
      textSelection: false,
      emulateScroll: true,
      onUpdate: (state) => {
        // state contains useful metrics: position, dragOffset, dragAngle, isDragging, isMoving, borderCollision
        // you can control scroll rendering manually without 'scrollMethod' option:
        content.style.transform = `translate(
          ${-state.position.x}px,
          0px
        )`;

        // content.style.transform = `translate(
        //   ${-state.position.x}px,
        //   ${-state.position.y}px
        // )`;
      },
      shouldScroll: (state, event) => {
        // disable scroll if clicked on button
        const isButton = event.target.nodeName.toLowerCase() === 'button';
        return !isButton;
      },
      onClick: (state, event, isTouchDevice) => {
        // prevent default link event
        const isLink = event.target.nodeName.toLowerCase() === 'link';
        if (isLink) {
          event.preventDefault();
        }
      }
    });

    // methods usage examples:
    this.sb.updateMetrics();
    // sb.scrollTo({ x: 100, y: 100 });
    this.sb.updateOptions({ emulateScroll: false });
    // sb.destroy();
    /*
    if(this.sb != null){
      return;
    }

    const viewport = document.querySelector('.viewport');
    const content = document.querySelector('.scrollable-content');

    const sb = new ScrollBooster({
      viewport,
      content,
      bounce: true,
      textSelection: false,
      emulateScroll: true,
      onUpdate: (state) => {
        // state contains useful metrics: position, dragOffset, dragAngle, isDragging, isMoving, borderCollision
        // you can control scroll rendering manually without 'scrollMethod' option:
        content.style.transform = `translate(
          ${-state.position.x}px,
          0px
        )`;

        // content.style.transform = `translate(
        //   ${-state.position.x}px,
        //   ${-state.position.y}px
        // )`;
      },
      shouldScroll: (state, event) => {
        // disable scroll if clicked on button
        const isButton = event.target.nodeName.toLowerCase() === 'button';
        return !isButton;
      },
      onClick: (state, event, isTouchDevice) => {
        // prevent default link event
        const isLink = event.target.nodeName.toLowerCase() === 'link';
        if (isLink) {
          event.preventDefault();
        }
      }
    });

    // methods usage examples:
    sb.updateMetrics();
    // sb.scrollTo({ x: 100, y: 100 });
    sb.updateOptions({ emulateScroll: false, isMove: false });
    // sb.destroy();
    */
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
     let selectStyle = {
       opacity: 0.5
     };

     if(this.state.selectTabKey === data.key){
      underLine = <div style={{width: 4, height: 4, backgroundColor: '#00bfff', marginTop: 9}}></div>

      selectStyle = {
        ...selectStyle,
        opacity: 1
      }
     }
     const tabNameDom = <div className={'menuContainer'} key={i}>
                          <button className={'menu_temp_select'} style={{...selectStyle}} onClick={(e) => {this.clickMenu(e, data.key)}}>
                            <div>{data.name}</div>
                          </button>
                          {underLine}
                        </div>
     menuArray.push(tabNameDom);
    }

    // return <div style={{display: 'flex', flexDirection: 'row', justifyContent: 'center'}}>
    //         {menuArray}
    //       </div>

    return <div className={'viewport'}>
            <div className={'scrollable-content'} style={{display: 'flex', flexDirection: 'row',}}>
              {menuArray}
            </div>
          </div>
  }

  getContentPage(){
    let contentPage = <></>;
    if(this.state.selectTabKey === TAB_STORE_INFO){
      contentPage = <StoreManagerTabStoreInfoPage store_user_id={this.state.store_user_id}></StoreManagerTabStoreInfoPage>;
    }
    else if(this.state.selectTabKey === TAB_ITEM_MANAGER){
      contentPage = <StoreManagerTabItemPage store_id={this.state.store_id}></StoreManagerTabItemPage>;
    }
    else if(this.state.selectTabKey === TAB_ORDER_LIST){
      contentPage = <StoreManagerTabOrderListPage store_id={this.state.store_id}></StoreManagerTabOrderListPage>;
    }
    else if(this.state.selectTabKey === TAB_ASK_LIST){
      contentPage = <StoreManagerTabAskOrderListPage store_id={this.state.store_id}></StoreManagerTabAskOrderListPage>;
    }
    else if(this.state.selectTabKey === TAB_STORE_ACCOUNT){
      contentPage = <StoreManagerTabAccountPage store_id={this.state.store_id}></StoreManagerTabAccountPage>;
    }
    else{
      contentPage = <StoreManagerTabTestPage></StoreManagerTabTestPage>;
    }

    return contentPage;
  }

  goStorePage(e){
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      baseURL = baseURLDom.value;
    }

    let goTail = this.state.alias;

    if(!this.state.alias){
      goTail = this.state.store_id;
    }

    let goURL = baseURL + '/store/'+goTail;

    // window.location.href = goURL;
    window.open(goURL);

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
          <div className={'flex_layer'} style={{alignItems: 'center'}}>
            <div className={'title_text'}>
              {this.state.nick_name} 상점 관리 
            </div>
            <button className={'show_button'} onClick={(e) => {this.goStorePage(e)}}>
                상점가기
            </button>
          </div>
        </div>

        <div className={'contentsContainer'}>
          {this.getMenuDom()}
          <div className={'contentPageContainer'}>
            {this.getContentPage()}
          </div>
        </div>
      </div>
    );    
  }
}

// StoreHome.defaultProps = {
//   color: 'red'
// }

export default StoreManager;