'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import StoreDoIt from '../component/StoreDoIt';

import ic_more from '../res/img/ic-more.svg';
import ic_btn_add from '../res/img/btn-add.svg';

import ic_system_circle from '../res/img/ic-system-circle.svg';

import ic_call from '../res/img/ic-call.svg';
import ic_email from '../res/img/ic-mail.svg';
import ic_ct from '../res/img/ic-ct.svg';
import ic_kakao from '../res/img/ic-kakao.svg';

import Util from '../lib/Util';
import moment_timezone from 'moment-timezone';
import Types from '../Types';

import StoreManagerHome_Item from '../component/StoreManagerHome_Item';
import StoreManagerHome_newOrderItem from '../component/StoreManagerHome_newOrderItem';

import {CopyToClipboard} from 'react-copy-to-clipboard';

import { ToastContainer, toast } from 'react-toastify';

const GO_ADD_ITEM_PAGE = 'GO_ADD_ITEM_PAGE';

const MAX_SHOW_ITEM_COUNT = 3;
class StoreManagerTabHomePage extends Component{

  constructor(props){
    super(props);

    this.state = {

      //첫번째 단 start
      new_order_count: 0,   //신규주문
      //첫번째 단 end

      //첫번째 옆 정산단 start
      total_payment_price: 0,

      next_deposit_date: '',
      standard_payment_date_start: '',
      standard_payment_date_end: '',
      //첫번째 옆 정산단 end

      notice_contents: '',
      notice_contents_link: '',
      notice_img_url: '',
      notice_img_url_link: '',


      contact_us_number: '070-8819-4308',
      contact_us_email: 'contact@crowdticket.kr',

      itemDatas: [],
      newOrderDatas: [],

      store_alias: '',
      store_link_url: ''
    }
  };

  componentDidMount(){
    this.requestPaymentInfo();
    this.requestStoreNoticeInfo();
    this.requestItemList();
    this.requestStoreNewOrderList();
    this.requestStoreAlias();
  };

  requestStoreAlias = () => {
    axios.post('/store/any/info/alias', {
      store_id: this.props.store_id
    }, (result) => {
      let _alias = result.alias;
      if(_alias === undefined || _alias === null){
        _alias = '';
      }
      this.setState({
        store_alias: _alias
      }, () => {
        this.setStoreLinkURL();
      })
    }, (error) => {

    })
  }

  setStoreLinkURL = () => {
    let url_tail = '';
    if(this.state.store_alias !== ''){
      url_tail = this.state.store_alias;
    }else{
      url_tail = this.props.store_id;
    }

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }
    
    let hrefURL = baseURL+'/store/'+url_tail;
    
