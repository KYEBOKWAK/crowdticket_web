'use strict';

import React, { Component } from 'react';

import InfiniteScroll from 'react-infinite-scroll-component';
import StoreContentsListItem from '../component/StoreContentsListItem';

import StoreReviewList from '../component/StoreReviewList';
import axios from '../lib/Axios';

import Util from '../lib/Util';

import Types from '../Types';

import StoreUserSNSList from '../component/StoreUserSNSList';

// import StrLib from '../lib/StrLib';
import Str from '../component/Str';

import Cookies from 'universal-cookie';

import Storage from '../lib/Storage';
import * as storageType from '../StorageKeys';

const cookies = new Cookies();

const MENU_STATE_CONTENTS = 'MENU_STATE_CONTENTS';
const MENU_STATE_REVIEW = 'MENU_STATE_REVIEW';

const REQUEST_ONCE_ITME = 10;
let isRequestInitData = false;

const MAX_WIDTH = 520;

class StoreDetailPage extends Component {

  constructor(props) {
    super(props);
    this.state = { 
      storeThumbListComponent: <></>,
      items: [],
      hasMore: true,
      galleryItems: [],
      menuState: MENU_STATE_CONTENTS,

      store_id: null,
      store_alias: null,

      title: '',
      profile_photo_url: '',
      thumb_img_url: '',
      store_user_id: null,

      name: '',
      store_content: '',

      commentCount: 0,

      isAdmin: false,

      language_code: 'kr'

      // window_width: window.innerWidth,
      // window_height: window.innerHeight,

      // thumb_img_parent_width: 520,

      // thumb_img_width: 520,
      // thumb_img_height: 280,
    };

    this.requestMoreData = this.requestMoreData.bind(this);
    this.updateDimensions = this.updateDimensions.bind(this);

    this.thumb_parent_ref = React.createRef();
    this.thumb_img_ref = React.createRef();
  }

  componentDidMount(){
    const pageKeyDom = document.querySelector('#app_page_key');
    if(pageKeyDom){
      console.log(pageKeyDom.value);
    }

    const store_id_dom = document.querySelector('#store_id');
    let _store_id = null;
    if(store_id_dom){
      // console.log(store_id_dom.value);
      if(store_id_dom.value){
        _store_id = Number(store_id_dom.value);  
      }
      // _store_id = Number(store_id_dom.value);
    }

    let _store_alias = null;
    const store_alias_dom = document.querySelector('#store_alias');
    if(store_alias_dom){
      // console.log(store_alias_dom.value);
      if(store_alias_dom.value){
        _store_alias = store_alias_dom.value;
      }
    }

    //store_detail_tabmenu
    let _menuState = this.state.menuState;
    const store_detail_tabmenu_dom = document.querySelector('#store_detail_tabmenu');
    if(store_detail_tabmenu_dom){
      // console.log(store_alias_dom.value);
      if(store_detail_tabmenu_dom.value){
        _menuState = store_detail_tabmenu_dom.value;
      }
    }

    this.setState({
      // items: _items.concat(),
      store_id: _store_id,
      store_alias: _store_alias,
      menuState: _menuState
    }, () => {

      Storage.load(storageType.LANGUAGE_CODE, (result) => {
        let language_code = 'kr';
        if(result.value){
          language_code = result.value;      
        }else{
          //값이 없음 
        }
  
        this.setState({
          language_code: language_code
        }, () => {
          this.requestStoreInfo();

          if(isLogin()){
            this.requestIsAdmin();
          }
        })
      })

      // this.requestStoreInfo();

      // if(isLogin()){
      //   this.requestIsAdmin();
      // }
    });

    window.addEventListener('resize', this.updateDimensions);
  }

  componentWillUnmount(){
    window.removeEventListener('resize', this.updateDimensions);
  }

  addViewCount = () => {
    let cookiesName = 'cr_view_'+this.state.store_id;

    let view_store = cookies.get(cookiesName);
    if(view_store === undefined){
      var today = new Date();

      var nextDay = new Date(today);
      nextDay.setMinutes(today.getMinutes() + 10);

      cookies.set(cookiesName, '0', 
      { 
        path: '/',
        expires: nextDay
      });

      axios.post('/store/any/viewcount/store/add', {
        store_id: this.state.store_id
      }, (result) => {

      }, (error) => {

      })
    }
  }

  storeItem(data){
    return <div key={data.id} style={{width: 110, height: 200}}>
              <img style={{width: 100, height: 100, borderRadius: 50}} draggable='false' src={data.img}/>
              {data.title+data.id}
            </div>
  }

  requestIsAdmin(){
    axios.post("/user/isadmin", {},
    (result) => {
      this.setState({
        isAdmin: result.isAdmin
      })
    }, (error) => {

    })
  }

