'use strict';

import React, { Component } from 'react';

import axios from '../lib/Axios';
import _axios from 'axios';
import Types from '../Types';

import icon_box from '../res/img/icon-box.svg';
import icon_camera from '../res/img/ic-camera-fill.svg';

import imageCompression from 'browser-image-compression';
import Util from '../lib/Util';

import ImageFileUploader from '../component/ImageFileUploader';

import ImageCroper from '../component/ImageCroper';

import ic_info from '../res/img/ic-info.svg';
import ic_radio_pressed from '../res/img/radio-pressed.svg';
import ic_radio_unpressed from '../res/img/radio-unpressed.svg';

import ic_radio_pressed_dis from '../res/img/radio-pressed-dis.svg';
import ic_radio_unpressed_dis from '../res/img/radio-unpressed-dis.svg';

import CompletedFileUpLoader from '../component/CompletedFileUpLoader';

import ic_check_checked from '../res/img/check-checked.svg';
import ic_check_unchecked from '../res/img/check-unchecked.svg';

import Category_Selecter from '../component/Category_Selecter';

const INPUT_STORE_MANAGER_ADD_ITEM_TITLE = "INPUT_STORE_MANAGER_ADD_ITEM_TITLE";
const INPUT_STORE_MANAGER_ADD_ITEM_CONTENT = "INPUT_STORE_MANAGER_ADD_ITEM_CONTENT";
const INPUT_STORE_MANAGER_ADD_ITEM_PRICE = "INPUT_STORE_MANAGER_ADD_ITEM_PRICE";
const INPUT_STORE_MANAGER_ADD_ITEM_ASK = "INPUT_STORE_MANAGER_ADD_ITEM_ASK";
const INPUT_STORE_MANAGER_LIMIT_COUNT = "INPUT_STORE_MANAGER_LIMIT_COUNT";
const INPUT_STORE_MANAGER_ADD_ITEM_NOTICE = "INPUT_STORE_MANAGER_ADD_ITEM_NOTICE";

const INPUT_STORE_MANAGER_ADD_ITEM_ASK_PLAY_TIME = "INPUT_STORE_MANAGER_ADD_ITEM_ASK_PLAY_TIME";

const INPUT_STORE_MANAGER_ADD_ITEM_YOUTUBE_URL = "INPUT_STORE_MANAGER_ADD_ITEM_YOUTUBE_URL";

const TEXTAREA_STORE_MANAGER_ADD_ITEM_SELLER_ANSWER = "TEXTAREA_STORE_MANAGER_ADD_ITEM_SELLER_ANSWER"

const IMAGE_FILE_WIDTH = 100;

class StoreAddItemPage extends Component{
  imageFileUploaderRef = React.createRef();

  fileInputRef = React.createRef();

  completedFileUploaderRef = React.createRef();

  constructor(props){
    super(props);

    let _item_product_category_type_list = [];
    for(let i = 0 ; i < Types.product_categorys.length ; i++){
      const data = Types.product_categorys[i];

      if(data.type === 'download'){
        continue;
      }
      const optionDom =  <option key={data.type} value={data.type}>{data.text}</option>;

      _item_product_category_type_list.push(optionDom);
    }

    this.state = {
      store_user_id: null,
      store_id: null,
      item_id: null,
      isLogin: false,
      pageState: Types.add_page_state.ADD,
      // pictures: [],
      // testImg: '',

      maxLength: 255,

      item_title: '',
      item_content: '',
      item_img_url: '',
      item_price: 0,
      item_price_usd: 0,
      item_ask: '',
      item_state: Types.item_state.SALE,
      item_ask_play_time: '',
      item_type_contents: Types.contents.customized,
      item_product_answer: '',

      // item_state_show: '판매중',
      item_state_show: this.getStateShow(Types.item_state.SALE),
      item_state_list: [
        <option key={Types.item_state.SALE} value={Types.item_state.SALE}>{this.getStateShow(Types.item_state.SALE)}</option>,
        <option key={Types.item_state.SALE_PAUSE} value={Types.item_state.SALE_PAUSE}>{this.getStateShow(Types.item_state.SALE_PAUSE)}</option>,
        <option key={Types.item_state.SALE_STOP} value={Types.item_state.SALE_STOP}>{this.getStateShow(Types.item_state.SALE_STOP)}</option>,
        <option key={Types.item_state.SALE_LIMIT} value={Types.item_state.SALE_LIMIT}>{this.getStateShow(Types.item_state.SALE_LIMIT)}</option>
      ],

      item_state_limit: Types.item_limit_state.UNLIMIT,
      item_state_limit_show: this.getLimitStateShow(Types.item_limit_state.UNLIMIT),
      item_state_limit_list: [
        <option key={Types.item_limit_state.UNLIMIT} value={Types.item_limit_state.UNLIMIT}>{this.getLimitStateShow(Types.item_limit_state.UNLIMIT)}</option>,
        <option key={Types.item_limit_state.LIMIT} value={Types.item_limit_state.LIMIT}>{this.getLimitStateShow(Types.item_limit_state.LIMIT)}</option>
      ],

      item_file_upload_state: Types.file_upload_state.NONE,
      item_file_upload_state_show: this.getFileUploadStateShow(Types.file_upload_state.NONE),
      item_file_upload_state_list: [
        <option key={Types.file_upload_state.NONE} value={Types.file_upload_state.NONE}>{this.getFileUploadStateShow(Types.file_upload_state.NONE)}</option>,
        <option key={Types.file_upload_state.IMAGE} value={Types.file_upload_state.IMAGE}>{this.getFileUploadStateShow(Types.file_upload_state.IMAGE)}</option>,
        <option key={Types.file_upload_state.FILES} value={Types.file_upload_state.FILES}>{this.getFileUploadStateShow(Types.file_upload_state.FILES)}</option>,
      ],

      item_product_state: Types.product_state.FILE,
      item_product_state_show: this.getProductStateShow(Types.product_state.FILE),
      item_product_state_list: [
        <option key={Types.product_state.FILE} value={Types.product_state.FILE}>{this.getProductStateShow(Types.product_state.FILE)}</option>,
        <option key={Types.product_state.TEXT} value={Types.product_state.TEXT}>{this.getProductStateShow(Types.product_state.TEXT)}</option>,
        <option key={Types.product_state.ONE_TO_ONE} value={Types.product_state.ONE_TO_ONE}>{this.getProductStateShow(Types.product_state.ONE_TO_ONE)}</option>,
      ],

      item_product_category_type: Types.product_categorys[0].type,
      item_product_category_type_show: Types.product_categorys[0].text,
      item_product_category_type_list: _item_product_category_type_list,

      order_limit_count: 0,
      ori_order_limit_count: 0,

      contentType: '',
      imageBinary: '',

      isChangeImg: false,

      file: '',
      show_image: '',
      temp_image: '',
      show_image_width: 0,
      show_image_height: 0,

      img_compress_progress: 0,
      item_notice: '',

      youtube_url: '',

      isShowImageCroper: false,

      is_check_agree_download_type: false,

      select_top_id: null,
      select_sub_id: null,

      currency_code: Types.currency_code.Won
    }

    // this.onDrop = this.onDrop.bind(this);
    this.onChangeSelect = this.onChangeSelect.bind(this);
    this.onChangeSelectLimit = this.onChangeSelectLimit.bind(this);
    this.onChangeFileupload = this.onChangeFileupload.bind(this);
    this.onChangeProductState = this.onChangeProductState.bind(this);

    this.handleImageUpload = this.handleImageUpload.bind(this);
    this.uploadFiles = this.uploadFiles.bind(this);
  };

