'use strict';

import React, { Component } from 'react';


// import { scale, verticalScale, moderateScale } from 'react-native-size-matters';
// import FontWeights from '@lib/fontWeights';

// import * as appKeys from '~/AppKeys';
import Util from '../lib/Util';
import axios from '../lib/Axios';

import { connect } from 'react-redux';

import Types from '../Types';

import StoreOrderItem from '../component/StoreOrderItem';

import icon_box from '../res/img/icon-box.svg';

import ic_checkbox_btn_s from '../res/img/ic-checkbox-btn-s.svg';
import ic_checkbox_btn_n from '../res/img/ic-checkbox-btn-n.svg';

import FileUploader from '../component/FileUploader';

import ic_radio_btn_n from '../res/img/radio-btn-n.svg'
import ic_radio_btn_s from '../res/img/radio-btn-s.svg'

import StorePlayTimePlan from '../component/StorePlayTimePlan';


// import * as GlobalKeys from '~/GlobalKeys';

//redux START
// import * as actions from '@actions/index';
// import { connect } from 'react-redux';
//redux END
// import Colors from '@lib/colors';
// import Types from '~/Types';

const INPUT_STORE_ORDER_NAME = "INPUT_STORE_ORDER_NAME";
const INPUT_STORE_ORDER_CONTACT = "INPUT_STORE_ORDER_CONTACT";
const INPUT_STORE_ORDER_EMAIL = "INPUT_STORE_ORDER_EMAIL";

const INPUT_STORE_ORDER_CARD_NUMBER = "INPUT_STORE_ORDER_CARD_NUMBER";
const INPUT_STORE_ORDER_CARD_YY = "INPUT_STORE_ORDER_CARD_YY";
const INPUT_STORE_ORDER_CARD_MM = "INPUT_STORE_ORDER_CARD_MM";
const INPUT_STORE_ORDER_CARD_BIRTH = "INPUT_STORE_ORDER_CARD_BIRTH";
const INPUT_STORE_ORDER_CARD_PW_TWODIGIT = "INPUT_STORE_ORDER_CARD_PW_TWODIGIT";

const INPUT_STORE_ORDER_REQUEST_CONTENTS = "INPUT_STORE_ORDER_REQUEST_CONTENTS";
// const INPUT_STORE_ORDER_CARD_PW_TWODIGIT = "";

class StoreOrderPage extends Component{

  // fileInput = React.createRef();
  fileUploaderRef = React.createRef();

  storePlayTimePlanRef = React.createRef();

  IMP = null;

  constructor(props){
    super(props);

    this.state = {
      pay_method: Types.pay_method.PAY_METHOD_TYPE_CARD,

      store_id: null,
      store_item_id: null,
      store_order_id: null,
      store_title: '',

      item_title: '',
      item_price: 0,
      item_content: '',
      item_thumb_img_url: '',
      item_nick_name: '',
      item_ask: '',
      item_file_upload_state: Types.file_upload_state.NONE,
      item_product_state: Types.product_state.TEXT,
      item_ask_play_time: '',

      isInitDeriveStateFromProps: false,
      user_id: null,
      name: '',
      contact: '',
      email: '',

      
      card_number : '',
      card_yy: '',
      card_mm: '',
      card_birth: '',
      card_pw_2digit: '',
      total_price: 0, //로컬에서 보내는 토탈 가격 정보와 서버 db 조회후 결제될 가격 정보가 일치하는지 체크한다

      requestContent: '',

      selectYearValue: 'yyyy',
      selectMonthValue: 'mm',
      optionYears: [],
      optionMonth: [],

      selectShowYearValue: 'yyyy',
      selectShowMonthValue: 'mm',

      agreeArray: [
        // {
        //   type: Types.agree.all,
        //   name: '모두 동의',
        //   isCheck: false,
        //   link: ''
        // }, 
        {
          type: Types.agree.refund,
          name: '환불 정책',
          isCheck: false,
          link: ''
        }, 
        {
          type: Types.agree.terms_useInfo,
          name: '크티 이용약관',
          isCheck: false,
          link: 'https://crowdticket.kr/terms/app'
        }, 
        {
          type: Types.agree.third,
          name: '제3자 정보제공정책',
          isCheck: false,
          link: 'https://crowdticket.kr/thirdterms/app'
        }
      ],

      payMethodArray: [
        {
          pay_method: Types.pay_method.PAY_METHOD_TYPE_CARD,
          text: '신용카드 (ISP)'
        },
        {
          pay_method: Types.pay_method.PAY_METHOD_TYPE_CARD_INPUT,
          text: '신용카드 (직접입력)'
        }
      ]
    }

    this.handleSelectChangeYear = this.handleSelectChangeYear.bind(this);
    this.handleSelectChangeMonth = this.handleSelectChangeMonth.bind(this);
  };

