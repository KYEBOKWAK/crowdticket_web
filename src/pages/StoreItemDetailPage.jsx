'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';
import Util from '../lib/Util';

import StoreUserSNSList from '../component/StoreUserSNSList';
import Types from '../Types';

import moment_timezone from 'moment-timezone';
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

import StoreOtherItems from '../component/StoreOtherItems';
import StoreReviewTalk from '../component/StoreReviewTalk';

import icon_order from '../res/img/icon-order.jpg';
import icon_check from '../res/img/icon-check.jpg';
import icon_gift from '../res/img/icon-gift.jpg';
import icon_good from '../res/img/icon-good.jpg';

import ReactPlayer from 'react-player';

import ImageFileUploader from '../component/ImageFileUploader';

import Popup_refund from '../component/Popup_refund';


class StoreItemDetailPage extends Component{

  orderButtonRef = React.createRef();

  constructor(props){
    super(props);

    this.state = {
      store_item_id: null,
      store_id: null,
      store_user_id: null,
      store_alias: '',
      typeContent: '',
      title: '',
      price: 0,
      content: '',
      thumb_img_url: '',

      store_title: '',
      store_content: '',
      store_user_profile_photo_url: '',

      item_state: Types.item_state.SALE,
      innerWidth: window.innerWidth,

      re_set_at: null,

      isManager: false,

      item_product_category_type: null,
      item_average_make_day: null,
      item_like_count: null,
      item_tag_list: [],

      item_ask: '',
      item_notice: '',

      is_show_other_items: true,
      is_show_order_reviews: true,

      youtube_url: '',

      isContentMoreExplain: true,
      show_refund_popup: false,

      is_show_bottom_button: true
    }

    this.updateDimensions = this.updateDimensions.bind(this);
  };

