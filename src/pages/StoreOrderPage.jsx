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

  constructor(props){
    super(props);

    this.state = {
      store_id: null,
      store_item_id: null,
      store_order_id: null,

      item_title: '',
      item_price: 0,
      item_content: '',
      item_thumb_img_url: '',
      item_nick_name: '',

      isInitDeriveStateFromProps: false,
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
          link: 'https://crowdticket.kr/thirdterms/app'
        }, 
        {
          type: Types.agree.terms_useInfo,
          name: '이용약관 / 정보이용정책',
          isCheck: false,
          link: 'https://crowdticket.kr/thirdterms/app'
        }, 
        {
          type: Types.agree.third,
          name: '제3자 정보제공정책',
          isCheck: false,
          link: 'https://crowdticket.kr/thirdterms/app'
        }],

      //밑에는 다 있음.
      // title: this.props.data.title,
      // contact: this.state.contact,
      // email: this.state.email,
      // name: this.state.name,
      // order_id: order_id,
    }

    this.handleSelectChangeYear = this.handleSelectChangeYear.bind(this);
    this.handleSelectChangeMonth = this.handleSelectChangeMonth.bind(this);
  };

  
  static getDerivedStateFromProps(nextProps, prevState) {
    if(!prevState.isInitDeriveStateFromProps)
    {
      if(nextProps.name !== prevState.name || nextProps.contact !== nextProps.contact ||
        nextProps.email !== prevState.email){
        return {
          name: nextProps.name,
          contact: nextProps.contact,
          email: nextProps.email,
          isInitDeriveStateFromProps: true
        }
      }
    }

    return null;
  }
  

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    const storeItemIDDom = document.querySelector('#store_item_id');
    if(storeItemIDDom){

      this.setState({
        store_item_id: Number(storeItemIDDom.value)
      }, function(){
        //아이템 정보 가져오기
        this.requestItemInfo()
      })
    }

    // showLoadingPopup('dddd');

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
    
  };

  componentDidUpdate(){
  }

  requestItemInfo(){
    axios.post('/store/any/item/info', {
      store_item_id: this.state.store_item_id
    }, (result) => {
      const data = result.data;
      this.setState({
        item_title: data.title,
        item_price: data.price,
        item_content: data.content,
        item_thumb_img_url: data.img_url,
        total_price: data.price,
        store_id: data.store_id,
        item_nick_name: data.nick_name
      })
    }, (error) => {

    })
  }

  requestUserInfo(){

  }

  isPassableOrder(){
    // let isOrder = true;

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
      this.requsetOrder();
    }
  }

  requsetOrder(){
    //pay_method = Types.pay_method.PAY_METHOD_TYPE_CARD_INPUT;
    let pay_method = Types.pay_method.PAY_METHOD_TYPE_CARD_INPUT;
    
    if(!this.state.store_id){
      alert("스토어 정보가 없습니다. 새로고침 해주세요.");
      return;
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
      pay_method: Types.pay_method.PAY_METHOD_TYPE_CARD
      // merchant_uid: merchant_uid
    }

    axios.post('/pay/store/onetime', {..._data}, 
    (result) => {      
      stopLoadingPopup();

      //order_id
      let baseURL = 'https://crowdticket.kr'
      const baseURLDom = document.querySelector('#base_url');
      if(baseURLDom){
        baseURL = baseURLDom.value;
      }

      let goURL = baseURL + '/complite/store/'+result.order_id;

      window.location.href = goURL;
      
    },
    (error) => {
      stopLoadingPopup();
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

  render(){

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

      let agreeButtonDom = <div className={'agree_button'} key={i}>
                              <button onClick={(e) => {this.clickAgree(e, agreeData.type)}}>
                                {agreeSelectImg}
                              </button>
                              <div className={'agree_text'}>
                                <a href={agreeData.link} target={'_blank'}><u>{agreeData.name}</u></a> 동의
                              </div>
                            </div>

      agreeList.push(agreeButtonDom);
    }

    let payDom = <></>;
    if(this.state.total_price > 0){
      payDom = <div className={'container_box'}>
                  <div className={'container_label'}>
                    결제방법
                  </div>

                  <div className={'card_info_container'}>
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

                      {/* <input className={'input_box'} type="text" value={this.state.card_yy} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CARD_YY)}}/> */}
                    
                      {/* <p className={'input_label'}>카드 월</p>
                      <input className={'input_box'} type="text" value={this.state.card_mm} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CARD_MM)}}/> */}
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
          ></StoreOrderItem>
          
          <div className={'request_label'}>
            컨텐츠 요청
          </div>
          
          <div className={'request_content_box'}>
            <textarea className={'textArea'} value={this.state.requestContent} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_REQUEST_CONTENTS)}} placeholder={"요청사항을 작성해주세요!"}></textarea>
            테스트용 문자 길이{this.state.requestContent.length}
          </div>
        </div>

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
    /*
    return(
      <>
      <div>
        주문하기
      </div>

      <div>
        이건 아이템 정보입니다.
        <div>{this.state.item_title}</div>
        <img style={{width: 100, height: 100}} src={this.state.item_thumb_img_url} />
        <div>{Util.getNumberWithCommas(this.state.item_price)}원</div>
      </div>
      <div>
        신청자 정보
      </div>
      
      <div>
        <p>이름</p>
        <input type="text" value={this.state.name} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_NAME)}}/>
      </div>

      <div>
        <p>전화번호</p>
        <input type="text" value={this.state.contact} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CONTACT)}}/>
      </div>

      <div>
        <p>이메일</p>
        <input type="text" value={this.state.email} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_EMAIL)}}/>
      </div>

      <div>
        결제
      </div>
      
      <div>
        <p>카드번호</p>
        <input type="text" value={this.state.card_number} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CARD_NUMBER)}}/>
      </div>

      <div>
        <p>카드년도(2020)</p>
        <input type="text" value={this.state.card_yy} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CARD_YY)}}/>
      </div>
      <div>
        <p>카드 월</p>
        <input type="text" value={this.state.card_mm} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CARD_MM)}}/>
      </div>
      <div>
        <p>생년월일(법인번호)</p>
        <input type="text" value={this.state.card_birth} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CARD_BIRTH)}}/>
      </div>
      <div>
        <p>비번 앞2자리</p>
        <input type="text" value={this.state.card_pw_2digit} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_ORDER_CARD_PW_TWODIGIT)}}/>
      </div>
      
      
      <button onClick={(e) => {this.clickOrder(e)}}>
        {Util.getNumberWithCommas(this.state.item_price)}원 주문하기
      </button>
      </>
    )
    */
  }
  
};

// props 로 넣어줄 스토어 상태값
const mapStateToProps = (state) => {
  return {
    name: state.user.name,
    email: state.user.email,
    contact: state.user.contact
    // pageViewKeys: state.page.pageViewKeys.concat()
  }
};

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
export default connect(mapStateToProps, null)(StoreOrderPage);
// export default StoreOrderPage;