  requestStoreInfo(){
    // console.log(this.state.store_alias);
    // console.log(this.state.store_id);
    axios.post('/store/any/detail/info', {
      store_alias: this.state.store_alias,
      store_id: this.state.store_id
    }, (result) => {
      this.setState({
        store_id: result.data.id,
        store_alias: result.data.alias,
        profile_photo_url: result.data.profile_photo_url,
        thumb_img_url: result.data.thumb_img_url,
        title: result.data.title,
        store_user_id: result.data.user_id,
        name: result.data.nick_name,
        store_content: result.data.store_content
      }, () => {
        this.addViewCount();
        this.initData();
      })
    }, (error) => {

    })
  }

  initData(){
    this.requestMoreData();
    this.getCommentsCount();
  }

  getCommentsCount(){
    axios.post('/comments/any/allcount', {
      commentType: Types.comment.commentType.store,
      target_id: this.state.store_id
    }, (result) => {
      this.setState({
        commentCount: result.commentsTotalCount
      })
    }, (error) => {

    })
  }

  createStore(){
    alert("크리에이터 인증 구글폼으로 갑니다");
  }

  goStoreManagement(){

  }

  requestMoreData(){
    
    // a fake async api call like which sends
    // 20 more records in 1.5 secs

    if(this.state.items.length === 0 && this.isRequestInitData){
      return;
    }

    if(this.state.items.length === 0){
      this.isRequestInitData = true;
    }

    axios.post('/store/any/detail/item/list', {
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items.length,
      store_id: this.state.store_id,

      language_code: this.state.language_code
      // lastID: 
    }, 
    (result) => {
      
      let itemsData = result.list.concat();
      let _items = this.state.items.concat();
      
      let hasMore = true;
      if(REQUEST_ONCE_ITME > itemsData.length ){
        hasMore = false;
      }

      for(let i = 0 ; i < itemsData.length ; i++){
        const data = itemsData[i];
        
        _items.push(data);
        // itemIndex++;
      }
      
      this.setState({
        items: _items.concat(),
        hasMore: hasMore
      });
    }, (error) => {

    })
  };

  clickMenu(e, menuState){
    e.preventDefault();

    this.setState({
      menuState: menuState
    })
  }

  clickWriteReview(e){
  }

  clickManagerPage(e){
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    let goURL = baseURL + '/manager/store';

    window.location.href = goURL;
  }

  clickCTAdmin(e){
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    //manager/store/{id}/admin
    let goURL = baseURL + '/admin/manager/store/' + this.state.store_id;

    window.location.href = goURL;
  }

  clickEvent = (e) => {
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    //manager/store/{id}/admin
    let goURL = baseURL + '/event/2020';

    // window.location.href = goURL;
    window.open(goURL);
  }

  updateDimensions(){
    // this.setState({ width: window.innerWidth, height: window.innerHeight });
    // console.log(window.innerWidth);

    // console.log(this.thumb_parent_ref.current.offsetWidth)

    /*
    var parentData = {
      offsetWidth: this.thumb_parent_ref.current.offsetWidth,
      offsetHeight: this.thumb_parent_ref.current.offsetHeight
    }

    var imgData = {
      offsetWidth: this.thumb_img_ref.current.offsetWidth,
      offsetHeight: this.thumb_img_ref.current.offsetHeight,
    };

    // var targetWidth =  imgData.naturalWidth / (imgData.naturalHeight / parentData.clientHeight);
    var targetWidth =  imgData.offsetWidth / (imgData.offsetHeight / parentData.offsetHeight);

    let resizeImg = {
      width: '100%',
      height: 'auto'
    }

    if(targetWidth <= window.innerWidth)
    {
      // $('.magazine_title_img').css('width', '100%');
      // $('.magazine_title_img').css('height', 'auto');
      resizeImg.width = '100%';
      resizeImg.height = 'auto';
    }
    else
    {
      // $('.magazine_title_img').css('width', targetWidth);
      // $('.magazine_title_img').css('height', parentData.clientHeight);
      resizeImg.width = targetWidth;
      resizeImg.height = parentData.offsetHeight;
    }

    this.setState({
      thumb_img_width: resizeImg.width,
      thumb_img_height: resizeImg.height
    })
*/
    /*
    let _thumb_img_parent_width = this.state.thumb_img_parent_width;
    if(window.innerWidth <= MAX_WIDTH){
      _thumb_img_parent_width = window.innerWidth
    }else{
      _thumb_img_parent_width = MAX_WIDTH;
    }

    console.log(_thumb_img_parent_width);

    this.setState({
      thumb_img_parent_width: _thumb_img_parent_width
    })
    */
  };

  /*
  resizeThumbImg(){
    var parentData = $('.magazine_title_image_container')[0];
    var imgData = $('.magazine_title_img')[0];

    var targetWidth =  imgData.naturalWidth / (imgData.naturalHeight / parentData.clientHeight);

    if(targetWidth <= window.innerWidth)
    {
      $('.magazine_title_img').css('width', '100%');
      $('.magazine_title_img').css('height', 'auto');
    }
    else
    {
      $('.magazine_title_img').css('width', targetWidth);
      $('.magazine_title_img').css('height', parentData.clientHeight);
    }
  };
  */

