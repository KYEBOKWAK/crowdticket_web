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
import icon_box from '../res/img/icon-box.svg';


const INPUT_STORE_MANAGER_TITLE = 'INPUT_STORE_MANAGER_TITLE';
const INPUT_STORE_MANAGER_CONTENT = 'INPUT_STORE_MANAGER_CONTENT';

const MAX_CATEGORY_LENGTH = 6;
const MAX_CONTENT_LENGTH = 45;

class StoreManagerTabStoreInfoPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      myID: null,
      store_id: null,

      title: '',
      contact: '',
      email: '',
      content: '',


      channels: [],
      channel_ori_data: [],
      channel_categorys_data: [],

      channel_category_select_options: []
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
  };

  componentDidUpdate(){
  }

  requestStoreInfo(){
    axios.post("/store/info/userid", {
      store_user_id: this.props.store_user_id
    }, (result) => {
      
      this.setState({
        store_id: result.data.store_id,
        title: result.data.title,
        // contact: result.data.contact,
        // email: result.data.email,
        content: result.data.content
      })
    }, (error) => {

    })
  }
  
  requestStoreChannelCategory(){
    axios.post("/store/sns/channel/category/list", {

    }, (result) => {
      console.log(result);
      
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
    console.log('asdf');
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
    // else if(type === INPUT_STORE_MANAGER_CONTACT){
    //   this.setState({
    //     contact: e.target.value
    //   })
    // }
    // else if(type === INPUT_STORE_MANAGER_EMAIL){
    //   this.setState({
    //     email: e.target.value
    //   })
    // }
    else if(type === INPUT_STORE_MANAGER_CONTENT){
      this.setState({
        content: e.target.value
      })
    }
  }

  onClickSave(e){
    e.preventDefault();

    showLoadingPopup('저장중입니다..');
    axios.post('/store/save/info', {
      store_id: this.state.store_id,
      title: this.state.title,
      // contact: this.state.contact,
      // email: this.state.email,
      content: this.state.content
    }, (result) => {
      this.queryChannelsRemove();
    }, (error) => {
      stopLoadingPopup();
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

                          <input className={'input_box category_input'} type="text" name={'channel_url'} placeholder={'채녈 주소를 입력해주세요.'} value={data.channel_link_url} onChange={(e) => {this.onChangeCategoryInput(e, data.index)}}/>

                          <div className={'category_button_container'}>
                            {plusButton}
                            {subButton}
                            {fakeButton}
                          </div>
                        </div>

      category_list.push(categoryList);
      // categories_channel_id
      // channel_link_url
    }

    return(
      <div className={'StoreManagerTabStoreInfoPage'}>
        <div className={'input_label'}>상점명</div>
        <input className={'input_box'} type="text" name={'title'} placeholder={'상점명을 입력해주세요.'} value={this.state.title} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_TITLE)}}/>

        {/* <div className={'input_label'}>상점 연락처</div>
        <input className={'input_box'} type="text" name={'contact'} placeholder={'-없이 입력해주세요.'} value={this.state.contact} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_CONTACT)}}/>

        <div className={'input_label'}>상점 이메일</div>
        <input className={'input_box'} type="text" name={'email'} placeholder={'상점 이메일을 입력해주세요.'} value={this.state.email} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_EMAIL)}}/> */}

        <div className={'input_label'}>상점 소개글</div>
        <textarea className={'textarea_box'} value={this.state.content} onChange={(e) => {this.onChangeInput(e, INPUT_STORE_MANAGER_CONTENT)}} maxLength={MAX_CONTENT_LENGTH} placeholder={"상점 소개글을 입력해주세요"}></textarea>
        <div className={'content_length_container'}>
          {this.state.content.length}/{MAX_CONTENT_LENGTH}
        </div>

        <div className={'input_label'}>소셜미디어 채널</div>
        <div>
          {category_list}
        </div>
        <div className={'category_max_text'}>
          최대 6개까지 등록 가능합니다.
        </div>


        <button className={'save_button'} onClick={(e) => {this.onClickSave(e)}}>
          저장하기
        </button>
      </div>
    )
  }
};

export default StoreManagerTabStoreInfoPage;