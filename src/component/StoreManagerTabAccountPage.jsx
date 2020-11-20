'use strict';

import React, { Component } from 'react';


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

import Util from '../lib/Util';
import Types from '../Types';
import InfiniteScroll from 'react-infinite-scroll-component';
import moment from 'moment';

const INPUT_STORE_MANAGER_ACCOUNT_NAME = "INPUT_STORE_MANAGER_ACCOUNT_NAME";
const INPUT_STORE_MANAGER_ACCOUNT_BANK_NAME = "INPUT_STORE_MANAGER_ACCOUNT_BANK_NAME";
const INPUT_STORE_MANAGER_ACCOUNT_NUMBER = "INPUT_STORE_MANAGER_ACCOUNT_NUMBER";

const INPUT_STORE_MANAGER_CONTACT = 'INPUT_STORE_MANAGER_CONTACT';
const INPUT_STORE_MANAGER_EMAIL = 'INPUT_STORE_MANAGER_EMAIL';

const REQUEST_ONCE_ITME = 5;
let isRequestInitData = false;

class StoreManagerTabAccountPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      account_name: '',
      account_number: '',
      account_bank: '',

      items: [],
      hasMore: true,

      contact: '',
      email: '',

      policy: `1. 정산은 상품 결제가 진행된 후 구매자에게 콘텐츠 전달까지 모두 완료된 건들에 한하여 진행됩니다.
        2. 크티 '콘텐츠 상점 beta' 수수료는 현재 카드결제 수수료 3.5%를 포함하여 총 15%로, 총 결제 금액에서 수수료를 제외한 금액을 정산하여 입금해드립니다.
        3. 콘텐츠 상점 정산일은 매 달 15일과 30일입니다.
        4. 매 달 1일~15일 사이에 판매가 완료된 건은 같은 달 30일에 정산이 진행되며, 16일~31일 사이에 판매가 완료된 건은 다음 달 15일에 정산됩니다.
        5. 정산일이 주말 또는 공휴일인 경우 그 다음 평일에 정산이 진행됩니다.
        6. 콘텐츠 판매자는 정산 받은 금액에 대해 부과되거나 의무가 있는 모든 세금을 성실하게 신고하고 납부할 의무가 있습니다.`
    }

    this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestMoreData();
    this.requestAccountInfo();
    this.requestStoreInfo();
  };

  componentDidUpdate(prevProps, prevState, snapshot) {
  }

  componentWillUnmount(){
  };

  requestStoreInfo(){
    axios.post("/store/info/userid", {
      store_user_id: this.props.store_user_id
    }, (result) => {
      
      this.setState({        
        contact: result.data.contact,
        email: result.data.email,
      })
    }, (error) => {

    })
  }

  requestAccountInfo(){
    //manager/account/info
    axios.post("/store/manager/account/info", {
      store_id: this.props.store_id
    }, (result) => {
      this.setState({
        account_name: result.data.account_name,
        account_number: result.data.account_number,
        account_bank: result.data.account_bank,
      })
    }, (error) => {

    })
  }

  requestMoreData(){
    if(this.state.items.length === 0 && this.isRequestInitData){
      return;
    }

    if(this.state.items.length === 0){
      this.isRequestInitData = true;
    }

    axios.post('/store/manager/account/paid/list', {
      store_id: this.props.store_id,
      limit: REQUEST_ONCE_ITME,
      skip: this.state.items.length,
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
  }


  onChangeInput(e, type){
    e.preventDefault();

    if(type === INPUT_STORE_MANAGER_ACCOUNT_NAME){
      this.setState({
        account_name: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_ACCOUNT_NUMBER){

      if(e.target.value.length > 0 && !isCheckOnlyNumber(e.target.value)){
        alert("숫자만 입력해주세요. (공백 혹은 - 이 입력되었습니다.)")
        return;
      }

      this.setState({
        account_number: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_ACCOUNT_BANK_NAME){
      this.setState({
        account_bank: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_EMAIL){
      this.setState({
        email: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_CONTACT){
      if(e.target.value.length > 0 && !isCheckOnlyNumber(e.target.value)){
        alert("숫자만 입력해주세요. (공백 혹은 - 이 입력되었습니다.)")
        return;
      }

      this.setState({
        contact: e.target.value
      })
    }
  }

  clickAccountChange(e){
    e.preventDefault();

    if(this.state.account_name === ''){
      alert("예금주명을 입력해주세요");
      return;
    }else if(this.state.account_bank === ''){
      alert("은행명을 입력해주세요");
      return;
    }else if(this.state.account_number === ''){
      alert('계좌번호를 입력해주세요');
      return;
    }else if(this.state.contact === ''){
      alert("비상 연락처를 반드시 입력해주세요.");
      return;
    }else if(this.state.email === ''){
      alert("연락용 이메일을 반드시 입력해주세요.");
      return;
    }

    if(!isCheckOnlyNumber(this.state.account_number)){
      alert("계좌번호에 (공백 혹은 - 이 입력되었습니다.)");
      return;
    }
    // manager/account/info/set

    axios.post("/store/manager/account/info/set", {
      store_id: this.props.store_id,
      account_name: this.state.account_name,
      account_number: this.state.account_number,
      account_bank: this.state.account_bank,

      email: this.state.email,
      contact: this.state.contact
    }, (result) => {
      alert("저장완료!");
    }, (error) => {

    })
  }

  render(){
    
    
    return(
      <div className={'StoreManagerTabAccountPage'}>
        <div className={'label_title'}>
          정산안내
        </div>

        <div className={'policy_container'}>
          <div className={'policy_label'}>
            크티 정산 규정
          </div>
          <div className={'policy_contents'}>
            {this.state.policy}
          </div>
        </div>

        <div className={'account_info_container'}>
          <div className={'label_title'}>
            정산정보
          </div>

          <div className={'input_label'}>예금주</div>
          <input className={'input_box'} type="name" name={'name'} placeholder={'이름을 입력해주세요'} value={this.state.account_name} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ACCOUNT_NAME)}}/>

          <div className={'input_label'}>비상 연락처(핸드폰)</div>
          <input className={'input_box'} type="text" name={'contact'} placeholder={'-없이 입력해주세요.'} value={this.state.contact} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_CONTACT)}}/>

          <div className={'input_label'}>연락용 이메일</div>
          <input className={'input_box'} type="text" name={'email'} placeholder={'연락용 이메일을 입력해주세요.'} value={this.state.email} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_EMAIL)}}/>

          <div className={'input_label'}>은행</div>
          <input className={'input_box'} type="text" name={'account_bank'} placeholder={'은행명을 입력해주세요'} value={this.state.account_bank} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ACCOUNT_BANK_NAME)}}/>

          <div className={'input_label'}>계좌번호</div>
          <input className={'input_box'} type="text" name={'account_number'} placeholder={'- 없이 입력해주세요'} value={this.state.account_number} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ACCOUNT_NUMBER)}}/>
        </div>

        <button className={'account_save_button'} onClick={(e) => {this.clickAccountChange(e)}}>
          저장하기
        </button>

        <div className={'paid_container'}>
          <div className={'label_title'}>
            정산 내역
          </div>

          <div className={'paid_list_container'}>
            <div className={'paid_list_title_container'}>
              <div className={'paid_title_date paid_title_font'}>
                일시
              </div>
              
              <div className={'paid_title_price paid_title_font'}>
                정산금액
              </div>
            </div>

            <InfiniteScroll
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
                // return <StoreContentsListItem key={data.id} store_id={data.store_id} id={data.id} store_item_id={data.id} thumbUrl={data.img_url} name={data.nick_name} title={data.title} price={data.price} isHomeList={true} store_alias={data.alias}></StoreContentsListItem>

                return <div key={data.id} className={'paid_list_title_container paid_list_item_container'}>
                        <div className={'paid_title_date paid_list_item_text'}>
                          {moment(data.created_at).format('YYYY-MM-DD')}
                        </div>
                        <div className={'paid_title_price paid_list_item_text'}>
                          {Util.getNumberWithCommas(data.pay_price)}원
                        </div>
                      </div>
              })}
            </InfiniteScroll>
            
          </div>
        </div>
      </div>
    )
  }
};

// props 로 넣어줄 스토어 상태값
// const mapStateToProps = (state) => {
//   // console.log(state);
//   return {
//     // pageViewKeys: state.page.pageViewKeys.concat()
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

// export default connect(mapStateToProps, mapDispatchToProps)(StoreItemDetailPage);
export default StoreManagerTabAccountPage;