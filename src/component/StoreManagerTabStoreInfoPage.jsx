'use strict';

import React, { Component } from 'react';

import axios from '../lib/Axios';
import icon_box from '../res/img/icon-box.svg';

import Profile from '../component/Profile';
import Types from '../Types';

import ic_success from '../res/img/ic-success.svg';
import ic_error from '../res/img/ic-error.svg';

import Util from '../lib/Util';

const INPUT_STORE_MANAGER_TITLE = 'INPUT_STORE_MANAGER_TITLE';
const INPUT_STORE_MANAGER_CONTENT = 'INPUT_STORE_MANAGER_CONTENT';

const INPUT_STORE_MANAGER_ACCOUNT_NAME = "INPUT_STORE_MANAGER_ACCOUNT_NAME";
const INPUT_STORE_MANAGER_ACCOUNT_BANK_NAME = "INPUT_STORE_MANAGER_ACCOUNT_BANK_NAME";
const INPUT_STORE_MANAGER_ACCOUNT_NUMBER = "INPUT_STORE_MANAGER_ACCOUNT_NUMBER";

const INPUT_STORE_MANAGER_CONTACT = 'INPUT_STORE_MANAGER_CONTACT';
const INPUT_STORE_MANAGER_EMAIL = 'INPUT_STORE_MANAGER_EMAIL';

const INPUT_STORE_MANAGER_ALIAS = 'INPUT_STORE_MANAGER_ALIAS';

const MAX_CATEGORY_LENGTH = 6;
const MAX_CONTENT_LENGTH = 45;
const MAX_ALIAS_LENGTH = 32;

const STORE_INFO_PROFILE_IMG_SIZE = 80;

class StoreManagerTabStoreInfoPage extends Component{

  profileRef = React.createRef();

  constructor(props){
    super(props);

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    baseURL = baseURL + '/store/';

    this.state = {
      myID: null,
      store_id: null,

      title: '',
      contact: '',
      email: '',
      content: '',

      store_alias: '',
      alias_warning: '',
      is_alias_check_success: false,


      channels: [],
      channel_ori_data: [],
      channel_categorys_data: [],

      channel_category_select_options: [],

      account_name: '',
      account_number: '',
      account_bank: '',

      store_base_url: baseURL

    }

    this.onChangeSelect = this.onChangeSelect.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestStoreInfo();
    this.requestStoreChannelCategory();
  };

  componentWillUnmount(){
    this.profileRef = null;
  };

  componentDidUpdate(){
  }

  requestAccountInfo = () => {
    //manager/account/info
    axios.post("/store/manager/account/info", {
      store_id: this.state.store_id
    }, (result) => {
      this.setState({
        account_name: result.data.account_name,
        account_number: result.data.account_number,
        account_bank: result.data.account_bank,
      })
    }, (error) => {

    })
  }

  requestStoreInfo(){
    axios.post("/store/info/userid", {
      store_user_id: this.props.store_user_id
    }, (result) => {

      let _title = result.data.title;
      if(_title === null){
        _title = '';
      }
      
      this.setState({
        store_id: result.data.store_id,
        title: _title,
        contact: result.data.contact,
        email: result.data.email,
        content: result.data.content,

        store_alias: result.data.alias
      }, () => {
        this.requestAccountInfo();
        this.checkAlias();
      })
    }, (error) => {

    })
  }
  