  componentDidMount(){
    this.IMP = window.IMP; // 생략가능
    this.IMP.init(process.env.REACT_APP_IAMPORT_CODE); // 'iamport' 대신 부여받은 "가맹점 식별코드"를 사용

    const storeItemIDDom = document.querySelector('#store_item_id');
    if(storeItemIDDom){

      this.setState({
        store_item_id: Number(storeItemIDDom.value)
      }, function(){
        //아이템 정보 가져오기
        if(!isLogin())
        {
          // loginPopup(null, null);
          loginPopup(() => {
            if(isLogin()){
              swal.close();
              window.location.reload();
              // this.setState({
              //   isLogin: true
              // }, function(){
              //   swal.close();
              //   window.location.reload();
              // })
            }
          }, null);
          return;
        }else{
          axios.post("/user/info", {}, 
          (result) => {
            let name = result.userInfo.nick_name;
            if(!result.userInfo.nick_name || result.userInfo.nick_name === ''){
              name = result.userInfo.name
            }
            this.setState({
              name: name,
              email: result.userInfo.email,
              contact: result.userInfo.contact,
              user_id: result.userInfo.user_id
            }, () => {
              this.requestItemInfo()
            })
            

          }, (error) => {
            alert("로그인 정보가 없습니다. 다시 로그인 후 이용 부탁드립니다.");
            return;
          })
        }
      })
    }

    if (document.addEventListener) {
      window.addEventListener('pageshow', function (event) {
          if (event.persisted || window.performance && 
              window.performance.navigation.type == 2) 
          {
            console.log("BFCahe로부터 복원됨");
              // location.reload();
          }else{
            console.log("새로 열린 페이지");
          }
      },
     false);
    }

   let nowDate = new Date();
   let nowYear = nowDate.getFullYear();

   let _optionYears = [];
   let _optionMonth = [];

   _optionYears.push(<option key={-1} value={'yyyy'}>{'yyyy'}</option>);
   _optionMonth.push(<option key={-1} value={'mm'}>{'mm'}</option>);
   for(let i = nowYear+10 ; i > 1900 ; i--){
     let yearDom = <option key={i} value={i.toString()}>{i.toString()}</option>;
     _optionYears.push(yearDom);
   }

   for(let i = 1 ; i <= 12 ; i++){
     let value = i.toString(); 
     if(i < 10){
      value = '0'+value;
     }
     

     let monthDom = <option key={i} value={value}>{value}</option>;
     _optionMonth.push(monthDom);
   }

   this.setState({
    //  selectYearValue: nowYear,
    //  selectMonthValue: 12,
     optionYears: _optionYears.concat(),
     optionMonth: _optionMonth.concat()
   })
  };

  componentWillUnmount(){
    this.IMP = null;
  };

  componentDidUpdate(){
  }

  requestItemInfo(){
    axios.post('/store/any/item/info', {
      store_item_id: this.state.store_item_id
    }, (result) => {
      const data = result.data;

      let ask_play_time = data.ask_play_time;
      if(ask_play_time === null){
        ask_play_time = '';
      }

      this.setState({
        item_title: data.title,
        item_price: data.price,
        item_content: data.content,
        item_thumb_img_url: data.img_url,
        total_price: data.price,
        store_id: data.store_id,
        item_nick_name: data.nick_name,
        item_ask: data.ask,
        store_title: data.store_title,

        item_file_upload_state: data.file_upload_state,

        item_ask_play_time: ask_play_time,
        item_product_state: data.product_state
      })
    }, (error) => {

    })
  }

  requestUserInfo(){

  }