    this.setState({
      store_link_url: hrefURL
    })
  }

  requestStoreNewOrderList = () => {
    axios.post('/store/order/new/list', {
      store_id: this.props.store_id
    }, (result) => {
      this.setState({
        newOrderDatas: result.list.concat()
      })
    }, (error) => {

    })
  }

  requestItemList = () => {
    axios.post('/store/item/list/all', {
      store_id: this.props.store_id
    }, 
    (result) => {
      // let itemOrderDatas = [];
      // for(let i = 0 ; i < result.list.length ; i++){
      //   const data = result.list[i];
      //   let orderData = {
      //     key: data.id,
      //     item_id: data.id,
      //     order_number: data.order_number
      //   }

      //   itemOrderDatas.push(orderData);
      // }

      this.setState({
        itemDatas: result.list.concat()
      })
    }, (error) => {

    })
  }

  requestPaymentInfo = () => {
    axios.post('/store/manager/payment/info', {
      store_id: this.props.store_id
    },
    (result) => {
      let total_payment_price = 0;
      let payment_detail_datas = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];

        total_payment_price += data.payment_price;

        // payment_detail_datas.push(data);
      }

      this.setState({
        next_deposit_date: result.next_deposit_date,
        standard_payment_date_start: result.standard_payment_date_start,
        standard_payment_date_end: result.standard_payment_date_end,

        total_payment_price: total_payment_price,

        // payment_detail_datas: payment_detail_datas.concat()
      })
    }, (error) => {

    })
  }

  requestStoreNoticeInfo = () => {
    axios.post("/store/notice/list", {}, 
    (result) => {

      let contents = '';
      let contents_link = '';

      let contents_img_url = '';
      let contents_img_url_link = '';
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        if(data.contents !== null && data.contents !== ''){
          contents = data.contents;
          contents_link = data.link;
          continue;
        }

        if(data.contents_img_url !== null && data.contents_img_url !== ''){
          contents_img_url = data.contents_img_url;
          contents_img_url_link = data.link;
          continue;
        }
      }

      this.setState({
        notice_contents: contents,
        notice_contents_link: contents_link,
        notice_img_url: contents_img_url,
        notice_img_url_link: contents_img_url_link
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  onClickNoticeContents = (e) => {
    e.preventDefault();

    if(this.state.notice_contents_link === null || this.state.notice_contents_link === ''){
      return;
    }

    window.open(this.state.notice_contents_link);
  }

  onClickNoticeImgContents = (e) => {
    e.preventDefault();

    if(this.state.notice_img_url_link === null || this.state.notice_img_url_link === ''){
      return;
    }

    window.open(this.state.notice_img_url_link);
  }

  onClickGoDoIt = (e, goType) => {
    e.preventDefault();

    let baseURL = ''
    const isAdmin = document.querySelector('#isAdmin').value;
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    let goURL = '';
    if(goType === GO_ADD_ITEM_PAGE){
      goURL = baseURL + '/store/item/addpage';
      if(isAdmin){
        goURL = baseURL + '/admin/manager/store/'+this.props.store_id+'/item/addpage';
      }
    }

    window.location.href = goURL;
  }

  onClickContactUsServiceCenter = (e) => {
    e.preventDefault();

    window.open('https://www.notion.so/crowdticket/bd04ecd76ae840a0b32feed12fd10d57');
  }

  onClickContactUsHelpCenter = (e) => {
    e.preventDefault();

    plusFriendChat();
  }

  goMoreButton = (e, tabKey) => {
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      baseURL = baseURLDom.value;
    }
    
    let hrefURL = baseURL+'/manager/store/?menu='+tabKey;
    const isAdmin = document.querySelector('#isAdmin').value;
    if(isAdmin){
      hrefURL = baseURL+'/admin/manager/store/'+this.props.store_id+'/?menu='+tabKey;
    }
    
    window.location.href = hrefURL;
  }

  render(){

    let next_deposit_date = moment_timezone(this.state.next_deposit_date).format('YYYY. MM. DD');
    
    let stanard_moment_start = moment_timezone(this.state.standard_payment_date_start);

    let stanard_moment_end = moment_timezone(this.state.standard_payment_date_end);

    let stanard_payment_date = '';
    let stanard_payment_start = stanard_moment_start.format('YYYY.MM.DD');
    let stanard_payment_end = stanard_moment_end.format('YYYY.MM.DD');
    if(stanard_moment_start.year() === stanard_moment_end.year()){
      stanard_payment_end = stanard_moment_end.format('MM.DD');
    }else{
      stanard_payment_end = stanard_moment_end.format('YYYY.MM.DD');
    }

    stanard_payment_date = stanard_payment_start + '~' + stanard_payment_end;


    let new_order_center_container_dom = <></>;
    let new_order_center_content_dom = <></>;
    if(this.state.newOrderDatas.length === 0 && this.state.itemDatas.length === 0){
      new_order_center_content_dom = <button onClick={(e) => {this.onClickGoDoIt(e, GO_ADD_ITEM_PAGE)}} className={'no_one_container'} className={'new_order_no_content_text'}>
                                      <div>
                                        {`주문을 받기 전,\n 먼저 상품을 등록해볼까요?`}
                                      </div>
                                      <img className={'new_order_no_content_plus_img'} src={ic_btn_add} />
                                    </button>;

    }else if(this.state.newOrderDatas.length === 0 && this.state.itemDatas.length > 0){
      new_order_center_content_dom = <div className={'new_order_no_content_text'}>
                                      {`신규 주문이 없어요.\n상점 링크 공유 배너를 클릭해\n상점을 홍보해보세요!`}
                                    </div>;
    }
    else{

    }

    new_order_center_container_dom = <div className={'new_order_no_content_container'}>
                                      {new_order_center_content_dom}
                                    </div>;

    // new_order_center_container_dom = new_order_center_content_dom;
                                    


    //공지사항 셋팅 start
    let notice_contents_dom = <></>;
    if(this.state.notice_contents !== null && this.state.notice_contents !== ''){

      let isDisabled = false;
      if(this.state.notice_contents_link === null || this.state.notice_contents_link === ''){
        isDisabled = true;
      }

      notice_contents_dom = <div className={'container_box'}>
                              <button onClick={(e) => {this.onClickNoticeContents(e)}} className={'notice_box_button'} disabled={isDisabled}>
                                <img src={ic_system_circle} />
                                <div className={'notice_box_text'}>
                                  {this.state.notice_contents}
                                </div>
                              </button>
                            </div>
    }

    let notice_img_url_dom = <></>;
    if(this.state.notice_img_url !== null && this.state.notice_img_url !== ''){

      let isDisabled = false;
      if(this.state.notice_img_url_link === null || this.state.notice_img_url_link === ''){
        isDisabled = true;
      }

      notice_img_url_dom = <div className={'container_box'}>
                            <button className={'notice_image_button'} onClick={(e) => {this.onClickNoticeImgContents(e)}} disabled={isDisabled}>
                              <img className={'notice_image'} src={this.state.notice_img_url} />
                            </button>
                          </div>
    }
    //공지사항 셋팅 end

    //진행중인 주문 start
    let newOrderCountText = this.state.newOrderDatas.length;
    let newOrderCount = this.state.newOrderDatas.length;
    // let now_order_center_dom = <></>;
    if(newOrderCount === 0 && this.state.itemDatas.length === 0){
      // now_order_center_dom = <button onClick={(e) => {this.onClickGoDoIt(e, GO_ADD_ITEM_PAGE)}} className={'no_one_container'}>
      //                         <img src={ic_btn_add} />
      //                         <div className={'no_one_text'}>
      //                           주문을 진행하기 전, 먼저 상품을 등록해볼까요?
      //                         </div>
      //                       </button>
    }else if(newOrderCount === 0 && this.state.itemDatas.length > 0){
      // now_order_center_dom = <div className={'no_one_container'}>
      //                         <div className={'new_order_no_content_text'}>
      //                           {`진행중인 주문이 없어요.`}
      //                         </div>
      //                       </div>;
    }

    if(newOrderCount < 10){
      newOrderCountText = '0'+newOrderCount;
    }

    //list 셋팅
    let order_items_container_dom = <></>;
    let order_item_doms = [];
    for(let i = 0 ; i < this.state.newOrderDatas.length ; i++){
      if(i >= MAX_SHOW_ITEM_COUNT){
        break;
      }

      const data = this.state.newOrderDatas[i];
      const itemDom = <StoreManagerHome_newOrderItem 
      callbackRefreshItems={() => {
        this.requestStoreNewOrderList();
      }} store_order_id={data.store_order_id} img_url={data.img_url} item_title={data.title} price={data.price} created_at={data.created_at}></StoreManagerHome_newOrderItem>

      let lineDom = <div className={'order_item_under_line'}></div>;
      if(i === 0){
        lineDom = <></>;
      }

      const itemContainerDom = <div key={i}>
                                {lineDom}
                                {itemDom}
                              </div>
      
      order_item_doms.push(itemContainerDom);
    }

    if(newOrderCount > 0){
      order_items_container_dom = <div className={'order_items_container'}>
                                    {order_item_doms}
                                  </div>
    }
    //진행중인 주문 end
    
    //판매중인 상품 start
    let now_sale_center_dom = <></>;
    let items_container_dom = <></>;
    let item_count = this.state.itemDatas.length;
    let item_count_text = this.state.itemDatas.length;
    if(item_count === 0){
      now_sale_center_dom = <button onClick={(e) => {this.onClickGoDoIt(e, GO_ADD_ITEM_PAGE)}} className={'no_one_container'}>
                              <img src={ic_btn_add} />
                              <div className={'no_one_text'}>
                                상품을 등록하고 주문을 받아볼까요?
                              </div>
                            </button>
    }
    else if(item_count < 10){
      item_count_text = '0'+item_count;
    }

    let item_doms = [];
    for(let i = 0 ; i < this.state.itemDatas.length ; i++){
      if(i >= MAX_SHOW_ITEM_COUNT){
        break;
      }

      const data = this.state.itemDatas[i];

      const itemDom = <StoreManagerHome_Item store_id={this.props.store_id} id={data.id} store_item_id={data.id} store_title={data.store_title} img_url={data.img_url} item_title={data.title} price={data.price} state={data.state}></StoreManagerHome_Item>

      let lineDom = <div className={'item_under_line'}></div>;
      if(i === 0){
        lineDom = <></>;
      }

      const itemContainerDom = <div key={i}>
                                {lineDom}
                                {itemDom}
                              </div>

      item_doms.push(itemContainerDom);
    }

    if(item_count > 0){
      items_container_dom = <div className={'items_container'}>
                              {item_doms}
                            </div>
    }
    //판매중인 상품 end

    return(
      <div className={'StoreManagerTabHomePage'}>
        <StoreDoIt store_id={this.props.store_id} store_user_id={this.props.store_user_id}></StoreDoIt>

        
        <div className={'container_box'}>
          <div className={'first_area_box'}>
            <div className={'new_order_box'}>
              <div className={'new_order_top_container'}>
                <div className={'new_order_top_title_text'}>
                  신규 주문
                  <span style={{marginLeft: 8}} className={'point_color'}>
                    {newOrderCountText}
                  </span>
                </div>
                <button onClick={(e) => {this.goMoreButton(e, 'TAB_ASK_LIST')}} className={'new_order_top_more_button'}>
                  전체보기
                  <img src={ic_more} />
                </button>
              </div>

              {new_order_center_container_dom}
              {order_items_container_dom}
            </div>

            <div className={'first_second_box'}>
              <div className={'calculate_box'}>
                <div className={'new_order_top_container'}>
                  <div className={'new_order_top_title_text'}>
                    정산
                  </div>
                  <button onClick={(e) => {this.goMoreButton(e, 'TAB_STORE_ACCOUNT')}} className={'new_order_top_more_button'}>
                    더보기
                    <img src={ic_more} />
                  </button>
                </div>

                <div className={'calculate_box_content_container'}>
                  <div className={'calculate_box_content_label'}>
                    정산 예정 금액
                  </div>
                  <div className={'calculate_box_price'}>
                    {Util.getNumberWithCommas(this.state.total_payment_price)}원
                  </div>
                </div>

                <div className={'calculate_box_content_container'}>
                  <div className={'calculate_box_content_label'}>
                    정산 기준일
                  </div>
                  <div className={'calculate_box_date_text'}>
                    {stanard_payment_date}
                  </div>
                </div>

                <div className={'calculate_box_content_container'}>
                  <div className={'calculate_box_content_label'}>
                    입금 예정일
                  </div>
                  <div className={'calculate_box_date_text'}>
                    {next_deposit_date}
                  </div>
                </div>

              </div>
              <CopyToClipboard 
              text={this.state.store_link_url} 
              onCopy={() => 
              {
                toast.dark('상점 링크가 복사되었습니다!', {
                  position: "top-center",
                  autoClose: 5000,
                  hideProgressBar: true,
                  closeOnClick: true,
                  pauseOnHover: true,
                  draggable: true,
                  progress: undefined,
                  });
              }}>
                <button className={'link_copy_button'}>
                  🔗 상점 링크를 공유해볼까요?
                </button>
              </CopyToClipboard>
            </div>
          </div>          
        </div>

        {notice_contents_dom}

        {/* <div className={'container_box'}>
          <div className={'contents_box'}>
            <div className={'contents_label'}>
              진행중인 주문
            </div>
            {now_order_center_dom}
          </div>
        </div> */}

        <div className={'container_box'}>
          <div className={'contents_box'}>
            <div className={'sale_item_label_container'}>
              <div className={'contents_label'}>
                판매중인 상품
                <span style={{marginLeft: 8}} className={'point_color'}>
                  {item_count_text}
                </span>
              </div>

              <button onClick={(e) => {this.goMoreButton(e, 'TAB_ITEM_MANAGER')}} className={'new_order_top_more_button'}>
                전체보기
                <img src={ic_more} />
              </button>
            </div>
            {now_sale_center_dom}
            {items_container_dom}
          </div>
        </div>

        {notice_img_url_dom}

        <div className={'container_box'}>
          <div className={'contents_box'}>
            <div className={'contents_label'}>
              도움이 필요하신가요?
            </div>

            <div className={'help_contact_us_container'}>
              <div className={'help_contact_us_box'}>
                <img src={ic_call}/>  
                <div className={'help_contact_us_text'}>
                  {this.state.contact_us_number}
                </div>
              </div>

              <div className={'help_contact_us_box'}>
                <img src={ic_email}/>  
                <div className={'help_contact_us_text'}>
                  {this.state.contact_us_email}
                </div>
              </div>
            </div>

            <button onClick={(e) => {this.onClickContactUsServiceCenter(e)}} className={'help_contact_service_center_button'}>
              <img src={ic_ct} />
              <div className={'help_contact_service_center_text'}>
                크티 고객 대만족센터
              </div>
            </button>

            <button onClick={(e) => {this.onClickContactUsHelpCenter(e)}} className={'help_contact_help_center_button'}>
              <img src={ic_kakao} />
              <div className={'help_contact_help_center_text'}>
                크티 크리에이터 헬프센터
              </div>
            </button>

            <div className={'help_contact_us_info'}>
              운영시간 평일 오전 10시 ~ 오후 7시, 운영시간 밖 지연 응답
            </div>
          </div>
        </div>
        <ToastContainer 
          position="top-center"
          autoClose={5000}
          hideProgressBar
          newestOnTop={false}
          closeOnClick
          rtl={false}
          pauseOnFocusLoss
          draggable
          pauseOnHover
        />
      </div>
    )
  }
};

export default StoreManagerTabHomePage;