'use strict';

import React, { Component } from 'react';

import ImageUploader from "react-images-upload";

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
import Types from '../Types';

import icon_box from '../res/img/icon-box.svg';
import icon_camera from '../res/img/ic-camera-fill.svg';


//add_item_page_state
//ADD_PAGE_STATE_ADD
//ADD_PAGE_STATE_EDIT

const INPUT_STORE_MANAGER_ADD_ITEM_TITLE = "INPUT_STORE_MANAGER_ADD_ITEM_TITLE";
const INPUT_STORE_MANAGER_ADD_ITEM_CONTENT = "INPUT_STORE_MANAGER_ADD_ITEM_CONTENT";
const INPUT_STORE_MANAGER_ADD_ITEM_PRICE = "INPUT_STORE_MANAGER_ADD_ITEM_PRICE";
const INPUT_STORE_MANAGER_ADD_ITEM_ASK = "INPUT_STORE_MANAGER_ADD_ITEM_ASK";
const INPUT_STORE_MANAGER_LIMIT_COUNT = "INPUT_STORE_MANAGER_LIMIT_COUNT";

class StoreAddItemPage extends Component{

  constructor(props){
    super(props);

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
      item_ask: '',
      item_state: Types.item_state.SALE,

      item_state_show: '판매중',
      item_state_list: [
        <option key={Types.item_state.SALE} value={Types.item_state.SALE}>{'판매 중'}</option>,
        <option key={Types.item_state.SALE_PAUSE} value={Types.item_state.SALE_PAUSE}>{'판매 일시중지'}</option>,
        <option key={Types.item_state.SALE_STOP} value={Types.item_state.SALE_STOP}>{'판매 중단 및 비공개'}</option>,
        <option key={Types.item_state.SALE_LIMIT} value={Types.item_state.SALE_LIMIT}>{'품절(강제 선택 불가)'}</option>
      ],

      item_state_limit: Types.item_limit_state.UNLIMIT,
      item_state_limit_show: '무제한',
      item_state_limit_list: [
        <option key={Types.item_limit_state.UNLIMIT} value={Types.item_limit_state.UNLIMIT}>{'무제한'}</option>,
        <option key={Types.item_limit_state.LIMIT} value={Types.item_limit_state.LIMIT}>{'한주간 한정 수량 판매'}</option>
      ],

      item_file_upload_state: Types.file_upload_state.NONE,
      item_file_upload_state_show: '없음',
      item_file_upload_state_list: [
        <option key={Types.file_upload_state.NONE} value={Types.file_upload_state.NONE}>{'없음'}</option>,
        <option key={Types.file_upload_state.IMAGE} value={Types.file_upload_state.IMAGE}>{'이미지'}</option>,
        <option key={Types.file_upload_state.FILES} value={Types.file_upload_state.FILES}>{'영상, 사운드, 기타 파일'}</option>,
      ],

      order_limit_count: 0,
      ori_order_limit_count: 0,

      contentType: '',
      imageBinary: '',

      isChangeImg: false

    }