  componentDidMount(){

    const myID = Number(document.querySelector('#myId').value);
    if(myID === 0){
      //ID값이 0이면 로그인 안함.
      alert("관리자만 접근 가능합니다.");
    }else{

      let store_id = document.querySelector('#store_id').value;
      if(store_id){
        store_id = Number(store_id);
        axios.post("/store/any/info/storeid", {
          store_id: store_id
        }, (result) => {
          this.initAddItemPage(result.data.store_user_id);
        }, (error) => {

        })
      }else{
        this.initAddItemPage(myID);
      }      
    }
  };

  componentWillUnmount(){
    imageFileUploaderRef = null;
    fileInputRef = null;
    completedFileUploaderRef = null;
  };

  componentDidUpdate(){
  }

  initAddItemPage(store_user_id){
    axios.post("/store/info/userid", {
      store_user_id: store_user_id
    }, 
    (result) => {
      const pageState = document.querySelector('#add_item_page_state').value;
      let item_id = document.querySelector('#item_id').value;
      if(item_id){
        item_id = Number(item_id);
      }
      if(pageState === 'ADD_PAGE_STATE_EDIT'){
        axios.post("/store/any/info/itemid", {
          store_item_id: item_id
        }, (result_item) => {
          if(result_item.data.store_id !== result.data.store_id){
            alert("주인장이 아닙니다!");
            return;
          }

          

          this.setState({
            store_user_id: store_user_id,
            store_id: result.data.store_id,
            item_id: item_id,
            pageState: pageState,
            isLogin: true
          }, () => {
            this.requestItemInfo();
          })

        }, (error_item) => {

        });

      }else{
        this.setState({
          store_user_id: store_user_id,
          store_id: result.data.store_id,
          item_id: null,
          pageState: pageState,
          isLogin: true
        }, () => {
          this.requestItemInfo();
        })
      }
    }, (error) => {

    })
  }

  getStateShow(item_state){
    if(item_state === Types.item_state.SALE){
      return '판매 중';
    }
    else if(item_state === Types.item_state.SALE_PAUSE){
      return '판매 일시중지';
    }
    else if(item_state === Types.item_state.SALE_LIMIT){
      return '품절(강제 선택 불가)';
    }
    else{
      return '판매 중단 및 비공개';
    }
  }

  getLimitStateShow(item_state_limit){
    if(item_state_limit === Types.item_limit_state.UNLIMIT){
      return '제한없음';
    }
    else if(item_state_limit === Types.item_limit_state.LIMIT){
      return '일주일에 판매 가능한 수량 설정';
    }
    else{
      return '제한없음';
    }
  }

  getFileUploadStateShow(state){
    if(state === Types.file_upload_state.NONE){
      return '받지 않음';
    }
    else if(state === Types.file_upload_state.IMAGE){
      return '이미지';
    }
    else if(state === Types.file_upload_state.FILES){
      return '영상, 사운드, 기타 파일';
    }
    else{
      return '받지 않음';
    }
  }

  getProductStateShow(state){
    if(state === Types.product_state.TEXT){
      return '텍스트 상품';
    }
    else if(state === Types.product_state.FILE){
      return '영상 및 이미지 상품';
    }
    else if(state === Types.product_state.ONE_TO_ONE){
      return '1:1 채팅 및 통화 등 실시간 상품';
    }
    else{
      return '텍스트 상품';
    }
  }

  getProductCategoryTypeShow = (type) => {
    
    const categoryData = Types.product_categorys.find((_value) => {return _value.type === type});
    if(categoryData === undefined){
      return '';
    }

    return categoryData.text;
  }