  isPassableOrder(){
    // let isOrder = true;

    if(this.state.store_item_id === null || this.state.store_item_id === undefined){
      alert("아이템 정보가 없습니다. 자동으로 새로고침 됩니다. 해당 이슈가 반복되는 경우 크티에 연락 바랍니다.");
      window.location.reload();
      return false
    }

    if(this.state.item_product_state === Types.product_state.ONE_TO_ONE){
      if(!this.storePlayTimePlanRef.isPassSelectTime()){
        alert("콘텐츠 진행 가능한 시간 최소 3개 이상을 선택해주세요");
        return false;
      }
    }

    if(this.state.requestContent === ''){
      alert('요청사항을 필수로 적어주세요');
      return false;
    }

    if(this.fileUploaderRef.getData().length === 0){
      if(this.state.item_file_upload_state === Types.file_upload_state.IMAGE){
        alert('이미지가 필수인 상품입니다. 상단의 콘텐츠 설명란을 참고해주세요.');
        return false;
      }else if(this.state.item_file_upload_state === Types.file_upload_state.FILES){
        alert('파일 혹은 이미지가 필수인 상품입니다. 상단의 콘텐츠 설명란을 참고해주세요.');
        return false;
      }
    }
    

    if(this.state.name === ''){
      // isOrder = false;
      alert('이름을 적어주세요');
      return false;
    }else if(this.state.contact === ''){
      // isOrder = false;
      alert('전화번호를 적어주세요');
      return false;
    }else if(this.state.email === ''){
      // isOrder = false;
      alert("이메일을 적어주세요");
      return false;
    }

    if(this.state.total_price === 0){

    }else{
      if(this.state.pay_method === Types.pay_method.PAY_METHOD_TYPE_CARD_INPUT){
        if(this.state.card_number === ''){
          // isOrder = false;
          alert("카드번호를 적어주세요");
          return false;
        }else if(this.state.card_yy === ''){
          // isOrder = false;
          alert("유효기간을 선택해주세요(년도)");
          return false;
        }else if(this.state.card_mm === ''){
          // isOrder = false;
          alert("유효기간을 선택해주세요(월)");
          return false;
        }else if(this.state.card_birth === ''){
          // isOrder = false;
          alert("생년월일 및 법인등록번호를 입력해주세요");
          return false;
        }else if(this.state.card_pw_2digit === ''){
          // isOrder = false;
          alert("카드 비밀번호 앞2자리를 입력해주세요");
          return false;
        }
      }
    }

    let isAllAgree = this.isAllAgree();
    if(!isAllAgree){
      // isOrder = false;
      alert("이용 정책에 동의 해주세요");
      return false;
    }
    

    return true
  }

  clickOrder(e){
    e.preventDefault();

    let isOrder = this.isPassableOrder();
    if(isOrder){
      this.requestCheckState();
    }
    
  }

  requestCheckState(){
    axios.post("/store/item/state/check", {
      store_item_id: this.state.store_item_id
    }, (result) => {
      // console.log(result);
      if(Number(result.item_state) === Types.item_state.SALE_LIMIT){
        swal("품절된 상품입니다.", '', 'error');
        return;
      }

      if(result.item_state === undefined){
        swal("** 구매오류. 죄송합니다. 재로그인(로그아웃->로그인) 후 이용해주세요.. 빠른 시일내에 수정하겠습니다. **", '', 'error');
        return;
      }

      if(Number(result.item_state) !== Types.item_state.SALE){
        // alert(result.item_state + '///' + Types.item_state.SALE + '///' + result + '##'+this.state.store_item_id);
        swal("판매중인 상품이 아닙니다.", '', 'error');
        return;
      }

      if(this.state.total_price === 0){
        this.requsetOrder();
      }else{
        if(this.state.pay_method === Types.pay_method.PAY_METHOD_TYPE_CARD_INPUT){
          this.requsetOrder();
        }else{
          // this.showIamportPayView();
          //isp는 모바일때문에 우선 order를 다셋팅 한 후 결제 시스템으로 들어간다.
          this.requestISPInsertStoreOrder();
        }
      }
      
      
    }, (error) => {

    })
  }

  showIamportPayView = (merchant_uid, store_order_id) => {
    if(this.IMP === null){
      alert("결제모듈 초기화 오류. 새로고침 후 이용해주세요.");
      return;
    }

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    const m_redirect_url = baseURL+'/store/isp/'+store_order_id+'/complite';
    console.log(m_redirect_url);

    this.IMP.request_pay({
      pg : 'nice', // version 1.1.0부터 지원.
      pay_method : Types.pay_method.PAY_METHOD_TYPE_CARD,
      merchant_uid : merchant_uid,
      name : this.state.item_title,
      amount : this.state.item_price,
      buyer_email : this.state.email,
      buyer_name : this.state.name,
      buyer_tel : this.state.contact,
      niceMobileV2 : true,
      m_redirect_url: m_redirect_url
    }, (rsp) => {
        if ( rsp.success ) {

          if(rsp.paid_amount !== this.state.total_price){
            alert("(에러)결제 가격과 구매 가격이 다릅니다.");
            return;
          }

          this.requestISPSuccess(rsp.imp_uid, rsp.merchant_uid, store_order_id);
        } else {
          this.requestISPError(rsp.imp_uid, rsp.merchant_uid, rsp.error_msg);
        }
    });
  }

