'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';
import Util from '../lib/Util';

import StoreUserSNSList from '../component/StoreUserSNSList';
import Types from '../Types';

import moment_timezone from 'moment-timezone';

import StoreOtherItems from '../component/StoreOtherItems';
// import StoreReviewTalk from '../component/StoreReviewTalk';

import icon_order from '../res/img/icon-order.jpg';
import icon_check from '../res/img/icon-check.jpg';
import icon_gift from '../res/img/icon-gift.jpg';
import icon_good from '../res/img/icon-good.jpg';

import ReactPlayer from 'react-player';

import ImageFileUploader from '../component/ImageFileUploader';

import Popup_refund from '../component/Popup_refund';

import StoreItemDetailReviewList from '../component/StoreItemDetailReviewList';

import Cookies from 'universal-cookie';

import ic_icon_download from '../res/img/icon-download.svg';
import icon_clip_tag from '../res/img/icon-clip-tag.svg';

import icon_download_big from '../res/img/icon-download-big.svg';

import Login from '../lib/Login';

const cookies = new Cookies();

const IMAGE_THUMB_FILE_WIDTH = 520;
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

      item_type_contents: Types.contents.customized,

      is_show_other_items: true,
      is_show_order_reviews: true,

      youtube_url: '',

      isContentMoreExplain: true,
      show_refund_popup: false,

      is_show_bottom_button: true,

      isAdmin: false,

      show_image_width: 0,
      show_image_height: 0,

      ori_show_image_width: 0,
      ori_show_image_height: 0,

      isThumbResize: false,

      download_type_file_count: 0
    }
  };

  updateDimensions = () => {

    if(window.innerWidth >= 520){
      if(!this.state.isThumbResize){
        this.setState({
          isThumbResize: true
        }, () => {
          this.onImgLoad({
            target: {
              naturalWidth: this.state.ori_show_image_width,
              naturalHeight: this.state.ori_show_image_height
            }
          })
        })
      }
    }else{
      if(this.state.isThumbResize){
        this.setState({
          isThumbResize: false
        })
      }
    }

    // this.setState({
    //   innerWidth: window.innerWidth
    // })
  }

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){

    window.addEventListener('scroll', this.handleScroll);
    window.addEventListener('resize', this.updateDimensions);

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

        this.addViewCount();
      })
    }

    if(isLogin()){
      this.requestIsAdmin();
    }
  };

  requestIsAdmin(){
    axios.post("/user/isadmin", {},
    (result) => {
      this.setState({
        isAdmin: result.isAdmin
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){
    window.removeEventListener('scroll', this.handleScroll);

    window.removeEventListener('resize', this.updateDimensions);
  };

  componentDidUpdate(){
  }

  addViewCount = () => {
    let cookiesName = 'cr_view_item_'+this.state.store_item_id;

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

      axios.post('/store/any/viewcount/item/add', {
        item_id: this.state.store_item_id
      }, (result) => {

      }, (error) => {

      })
    }
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

  requestItemInfo = () => {
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

        youtube_url: data.youtube_url,
        item_type_contents: data.type_contents
      }, () => {
        this.requestDownloadFileCount();
      })
    }, (error) => {

    })
  }

  requestDownloadFileCount = () => {
    if(this.state.item_type_contents === Types.contents.customized){
      return;
    }

    axios.post('/store/any/download/file/count', {
      store_item_id: this.state.store_item_id
    }, (result) => {
      this.setState({
        download_type_file_count: result.file_count
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

    if(this.state.item_type_contents === Types.contents.completed){
      // download_type_file_count
      const pointTagDom = <div key={_pointTags.length} className={'point_tag_box point_tag_box_file_type'}>
                            <img src={icon_clip_tag} />
                            <div style={{marginLeft: 4}}>
                              첨부파일 {this.state.download_type_file_count}개
                            </div>
                          </div>;

      _pointTags.push(pointTagDom);
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
   
  //  window.location.href = hrefURL;

   if(isLogin()){
    window.location.href = hrefURL;
   }else{
    Login.start();
   }

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
    if(tailUrl === null || tailUrl === ''){
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

    if(this.state.isAdmin){
      goURL = baseURL + '/admin/manager/store/'+this.state.store_id+'/item/'+this.state.store_item_id+'/editpage?back=DETAIL_PAGE';
    }
    
    window.location.href = goURL;
  }

  onClickRefundButton = (e) => {
    e.preventDefault();

    this.setState({
      show_refund_popup: true
    })
  }
  

  onImgLoad = (img) => {
    let show_image_width = img.target.naturalWidth;
    let show_image_height = img.target.naturalHeight;
    

    // console.log("sdddd");
    //가로로 긴 이미지인가?
    //세로가 긴 이미지는 width 만 맞추면 height는 자동 맞춰짐
    if(show_image_width < IMAGE_THUMB_FILE_WIDTH){
      //520사이즈보다 작으면 확대 해야 한다
      show_image_width = '100%';
      show_image_height = 'auto';
    }
    else if(img.target.naturalWidth >= img.target.naturalHeight){
      //가로가 긴 이미지
      //세로 비율을 찾는다

      const ratio = IMAGE_THUMB_FILE_WIDTH / img.target.naturalHeight;

      const imgReSizeWidth = img.target.naturalWidth * ratio;
      const imgReSizeHeight = img.target.naturalHeight * ratio;

      
      show_image_width = imgReSizeWidth,
      show_image_height = imgReSizeHeight
    }else if(img.target.naturalWidth < img.target.naturalHeight){
      //세로로 긴거
      show_image_width = '100%';
      show_image_height = 'auto';
    }

    this.setState({
      show_image_width: show_image_width,
      show_image_height: show_image_height,

      ori_show_image_width: img.target.naturalWidth,
      ori_show_image_height: img.target.naturalHeight
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

      
      store_order_reviews = <div>
                              <div className={'container_label_text'}>
                                최근 진행된 주문 후기
                              </div>

                              <div className={'content_container'}>
                                <StoreItemDetailReviewList store_id={this.state.store_id}></StoreItemDetailReviewList>
                              </div>
                            </div>
      

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
    if(this.state.isManager || this.state.isAdmin){
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
      refundPopupDom = <Popup_refund item_type_contents={this.state.item_type_contents} closeCallback={() => {
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

    let imageStyle = {}
    if(this.state.show_image_width > 0){
      imageStyle = {
        width:this.state.show_image_width,
        height: this.state.show_image_height,
      }
    }

    let download_type_notice_dom = <></>;
    let need_item_notice_dom = <></>;

    let how_to_text_1 = `콘텐츠\n주문하고`;
    let how_to_text_2 = `크리에이터가\n승인하고`;
    let how_to_text_3 = `콘텐츠가\n준비되면`;
    let how_to_text_4 = `소통하고\n즐기면 끝!`;

    let how_to_icon_3 = icon_gift;
    if(this.state.item_type_contents === Types.contents.completed){
      how_to_text_2 = `‘나의 콘텐츠 주문’\n확인하고`;
      how_to_text_3 = `바로 다운로드\n받아서`;
      how_to_text_4 = `편하게\n즐기면 끝!`;
      how_to_icon_3 = icon_download_big;

      download_type_notice_dom = <div className={'download_type_notice_box'}>
                                  <img src={ic_icon_download} />
                                  <div className={'download_type_notice_text'}>
                                    해당 콘텐츠는 주문 및 결제 후 즉시 다운로드가 가능한 콘텐츠입니다.
                                  </div>
                                </div>
    }else{
      need_item_notice_dom = <div>
                              <div className={'container_label_text'}>
                                구매시 필요사항
                              </div>

                              <div className={'content_container'}>
                                {this.state.item_ask}
                              </div>
                            </div>;




    }

    return(
      <div className={'StoreItemDetailPage'}>
        <div className={'item_img_container'}>
          <div className={'item_img_box'}>
            <img className={'item_img'} style={imageStyle} onLoad={(img) => {this.onImgLoad(img)}} src={this.state.thumb_img_url} />
          </div>
          <div className={'item_img_cover'}>
          </div>
          {store_user_dom}
        </div>

        {download_type_notice_dom}

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

          {/* <div className={'container_label_text'}>
            구매시 필요사항
          </div>

          <div className={'content_container'}>
            {this.state.item_ask}
          </div> */}
          {need_item_notice_dom}

          {itemNoticeDom}

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
                {how_to_text_1}
              </div>
            </div>

            <div className={'use_img_box'}>
              <div className={'use_img_circle'}>
                <img className={'icon_check_img'} src={icon_check} />
              </div>
              <div className={'use_box_text'}>
                {how_to_text_2}
              </div>
            </div>

            <div className={'use_img_box'}>
              <div className={'use_img_circle'}>
                <img className={'icon_gift_img'} src={how_to_icon_3} />
              </div>
              <div className={'use_box_text'}>
                {how_to_text_3}
              </div>
            </div>

            <div className={'use_img_box'}>
              <div className={'use_img_circle'}>
                <img className={'icon_good_img'} src={icon_good} />
              </div>
              <div className={'use_box_text'}>
                {how_to_text_4}
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
  }
};

export default StoreItemDetailPage;