  requestItemInfo(){
    if(this.state.pageState === Types.add_page_state.ADD){
      return;
    }

    if(!this.state.item_id){
      alert("아이템 id 정보 에러");
      return;
    }

    axios.post('/store/any/item/info', {
      store_item_id: this.state.item_id
    }, (result) => {

      let limitType = Types.item_limit_state.UNLIMIT;
      
      if(result.data.order_limit_count > 0){
        // item_state_limit
        limitType = Types.item_limit_state.LIMIT;
      }

      let _ask_play_time = result.data.ask_play_time;
      if(_ask_play_time === null){
        _ask_play_time = '';
      }

      let _item_notice = result.data.item_notice;
      if(_item_notice === null){
        _item_notice = '';
      }

      let _item_youtube_url = result.data.youtube_url;
      if(_item_youtube_url === null){
        _item_youtube_url = '';
      }


      let _product_category_type = result.data.product_category_type;
      let _product_category_type_show = this.getProductCategoryTypeShow(_product_category_type);
      if(_product_category_type === null){
        const categoryData = Types.product_categorys.find((value) => {return value.product_state === result.data.product_state});

        _product_category_type = categoryData.type;
        _product_category_type_show = categoryData.text;
      }
      
      this.setState({
        item_ask_play_time: _ask_play_time,
        item_title: result.data.title,
        item_content: result.data.content,
        item_img_url: result.data.img_url,
        item_price: result.data.price,
        item_ask: result.data.ask,
        item_state: result.data.state,
        item_state_show: this.getStateShow(result.data.state),

        item_state_limit: limitType,
        item_state_limit_show: this.getLimitStateShow(limitType),
        order_limit_count: result.data.order_limit_count,
        ori_order_limit_count: result.data.order_limit_count,

        item_file_upload_state: result.data.file_upload_state,
        item_file_upload_state_show: this.getFileUploadStateShow(result.data.file_upload_state),

        item_product_state: result.data.product_state,
        item_product_state_show: this.getProductStateShow(result.data.product_state),

        item_product_category_type: _product_category_type,
        item_product_category_type_show: _product_category_type_show,

        show_image: result.data.img_url,

        item_notice: _item_notice,

        youtube_url: _item_youtube_url,
        item_type_contents: result.data.type_contents,
        item_product_answer: result.data.completed_type_product_answer,

        select_top_id: result.data.category_top_item_id,
        select_sub_id: result.data.category_sub_item_id,

        currency_code: result.data.currency_code,

        item_price_usd: result.data.price_USD
      })
    }, (error) => {

    })
  }