  requestISPSuccess = (imp_uid, merchant_uid, store_order_id) => {
    showLoadingPopup('결제 완료중..');
    axios.post("/pay/store/isp/success", {
      imp_uid: imp_uid,
      merchant_uid: merchant_uid,
      order_id: store_order_id,
      pay_method: this.state.pay_method
    }, (result) => {
      axios.post("/pay/store/send/message", {
        store_order_id: store_order_id
      }, (result_message) => {
        stopLoadingPopup();
        this.nextOrderComplite(result.order_id);
      }, (error_message) => {
        stopLoadingPopup();
        this.nextOrderComplite(result.order_id);
      })
      
    }, (error) => {
      stopLoadingPopup();
      swal("결제 DB 에러", '결제 DB STATE 상태 변경 실패', 'error');
    })
  }

  requestISPError = (imp_uid, merchant_uid, error_msg) => {
    axios.post("/pay/store/isp/error", {
      imp_uid: imp_uid,
      merchant_uid: merchant_uid
    }, (result) => {
      swal("결제 실패", error_msg, 'error');
    }, (error) => {
      swal("결제 실패", error_msg, 'error');
    })
  }

  requestISPInsertStoreOrder = () => {
    if(this.IMP === null){
      alert("결제모듈 초기화 오류. 새로고침 후 이용해주세요.");
      return;
    }

    showLoadingPopup('결제창 요청중..');

    const merchant_uid = Util.getPayStoreNewMerchant_uid(this.state.store_id, this.state.user_id);

    axios.post("/pay/store/isp/iamport", {
      merchant_uid: merchant_uid,
      // imp_uid: imp_uid,

      store_id: this.state.store_id,
      item_id: this.state.store_item_id,
      
      total_price: this.state.total_price, //로컬에서 보내는 토탈 가격 정보와 서버 db 조회후 결제될 가격 정보가 일치하는지 체크한다
      title: this.state.item_title,
      contact: this.state.contact,
      email: this.state.email,
      name: this.state.name,
      requestContent: this.state.requestContent,
      pay_method: this.state.pay_method
    }, (result) => {
      // console.log(result);

      stopLoadingPopup();

      this.fileUploaderRef.uploadFiles(this.state.user_id, Types.file_upload_target_type.orders_items, 
      (result_upload_files) => {

        showLoadingPopup('결제창 요청중..');  

        let filesInsertID = [];
        for(let i = 0 ; i < result_upload_files.list.length ; i++){
          const data = result_upload_files.list[i];
          let _data = {
            file_id: data.insertId
          }
          
          filesInsertID.push(_data);
        }
        
        axios.post("/store/item/order/islast", {
          item_id: this.state.store_item_id,
          store_item_order_id: result.order_id
        }, (result_last_order) => {

          if(filesInsertID.length === 0){
            stopLoadingPopup();
            this.showIamportPayView(merchant_uid, result.order_id);
          }else{
            axios.post("/store/file/set/orderid", {
              store_order_id: result.order_id,
              filesInsertID: filesInsertID.concat()
            }, (result_files) => {
              stopLoadingPopup();
              this.showIamportPayView(merchant_uid, result.order_id);
            }, (error_files) => {
              stopLoadingPopup();
            })
          }
        }, (error) => {
          stopLoadingPopup();
        })
  
      }, (error_upload_files) => {
        alert('파일 업로드 실패. 새로고침 후 다시 시도해주세요.');
        return;
      });

    }, (error) => {
      stopLoadingPopup();
    })
  }