  requestStoreChannelCategory(){
    axios.post("/store/sns/channel/category/list", {

    }, (result) => {      
      let _channel_category_select_options = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];

        _channel_category_select_options.push(<option key={data.id} value={data.id}>{data.title}</option>);
      }
      this.setState({
        channel_categorys_data: result.list.concat(),
        channel_category_select_options: _channel_category_select_options.concat()
      }, () => {
        this.requestStoreChannels();
      })
    }, (error) => {

    })
  }

  requestStoreChannels(){
    axios.post("/store/sns/channel/list", {
      store_user_id: this.props.store_user_id
    }, (result) => {
      // console.log(result);
      let _channels = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];

        let channelData = {
          ...data,
          index: i
        }

        _channels.push(channelData);
      }

      this.setState({
        channels: _channels.concat(),
        channel_ori_data: _channels.concat()
      }, () => {
        if(this.state.channels.length === 0){
          this.addChannels();
        }
      })
    }, (error) => {

    })
  }

  findCategoryTitle(category_id){
    if(this.state.channel_categorys_data.length === 0){
      return '';
    }

    const categoryData = this.state.channel_categorys_data.find((value) => {return value.id === category_id});
    if(!categoryData){
      return '';
    }

    return categoryData.title;
  }

  onChangeInput(e, type) {
    e.preventDefault();

    if(type === INPUT_STORE_MANAGER_TITLE){
      this.setState({
        title: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_ACCOUNT_NAME){
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
    else if(type === INPUT_STORE_MANAGER_CONTENT){
      this.setState({
        content: e.target.value
      })
    }
    else if(type === INPUT_STORE_MANAGER_ALIAS){
      this.setState({
        store_alias: e.target.value,
        is_alias_check_success: false
      }, () => {
        this.checkAlias();
      })
    }
  }

  checkAlias = () => {

    if(this.state.store_alias.length <= 0){
      this.setState({
        alias_warning: ''
      })
      return;
    }

    //프론트글자 체크
    let warning_text = '';
    let isWarning = false;
    if(Util.checkPatternSpecial(this.state.store_alias.charAt(0))){
      // console.log("특수문자가 있음");
      isWarning = true;
      warning_text = '첫글자는 특수문자가 올 수 없습니다.';
    }else if(Util.checkPatternSpecialInAlias(this.state.store_alias)){
      isWarning = true;
      warning_text = '특수문자는 _ 만 입력이 가능합니다.';
    }else if(Util.checkPatternKor(this.state.store_alias)){
      isWarning = true;
      warning_text = '한글은 입력 불가능합니다.';
    }else if(this.state.store_alias.length === MAX_ALIAS_LENGTH){
      isWarning = true;
      warning_text = '32자 이내만 가능합니다';
    }

    if(isWarning){
      this.setState({
        alias_warning: warning_text
      })

      return;
    }

    axios.post("/store/alias/check", {
      store_alias: this.state.store_alias,
      store_id: this.state.store_id
    }, (result) => {

      let is_alias_check_success = false;
      if(result.warning_text === ''){
        is_alias_check_success = true;
      }

      this.setState({
        alias_warning: result.warning_text,
        is_alias_check_success: is_alias_check_success
      })
    }, (error) => {

    })
  }

  onClickSave(e){
    e.preventDefault();

    if(this.state.store_alias === ''){
      alert("상점 링크 주소를 입력해주세요");
      return;
    }
    
    if(!this.state.is_alias_check_success){
      alert("우효한 상점 링크 주소를 입력해주세요");
      return;
    }

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

    showLoadingPopup('저장중입니다..');

    this.profileRef.uploadProfileImage(this.props.store_user_id, Types.file_upload_target_type.user, 
    () => {
      axios.post("/store/manager/account/info/set", {
        store_id: this.state.store_id,
        account_name: this.state.account_name,
        account_number: this.state.account_number,
        account_bank: this.state.account_bank,
  
        email: this.state.email,
        contact: this.state.contact
      }, (result) => {
        axios.post('/store/save/info/v1', {
          store_id: this.state.store_id,
          title: this.state.title,
          // contact: this.state.contact,
          // email: this.state.email,
          content: this.state.content,

          alias: this.state.store_alias
        }, (result) => {
          this.queryChannelsRemove();
        }, (error) => {
          stopLoadingPopup();
        })
      }, (error) => {
        stopLoadingPopup();
      })
    }, 
    () => {
      stopLoadingPopup();
      alert('프로필 이미지 저장 오류');
    })
  }

  queryChannelsRemove(){
    //
    //삭제된 데이터를 찾아서 삭제됐다고 해준다.
    let _removeChannelList = [];
    let _channel_change_data = this.state.channel_ori_data.concat();
    for(let i = 0 ; i < _channel_change_data.length ; i++){
      let data = _channel_change_data[i];

      // let isDelete = true;
      let channelData = this.state.channels.find((value) => {
        return value.channel_id === data.channel_id;
      });

      // let isDelete = true;

      if(!channelData){
        //삭제됨
        _removeChannelList.push(data);
      }else {
        if(channelData.channel_link_url === ''){
          //빈칸이여도 삭제
          _removeChannelList.push(data);
        }
      }
    }

    if(_removeChannelList.length === 0){
      this.queryChannelsAdd();
      return;
    }
    
    axios.post("/store/channels/remove", {
      store_user_id: this.props.store_user_id,
      channels: _removeChannelList
    }, (result) => {
      this.queryChannelsAdd();
      // stopLoadingPopup();
      // swal("저장 성공!", "", "success");
    }, (error) => {
      stopLoadingPopup();
    })
  }

  queryChannelsAdd(){

    let _addChannelData = [];
    for(let i = 0 ; i < this.state.channels.length ; i++){
      let data = this.state.channels[i];
      if(data.channel_id === null){
        if(data.channel_link_url === ''){
          continue;
        }

        _addChannelData.push(data);
      }
    }

    if(_addChannelData.length === 0){
      //추가한것도 없음
      this.queryChannelsUpdate();
      return;
    }

    axios.post("/store/channels/add", {
      store_user_id: this.props.store_user_id,
      channels: _addChannelData
    }, (result) => {
      // this.queryChannelsAdd();
      this.queryChannelsUpdate();
      // stopLoadingPopup();
      // swal("저장 성공!", "", "success");
    }, (error) => {
      stopLoadingPopup();
    })
  }

  queryChannelsUpdate(){
    axios.post("/store/channels/update", {
      store_user_id: this.props.store_user_id,
      channels: this.state.channels
    }, (result) => {
      this.requestStoreChannels()
      stopLoadingPopup();
      swal("저장 성공!", "", "success");      
    }, (error) => {
      stopLoadingPopup();
    })
  }

  onChangeSelect(e, index){
    let _channels = this.state.channels.concat();

    let channelData = _channels.find((value) => {
      return value.index === index
    });

    if(!channelData){
      return;
    }

    channelData.categories_channel_id = Number(e.target.value);

    this.setState({
      channels: _channels.concat()
    })
    
    // event.target.value
    
    // console.log(channel_id);
    // let _item_state_show = ''
    // let value = Number(event.target.value);

    // _item_state_show = this.getStateShow(value);
    // /*
    // if(value === Types.item_state.SALE){
    //   _item_state_show = '판매중';
    // }else{
    //   _item_state_show = '판매중지';
    // }
    // */

    // this.setState({
    //   item_state: value,
    //   item_state_show: _item_state_show
    // })
  }

  onChangeCategoryInput(e, index){
    let _channels = this.state.channels.concat();

    let channelData = _channels.find((value) => {
      return value.index === index
    });

    if(!channelData){
      return;
    }

    channelData.channel_link_url = e.target.value;

    this.setState({
      channels: _channels.concat()
    })
  }

  addChannels(){
    let _channels = this.state.channels.concat();

    if(_channels.length === MAX_CATEGORY_LENGTH){
      alert('채널은 최대 6개까지만 등록 가능합니다.');
      return;
    }

    let channelData = {
      categories_channel_id: 1,
      channel_id: null,
      index: _channels.length,
      channel_link_url: ""
    }

    _channels.push(channelData);

    this.setState({
      channels: _channels.concat()
    })
  }

  clickPlusButton(e){
    e.preventDefault();

    this.addChannels();
    
  }

  clickSubButton(e, index){
    e.preventDefault();

    let _channels = this.state.channels.concat();

    if(_channels.length === 1){
      alert("채널 입력란 제거 오류")
      return;
    }

    let findIdx = _channels.findIndex((value) => {return value.index === index});
    if(findIdx < 0){
      alert("카테고리 삭제 실패");
      return;
    }

    _channels.splice(findIdx, 1);

    for(let i = 0 ; i < _channels.length ; i++){
      _channels[i].index = i;
    }

    console.log(_channels);

    this.setState({
      channels: _channels.concat()
    })
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
      store_id: this.state.store_id,
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
    // categories_channel_id
    let category_list = [];

    let isMaxChannel = false;
    if(this.state.channels.length === MAX_CATEGORY_LENGTH){
      isMaxChannel = true;
    }

    for(let i = 0 ; i < this.state.channels.length ; i++){
      const data = this.state.channels[i];
      const _categoryTitle = this.findCategoryTitle(data.categories_channel_id);

      let isLastChannel = false;
      let plusButton = <></>;
      let fakeButton = <></>;

      let subButton = <button onClick={(e) => {this.clickSubButton(e, data.index)}} className={'sub_button'}>
                        -
                      </button>
      if(i === this.state.channels.length - 1){
        plusButton = <button onClick={(e) => {this.clickPlusButton(e)}} className={'plus_button'}>
                      +
                    </button>
      }else{
        fakeButton = <div className={'fake_button'}></div>;
        
      }

      if(this.state.channels.length === 1){
        subButton = <></>;
        fakeButton = <div className={'fake_button'}></div>;
      }

      if(isMaxChannel){
        plusButton = <></>;
        fakeButton = <div className={'fake_button'}></div>;
      }

      let categoryList = <div key={data.index} className={'category_container'}> 
                          <div className={'select_box'}>
                            {_categoryTitle}
                            <img src={icon_box} />

                            <select className={'select_tag'} value={data.categories_channel_id} onChange={(e) => {this.onChangeSelect(e, data.index)}}>
                              {this.state.channel_category_select_options}
                            </select>
                          </div>

                          <input className={'input_box category_input'} type="text" name={'channel_url'} placeholder={'채널 주소를 입력해주세요.'} value={data.channel_link_url} onChange={(e) => {this.onChangeCategoryInput(e, data.index)}}/>

                          <div className={'category_button_container'}>
                            {plusButton}
                            {subButton}
                            {fakeButton}
                          </div>
                        </div>

      category_list.push(categoryList);
    }

    let alias_warning_dom = <></>;
    if(this.state.alias_warning !== ''){
      alias_warning_dom = <div className={'alias_warning_container'}>
                            {this.state.alias_warning}
                          </div>
    }

    let alias_warning_icon_img = <></>;
    if(this.state.store_alias === ''){
      alias_warning_icon_img = <></>;
    }else{
      if(this.state.alias_warning === ''){
        alias_warning_icon_img = <img src={ic_success} />
      }else{
        alias_warning_icon_img = <img src={ic_error} />
      }
      
    }

    return(
      <div className={'StoreManagerTabStoreInfoPage'}>

        <div className={'label_title'}>
          상점 정보
        </div>

        <div style={{width: STORE_INFO_PROFILE_IMG_SIZE, height: STORE_INFO_PROFILE_IMG_SIZE}} className={'profile_container'}>
          <Profile ref={(ref) => {this.profileRef = ref;}} user_id={this.props.store_user_id} circleSize={STORE_INFO_PROFILE_IMG_SIZE} isEdit={true}></Profile>
        </div>

        <div className={'input_container'} style={{marginTop: 0}}>
          <div className={'input_label'}>상점명</div>
          <input className={'input_box'} type="text" name={'title'} placeholder={'상점명을 입력해주세요.'} value={this.state.title} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_TITLE)}}/>
        </div>

        <div className={'input_container'}>
          <div className={'input_label'}>상점 소개글</div>
          <textarea className={'textarea_box'} value={this.state.content} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_CONTENT)}} maxLength={MAX_CONTENT_LENGTH} placeholder={"상점 소개글을 입력해주세요"}></textarea>
          <div className={'content_length_container'}>
            {this.state.content.length}/{MAX_CONTENT_LENGTH}
          </div>
        </div>

        <div className={'input_container'}>
          <div className={'input_label'}>소셜미디어 채널</div>
          <div>
            {category_list}
          </div>
          <div className={'category_max_text'}>
            최대 6개까지 등록 가능합니다.
          </div>
        </div>

        <div className={'input_container'}>
          <div className={'input_label'}>상점 링크</div>
          <div className={'alias_container'}>
            <div className={'alias_front_box'}>
              {this.state.store_base_url}
            </div>
            <div className={'alias_input_box_container'}>
             <input 
              // style = 
              // {
              //   {
              //     borderTopLeftRadius: 0, 
              //     borderTopRightRadius: 0,
              //     borderBottomLeftRadius: 0,
              //     borderBottomRightRadius: 0,
              //     borderRight: 0,
              //     paddingRight: 0
              //   }
              // } 
              className={'input_box alias_input_box'} 
              value={this.state.store_alias} 
              onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ALIAS)}} 
              maxLength={MAX_ALIAS_LENGTH} 
              placeholder={"링크에 사용될 상점명을 입력해주세요."}/>

              <div className={'alias_check_box'}>
                {alias_warning_icon_img}
              </div>
            </div>
          </div>

          {alias_warning_dom}
        </div>

        <div className={'account_info_container'}>
          <div className={'label_title'}>
            정산정보
          </div>
          <div className={'category_max_text'}>
            외부에 공개되지 않는 정보입니다
          </div>

          <div className={'input_container'}>
            <div className={'input_label'}>예금주</div>
            <input className={'input_box'} type="name" name={'name'} placeholder={'이름을 입력해주세요'} value={this.state.account_name} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ACCOUNT_NAME)}}/>
          </div>

          <div className={'input_container'}>
            <div className={'input_label'}>휴대전화번호 (주문 알림 및 정산 안내 발송용)</div>
            <input className={'input_box'} type="text" name={'contact'} placeholder={'-없이 입력해주세요.'} value={this.state.contact} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_CONTACT)}}/>
          </div>

          <div className={'input_container'}>
            <div className={'input_label'}>연락용 이메일</div>
            <input className={'input_box'} type="text" name={'email'} placeholder={'연락용 이메일을 입력해주세요.'} value={this.state.email} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_EMAIL)}}/>
          </div>

          <div className={'input_container'}>
            <div className={'input_label'}>은행</div>
            <input className={'input_box'} type="text" name={'account_bank'} placeholder={'은행명을 입력해주세요'} value={this.state.account_bank} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ACCOUNT_BANK_NAME)}}/>
          </div>

          <div className={'input_container'}>
            <div className={'input_label'}>계좌번호</div>
            <input className={'input_box'} type="text" name={'account_number'} placeholder={'- 없이 입력해주세요'} value={this.state.account_number} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_ACCOUNT_NUMBER)}}/>
          </div>
        </div>


        <button className={'save_button'} onClick={(e) => {this.onClickSave(e)}}>
          저장하기
        </button>
      </div>
    )
  }
};

export default StoreManagerTabStoreInfoPage;