  onChangeInput(e, type){
    e.preventDefault();

    if(type === INPUT_STORE_MANAGER_ADD_ITEM_TITLE){
      this.setState({
        item_title: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_ADD_ITEM_CONTENT){
      this.setState({
        item_content: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_ADD_ITEM_PRICE){
      if(e.target.value < 0){
        return;
      }
      this.setState({
        item_price: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_ADD_ITEM_ASK){
      this.setState({
        item_ask: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_LIMIT_COUNT){
      this.setState({
        order_limit_count: e.target.value
      })
    }else if(type === INPUT_STORE_MANAGER_ADD_ITEM_ASK_PLAY_TIME){
      this.setState({
        item_ask_play_time: e.target.value
      })
    }else if(type === INPUT_STORE_MANAGER_ADD_ITEM_NOTICE){
      this.setState({
        item_notice: e.target.value
      })
    }else if(type === INPUT_STORE_MANAGER_ADD_ITEM_YOUTUBE_URL){
      this.setState({
        youtube_url: e.target.value
      })
    }else if(type === TEXTAREA_STORE_MANAGER_ADD_ITEM_SELLER_ANSWER){
      this.setState({
        item_product_answer: e.target.value
      })
    }
  }

  onChangeSelect(event){
    // event.target.value
    
    let _item_state_show = ''
    let value = Number(event.target.value);

    _item_state_show = this.getStateShow(value);

    if(this.state.item_state === Types.item_state.SALE_LIMIT){

      if(this.state.item_state_limit === Types.item_limit_state.LIMIT && value === Types.item_state.SALE){
        // alert('[품절] 상태에선 [판매중] 변경이 불가능합니다. 판매를 원하시면 [판매 수량 제한 옵션]을 변경해주세요.');
        axios.post("/store/item/soldout/check", {
          order_limit_count: this.state.order_limit_count,
          item_id: this.state.item_id
        }, (result) => {
          if(result.isSoldOut){
            alert('품절된 상품입니다. 판매하기 원하시면 제한 수를 늘려주세요.');
            return;
          }

          this.setState({
            item_state: value,
            item_state_show: _item_state_show
          })
        }, (error) => {

        })

        return;
      }
    }

    if(value === Types.item_state.SALE_LIMIT){
      alert("[품절] 상태론 변경이 불가능합니다.");
      return;
    }

    this.setState({
      item_state: value,
      item_state_show: _item_state_show
    })
  }

  onChangeSelectLimit(event){
    this.setState({
      item_state_limit: event.target.value,
      item_state_limit_show: this.getLimitStateShow(event.target.value)
    })
  }

  onChangeFileupload(event){
    const value = Number(event.target.value);
    this.setState({
      item_file_upload_state: value,
      item_file_upload_state_show: this.getFileUploadStateShow(value)
    })
  }

  onChangeProductState(event){
    const value = Number(event.target.value);
    this.setState({
      item_product_state: value,
      item_product_state_show: this.getProductStateShow(value)
    })
  }

  onChangeProductCategoryType = (event) => {
    const value = event.target.value;
    
    const categoryData = Types.product_categorys.find((_value) => {return _value.type === value});
    this.setState({
      item_product_category_type: value,
      item_product_category_type_show: categoryData.text,

      item_product_state: categoryData.product_state
    })
  }

  clickPhotoAdd(e){
    e.preventDefault();

    this.fileInputRef.click();
    // document.querySelector('.chooseFileButton').click();
  }

  clickContentsOk(e){
    e.preventDefault();

    if(this.state.show_image === null || this.state.show_image === undefined || this.state.show_image === ''){
      alert("상품의 이미지를 등록해주세요");
      return;
    }

    if(this.state.item_title === ''){
      alert("콘텐츠명을 입력해주세요");
      return;
    }
    
    if(this.state.item_price === ''){
      alert("콘텐츠 가격을 입력해주세요");
      return;
    }
    
    if(this.state.item_content === ''){
      alert("콘텐츠 설명을 입력해주세요");
      return;
    }
    
    if(this.state.item_ask === ''){
      if(this.state.item_type_contents === Types.contents.customized){
        alert("구매 요청사항을 적어주세요");
        return;
      }
    }
    
    if(this.state.item_price < 0){
      alert("0원 이상의 가격으로 입력해주세요.");
      return;
    }
    
    if(this.state.select_sub_id === null){
      alert('콘텐츠의 카테고리를 선택해주세요!');
      return;
    }

    // if(this.state.item_product_state === Types.product_state.ONE_TO_ONE){
    //   if(this.state.item_ask_play_time === null || this.state.item_ask_play_time === ''){
    //     alert("1:1 상품은 반드시 진행 가능 시간을 작성해야 합니다.");
    //     return;
    //   }
    // }

    if(this.state.youtube_url !== ''){
      if(!Util.matchYoutubeUrl(this.state.youtube_url)){
        alert("올바른 유투브 url 을 입력해주세요");
        return;
      }
    }

    // let order_limit_count = this.state.order_limit_count;
    if(this.state.item_state_limit === Types.item_limit_state.LIMIT){
      if(!this.state.order_limit_count || this.state.order_limit_count <= 0){
        alert("판매 수량을 1개 이상 입력해주세요. 판매를 중단 하고 싶으시면 하단의 판매상태 옵션을 이용해주세요.");
        return;
      }
    }

    if(this.state.item_type_contents === Types.contents.completed){
      if(this.completedFileUploaderRef.getData().length === 0){
        alert('완성형 콘텐츠는 콘텐츠 파일이 1개 이상 등록 되어야 합니다.');
        return;
      }

      if(!this.state.is_check_agree_download_type){
        alert('정산 보류 동의에 체크 해야 합니다');
        return;
      }
    }

    this.requestSetItemInfo();
  }

  requestSetItemInfo = () => {
    let order_limit_count = this.state.order_limit_count;
    if(this.state.item_state_limit === Types.item_limit_state.LIMIT){
      if(!this.state.order_limit_count || this.state.order_limit_count <= 0){
        alert("판매 수량을 1개 이상 입력해주세요. 판매를 중단 하고 싶으시면 하단의 판매상태 옵션을 이용해주세요.");
        return;
      }
    }
    else{
      order_limit_count = 0;
    }

    if(this.state.pageState === Types.add_page_state.ADD){
      showLoadingPopup('등록중입니다..');

      axios.post("/store/item/add", {
        store_id: this.state.store_id,
        price: this.state.item_price,
        state: this.state.item_state,
        title: this.state.item_title,
        img_url: this.state.item_img_url,
        content: this.state.item_content,
        ask: this.state.item_ask,

        order_limit_count: order_limit_count,

        file_upload_state: this.state.item_file_upload_state,

        product_state: this.state.item_product_state,
        product_category_type: this.state.item_product_category_type,

        ask_play_time: this.state.item_ask_play_time,

        item_notice: this.state.item_notice,

        youtube_url: this.state.youtube_url,

        completed_type_product_answer: this.state.item_product_answer,
        type_contents: this.state.item_type_contents,

        category_top_item_id: this.state.select_top_id,
        category_sub_item_id: this.state.select_sub_id
      }, (result) => {
        this.nextFileCheck(result.item_id);
      }, (error) => {
        stopLoadingPopup();
        // alert("에러");
      })
    }else if(this.state.pageState === Types.add_page_state.EDIT){

      let isChangeLimitCount = false;
      if(this.state.order_limit_count !== this.state.ori_order_limit_count){
        isChangeLimitCount = true;
      }

      showLoadingPopup('수정중입니다..');
      axios.post('/store/item/update', {
        store_id: this.state.store_id,
        price: this.state.item_price,
        state: this.state.item_state,
        title: this.state.item_title,
        // img_url: this.state.item_img_url,
        content: this.state.item_content,
        ask: this.state.item_ask,
        item_id: this.state.item_id,

        order_limit_count: order_limit_count,
        isChangeLimitCount: isChangeLimitCount,

        file_upload_state: this.state.item_file_upload_state,
        product_state: this.state.item_product_state,

        product_category_type: this.state.item_product_category_type,

        ask_play_time: this.state.item_ask_play_time,
        item_notice: this.state.item_notice,

        youtube_url: this.state.youtube_url,

        completed_type_product_answer: this.state.item_product_answer,
        type_contents: this.state.item_type_contents,

        category_top_item_id: this.state.select_top_id,
        category_sub_item_id: this.state.select_sub_id
      }, (result_update) => {

        this.nextFileCheck(this.state.item_id);
      }, (error_update) => {
        stopLoadingPopup();
        // alert("에러");
      })
    }
  }

  nextFileCheck = (item_id) => {
    this.imageFileUploaderRef.setItems_imgsData(item_id, () => {

      if(this.completedFileUploaderRef.current === null){
        // this.complitePopup();
        if(!this.state.isChangeImg){
          this.complitePopup();
          return;
        }
    
        if(this.state.imageBinary === ''){
          this.complitePopup();
          return;
        }
  
        this.uploadFiles(item_id, Types.file_upload_target_type.items);
        
      }else{
        this.completedFileUploaderRef.setFiles_DownloadIDData(item_id, () => {
          if(!this.state.isChangeImg){
            this.complitePopup();
            return;
          }
      
          if(this.state.imageBinary === ''){
            this.complitePopup();
            return;
          }
    
          this.uploadFiles(item_id, Types.file_upload_target_type.items);
        }, () => {
          stopLoadingPopup();
        })
      }
      
    }, () => {
      stopLoadingPopup();
    })
  }

  /*
  nextFileCheck = (item_id) => {
    this.imageFileUploaderRef.setItems_imgsData(item_id, () => {
      if(!this.state.isChangeImg){
        this.complitePopup();
        return;
      }
  
      if(this.state.imageBinary === ''){
        // stopLoadingPopup();
        // this.showEditPopup();
        this.complitePopup();
        return;
      }

      this.uploadFiles(item_id, Types.file_upload_target_type.items);
    }, () => {
      stopLoadingPopup();
    })
  }
  */

  complitePopup = () => {
    stopLoadingPopup();
    if(this.state.pageState === Types.add_page_state.ADD){
      swal("등록완료", "", "success").then(() => {
        this.goBack();
      });

    }else{
      swal("수정완료!", "", "success").then(() => {
        if(this.completedFileUploaderRef.current !== null){
          this.completedFileUploaderRef.isRefresh();
        }
      });
    }
  }

  uploadFiles = (item_id, target_type) => {
    if(!target_type){
      return;
    }

    const file = this.state.imageBinary;
    let data = new FormData();
    data.append('target_id', item_id);
    data.append('target_type', target_type);

    data.append("blob", file, file.name);
    
    // return;
    
    const options = {
      header: { "content-type": "multipart/form-data" },
      // onUploadProgress: (progressEvent) => {
      //   const {loaded, total} = progressEvent;
      //   let percent = Math.floor( (loaded * 100) / total);
      //   // console.log(`${loaded}kb of ${total}kb | ${percent}%`);
      //   this.setState({
      //     uploading_progress: percent
      //   })
      // }
    }
    
    let apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_REAL;
    const app_type_key = document.querySelector('#g_app_type');
    if(app_type_key){
      if(app_type_key.value === 'local'){
        apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_local;
      }else if(app_type_key.value === 'qa'){
        apiURL = process.env.REACT_APP_UPLOAD_API_SERVER_QA;
      }
    }

    _axios.post(`${apiURL}/uploader/files/item/img`, data, options).then((res) => {
      // console.log(res);

      this.complitePopup();
      // stopLoadingPopup();
      // if(this.state.pageState === Types.add_page_state.ADD){
      //   swal("등록완료!", '', 'success');
      // }else{
      //   this.showEditPopup();
      // }
      
    }).catch((error) => {
      stopLoadingPopup();
      alert('이미지 저장 에러');
    })
  }

  clickBackButton(e){
    e.preventDefault();

    this.goBack();
  }
  goBack(){
    let url_tail = '';
    if(this.state.alias){
      url_tail = this.state.alias;
    }else{
      url_tail = this.state.store_id;
    }

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      baseURL = baseURLDom.value;
    }
    
    let hrefURL = baseURL+'/manager/store/?menu=TAB_ITEM_MANAGER';
    const isAdmin = document.querySelector('#isAdmin').value;
    if(isAdmin){
      hrefURL = baseURL+'/admin/manager/store/'+this.state.store_id+'/?menu=TAB_ITEM_MANAGER';
    }

    const go_back_edit_page = document.querySelector('#go_back_edit_page').value;
    if(go_back_edit_page){
      hrefURL = baseURL+'/item/store/'+this.state.item_id;
    }
    
    window.location.href = hrefURL;
  }

  onInputClick = (event) => {
    event.target.value = ''
  }

  uploadFile = ({target: {files}}) => {
    // console.log(files)

    const file = files[0];

    // centerImage
    var reader = new FileReader();
    reader.onload = (e) => {
      const imagePreview = e.target.result;

      this.setState({
        file: file,
        show_image: imagePreview
      })
    };

    reader.readAsDataURL(file);
  }

  handleImageUpload = (event) => {
 
    var imageFile = event.target.files[0];

    let contentType = imageFile.type;
   
    var options = {
      maxSizeMB: 2,
      maxWidthOrHeight: 1920,
      useWebWorker: true,

      onProgress: (value) => {
        let _value = value;
        if(value === 100){
          _value = 0
        }

        this.setState({
          img_compress_progress: _value
        })
      } 
    }

    imageCompression(imageFile, options)
      .then( (compressedFile) => {

        var reader = new FileReader();
        reader.onload = (e) => {
          const imagePreview = e.target.result;

          this.setState({
            // file: compressedFile,
            temp_image: imagePreview,
            isShowImageCroper: true
          })
        };

        reader.readAsDataURL(compressedFile);
      })
      .catch( (error) => {
        alert(error.message);
        return;
        // console.log(error.message);
      });
  }

  onImgLoad = (img) => {
    let show_image_width = img.target.offsetWidth;
    let show_image_height = img.target.offsetHeight;
    
    //가로로 긴 이미지인가?
    //세로가 긴 이미지는 width 만 맞추면 height는 자동 맞춰짐
    if(img.target.offsetWidth > img.target.offsetHeight){
      //가로가 긴 이미지
      //세로 비율을 찾는다
      const ratio = IMAGE_FILE_WIDTH / img.target.offsetHeight;

      const imgReSizeWidth = img.target.offsetWidth * ratio;
      const imgReSizeHeight = img.target.offsetHeight * ratio;

      
      show_image_width = imgReSizeWidth,
      show_image_height = imgReSizeHeight
      
    }

    this.setState({
      show_image_width: show_image_width,
      show_image_height: show_image_height
    })
  }

  setThumbImage = (imageData) => {
    var reader = new FileReader();
      reader.onload = (e) => {
        const imagePreview = e.target.result;

        this.setState({
          show_image: imagePreview,
          temp_image: '',
          imageBinary: imageData,
          // contentType: contentType,
          isChangeImg: true,

          show_image_width: 0,
          show_image_height: 0,

          isShowImageCroper: false
        })
      };

    reader.readAsDataURL(imageData);
  }

  setTypeContents = (type_contents) => {
    if(this.state.pageState === Types.add_page_state.EDIT){
      alert('에러! 선택이 불가능 합니다. 새로고침 해주세요');
      return;
    }

    this.setState({
      item_type_contents: type_contents
    }, () => {

      let productCategoryType = {
        target: {
          value: 'video'
        }
      }

      let fileupload = {
        target: {
          value: Types.file_upload_state.NONE
        }
      }

      let selectLimit = {
        target: {
          value: Types.item_limit_state.UNLIMIT
        }
      }

      if(this.state.item_type_contents === Types.contents.completed){
        productCategoryType = {
          target: {
            value: 'download'
          }
        }

        fileupload = {
          target: {
            value: Types.file_upload_state.NONE
          }
        }

        selectLimit = {
          target: {
            value: Types.item_limit_state.UNLIMIT
          }
        }
      }

      this.onChangeFileupload(fileupload);
      this.onChangeProductCategoryType(productCategoryType);
      this.onChangeSelectLimit(selectLimit);
    })
  }

  onClickTypeContents = (e, type_contents) => {
    e.preventDefault();

    this.setTypeContents(type_contents);
  }

  onClickAgree = (e) => {
    e.preventDefault();

    let isAgree = this.state.is_check_agree_download_type;
    if(isAgree){
      isAgree = false;
    }else{
      isAgree = true;
    }

    this.setState({
      is_check_agree_download_type: isAgree
    })
  }

  render(){
    if(!this.state.isLogin){
      return(
        <div>
          관리자만 접근 가능합니다.
        </div>
      )
    }

    let pageTitle = '';
    let buttonText = '';
    if(this.state.pageState === Types.add_page_state.ADD){
      pageTitle = '상품등록';
      buttonText = '등록하기';
    }else{
      pageTitle = '상품수정';
      buttonText = '수정하기';
    }

    let photoThumbImg = <></>;

    if(this.state.show_image){
      let imageStyle = {}
      if(this.state.show_image_width > 0){
        imageStyle = {
          width:this.state.show_image_width,
          height: this.state.show_image_height,
        }
      }

      photoThumbImg = <img style={imageStyle} onLoad={(img) => {this.onImgLoad(img)}} className={'camera_img'} src={this.state.show_image} />;
    }

    let limitCountDom = <></>;
    if(this.state.item_state_limit === Types.item_limit_state.LIMIT){
      limitCountDom = <div>
                        <div className={'input_label'} style={{marginTop: 20}}>
                          판매 가능 수량
                        </div>
                        <input className={'input_box'} type="number" name={'limit_count'} placeholder={'일주일에 판매 가능한 수량을 입력해주세요.'} value={this.state.order_limit_count} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_LIMIT_COUNT)}}/>
                        <div className={'limit_explain_text'}>
                          최대 판매 가능 수량까지 도달하면 판매 상태가 '품절'로 바뀝니다. 판매 수량은 매주 월요일 0시에 초기화되며, 자동으로 판매 상태가 '판매 중'으로 다시 바뀝니다.
                        </div>
                      </div>
    }

    let imgCompressValueText = '';
    if(this.state.img_compress_progress > 0){
      imgCompressValueText = this.state.img_compress_progress + '%';
    }

    let imageCroperDom = <></>;
    if(this.state.isShowImageCroper){
      imageCroperDom = <ImageCroper 
                        image={this.state.temp_image}
                        callbackExit={() => {
                          this.setState({
                            temp_image: '',
                            isShowImageCroper: false
                          })
                        }}
                        callbackConfirm={(imageData) => {
                          // this.setImageCompress(imageData);
                          this.setThumbImage(imageData);
                        }}>
                        </ImageCroper>
    }

    
    let radio_img_customized = null;
    let radio_img_completed = null;
    let isTypeContentsButtonDisabled = false;
    if(this.state.item_type_contents === Types.contents.customized){
      if(this.state.pageState === Types.add_page_state.ADD){
        radio_img_customized = ic_radio_pressed;
        radio_img_completed = ic_radio_unpressed;
      }else{
        isTypeContentsButtonDisabled = true;
        radio_img_customized = ic_radio_pressed_dis;
        radio_img_completed = ic_radio_unpressed_dis;
      }
    }else if(this.state.item_type_contents === Types.contents.completed){
      if(this.state.pageState === Types.add_page_state.ADD){
        radio_img_customized = ic_radio_unpressed;
        radio_img_completed = ic_radio_pressed;
      }else{
        isTypeContentsButtonDisabled = true;
        radio_img_customized = ic_radio_unpressed_dis;
        radio_img_completed = ic_radio_pressed_dis;
      }
    }

    let typeContentsDom = <div className={'type_contents_container'}>
                            <button onClick={(e) => {this.onClickTypeContents(e, Types.contents.customized)}} className={'type_contents_box'} disabled={isTypeContentsButtonDisabled}>
                              <img src={radio_img_customized} />
                              <div className={'type_contents_content_container'}>
                                <div className={'type_contents_label'}>
                                  맞춤제작 콘텐츠
                                </div>
                                <div className={'type_contents_explain_container'}>
                                  <img src={ic_info} />
                                  <div className={'type_contents_explain'}>
                                    주문이 들어오면 고객님의 요청사항에 맞춰 콘텐츠를 준비합니다.
                                  </div>
                                </div>
                              </div>
                            </button>
                            
                            <button onClick={(e) => {this.onClickTypeContents(e, Types.contents.completed)}} className={'type_contents_box type_contents_box_gap'} disabled={isTypeContentsButtonDisabled}>
                              <img src={radio_img_completed} />
                              <div className={'type_contents_content_container'}>
                                <div className={'type_contents_label'}>
                                  완성형 콘텐츠
                                </div>
                                <div className={'type_contents_explain_container'}>
                                  <img src={ic_info} />
                                  <div className={'type_contents_explain'}>
                                    미리 제작한 콘텐츠를 고객님이 주문 즉시 다운받을 수 있도록 합니다.
                                  </div>
                                </div>
                              </div>
                            </button>
                          </div>;


    let content_provision_form_dom = <></>;
    let buyer_request_form_dom = <></>;
    let receive_files_from_buyer = <></>;
    let sell_count_limite_dom = <></>;

    let seller_answer_dom = <></>;
    let completed_type_file_upload_dom = <></>;

    let completed_agree_check_dom = <></>;
    if(this.state.item_type_contents === Types.contents.customized){
      content_provision_form_dom = <div>
                                    <div className={'input_container'}>
                                      <div className={'input_label'}>
                                        콘텐츠 제공 형태
                                      </div>
                                      <div className={'necessary_dot'}>
                                      </div>
                                    </div>
                                    <div className={'select_box'}>
                                      {this.state.item_product_category_type_show}
                                      <img src={icon_box} />

                                      <select className={'select_tag'} value={this.state.item_product_category_type} onChange={this.onChangeProductCategoryType}>
                                        {this.state.item_product_category_type_list}
                                      </select>
                                    </div>
                                  </div>;

      //구매자 요청 폼
      buyer_request_form_dom = <div className={'box_container'}>
                                <div className={'box_label'}>구매자 요청 폼</div>

                                <div className={'input_container'}>
                                  <div className={'input_label'}>
                                    구매자 요청사항
                                  </div>
                                  <div className={'necessary_dot'}>
                                  </div>
                                </div>

                                <textarea className={'input_content_ask_textarea'} value={this.state.item_ask} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ADD_ITEM_ASK)}} placeholder={`콘텐츠 제공을 위해 구매자에게 받아야하는 정보나 주문관련 전하고 싶은 내용이 있다면 작성해주세요.\n\n예) '사진을 올려주세요', '주문은 ~~~ 이렇게 해주세요', '고민이나 사연을 알려주세요' 등`}></textarea>
                                
                              </div>

      //구매자에게 사진 또는 파일 받기
      receive_files_from_buyer = <div className={'box_container'}>
                                  <div className={'input_container'}>
                                    <div className={'input_label'}>
                                      구매자에게 사진 또는 파일 받기
                                    </div>
                                    <div className={'necessary_dot'}>
                                    </div>
                                  </div>

                                  <div className={'select_box'}>
                                    {this.state.item_file_upload_state_show}
                                    <img src={icon_box} />

                                    <select className={'select_tag'} value={this.state.item_file_upload_state} onChange={this.onChangeFileupload}>
                                      {this.state.item_file_upload_state_list}
                                    </select>
                                  </div>

                                  <div className={'limit_explain_text'}>
                                    구매자가 업로드 해야만 하는 파일 종류를 선택해주세요
                                  </div>
                                </div>;

      //판매 수량 제한
      sell_count_limite_dom = <div className={'box_container'}>
                                <div className={'input_container'}>
                                  <div className={'box_label'}>
                                    판매 수량 제한
                                  </div>
                                  <div className={'necessary_dot'}>
                                  </div>
                                </div>

                                <div className={'select_box'}>
                                  {this.state.item_state_limit_show}
                                  <img src={icon_box} />

                                  <select className={'select_tag'} value={this.state.item_state_limit} onChange={this.onChangeSelectLimit}>
                                    {this.state.item_state_limit_list}
                                  </select>
                                </div>

                                {limitCountDom}
                              </div>
    }
    else if(this.state.item_type_contents === Types.contents.completed){
      //판매자 인사 등록
      seller_answer_dom = <div className={'box_container'}>
                            <div className={'input_container'}>
                              <div className={'box_label'}>
                                판매자 인사 등록
                              </div>
                              {/* <div className={'necessary_dot'}>
                              </div> */}
                            </div>

                            <textarea className={'seller_answer_dom_textarea'} value={this.state.item_product_answer} onChange={(e) => {this.onChangeInput(e, TEXTAREA_STORE_MANAGER_ADD_ITEM_SELLER_ANSWER)}} placeholder={`구매자를 위한 감사 인사를 남겨주세요. 입력한 내용은 구매자의 주문결과창에 표시됩니다.`}></textarea>
                          </div>

      let isShowUploaderButton = false;
      if(this.state.pageState === Types.add_page_state.ADD){
        isShowUploaderButton = true;
      }

      completed_type_file_upload_dom = <div className={'box_container'}>
                                        <div className={'input_container'}>
                                          <div className={'box_label'}>
                                            콘텐츠 파일 등록
                                          </div>
                                          <div className={'necessary_dot'}>
                                          </div>
                                        </div>

                                        <CompletedFileUpLoader store_user_id={this.state.store_user_id} ref={(ref) => {this.completedFileUploaderRef = ref;}} store_item_id={this.state.item_id} isUploader={true} isShowUploaderButton={isShowUploaderButton}></CompletedFileUpLoader>
                                      </div>

      //동의 체크

      let checkImg = ic_check_unchecked;
      if(this.state.is_check_agree_download_type){
        checkImg = ic_check_checked;
      }

      completed_agree_check_dom = <button onClick={(e) => {this.onClickAgree(e)}} className={'complited_type_agree_container'}>
                                    <img style={{width: 20, height: 20}} src={checkImg} />
                                    <div className={'complited_type_agree_text'}>
                                      등록한 콘텐츠로 인해 저작권 및 법적 요구사항을 위반하는 문제 발생 시 정산이 보류될 수 있음에 동의합니다.
                                    </div>
                                  </button>
    }

    let priceTitleText = '콘텐츠 가격';
    let priceText = this.state.item_price;
    let priceInputDisabled = false;
    if(this.state.currency_code === Types.currency_code.US_Dollar){
      priceTitleText = '콘텐츠 가격(달러 - 해외 결제 베타 서비스 / 수정이 필요하면 크티로 연락주세요)';
      priceText = this.state.item_price_usd;
      priceInputDisabled = true;
    }

    return (
      <div className={'StoreAddItemPage'}>

        <div className={'page_title_text'}>
          {pageTitle}
        </div>

        <div className={'necessary_box'}>
          
          <div className={'necessary_dot'}>
          </div>
          
          <div className={'necessary_text'}>
            필수 항목입니다.
          </div>
        </div>

        <div className={'box_container'}>
          <div className={'input_container'}>
            <div className={'box_label'}>
              콘텐츠 유형
            </div>
            <div className={'necessary_dot'}>
            </div>
          </div>

          {typeContentsDom}
        </div>

        <div className={'box_container'}>
          <div className={'photo_upload_container'}>
            <div className={'box_label'}>
              대표 이미지
            </div>
            <div className={'necessary_dot'}>
            </div>
          </div>

          <div className={'flex_layer'} style={{marginTop: 15}}>
            <button onClick={(e) => {this.clickPhotoAdd(e)}} className={'camera_container'}>
              <div className={'camera_circle'}>
                <img src={icon_camera} />
              </div>
            </button>

            <div className={'camera_img_container'}>
              {photoThumbImg}
            </div>

            <input onClick={this.onInputClick} accept={'image/*'} ref={(ref) => {this.fileInputRef = ref}} type="file" className={'input_order_file_upload'} onChange={this.handleImageUpload} style={{display: 'none'}}/>
          </div>
          <div className={'limit_explain_text'}>
          {imgCompressValueText}
          </div>
        </div>

        <div className={'box_container'}>
          <div className={'box_label'}>기본 정보</div>

          <div className={'input_container'}>
            <div className={'input_label'}>
              콘텐츠명
            </div>
            <div className={'necessary_dot'}>
            </div>
          </div>
          <input className={'input_box'} type="text" name={'title'} placeholder={'콘텐츠를 짧은 한 문장으로 표현해주세요!'} value={this.state.item_title} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ADD_ITEM_TITLE)}}/>