  requestAfterISPPay = (imp_uid, merchant_uid) => {
    showLoadingPopup('완료중입니다..');  

    axios.post("/pay/store/iamport", {
      merchant_uid: merchant_uid,
      imp_uid: imp_uid,

      store_id: this.state.store_id,
      item_id: this.state.store_item_id,
      
      total_price: this.state.total_price, //로컬에서 보내는 토탈 가격 정보와 서버 db 조회후 결제될 가격 정보가 일치하는지 체크한다
      title: this.state.item_title,
      contact: this.state.contact,
      email: this.state.email,
      name: this.state.name,
      requestContent: this.state.requestContent,
      pay_method: this.state.pay_method
    }, (result) => {
      // console.log(result);

      stopLoadingPopup();

      this.fileUploaderRef.uploadFiles(this.state.user_id, Types.file_upload_target_type.orders_items, 
      (result_upload_files) => {

        showLoadingPopup('완료중입니다..');  

        let filesInsertID = [];
        for(let i = 0 ; i < result_upload_files.list.length ; i++){
          const data = result_upload_files.list[i];
          let _data = {
            file_id: data.insertId
          }
          
          filesInsertID.push(_data);
        }
        
        axios.post("/store/item/order/islast", {
          item_id: this.state.store_item_id,
          store_item_order_id: result.order_id
        }, (result_last_order) => {

          if(filesInsertID.length === 0){
            stopLoadingPopup();
            this.nextOrderComplite(result.order_id);  
          }else{
            axios.post("/store/file/set/orderid", {
              store_order_id: result.order_id,
              filesInsertID: filesInsertID.concat()
            }, (result_files) => {
              stopLoadingPopup();
              this.nextOrderComplite(result.order_id);
            }, (error_files) => {
              stopLoadingPopup();
            })
          }
        }, (error) => {
          stopLoadingPopup();
        })      
  
      }, (error_upload_files) => {
        alert('파일 업로드 실패. 새로고침 후 다시 시도해주세요.');
        return;
      });

    }, (error) => {
      stopLoadingPopup();
    })
  }

  nextOrderComplite = (store_order_id) => {
    if(this.state.item_product_state === Types.product_state.ONE_TO_ONE){
      const event_play_times = this.storePlayTimePlanRef.getSelectTimes();
      axios.post("/store/eventplaytime/set", {
        store_order_id: store_order_id,
        event_play_times: event_play_times.concat()
      }, (result) => {
        this.goOrderComplite(store_order_id);
      }, (error) => {
        alert("시간 DB 셋팅 오류");
      })
    }else{
      this.goOrderComplite(store_order_id);
    }
  }

  goOrderComplite(order_id){
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      baseURL = baseURLDom.value;
    }

    let goURL = baseURL + '/complite/store/'+order_id;