  render() {
    if(!this.state.store_id){
      // console.log('!?!?!?!?');
      // console.log(this.state.store_id);
      return <></>;
    }

    let contentsUnderLine = <></>;
    let reviewUnderLine = <></>;

    let mainContent = <></>;
    let menuContentsTextStyle= {
      fontSize: 16,
      fontWeight: 'bold',
      color: '#222222',
      opacity: 0.5
    };
    let menuReviewTextStyle= {
      fontSize: 16,
      fontWeight: 'bold',
      color: '#222222',
      opacity: 0.5
    };

    if(this.state.menuState === MENU_STATE_CONTENTS){
      contentsUnderLine = <div className={'selectCircle'}></div>;
      menuContentsTextStyle = {
        ...menuContentsTextStyle,
        opacity: 1
      }

      mainContent = <InfiniteScroll
                      // style={{backgroundColor: 'red'}}
                      dataLength={this.state.items.length} //This is important field to render the next data
                      next={this.requestMoreData}
                      hasMore={this.state.hasMore}
                      loader=
                      {
                        <div style={{display: 'flex', justifyContent: 'center'}}>
                          <h4>Loading...</h4>
                        </div>
                      }
                      endMessage={
                        <></>
                        // <p style={{ textAlign: 'center' }}>
                        //   <b>Yay! You have seen it all</b>
                        // </p>
                      }
                      // below props only if you need pull down functionality
                      // refreshFunction={this.refresh}
                      // pullDownToRefresh
                      pullDownToRefreshThreshold={50}
                      pullDownToRefreshContent={
                        <></>
                        // <h3 style={{ textAlign: 'center' }}>&#8595; Pull down to refresh</h3>
                      }
                      releaseToRefreshContent={
                        <></>
                        // <h3 style={{ textAlign: 'center' }}>&#8593; Release to refresh</h3>
                      }
                    >
                      {this.state.items.map((data) => {
                        return <StoreContentsListItem key={data.id} store_title={data.store_title} store_id={this.state.store_id} id={data.id} store_item_id={data.id} thumbUrl={data.img_url} name={data.nick_name} title={data.title} price={data.price} type_contents={data.type_contents} price_USD={data.price_USD} currency_code={data.currency_code}></StoreContentsListItem>
                      })}
                    </InfiniteScroll>
    }else if(this.state.menuState === MENU_STATE_REVIEW){
      reviewUnderLine = <div className={'selectCircle'}></div>;
      menuReviewTextStyle = {
        ...menuReviewTextStyle,
        opacity: 1
      }
      mainContent = <StoreReviewList store_id={this.state.store_id}></StoreReviewList>;
    }

    let managerButton = <></>;
    let adminManagerButton = <></>;
    if(Util.isAdmin(this.state.store_user_id)){
      managerButton = <button className={'admin_button'} onClick={(e) => {this.clickManagerPage(e)}}>
                        관리자 페이지
                      </button>
    }

    if(this.state.isAdmin){
      adminManagerButton = <button className={'ct_admin_button'} onClick={(e) => {this.clickCTAdmin(e)}}>
                              크티 관리자
                            </button>
    }

    return (
      <div className={'StoreDetailPage'}>
        <div className={'bg_img_container'} ref={this.thumb_parent_ref}>
            <img className={'bg_img'} src={this.state.thumb_img_url}/>
            <div className={'black-mask'} style={{backgroundColor: 'rgba(0,0,0,0.6)'}}>
            </div>
            <div className={'user_img_container flex_layer flex_direction_row'}>
              <div>
                <div className={'user_name'}>
                  {/* {this.state.name} */}
                  <div className={'flex_layer'} style={{alignItems: 'center'}}>
                    {this.state.title}
                    {managerButton}
                    {adminManagerButton}
                  </div>
                </div>
                <div className={'store_content'}>
                  {this.state.store_content}
                </div>
              </div>
              <img className={'user_img'} src={this.state.profile_photo_url} />
              <StoreUserSNSList store_id={this.state.store_id}></StoreUserSNSList>
            </div>
        </div>

        <div className={'contentsContainer flex_layer flex_direction_column'}>
          <div className={'contentsMenuContainer flex_layer flex_direction_row'}>
            <button onClick={(e) => {this.clickMenu(e, MENU_STATE_CONTENTS)}} style={{width: '100%', display: 'flex', flexDirection: 'column', alignItems: 'center'}}>
              <div style={menuContentsTextStyle}><Str strKey={'s10'}/></div>
              {contentsUnderLine}
            </button>
            <button onClick={(e) => {this.clickMenu(e, MENU_STATE_REVIEW)}} style={{width: '100%', display: 'flex', flexDirection: 'column', alignItems: 'center'}}>
              <div style={menuReviewTextStyle}><Str strKey={'s11'}/> {this.state.commentCount}</div>
              {reviewUnderLine}
            </button>
          </div>
          {mainContent}

        </div>        
      </div>
    );
  }
}

export default StoreDetailPage;