    this.onDrop = this.onDrop.bind(this);
    this.onChangeSelect = this.onChangeSelect.bind(this);
    this.onChangeSelectLimit = this.onChangeSelectLimit.bind(this);
    this.onChangeFileupload = this.onChangeFileupload.bind(this);
  };

  onDrop(pictureFiles, pictureDataURLs) {
    // console.log(pictureFiles);
    // console.log(pictureDataURLs);

    let imgIndex = pictureDataURLs.length - 1;
    if(imgIndex < 0){
      imgIndex = 0;
    }

    let contentType = pictureFiles[imgIndex].type;
    
    this.setState({
      // pictures: this.state.pictures.concat(pictureFiles),
      item_img_url: pictureDataURLs[imgIndex],
      imageBinary: pictureDataURLs[imgIndex],
      contentType: contentType,
      isChangeImg: true
    }, () => {
      //test//
      // axios.post("/uploader/save/img", {
      //   target_id: 3,
      //   imageBinary: this.state.imageBinary,
      //   contentType: this.state.contentType,
      //   type: Types.save_img.item
      // }, (result) => {
      //   console.log(result);
      // }, (error) => {
      //   console.log(error);
      // })
    });
  }

  initData(){

  }

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

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
      // console.log(store_id);

      // this.requestLoginToken(myID);
      // store.dispatch(actions.setUserID(myID));
      
    }

    /*
    const myID = Number(document.querySelector('#myId').value);
    if(myID === 0){
      //ID값이 0이면 로그인 안함.
      alert("관리자만 접근 가능합니다.");
    }else{
      // this.requestLoginToken(myID);
      // store.dispatch(actions.setUserID(myID));
      axios.post("/store/info/userid", {
        // store_user_id: this.props.store_user_id
      }, 
      (result) => {

        const pageState = document.querySelector('#add_item_page_state').value;
        let item_id = document.querySelector('#item_id').value;
        if(item_id){
          item_id = Number(item_id);
        }

        this.setState({
          store_user_id: myID,
          store_id: result.data.store_id,
          item_id: item_id,
          pageState: pageState,
          isLogin: true
        }, () => {
          this.requestItemInfo();
        })
      }, (error) => {

      })
    }
    */
  };

  componentWillUnmount(){
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
          item_id: item_id,
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
      return '무제한';
    }
    else if(item_state_limit === Types.item_limit_state.LIMIT){
      return '한주간 한정 수량 판매';
    }
    else{
      return '무제한';
    }
  }

  getFileUploadStateShow(state){
    if(state === Types.file_upload_state.NONE){
      return '없음';
    }
    else if(state === Types.file_upload_state.IMAGE){
      return '이미지';
    }
    else if(state === Types.file_upload_state.FILES){
      return '영상, 사운드, 기타 파일';
    }
    else{
      return '없음';
    }
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

      // let file_upload_state = result.data.file_upload_state
      
      this.setState({
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
        item_file_upload_state_show: this.getFileUploadStateShow(result.data.file_upload_state)
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

  clickPhotoAdd(e){
    e.preventDefault();

    document.querySelector('.chooseFileButton').click();
  }

  clickContentsOk(e){
    e.preventDefault();

    if(this.state.item_title === ''){
      alert("콘텐츠명을 입력해주세요");
      return;
    }else if(this.state.item_price === ''){
      alert("콘텐츠 가격을 입력해주세요");
      return;
    }else if(this.state.item_content === ''){
      alert("콘텐츠 설명을 입력해주세요");
      return;
    }else if(this.state.item_ask === ''){
      alert("구매 요청사항을 적어주세요");
      return;
    }else if(this.state.item_price < 0){
      alert("0원 이상의 가격으로 입력해주세요.");
      return;
    }

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

        file_upload_state: this.state.item_file_upload_state
      }, (result) => {
        if(this.state.imageBinary === ''){
          stopLoadingPopup();
          swal("등록완료!", '', 'success');
          return;
        }

        axios.post("/uploader/save/img", {
          target_id: result.item_id,
          imageBinary: this.state.imageBinary,
          contentType: this.state.contentType,
          type: Types.save_img.item
        }, (result) => {
          stopLoadingPopup();


          swal("등록완료!", '', 'success');
        }, (error) => {
          stopLoadingPopup();
          // alert("에러");
        })
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

        file_upload_state: this.state.item_file_upload_state
      }, (result_update) => {
        if(!this.state.isChangeImg){
          stopLoadingPopup();
          this.showEditPopup();
          return;
        }

        if(this.state.imageBinary === ''){
          stopLoadingPopup();
          this.showEditPopup();
          return;
        }

        axios.post("/uploader/save/img", {
          target_id: this.state.item_id,
          imageBinary: this.state.imageBinary,
          contentType: this.state.contentType,
          type: Types.save_img.item
        }, (result) => {
          stopLoadingPopup();
          this.showEditPopup();
        }, (error) => {
          stopLoadingPopup();
          // alert("에러");
        })

      }, (error_update) => {
        stopLoadingPopup();
        // alert("에러");
      })
    }
  }

  showEditPopup(){
    swal("수정완료!", '', 'success');
    /*
    swal("수정완료!", {
      buttons: {
        nosave: {
          text: "더 수정하기",
          value: "close",
        },
        save: {
          text: "돌아가기",
          value: "back",
        },
      },
    })
    .then((value) => {
      switch (value) {
        case "back":
          {
            // this.goBack();
          }
          break;
        case "close":
          {

          }break;
      }
    });
    */
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
    
    window.location.href = hrefURL;
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
    if(this.state.item_img_url){
      photoThumbImg = <img className={'camera_img'} src={this.state.item_img_url} />;
    }

    let limitCountDom = <></>;
    if(this.state.item_state_limit === Types.item_limit_state.LIMIT){
      limitCountDom = <div>
                        <div className={'input_label'} style={{marginTop: 20}}>
                          주간 판매 제한 수
                        </div>
                        <input className={'input_box'} type="number" name={'limit_count'} placeholder={'일주일에 판매 가능한 수량을 입력해주세요.'} value={this.state.order_limit_count} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_LIMIT_COUNT)}}/>
                        <div className={'limit_explain_text'}>
                          일주일에 판매 가능한 수 입니다. 최대 수량에 도달하면 자동으로 판매가 일시중지되며, 판매 수량은 매주 월요일 0시에 초기화되어 다시 주문이 가능해집니다.
                        </div>
                      </div>
    }
    return (
      <div className={'StoreAddItemPage'}>
        <div className={'page_title_text'}>
          {pageTitle}
        </div>

        <div className={'box_container'} style={{marginTop: 0}}>
          <div className={'box_label'}>
            사진 업로드
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

            <ImageUploader
              withIcon={false}
              buttonText="Choose images"
              onChange={this.onDrop}
              imgExtension={[".jpg", ".gif", ".png", ".gif", ".jpeg"]}
              maxFileSize={5242880}
            />
          </div>
        </div>

        <div className={'box_container'}>
          <div className={'box_label'}>상품 정보</div>
          <div className={'input_label'} style={{marginTop: 10}}>
            콘텐츠명
          </div>
          <input className={'input_box'} type="text" name={'title'} placeholder={'콘텐츠명을 입력해주세요.'} value={this.state.item_title} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ADD_ITEM_TITLE)}}/>

          <div className={'input_label'} style={{marginTop: 20}}>
            콘텐츠 가격
          </div>
          <input className={'input_box'} type="number" name={'price'} placeholder={'콘텐츠 가격을 입력해주세요.'} value={this.state.item_price} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ADD_ITEM_PRICE)}}/>
          
          <div className={'input_label'}>
            콘텐츠 설명
          </div>
          <textarea className={'input_content_textarea'} value={this.state.item_content} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ADD_ITEM_CONTENT)}} placeholder={"콘텐츠의 설명을 입력해주세요."}></textarea>
          {/* <div className={'input_length_text'}>
            {this.state.item_content.length}/{this.state.maxLength}
          </div> */}
        </div>

        <div className={'box_container'}>
          <div className={'box_label'}>구매자 요청 폼</div>

          <div className={'input_label'}>
            구매자 요청사항
          </div>
          <textarea className={'input_content_ask_textarea'} value={this.state.item_ask} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ADD_ITEM_ASK)}} placeholder={"예시: \n 1. 이름을 써주세요"}></textarea>
          <div className={'input_ask_explain'}>
            구매자가 콘텐츠 주문시 보게 될 콘텐츠 신청 양식 텍스트입니다
          </div>
        </div>

        <div className={'box_container'}>
          <div className={'box_label'}>파일 업로드 옵션</div>

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
        </div>

        <div className={'box_container'}>
          <div className={'box_label'}>판매 수량 제한 옵션</div>

          <div className={'select_box'}>
            {this.state.item_state_limit_show}
            <img src={icon_box} />

            <select className={'select_tag'} value={this.state.item_state_limit} onChange={this.onChangeSelectLimit}>
              {this.state.item_state_limit_list}
            </select>
          </div>

          {limitCountDom}
        </div>

        <div className={'box_container'}>
          <div className={'box_label'}>판매상태</div>

          <div className={'select_box'}>
            {this.state.item_state_show}
            <img src={icon_box} />

            <select className={'select_tag'} value={this.state.item_state} onChange={this.onChangeSelect}>
              {this.state.item_state_list}
            </select>
          </div>
          <div className={'limit_explain_text'}>
            일주일 이상 콘텐츠 요청을 받기 어려울 때는 판매 일시중지를 해주세요.
          </div>
        </div>

        <div className={'button_container'}>
          <button className={'button_back'} onClick={(e) => {this.clickBackButton(e)}}>
            돌아가기
          </button>
          <button className={'button_ok'} onClick={(e) => {this.clickContentsOk(e)}}>
            {buttonText}
          </button>
        </div>

      </div>
    )
    // return(
    //   <>
    //   <div>
    //     상품 등록
    //   </div>
    //   <div>
    //     이미지 등록
    //   </div>
    //   <button onClick={() => {
    //     // chooseFileButton
    //     document.querySelector('.chooseFileButton').click();

    //   }}>
    //     이미지 추가 버튼
    //   </button>
      
    //   <img style={{width: 300, height: 300}} src={this.state.testImg} />
    //   <div>
    //     상품명
    //   </div>
    //   <div>
    //     콘텐츠 설명명
    //   </div>
    //   <button>상품 등록</button>
    //   </>
    // )
  }
};

export default StoreAddItemPage;