    window.location.href = goURL;
  }

  requsetOrder(){

    let pay_method = Types.pay_method.PAY_METHOD_TYPE_CARD_INPUT;
    
    if(!this.state.store_id){
      alert("스토어 정보가 없습니다. 새로고침 해주세요.");
      return;
    }

    this.fileUploaderRef.uploadFiles(this.state.user_id, Types.file_upload_target_type.orders_items, 
    (result_upload_files) => {
      let filesInsertID = [];
      for(let i = 0 ; i < result_upload_files.list.length ; i++){
        const data = result_upload_files.list[i];
        let _data = {
          file_id: data.insertId
        }
        
        filesInsertID.push(_data);
      }

      showLoadingPopup('결제가 진행중입니다..');

      let _data = {
        store_id: this.state.store_id,
        item_id: this.state.store_item_id,
        card_number : this.state.card_number,
        card_yy: this.state.card_yy,
        card_mm: this.state.card_mm,
        card_birth: this.state.card_birth,
        card_pw_2digit: this.state.card_pw_2digit,
        total_price: this.state.total_price, //로컬에서 보내는 토탈 가격 정보와 서버 db 조회후 결제될 가격 정보가 일치하는지 체크한다
        title: this.state.item_title,
        contact: this.state.contact,
        email: this.state.email,
        name: this.state.name,
        requestContent: this.state.requestContent,
        pay_method: this.state.pay_method
        // merchant_uid: merchant_uid
      }

      axios.post('/pay/store/onetime', {..._data}, 
      (result) => {
        axios.post("/store/item/order/islast", {
          item_id: this.state.store_item_id,
          store_item_order_id: result.order_id
        }, (result_last_order) => {

          if(filesInsertID.length === 0){
            stopLoadingPopup();
            this.nextOrderComplite(result.order_id);  
          }else{
            axios.post("/store/file/set/orderid", {
              store_order_id: result.order_id,
              filesInsertID: filesInsertID.concat()
            }, (result_files) => {
              stopLoadingPopup();
              this.nextOrderComplite(result.order_id);
            }, (error_files) => {
              stopLoadingPopup();
            })
          }
        }, (error) => {
          stopLoadingPopup();
        })      
      },
      (error) => {
        stopLoadingPopup();
      });

    }, (error_upload_files) => {
      alert('파일 업로드 실패. 새로고침 후 다시 시도해주세요.');
      return;
    });
  }

  onChangeInput(e, type){
    e.preventDefault();
    
    if(type === INPUT_STORE_ORDER_CARD_NUMBER){
      if(e.target.value.length > 0 && !isCheckOnlyNumber(e.target.value)){
        alert("숫자만 입력해주세요. (공백 혹은 - 이 입력되었습니다.)")
        return;
      }

      this.setState({
        card_number: e.target.value
      })
    }
    else if(type === INPUT_STORE_ORDER_CARD_YY){
      this.setState({
        card_yy: e.target.value
      })
    }
    else if(type === INPUT_STORE_ORDER_CARD_MM){
      this.setState({
        card_mm: e.target.value
      })
    }
    else if(type === INPUT_STORE_ORDER_CARD_BIRTH){
      if(e.target.value.length > 0 && !isCheckOnlyNumber(e.target.value)){
        alert("숫자만 입력해주세요. (공백 혹은 - 이 입력되었습니다.)")
        return;
      }

      this.setState({
        card_birth: e.target.value
      })
    }
    else if(type === INPUT_STORE_ORDER_CARD_PW_TWODIGIT){
      this.setState({
        card_pw_2digit: e.target.value
      })
    }
    else if(type === INPUT_STORE_ORDER_NAME){
      this.setState({
        name: e.target.value
      })
    }
    else if(type === INPUT_STORE_ORDER_CONTACT){
      
      if(e.target.value.length > 0 && !isCheckPhoneNumber(e.target.value)){
        return;
      }

      this.setState({
        contact: e.target.value
      })
    }
    else if(type === INPUT_STORE_ORDER_EMAIL){
      this.setState({
        email: e.target.value
      })
    }
    else if(type === INPUT_STORE_ORDER_REQUEST_CONTENTS){
      this.setState({
        requestContent: e.target.value
      })
    }
  }

  handleSelectChangeYear(event){
    this.setState({
      card_yy: event.target.value,
      selectShowYearValue: event.target.value,
      selectYearValue: event.target.value
    })
  }

  handleSelectChangeMonth(event){
    this.setState({
      card_mm: event.target.value,
      selectShowMonthValue: event.target.value,
      selectMonthValue: event.target.value
    })
  }

  isAllAgree(){
    let isAllAgree = true;
    for(let i = 0 ; i < this.state.agreeArray.length ; i++){
      let agreeData = this.state.agreeArray[i];
      if(!agreeData.isCheck){
        isAllAgree = false;
        break;
      }
    }

    return isAllAgree;
  }

  clickAgree(e, type){
    e.preventDefault();

    let _agreeArray = this.state.agreeArray.concat();
    let agreeData = _agreeArray.find((value) => {
      return value.type === type;
    })

    if(!agreeData){
      alert('정책 동의 오류');
      return;
    }

    if(agreeData.isCheck){
      agreeData.isCheck = false;
    }else{
      agreeData.isCheck = true;
    }

    this.setState({
      agreeArray: _agreeArray.concat()
    })
  }

  clickAllAgree(e){
    e.preventDefault();

    let isAllAgree = this.isAllAgree();
    
    let _agreeArray = this.state.agreeArray.concat();
    for(let i = 0 ; i < _agreeArray.length ; i++){
      let agreeData = _agreeArray[i];
      if(isAllAgree){
        agreeData.isCheck = false;
      }else{
        agreeData.isCheck = true;
      }
    }

    this.setState({
      agreeArray: _agreeArray.concat()
    })
  }

  onClickMethod = (e, method_type) => {
    e.preventDefault();

    this.setState({
      pay_method: method_type
    })
  }

  render(){
    if(this.state.store_item_id === null){
      return (<></>);
    }
    
    let isAllAgree = this.isAllAgree();
    let allAgreeImage = <img src={ic_checkbox_btn_n} />
    if(isAllAgree){
      allAgreeImage = <img src={ic_checkbox_btn_s} />
    }

    let agreeList = [];
    for(let i = 0 ; i < this.state.agreeArray.length ; i++){
      let agreeData = this.state.agreeArray[i];
      let agreeSelectImg = <img className={'agreeImg'} src={ic_checkbox_btn_n} />;
      if(agreeData.isCheck){
        agreeSelectImg = <img className={'agreeImg'} src={ic_checkbox_btn_s} />
      }

      let linkTextDom = <a href={agreeData.link} target={'_blank'}><u>{agreeData.name}</u></a>;
      if(agreeData.type === Types.agree.refund){
        linkTextDom = agreeData.name;
      }

      let agreeButtonDom = <div className={'agree_button'} key={i}>
                              <button onClick={(e) => {this.clickAgree(e, agreeData.type)}}>
                                {agreeSelectImg}
                              </button>
                              <div className={'agree_text'}>
                                {linkTextDom} 동의
                              </div>
                            </div>

      agreeList.push(agreeButtonDom);
    }

    let payDom = <></>;
    if(this.state.total_price > 0){

      let payFormDom = <></>;
      if(this.state.pay_method === Types.pay_method.PAY_METHOD_TYPE_CARD_INPUT){
        payFormDom = <div className={'card_info_container'}>
                      <p className={'input_label'}>카드번호</p>
                      <input className={'input_box'} placeholder={'- 없이 숫자만 입력'} type="text" name="cc-number" autoComplete="off" value={this.state.card_number} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CARD_NUMBER)}}/>

                      <div>
                        <p className={'input_label'}>유효기간</p>

                        <div className={'flex_layer'}>
                          <div className={'select_box'}>
                            {this.state.selectShowMonthValue}
                            <img src={icon_box} />

                            <select className={'select_tag'} value={this.state.selectMonthValue} onChange={this.handleSelectChangeMonth}>
                              {this.state.optionMonth}
                            </select>
                          </div>

                          <div className={'select_box'} style={{marginLeft: 8}}>
                            {this.state.selectShowYearValue}
                            <img src={icon_box} />

                            <select className={'select_tag'}  value={this.state.selectYearValue} onChange={this.handleSelectChangeYear}>
                              {this.state.optionYears}
                            </select>
                          </div>
                        </div>
                      </div>
                    
                      <p className={'input_label'}>카드 소유자 생년월일 (법인등록번호)</p>
                      <input className={'input_box'} type="text" name="bday" autoComplete="off" placeholder='주민번호 앞 6자리(법인등록번호 7자리)'value={this.state.card_birth} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CARD_BIRTH)}}/>

                      <p className={'input_label'}>카드 비밀번호 앞2자리</p>
                      <div className={'flex_layer'}>
                        <input className={'input_box'} maxLength={2} autoComplete={"new-password"} style={{width: 100}} type={"password"} value={this.state.card_pw_2digit} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CARD_PW_TWODIGIT)}}/>
                        <div className={'password_back_bod'}>
                          **
                        </div>
                      </div>
                    </div>
      }

      let payMethodDoms = [];
      for(let i=0 ; i < this.state.payMethodArray.length ; i++){
        const data = this.state.payMethodArray[i];

        let imgRadioImg = <></>;
        if(this.state.pay_method === data.pay_method){
          imgRadioImg = <img src={ic_radio_btn_s} />
        }else{
          imgRadioImg = <img src={ic_radio_btn_n} />
        }

        let payMethodDom = <button key={i} className={'pay_method_button'} onClick={(e) => {this.onClickMethod(e, data.pay_method)}}>
                            {imgRadioImg}
                            <div className={'pay_method_text'}>
                              {data.text}
                            </div>
                          </button>;

        payMethodDoms.push(payMethodDom);
      }

      payDom = <div className={'container_box'}>
                  <div className={'container_label'}>
                    결제방법
                  </div>
                  <div className={'pay_method_container'}>
                    {payMethodDoms}
                    {payFormDom}
                  </div>
                </div>
    }

    let oneTooneNoticeDom = <></>;
    let oneTooneSelectDom = <></>;
    if(this.state.item_product_state === Types.product_state.ONE_TO_ONE){
      oneTooneNoticeDom = <div className={'container_box'} style={{display:'flex', backgroundColor: '#feeff2'}}>
                            <div className={'oneToone_notice_warning'}>
                              !
                            </div>
                            <div className={'oneToone_notice_content'}>
                              {'다음 1~2주 사이에 크리에이터와 실시간 콘텐츠 진행이 가능한 시간대를 \n아래에서 3개 이상 선택해주세요.\n\n크리에이터가 확인 후 선택한 시간대 안에서 최종 진행 시간을 결정하여 알려드립니다!'}
                            </div>
                          </div>

      oneTooneSelectDom = <div className={'container_box'}>
                            <StorePlayTimePlan ref={(ref) => {this.storePlayTimePlanRef = ref;}} store_item_id={this.state.store_item_id}></StorePlayTimePlan>
                          </div>
    }

    return(
      <div className={'StoreOrderPage'}>
        <div className={'title_label'}>
          주문
        </div>
        <div className={'sub_title_label'}>
          주문내역
        </div>

        <div className={'container_box'}>
          <StoreOrderItem 
            id={this.state.store_item_id} 
            store_item_id={this.state.store_item_id}
            thumbUrl={this.state.item_thumb_img_url}
            name={this.state.item_nick_name}
            title={this.state.item_title}
            price={this.state.item_price}
            store_title={this.state.store_title}
          ></StoreOrderItem>
          
          <div className={'request_label'}>
            콘텐츠 요청
          </div>

          <div className={'ask_container'}>
            {this.state.item_ask}
          </div>

          <div className={'request_content_box'}>
            <textarea className={'textArea'} value={this.state.requestContent} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_REQUEST_CONTENTS)}} placeholder={"요청사항을 작성해주세요!"}></textarea>
          </div>

          {/* 파일 input START */}
          <FileUploader ref={(ref) => {this.fileUploaderRef = ref;}} state={this.state.item_file_upload_state} isUploader={true}></FileUploader>
          {/* 파일 input END */}
        </div>

        {oneTooneNoticeDom}
        {oneTooneSelectDom}

        <div className={'container_box'}>
          <div className={'container_label'}>
            신청자 정보
          </div>

          <div className={'input_label'}>이름</div>
          <input className={'input_box'} type="name" name={'name'} placeholder={'이름을 입력해주세요'} value={this.state.name} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_NAME)}}/>

          <div className={'input_label'}>전화번호</div>
          <input className={'input_box'} type="tel" name={'tel'} placeholder={'전화번호를 입력해주세요'} value={this.state.contact} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CONTACT)}}/>

          <div className={'input_label'}>이메일</div>
          <input className={'input_box'} type="email" name={'email'} placeholder={'이메일을 입력해주세요'} value={this.state.email} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_EMAIL)}}/>
          
        </div>

        <div className={'container_box'}>
          <div className={'container_label'}>
            결제
          </div>

          <div className={'pay_info_container'}>
            <div className={'pay_info_label'}>
              {this.state.item_title}
            </div>
            <div className={'pay_info_value'}>
              {Util.getNumberWithCommas(this.state.item_price)}원
            </div>

            
          </div>

          <div className={'under_line'}>
          </div>

          <div className={'pay_info_total_price'}>
              {Util.getNumberWithCommas(this.state.total_price)}원
          </div>
        </div>

        
        {payDom}


        <div className={'policy_container'}>
          <div className={'policy_title'}>
            크티 취소/환불 규정
          </div>
          <div className={'policy_content'}>
            1. 모든 콘텐츠 주문은 크리에이터의 승인이 필요합니다.<br/>
            2. 크리에이터의 의사에 따라 콘텐츠 주문이 반려될 수 있습니다.<br/>
            3. 주문 날짜로부터 7일 안에 승인이 안되거나 반려될 경우 결제 금액은 전액 환불됩니다.<br/>
            4. 주문이 승인되기 전 구매자에 의한 주문 취소 및 환불이 가능합니다.<br/>
            5. 크리에이터가 주문을 승인한 이후에는 취소 및 환불이 불가능합니다. 단, 주문 날짜로부터 최대 14일 이내에 콘텐츠를 제공받지 못한 경우에는 결제 금액을 전액 환불해드립니다.<br/>
            6. 콘텐츠를 제공 받은 이후에는 단순 불만족 또는 변심으로 인한 환불이 불가능하니 유의해주세요.
          </div>
        </div>

        <div className={'container_box'}>
          <div className={'container_label'}>
            크티 이용 정책 동의
          </div>

          <button onClick={(e) => {this.clickAllAgree(e)}} style={{marginTop: 22}}>
            <div style={{display: 'flex', alignItems: 'center'}}>
              {allAgreeImage}
              <div style={{fontSize: 14, color: '#4d4d4d', marginLeft: 8}}>
                모두 동의
              </div>
            </div>
          </button>

          <div className={'under_line'}>
          </div>

          {agreeList}
        </div>

        <button className={'order_button'} onClick={(e) => {this.clickOrder(e)}}>
          {Util.getNumberWithCommas(this.state.item_price)}원 주문하기
        </button>
      </div>
    )
  }
  
};

// props 로 넣어줄 스토어 상태값
// const mapStateToProps = (state) => {
//   return {
//     name: state.user.name,
//     email: state.user.email,
//     contact: state.user.contact
//   }
// };

// const mapDispatchToProps = (dispatch) => {
//   return {
//     // handleAddPageViewKey: (pageKey: string, data: any) => {
//     //   dispatch(actions.addPageViewKey(pageKey, data));
//     // },
//     // handleAddToastMessage: (toastType:number, message: string, data: any) => {
//     //   dispatch(actions.addToastMessage(toastType, message, data));
//     // }
//   }
// };

StoreOrderPage.defaultProps = {
  // name: ''
  // people: [
  // ]
}

// export default connect(mapStateToProps, mapDispatchToProps)(StoreItemDetailPage);
// export default connect(mapStateToProps, null)(StoreOrderPage);
export default StoreOrderPage;