          <div className={'input_container'}>
            <div className={'input_label'}>
              {/* 콘텐츠 가격 */}
              {priceTitleText}
            </div>
            <div className={'necessary_dot'}>
            </div>
          </div>
          <input className={'input_box'} type="number" name={'price'} placeholder={'콘텐츠 가격을 입력해주세요.'} value={priceText} disabled={priceInputDisabled} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ADD_ITEM_PRICE)}}/>
          
          <div className={'input_container'}>
            <div className={'input_label'}>
              콘텐츠 소개
            </div>
            <div className={'necessary_dot'}>
            </div>
          </div>
          <textarea className={'input_content_textarea'} value={this.state.item_content} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ADD_ITEM_CONTENT)}} placeholder={`판매 할 콘텐츠에 대한 소개를 작성해주세요!\n\n당장 소개가 떠오르지 않는다면 아래 예시와 같은 내용을 적어보는 건 어떨까요?\n\n- 콘텐츠 제공 형태 (파일 유형, 영상 길이, 이미지 사이즈, 진행 방식, 내용물, 특징 등)\n- 콘텐츠 기획 의도 및 준비 과정 소개\n- 작업 가능 범위\n- 콘텐츠 관련 팬들에게 전하고 싶은 말`}></textarea>

          <div className={'input_container'}>
            <div className={'input_label'}>
              콘텐츠 카테고리
            </div>
            <div className={'necessary_dot'}>
            </div>
          </div>
          <div style={{marginTop: 8}}>
            <Category_Selecter 
            item_type_contents={this.state.item_type_contents}
            default_category_sub_id={this.state.select_sub_id} 
            callback_select={(select_top_id, select_sub_id) => {
              this.setState({
                select_sub_id: select_sub_id,
                select_top_id: select_top_id
              })
            }}></Category_Selecter>
          </div>

          {content_provision_form_dom}

          <div className={'input_label'} style={{marginTop: 16}}>
            콘텐츠 소개용 영상 등록
          </div>
          <input className={'input_box'} type="text" name={'youtube_url'} placeholder={'콘텐츠 소개용 유튜브 영상 url을 넣어주세요'} value={this.state.youtube_url} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ADD_ITEM_YOUTUBE_URL)}}/>

          <div className={'input_label'} style={{marginTop: 16}}>
            콘텐츠 소개용 이미지 등록
          </div>

          <ImageFileUploader store_user_id={this.state.store_user_id} ref={(ref) => {this.imageFileUploaderRef = ref;}} store_item_id={this.state.item_id} isUploader={true}></ImageFileUploader>

          <div className={'input_container'}>
            <div className={'input_label'}>
              유의사항
            </div>
          </div>
          <textarea className={'input_content_textarea'} style={{height: 250}} value={this.state.item_notice} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ADD_ITEM_NOTICE)}} placeholder={`콘텐츠 관련하여 구매자에게 반드시 전해야 하는 유의사항이 있다면 작성해주세요.\n\n예) '콘텐츠의 제작과정이 유튜브에 업로드 될 수 있습니다', '저작권 위반 소지가 있는 작업은 어렵습니다' 등`}></textarea>

          
        </div>

        {buyer_request_form_dom}

        {receive_files_from_buyer}

        {sell_count_limite_dom}

        {completed_type_file_upload_dom}

        {seller_answer_dom}

        <div className={'box_container'}>
          <div className={'input_container'}>
            <div className={'box_label'}>
              판매상태
            </div>
            <div className={'necessary_dot'}>
            </div>
          </div>

          <div className={'select_box'}>
            {this.state.item_state_show}
            <img src={icon_box} />

            <select className={'select_tag'} value={this.state.item_state} onChange={this.onChangeSelect}>
              {this.state.item_state_list}
            </select>
          </div>
          {/* <div className={'limit_explain_text'}>
            일주일 이상 콘텐츠 요청을 받기 어려울 때는 판매 일시중지를 해주세요.
          </div> */}
        </div>

        {completed_agree_check_dom}

        <div className={'button_container'}>
          <button className={'button_back'} onClick={(e) => {this.clickBackButton(e)}}>
            돌아가기
          </button>
          <button className={'button_ok'} onClick={(e) => {this.clickContentsOk(e)}}>
            {buttonText}
          </button>
        </div>

        {imageCroperDom}
      </div>
    )
  }
};

export default StoreAddItemPage;