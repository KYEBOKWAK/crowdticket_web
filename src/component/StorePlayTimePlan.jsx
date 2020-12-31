'use strict';

import React, { Component } from 'react';
import axios from '../lib/Axios';

import Types from '../Types';

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

import ic_plus_circle from '../res/img/ic-plus-circle.svg';

import Popup_SelectTime from '../component/Popup_SelectTime';

import moment_timezone from 'moment-timezone';
moment_timezone.tz.setDefault("Asia/Seoul");

import ic_down_arrow_img from '../res/img/ic-down-arrow.svg';
import ic_up_arrow_img from '../res/img/ic-up-arrow.svg';

import ic_radio_button_s_img from '../res/img/radio-btn-s.svg';
import ic_radio_button_n_img from '../res/img/radio-btn-n.svg';

import icon_box from '../res/img/icon-box.svg';

const HOPE_PLAY_TIME_MAX = 5;
class StorePlayTimePlan extends Component{

  constructor(props){
    super(props);

    this.state = {
      isShowSelectTimePopup: false,
      store_id: null,

      item_ask_play_time: '',
      item_product_state: Types.product_state.TEXT,
      store_title: '',
      profile_photo_url: '',

      isPopupSelectTime: false,
      selectTimeDataKey: -1,
      // selectTime: null,
      dayOfWeekData: ['일', '월', '화', '수', '목', '금', '토'],
      hopeTimes: 
      [
        {
          key: 0,
          id: null,
          start_time: null,
          end_time: null,
          select_time: null,
        },
        {
          key: 1,
          id: null,
          start_time: null,
          end_time: null,
          select_time: null,
        },
        {
          key: 2,
          id: null,
          start_time: null,
          end_time: null,
          select_time: null,
        }
      ],

      isHide: false,
      selectKey: null,
      select_detail_hour: null,

      select_detail_hour_show: '시간',
      select_detail_hour_value: '',
      select_detail_hour_options: [],

      select_time: '',
      product_detail_ask: '',
      time_check_state: false
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    this.requestItemInfo();
    this.requestPlayTimeInfo();
    this.requestDetailAskGet();
    this.requestSelectTime();
    this.requestStoreOrderInfo();
  };

  requestStoreOrderInfo = () => {
    if(this.props.store_order_id === null || this.props.store_order_id === undefined){
      return;
    }

    axios.post('/orders/store/info', {
      store_order_id: this.props.store_order_id
    }, (result) => {
      
      this.setState({
        time_check_state: result.data.time_check_state
        // time_check_state: true
      })
    }, (error) => {

    })
  }

  requestSelectTime = () => {
    if(this.props.store_order_id === null || this.props.store_order_id === undefined){
      return;
    }

    axios.post("/store/eventplaytime/select/get", {
      store_order_id: this.props.store_order_id
    }, (result) => {
      this.setState({
        select_time: result.select_time
      })
    }, (error) => {

    })
  }

  requestDetailAskGet = () => {
    if(this.props.store_order_id === null || this.props.store_order_id === undefined){
      return;
    }

    axios.post("/store/order/detailask/get", {
      store_order_id: this.props.store_order_id
    }, (result) => {
      let product_detail_ask = result.product_detail_ask;
      if(product_detail_ask === null){
        product_detail_ask = '';
      }

      this.setState({
        product_detail_ask: product_detail_ask
      })
    }, (error) => {

    })
  }

  requestPlayTimeInfo = () => {
    if(this.props.store_order_id === null || this.props.store_order_id === undefined){
      return;
    }
    axios.post("/store/eventplaytime/get", 
    {
      store_order_id: this.props.store_order_id
    }, (result) => {
      let _hopeTimes = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];

        const hopeTimeData = {
          key: i,
          id: data.id,
          start_time: data.start_time,
          end_time: data.end_time,
          select_time: data.select_time,
        }

        _hopeTimes.push(hopeTimeData);
      }
      
      this.setState({
        hopeTimes: _hopeTimes.concat()
      })
    }, (error) => {

    })
  }

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  }

  getSelectTimes = () => {
    return this.state.hopeTimes;
  }

  getProductDetailAsk = () => {
    return this.state.product_detail_ask
  }

  isPassSelectTime = () => {
    let isSetTimeCount = 0;
    for(let i = 0 ; i < this.state.hopeTimes.length ; i++){
      const data = this.state.hopeTimes[i];

      if(data.start_time !== null){
        isSetTimeCount++;
      }
    }

    if(isSetTimeCount < 3){
      return false;
    }

    return true;
  }

  getSelectKey = () => {
    return this.state.selectKey;
  }

  requestItemInfo = () => {
    axios.post('/store/any/item/info', {
      store_item_id: this.props.store_item_id
    }, (result) => {
      const data = result.data;

      let ask_play_time = data.ask_play_time;
      if(ask_play_time === null){
        ask_play_time = '';
      }

      this.setState({
        store_id: data.store_id,
        
        store_title: data.store_title,

        item_ask_play_time: ask_play_time,
        item_product_state: data.product_state,
        profile_photo_url: data.profile_photo_url
      })
    }, (error) => {

    })
  }

  getHopeTimeData = (timesDataKey) => {
    const timeData = this.state.hopeTimes.find((value) => {return value.key === timesDataKey});
    return timeData
  }

  onClickTimeItem = (e, timesDataKey) => {
    // this.state.hopeTimes
    e.preventDefault();

    const timeData = this.getHopeTimeData(timesDataKey);
    if(timeData === undefined){
      alert("시간 정보가 없습니다");
      return;
    }

    this.setState({
      isPopupSelectTime: true,
      selectTimeDataKey: timeData.key
    })
  }

  onClickAddTime = (e) => {
    e.preventDefault();

    let hopeTimes = this.state.hopeTimes.concat();
    // console.log(hopeTimes);

    if(hopeTimes.length >= 5){
      alert('최대 5개까지 추가 가능합니다.');
      return;
    }

    let hopeTimeData = {
      key: hopeTimes.length,
      id: null,
      start_time: null,
      end_time: null,
      select_time: null
    }

    hopeTimes.push(hopeTimeData);

    this.setState({
      hopeTimes: hopeTimes.concat()
    })
  }

  onClickHide = (e) => {
    e.preventDefault();

    let isHide = this.state.isHide;
    if(isHide){
      isHide = false;
    }else{
      isHide = true;
    }

    this.setState({
      isHide: isHide
    })
  }

  onClickSelectTime = (e, timeKey) => {
    e.preventDefault();

    this.setState({
      selectKey: timeKey
    }, () => {
      this.setSelectDetailHourOptions(this.state.selectKey);
    })
  }

  getDetailHourTimeShow = () => {
    let startTimeEnd = Number(this.state.select_detail_hour_value);

    let start_at = 'AM';
    if(startTimeEnd >= 12){
      start_at = 'PM';
      // startTimeEnd = startTimeEnd - 12;
    }

    if(startTimeEnd < 10){
      startTimeEnd = '0'+startTimeEnd;
    }

    return startTimeEnd + ':00' + ' ' + start_at;
  }

  setSelectDetailHourOptions = (selectKey) => {
    if(selectKey === null){
      return '';
    }
    
    const timeData = this.state.hopeTimes.find((value) => {return value.key === selectKey});
    if(timeData === undefined){
      alert("시간 선택 오류");
      return;
    }

    let start_time_moment = moment_timezone(timeData.start_time);
    let end_time_moment = moment_timezone(timeData.end_time);

    let startTimeStart = start_time_moment.hour();
    let endTimeStart = end_time_moment.hour();

    //자정 확인
    let endTimeSecond = end_time_moment.second();
    if(endTimeStart === 23 && endTimeSecond === 59){
      endTimeStart = 24;
    }
    ///////   

    let selectShow = '';

    let select_detail_hour_options = [];
    for(let i = startTimeStart ; i < endTimeStart ; i++){
      let _time = i;
      let start_at = 'AM';
      if(_time >= 12){
        start_at = 'PM';
        // _time = _time - 12;
      }

      if(_time < 10){
        _time = '0'+_time;
      }

      _time = _time + ':00' + ' ' + start_at;

      select_detail_hour_options.push(<option key={i} value={i}>{_time}</option>);

      if(i === startTimeStart){
        selectShow = _time;
      }
    }

    this.setState({
      select_detail_hour_show: selectShow,
      select_detail_hour_value: startTimeStart,
      select_detail_hour: ' ' + selectShow + ' 시작',
      select_detail_hour_options: select_detail_hour_options.concat()
    }, () => {
      this.setSelectTime();
    })
  }

  setSelectTime = () => {
    if(this.state.selectKey === null){
      return '';
    }
    
    const timeData = this.state.hopeTimes.find((value) => {return value.key === this.state.selectKey});
    if(timeData === undefined){
      alert("시간 선택 오류");
      return;
    }
    

    let dayInfo = moment_timezone(timeData.start_time).format("YYYY-MM-DD");
    dayInfo = dayInfo + ' ' + this.state.select_detail_hour_value + ':00:00';

    this.setState({
      select_time: dayInfo
    })
  }

  getSelectTime = () => {
    return this.state.select_time;
  }

  getSelectTimeId = () => {
    if(this.state.selectKey === null){
      return null;
    }

    const timeData = this.state.hopeTimes.find((value) => {return value.key === this.state.selectKey});
    if(timeData === undefined){
      alert("시간 선택 오류");
      return;
    }

    return timeData.id;
  }

  getSelectFullTimeText = (selectKey) => {
    if(selectKey === null){
      return '';
    }
    
    const timeData = this.state.hopeTimes.find((value) => {return value.key === selectKey});
    if(timeData === undefined){
      alert("시간 선택 오류");
      return;
    }

    let startDay = moment_timezone(timeData.start_time).format("YYYY년 MM월 DD일");
    // let startHour = moment_timezone(time_moment).hour();
    let dayOfWeekWord = this.state.dayOfWeekData[moment_timezone(timeData.start_time).day()];

    let selectDayText = startDay + ' (' + dayOfWeekWord + ')';
    if(this.state.select_detail_hour){
      selectDayText = selectDayText + this.state.select_detail_hour;
    }
    

    return selectDayText;
  }

  getSelectTimeReadyProduct = () => {
    if(this.state.select_time === ''){
      return '';
    }

    let startDay = moment_timezone(this.state.select_time).format("YYYY년 MM월 DD일");
    let startHour = moment_timezone(this.state.select_time).hour();
    let dayOfWeekWord = this.state.dayOfWeekData[moment_timezone(this.state.select_time).day()];

    let selectDayText = startDay + ' (' + dayOfWeekWord + ')';
    // if(this.state.select_detail_hour){

    let time_at = 'AM';
    let time_hour = startHour;
    if(time_hour >= 12){
      time_at = 'PM';
      // time_hour = time_hour - 12;
    }

    if(time_hour < 10){
      time_hour = '0'+time_hour;
    }

    time_hour = time_hour + ':00'

    selectDayText = selectDayText + ' ' + time_at + ' ' + time_hour + ' 시작';

    return selectDayText;
  }

  onChangeDetailTime = (event) => {
    this.setState({
      select_detail_hour_value: event.target.value,
    }, () => {
      this.setState({
        select_detail_hour_show: this.getDetailHourTimeShow(),
        select_detail_hour: ' ' + this.getDetailHourTimeShow() + ' 시작'
      }, () => {
        this.setSelectTime();
      })
    })
  }

  onChangeInput = (e) => {
    e.preventDefault();

    this.setState({
      product_detail_ask: e.target.value
    })
  }

  onClickTimeCheck = (e) => {
    e.preventDefault();

    axios.post("/orders/store/timecheck/ok", {
      store_order_id: this.props.store_order_id
    }, (result) => {
      this.setState({
        time_check_state: result.time_check_state
      })
    }, (error) => {

    })
  }

  render(){
    if(this.props.store_order_state === Types.order.ORDER_STATE_CANCEL_STORE_RETURN){
      return(
        <></>
      )
    }

    if(this.state.hopeTimes.length === 0){
      return (
        <></>
      )
    }

    let product_ask_time_dom = <></>;
    // let review_placehold_text = '기대평 & 리뷰를 남겨보세요!';
    if(this.state.item_ask_play_time !== null && this.state.item_ask_play_time !== ''){
      product_ask_time_dom = <div className={'product_answer_wrapper'}>
                              <div className={'product_answer_container'}>
                                <img className={'product_answer_img'} src={this.state.profile_photo_url} />
                                <div className={'product_answer_content_container'}>
                                  <div className={'product_answer_name'}>
                                    {this.state.store_title}
                                  </div>
                                  <div className={'product_answer_content'}>
                                    {this.state.item_ask_play_time}
                                  </div>
                                </div>
                              </div>
                            </div>
    }

    //시간 셋팅 start
    let hopeTimeDoms = [];
    for(let i = 0 ; i < this.state.hopeTimes.length ; i++){
      const data = this.state.hopeTimes[i];

      let dataDom = <></>;
      if(data.start_time === null){
        dataDom = <div key={i} className={'play_time_item_container_wrapper'}>
                    <button onClick={(e) => {this.onClickTimeItem(e, data.key)}} className={'play_time_item_container'}>
                      <img src={ic_plus_circle} />
                      <div className={'play_time_item_text'}>
                        희망 시간대를 입력해주세요
                      </div>
                    </button>
                    <div className={'play_time_item_under_line'}>
                    </div>
                  </div>
      }else{

        let startDay = moment_timezone(data.start_time).format("YYYY년 MM월 DD일");
        let startHour = moment_timezone(data.start_time).hour();
        let endHour = moment_timezone(data.end_time).hour();
        let dayOfWeekWord = this.state.dayOfWeekData[moment_timezone(data.start_time).day()];

        let endSec = moment_timezone(data.end_time).second();
        let isMidnightEndTime = false;
        if(endHour === 23 && endSec === 59){
          //자정이다.
          isMidnightEndTime = true;
        }
        //자정인지 확인한다.

        let start_at = 'AM';
        let end_at = 'AM';
        if(startHour >= 12){
          start_at = 'PM';
          // startHour = startHour - 12;
        }

        if(endHour >= 12){
          end_at = 'PM';
          // endHour = endHour - 12;
        }

        if(startHour < 10){
          startHour = '0'+startHour;
        }

        if(endHour < 10){
          endHour = '0'+endHour;
        }

        if(start_at === end_at){
          end_at = '';
        }

        startHour = startHour+":00";
        endHour = endHour+":00";

        if(isMidnightEndTime){
          endHour = '자정';
          end_at = '';
        }

        let selectDayText = startDay + ' (' + dayOfWeekWord + ')';
        let selectHourText = start_at + ' ' + startHour + ' - ' + end_at + ' ' + endHour;
        

        let editButton = <></>;
        if(this.props.store_order_state === null){
          editButton = <button onClick={(e) => {this.onClickTimeItem(e, data.key)}} className={'play_time_text_edit_button'}>
                          수정
                        </button>
        }

        let radioImg = <></>;
        let timeInfoContainerDom = <></>;
        if(this.props.isManager){
          if(this.props.store_order_state === Types.order.ORDER_STATE_APP_STORE_PAYMENT){

            let icRadioImg = ic_radio_button_n_img;
            if(this.state.selectKey === data.key){
              icRadioImg = ic_radio_button_s_img;
            }

            timeInfoContainerDom = <button onClick={(e) => {this.onClickSelectTime(e, data.key)}} className={'play_time_text_edit_container'}>
                                      <img className={'select_radio_img'} src={icRadioImg} />
                                      <div className={'time_text_container'}>
                                        <div>
                                          {selectDayText}
                                        </div>
                                        <div>
                                          {selectHourText}
                                        </div>
                                      </div>
                                    </button>
          }
        }else{
          timeInfoContainerDom = <div className={'play_time_text_edit_container'}>
                                    <div className={'time_text_container'}>
                                      <div>
                                        {selectDayText}
                                      </div>
                                      <div>
                                        {selectHourText}
                                      </div>
                                    </div>

                                    {editButton}
                                  </div>
        }

        dataDom = <div key={i} className={'play_time_item_container_wrapper'}>
                    {/* <div className={'play_time_text_edit_container'}>
                      <div className={'time_text_container'}>
                        <div>
                          {selectDayText}
                        </div>
                        <div>
                          {selectHourText}
                        </div>
                      </div>

                      {editButton}
                    </div> */}
                    {timeInfoContainerDom}
                    
                    <div className={'play_time_item_under_line'}>
                    </div>
                  </div>
      }

      hopeTimeDoms.push(dataDom);
    }
    //시간 셋팅 end

    let popup_selectTime_dom = <></>;
    if(this.state.isPopupSelectTime){
      const selectTimeData = this.getHopeTimeData(this.state.selectTimeDataKey);
      if(selectTimeData === undefined){
        alert("시간 정보가 없습니다");
        return;
      }
      popup_selectTime_dom = <Popup_SelectTime 
                                selectTimeData={selectTimeData}
                                setCallback={
                                  (selectTimeData) => {
                                    // console.log(selectTimeData);

                                    let hopeTimes = this.state.hopeTimes.concat();
                                    const hopeTimeDataIndex = hopeTimes.findIndex((value) => {return value.key === selectTimeData.key});
                                    if(hopeTimeDataIndex < 0 || hopeTimeDataIndex >= hopeTimes.length){
                                      alert("시간 정보 조회 오류");
                                      return;
                                    }

                                    hopeTimes[hopeTimeDataIndex] = {
                                      ...selectTimeData
                                    }
                                    

                                    // console.log(timeData);

                                    this.setState(
                                      {
                                        isPopupSelectTime: false,
                                        selectTimeDataKey: -1,
                                        hopeTimes: hopeTimes.concat()
                                      }, () => {
                                        // console.log(this.state.hopeTimes);
                                      })
                                  }
                                }
                                closeCallback={() => 
                                {
                                  this.setState(
                                    {
                                      isPopupSelectTime: false,
                                      selectTimeDataKey: -1
                                    })
                                }}>

                              </Popup_SelectTime>;
    }

    let contentDom = <></>;
    let playHideButtonDom = <></>;

    let timeAddButtonDom = <></>;
    if(this.props.store_order_state === null){
      //시간 선택 화면
      timeAddButtonDom = <button onClick={(e) => {this.onClickAddTime(e)}} className={'play_time_add_button'}>
                            {'희망 시간대 추가하기 >'}
                          </button>
    }else{

      let arrowImgSrc = ic_down_arrow_img;
      if(this.state.isHide){
        //진행가능 시간이 나올때
        arrowImgSrc = ic_up_arrow_img;
      }
      playHideButtonDom = <button onClick={(e) => {this.onClickHide(e)}} className={'play_time_hide_button'}>
                            진행 가능 시간
                            <img className={'play_time_hide_arrow_img'} src={arrowImgSrc} />
                          </button>
    }


    

    
    if(!this.state.isHide){
      contentDom = <div>
                    <div>
                      {product_ask_time_dom}
                    </div>
                    <div>
                      {hopeTimeDoms}
                    </div>
                    
                    {timeAddButtonDom}
                    {popup_selectTime_dom}
                  </div>
    }


    let detail_select_time_dom = <></>;
    if(this.props.isManager){
      if(this.state.selectKey !== null && this.props.store_order_state === Types.order.ORDER_STATE_APP_STORE_PAYMENT){
        
        detail_select_time_dom = <div>
                                    <div className={'select_time_label'}>
                                      정확한 시간 정하기
                                    </div>
                                    <div className={'select_time_detail_label'}>
                                      {this.getSelectFullTimeText(this.state.selectKey)}
                                    </div>
                                    <div className={'select_box'}>
                                      {this.state.select_detail_hour_show}
                                      <img src={icon_box} />

                                      <select className={'select_tag'} value={this.state.select_detail_hour_value} onChange={this.onChangeDetailTime}>
                                        {this.state.select_detail_hour_options}
                                      </select>
                                    </div>
                                    <div>
                                      <textarea className={'ask_text_area'} value={this.state.product_detail_ask} onChange={(e) => {this.onChangeInput(e)}} placeholder={"콘텐츠 진행을 위한 지시사항 및 구매자를 위한 감사인사를 적어주세요!"}></textarea>
                                    </div>
                                  </div>
      }
    }

    // if(this.props.isManager && this.props.store_order_state === Types.order.ORDER_STATE_APP_STORE_READY){
    if(this.props.store_order_state === Types.order.ORDER_STATE_APP_STORE_READY ||
      this.props.store_order_state === Types.order.ORDER_STATE_APP_STORE_PLAYING_CONTENTS ||
      this.props.store_order_state === Types.order.ORDER_STATE_APP_STORE_CUSTOMER_COMPLITE){

      let product_detail_ask_dom = <></>;
      if(this.state.product_detail_ask !== ''){
        product_detail_ask_dom = <div style={{marginTop: 20}}>
                                    <div className={'product_answer_wrapper'}>
                                      <div className={'product_answer_container'}>
                                        <img className={'product_answer_img'} src={this.state.profile_photo_url} />
                                        <div className={'product_answer_content_container'}>
                                          <div className={'product_answer_name'}>
                                            {this.state.store_title}
                                          </div>
                                          <div className={'product_answer_content'}>
                                            {this.state.product_detail_ask}
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
      }

      let right_content_dom = <></>;
      let contents_flexDirection = 'column';
      let contents_AlignItems = 'flex-start';
      let contents_JustifyContent = 'unset';
      if(this.props.isManager || this.state.time_check_state){
        let time_check_word_manager_dom = <></>;
        if(this.props.isManager && this.state.time_check_state){
          time_check_word_manager_dom = <div style={{fontSize: 12}}>
                                          구매자 시간 확인 완료
                                        </div>
        }

        right_content_dom = <div>
                              <div style={{marginTop: 8, marginBottom: 30}} className={'select_time_detail_label'}>
                                {this.getSelectTimeReadyProduct()}
                                {time_check_word_manager_dom}
                              </div>

                              <div className={'under_line'}>
                              </div>

                              {product_detail_ask_dom}
                            </div>
      }else{
        contents_flexDirection = 'row';
        contents_AlignItems = 'center';
        contents_JustifyContent = 'space-between';

        right_content_dom = <button onClick={(e) => {this.onClickTimeCheck(e)}} className={'time_check_button'}>
                              진행시간 확인
                            </button>
      }

      return(
        <div className={'StorePlayTimePlan'}>
          <div style={{marginTop: 20, display: 'flex', flexDirection: contents_flexDirection, justifyContent: contents_JustifyContent, alignItems: contents_AlignItems}}>
            <div className={'select_time_label'}>
              콘텐츠 진행 일정
            </div>
            {right_content_dom}
          </div>
        </div>
      )
    }

    return(
      <div className={'StorePlayTimePlan'}>
        {playHideButtonDom}
        {contentDom}
        {detail_select_time_dom}
      </div>
    )
  }
};

StorePlayTimePlan.defaultProps = {
  isManager: false,
  store_order_id: null,
  store_order_state: null
}


export default StorePlayTimePlan;