  updateDimensions(){
    this.setState({
      innerWidth: window.innerWidth
    })
  }

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){

    window.addEventListener('scroll', this.handleScroll);

    const storeItemIDDom = document.querySelector('#store_item_id');
    if(storeItemIDDom){
      this.setState({
        store_item_id: Number(storeItemIDDom.value)
      }, function(){
        //아이템 정보 가져오기
        this.requestItemInfo();
        this.requestStoreInfo();
        this.requestItemTags();
        this.requestOrdersCount();
        this.requestAverageDay();
      })
    }

    window.addEventListener('resize', this.updateDimensions);

    // history.pushState(null, null, location.href);
    // window.onpageshow = function(event){
    //   if(event.persisted || (window.performance && window.performance.navigation.type == 2)){
    //     console.log("adsfsdf");
    //   }
    // }
    // window.onpopstate = function(event) {
    //   console.log("asdfasdf");
    //     // history.go(1);
    // };
    // console.log("########");
  };

  componentWillUnmount(){
    window.removeEventListener('scroll', this.handleScroll);
  };

  componentDidUpdate(){
  }

  handleScroll = (e) => {
    const { top } = this.orderButtonRef.current.getBoundingClientRect();

    if(window.innerHeight > top){
      if(this.state.is_show_bottom_button){
        this.setState({
          is_show_bottom_button: false
        })
      }
    }else{
      if(!this.state.is_show_bottom_button){
        this.setState({
          is_show_bottom_button: true
        })
      }
    }
  }

  requestItemInfo(){
    // console.log(this.state.store_item_id);
    axios.post('/store/any/item/info', {
      store_item_id: this.state.store_item_id
    }, (result) => {
      const data = result.data;
      
      this.setState({
        title: data.title,
        price: data.price,
        content: data.content,
        thumb_img_url: data.img_url,

        item_ask: data.ask,

        item_state: data.state,
        re_set_at: data.re_set_at,

        item_product_category_type: data.product_category_type,
        item_notice: data.item_notice,

        youtube_url: data.youtube_url
      })
    }, (error) => {

    })
  }

  requestItemTags = () => {
    axios.post('/store/any/tags/get', {
      item_id: this.state.store_item_id
    }, (result) => {
      let item_tag_list = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        item_tag_list.push(data.tag);
      }

      this.setState({
        item_tag_list: item_tag_list.concat()
      })
    }, (error) => {

    })
  }

  requestOrdersCount = () => {
    axios.post("/store/any/like/count", {
      item_id: this.state.store_item_id
    }, (result) => {
      if(result.order_count >= 10){
        this.setState({
          item_like_count: result.order_count
        })
      }
      
    }, (error) => {

    })
  }

  requestAverageDay = () => {
    axios.post("/store/any/averageday", {
      item_id: this.state.store_item_id
    }, (result) => {
      //주문수가 5개 이상부터 평균 계산된다.
      if(result.list.length < 5){
        return;
      }

      let daysSum = 0;
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        const timeDiff = moment_timezone(data.relay_at).diff(data.apporve_at);
        
        let day = moment_timezone.duration(timeDiff).days();
        if(day === 0){
          day = 1;
        }

        daysSum+=day;
      }

      let averageDay = Math.floor(daysSum / result.list.length);

      this.setState({
        item_average_make_day: averageDay
      })
      
    }, (error) => {

    })
  }

  getPointTag = () => {
    let _pointTags = [];
    if(this.state.item_product_category_type){
      const categoryData = Types.product_categorys.find((value) => {return value.type === this.state.item_product_category_type});
      if(categoryData){
        const pointTagDom = <div key={_pointTags.length} className={'point_tag_box'}>
                              <span className={'point_tag_point_color'}>{categoryData.text}</span>
                              {' ' + categoryData.subText}
                            </div>
                            

        _pointTags.push(pointTagDom);
      }
    }
    
    if(this.state.item_average_make_day){
      const pointTagDom = <div key={_pointTags.length} className={'point_tag_box'}>
                            평균 제작 기간 <span className={'point_tag_point_color'}>{this.state.item_average_make_day}일</span>
                          </div>;

      _pointTags.push(pointTagDom);
    }

    if(this.state.item_like_count){
      const pointTagDom = <div key={_pointTags.length} className={'point_tag_box'}>
                            <span className={'point_tag_point_color'}>{this.state.item_like_count}명</span>의 팬이 만족했어요!
                          </div>;

      _pointTags.push(pointTagDom);
    }

    if(this.state.item_tag_list.length > 0){
      for(let i = 0 ; i < this.state.item_tag_list.length ; i++){
        const data = this.state.item_tag_list[i];

        const pointTagDom = <div key={_pointTags.length} className={'point_tag_box'}>
                              {data}
                            </div>;

        _pointTags.push(pointTagDom);
      }
    }

    return _pointTags.concat()
  }

  requestStoreInfo(){
    axios.post("/store/any/info/itemid", {
      store_item_id: this.state.store_item_id
    }, (result) => {
      this.setState({
        store_id: result.data.store_id,
        store_user_id: result.data.store_user_id,
        store_alias: result.data.alias,
        store_title: result.data.title,
        store_content: result.data.content,
        store_user_profile_photo_url: result.data.profile_photo_url,
      }, () => {
        if(Util.isAdmin(this.state.store_user_id)){
          this.setState({
            isManager: true
          })
        }
      })
    }, (error) => {

    })
  }

  clickOrder(e){
   e.preventDefault();

   let baseURL = 'https://crowdticket.kr'
   const baseURLDom = document.querySelector('#base_url');
   if(baseURLDom){
     // console.log(baseURLDom.value);
     baseURL = baseURLDom.value;
   }
   
   let hrefURL = baseURL+'/order/store/'+this.state.store_item_id;
   
   window.location.href = hrefURL;

  }

  clickGoStore(e){
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }
    
    let tailUrl = this.state.store_alias;
    if(tailUrl === ''){
      tailUrl = this.state.store_id;
    }
    let hrefURL = baseURL+'/store/'+tailUrl;
    
    window.location.href = hrefURL;
  }

  clickEdit(e){
    e.preventDefault();

    let baseURL = ''
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }
    
    let goURL = baseURL + '/store/item/'+this.state.store_item_id+'/editpage?back=DETAIL_PAGE';
    
    window.location.href = goURL;
  }

  onClickRefundButton = (e) => {
    e.preventDefault();

    this.setState({
      show_refund_popup: true
    })
  }

  render(){
    if(this.state.store_item_id === null){
      return(
        <></>
      )
    }

    let store_user_dom = <></>;
    let store_other_items = <></>;
    let store_order_reviews = <></>;
    if(this.state.store_id){
      store_user_dom = <div className={'user_info_container'}>
                          <div className={'user_info_wrapper'}>
                            <div style={{display: 'flex', alignItems: 'center'}}>
                              <div style={{}}>
                                <img className={'user_img'} src={this.state.store_user_profile_photo_url} />
                              </div>
                              <div className={'store_contents_container'}>
                                <div className={'store_contents_title'}>
                                  {this.state.store_title}
                                </div>
                                <div className={'store_contents_content'}>
                                  {this.state.store_content}
                                </div>
                              </div>
                            </div>
                          </div>
                          <div style={{display: "flex", alignItems: 'flex-start'}}>
                            <StoreUserSNSList store_id={this.state.store_id} inItemDetailPage={true}></StoreUserSNSList>
                          </div>
                        </div>;

      if(this.state.is_show_other_items){
        store_other_items = <div>
                              <div className={'container_label_text'}>
                                크리에이터의 다른 콘텐츠 상품
                              </div>

                              <div className={'content_container'} style={{paddingRight: 0}}>
                                <StoreOtherItems store_id={this.state.store_id} item_id={this.state.store_item_id} isHideCallback={(isHide) => {
                                  if(this.state.is_show_other_items){
                                    if(isHide){
                                      this.setState({
                                        is_show_other_items: false
                                      })
                                    }
                                  }
                                  
                                }}></StoreOtherItems>  
                              </div>
                            </div>
        
      }

      
      // store_order_reviews = <div>
      //                         <div className={'container_label_text'}>
      //                           최근 진행된 주문
      //                         </div>

      //                         <div className={'content_container'}>
      //                           <StoreReviewTalk store_id={this.state.store_id}></StoreReviewTalk>
      //                         </div>
      //                       </div>
      

    }

    let isButtonDisabel = false;
    let buttonText = '주문하기';
    let warningNoticeDom = <></>;    

    if(this.state.item_state === Types.item_state.SALE_STOP ||
      this.state.item_state === Types.item_state.SALE_PAUSE){
        isButtonDisabel = true;
        buttonText = '';

        let pauseText = "";
        if(this.state.item_state === Types.item_state.SALE_STOP){
          pauseText = "판매가 중지되었습니다.";
          buttonText = "판매중지";
        }else if(this.state.item_state === Types.item_state.SALE_PAUSE){
          pauseText = "콘텐츠 재 입고 준비 중입니다. 다음에 다시 찾아주세요!";

          buttonText = "준비 중";
        }

        warningNoticeDom = <div className={'warning_notice_dom_container'}>{pauseText}</div>
    }
    else if(this.state.item_state === Types.item_state.SALE_LIMIT){
      isButtonDisabel = true;
      buttonText = '준비 중';

      warningNoticeDom = <div className={'warning_notice_dom_container'}>
                            {`지금은 콘텐츠 요청이 너무 많아 잠시 주문을 마감합니다.\n다음에 다시 찾아주세요!`}
                            <span className={'reset_date_text'}>{' 재오픈 예정일은 ' + moment_timezone(this.state.re_set_at).format('YYYY년 MM월 DD일') + ' 입니다'}</span>
                          </div>
    }

    let goItemEditPageDom = <></>;
    if(this.state.isManager){
      goItemEditPageDom = <button onClick={(e) => this.clickEdit(e)} className={'edit_button'}>
                            상품 수정하기
                          </button>
    }

    const _pointTags = this.getPointTag();

    let youtube_dom = <></>;
    if(Util.matchYoutubeUrl(this.state.youtube_url)){
      // const baseURLDom = document.querySelector('#base_url');
      // let baseURL = 'https://crowdticket.kr';
      // if(baseURLDom){
      //   // console.log(baseURLDom.value);
      //   baseURL = baseURLDom.value;
      // }

      youtube_dom = <div className={'youtube_container'}>
                      <ReactPlayer controls={true} width={'100%'} height={'260px'} url={this.state.youtube_url} 
                      config={{
                        youtube: {
                          playerVars: 
                          { 
                            'origin': 'https://crowdticket.kr'
                          }
                        }
                      }}
                      />
                    </div>
    }

    let contentMoreExplainDom = <></>;
    if(this.state.isContentMoreExplain){
      contentMoreExplainDom = <div>
                                <div className={'under_line'}>
                                </div>
                                <div style={{marginBottom: 12}}>
                                  <ImageFileUploader store_item_id={this.state.store_item_id} isUploader={false} noDataCallback={(isNoData) => {
                                    if(isNoData && (this.state.youtube_url === null || this.state.youtube_url === '')){
                                      this.setState({
                                        isContentMoreExplain: false
                                      })
                                    }
                                  }}></ImageFileUploader>
                                </div>

                                {youtube_dom}
                              </div>
    }
    

    let refundPopupDom = <></>;
    if(this.state.show_refund_popup){
      refundPopupDom = <Popup_refund closeCallback={() => {
        this.setState({
          show_refund_popup: false
        })
      }} ></Popup_refund>
    }

    let bottomButton = <></>;
    if(this.state.is_show_bottom_button){
      bottomButton = <button onClick={(e) => {this.clickOrder(e)}} className={'button_fix_pay'} disabled={isButtonDisabel}>
                        {buttonText}
                      </button>;
    }

    let itemNoticeDom = <></>;
    if(this.state.item_notice && this.state.item_notice !== ''){
      itemNoticeDom = <div>
                        <div className={'container_label_text'}>
                          유의사항
                        </div>

                        <div className={'content_container'}>
                          {this.state.item_notice}
                        </div>
                      </div>
    }

    return(
      <div className={'StoreItemDetailPage'}>
        <div className={'item_img_container'}>
          <img className={'item_img'} src={this.state.thumb_img_url} />
          <div className={'item_img_cover'}>
          </div>
          {store_user_dom}
        </div>

        <div className={'item_detail_page_container'}>
          <div className={'content_container'}>
            <div className={'content_title'}>
              {this.state.title}
            </div>
            <div className={'price_text_container'}>
              <div className={'content_price'}>
                {Util.getNumberWithCommas(this.state.price)}원
              </div>
              {goItemEditPageDom}
            </div>
          </div>

          <div className={'point_tag_container'}>
            {_pointTags}
          </div>

          {warningNoticeDom}

          <div className={'content_container'}>
            <div className={'content_text'}>
              {this.state.content}
              
            </div>
            {contentMoreExplainDom}
          </div>

          <div className={'container_label_text'}>
            구매시 필요사항
          </div>

          <div className={'content_container'}>
            {this.state.item_ask}
          </div>

          {itemNoticeDom}
          {/* <div className={'container_label_text'}>
            유의사항
          </div>

          <div className={'content_container'}>
            {this.state.item_notice}
          </div> */}

          <div className={'refund_container'}>
            <button onClick={(e) => {this.onClickRefundButton(e)}} className={'cancel_popup_text'}>
              <u>크티 콘텐츠 취소/환불 규정</u>
            </button>
          </div>

          {store_other_items}

          {store_order_reviews}

          
          <div className={'container_label_text'}>
            콘텐츠 상점 이용 방법
          </div>

          <div className={'use_img_container'}>
            <div className={'use_img_box'}>
              <div className={'use_img_circle'}>
                <img className={'icon_order_img'} src={icon_order} />
              </div>
              <div className={'use_box_text'}>
                {`콘텐츠 
                주문하고`}
              </div>
            </div>

            <div className={'use_img_box'}>
              <div className={'use_img_circle'}>
                <img className={'icon_check_img'} src={icon_check} />
              </div>
              <div className={'use_box_text'}>
                {`크리에이터가 
                승인하고`}
              </div>
            </div>

            <div className={'use_img_box'}>
              <div className={'use_img_circle'}>
                <img className={'icon_gift_img'} src={icon_gift} />
              </div>
              <div className={'use_box_text'}>
                {`콘텐츠가 
                준비되면`}
              </div>
            </div>

            <div className={'use_img_box'}>
              <div className={'use_img_circle'}>
                <img className={'icon_good_img'} src={icon_good} />
              </div>
              <div className={'use_box_text'}>
                {`소통하고 
                즐기면 끝!`}
              </div>
            </div>
          </div>

          <div ref={this.orderButtonRef} className={'buttons_container'}>
            <button onClick={(e) => {this.clickGoStore(e)}} className={'button_go_store'}>
              상점가기
            </button>
            <div className={'button_gap'}>
            </div>
            <button onClick={(e) => {this.clickOrder(e)}} className={'button_pay'} disabled={isButtonDisabel}>
              {buttonText}
            </button>
          </div>
        </div>
        

        {refundPopupDom}

        {bottomButton}
      </div>
    )

    /*
    return(
      <div className={'StoreItemDetailPage'}>
        <div className={'item_img_container'}>
          <img className={'item_img'} src={this.state.thumb_img_url} />
          <div className={'item_img_cover'}>
          </div>
          {store_user_dom}
        </div>

        <div className={'item_detail_page_container'}>
        </div>
        <div className={'content_container'}>
          <div className={'content_title'}>
            {this.state.title}
          </div>
          <div className={'price_text_container'}>
            <div className={'content_price'}>
              {Util.getNumberWithCommas(this.state.price)}원
            </div>
            {goItemEditPageDom}
          </div>
        </div>

        <div className={'point_tag_container'}>
          {_pointTags}
        </div>

        {warningNoticeDom}

        <div className={'content_container'}>
          <div className={'content_text'}>
            {this.state.content}
            
          </div>
          {contentMoreExplainDom}
        </div>

        <div className={'container_label_text'}>
          구매시 필요사항
        </div>

        <div className={'content_container'}>
          {this.state.item_ask}
        </div>

        <div className={'container_label_text'}>
          유의사항
        </div>

        <div className={'content_container'}>
          {this.state.item_notice}
        </div>

        <div className={'refund_container'}>
          <button onClick={(e) => {this.onClickRefundButton(e)}} className={'cancel_popup_text'}>
            <u>크티 콘텐츠 취소/환불 규정</u>
          </button>
        </div>

        {store_other_items}

        {store_order_reviews}

        
        <div className={'container_label_text'}>
          콘텐츠 상점 이용 방법
        </div>

        <div className={'use_img_container'}>
          <div className={'use_img_box'}>
            <div className={'use_img_circle'}>
              <img className={'icon_order_img'} src={icon_order} />
            </div>
            <div className={'use_box_text'}>
              {`콘텐츠 
              주문하고`}
            </div>
          </div>

          <div className={'use_img_box'}>
            <div className={'use_img_circle'}>
              <img className={'icon_check_img'} src={icon_check} />
            </div>
            <div className={'use_box_text'}>
              {`크리에이터가 
              승인하고`}
            </div>
          </div>

          <div className={'use_img_box'}>
            <div className={'use_img_circle'}>
              <img className={'icon_gift_img'} src={icon_gift} />
            </div>
            <div className={'use_box_text'}>
              {`콘텐츠가 
              준비되면`}
            </div>
          </div>

          <div className={'use_img_box'}>
            <div className={'use_img_circle'}>
              <img className={'icon_good_img'} src={icon_good} />
            </div>
            <div className={'use_box_text'}>
              {`소통하고 
              즐기면 끝!`}
            </div>
          </div>
        </div>

        <div className={'buttons_container'}>
          <button onClick={(e) => {this.clickGoStore(e)}} className={'button_go_store'}>
            상점가기
          </button>
          <div className={'button_gap'}>
          </div>
          <button onClick={(e) => {this.clickOrder(e)}} className={'button_pay'} disabled={isButtonDisabel}>
            {buttonText}
          </button>
        </div>

        {refundPopupDom}
      </div>
    )
    */

    /*
    return(
      <div className={'StoreItemDetailPage'}>
        <img className={'item_img'} src={this.state.thumb_img_url} />
        <div className={'content_container'}>
          <div className={'content_title'}>
            {this.state.title}
          </div>
          <div className={'content_price'}>
            {Util.getNumberWithCommas(this.state.price)}원
          </div>
          <div className={'content_text'}>
            {this.state.content}
          </div>

          <button onClick={(e) => {this.clickOrder(e)}} className={'button_pay'}>
            주문하기
          </button>
        </div>
      </div>
    )
    */
  }
};

export default StoreItemDetailPage;