'use strict';

import React, { Component, createRef } from 'react';

import Types from '../Types';

import ic_exit_circle from '../res/img/ic-exit-circle.svg';

import axios from '../lib/Axios';
import icon_box from '../res/img/icon-box.svg';

import moment_timezone from 'moment-timezone';

// import Quill from 'quill';

// start_time: null,
//           end_time: null,
//           select_time: null
class Popup_SelectTime extends Component{
  // _quill = null;

  constructor(props){
    super(props);

    let nowTimeMoment = moment_timezone();
    let endTimeMoment = moment_timezone(nowTimeMoment).add(90, 'days');

    this.state = {
      start_time: null,
      end_time: null,
      select_time: null,

      now_time_moment: nowTimeMoment,
      end_time_moment: endTimeMoment,

      select_year_show: '년',
      select_year_value: '',
      select_year_options: this.getYearOptionDom(nowTimeMoment, endTimeMoment),

      select_month_show: '월',
      select_month_value: '',
      select_month_options: [],

      select_day_show: '일',
      select_day_value: '',
      select_day_options: [],

      select_hour_start_show: '시',
      select_hour_start_value: '',
      select_hour_start_options: [],

      select_hour_end_show: '시',
      select_hour_end_value: '',
      select_hour_end_options: [],
    }

    // this.handleChange = this.handleChange.bind(this)
    //3.0.0
    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  // getQuillHeight = () => {
  //   return window.innerHeight - 240;//36은 하단의 버튼 container 높이임
  // }

  componentDidMount(){
    console.log(this.props.selectTimeData);

    if(this.props.selectTimeData.start_time === null){
      //null이면 현재 시간 기준임.
      const nowYear = this.state.now_time_moment.year();
      this.setState({
        select_year_show: nowYear + '년',
        select_year_value: nowYear,
      }, () => {
        this.setMonthValue();
      })
    }else{
      let nowTimeMoment = moment_timezone(this.props.selectTimeData.start_time);
      let endTimeMoment = moment_timezone(this.props.selectTimeData.end_time);

      const nowYear = nowTimeMoment.year();
      this.setState({
        now_time_moment: nowTimeMoment,
        end_time_moment: endTimeMoment,

        select_year_show: nowYear + '년',
        select_year_value: nowYear,
        select_year_options: this.getYearOptionDom(nowTimeMoment, endTimeMoment),
      }, () => {
        this.setMonthValue();
      })
    }
    // this.requestProductText();

    // let nowTimeMoment = moment_timezone().format("YYYY-MM-DD HH:mm:ss");
    // let endTimeMoment = moment_timezone(nowTimeMoment).add(90, 'days').format("YYYY-MM-DD HH:mm:ss");

    // let nowTimeMoment = moment_timezone();
    // let endTimeMoment = moment_timezone(nowTimeMoment).add(90, 'days');

    // console.log(nowTimeMoment.year() + ' / ' + nowTimeMoment.month() + ' / ' + nowTimeMoment.day());
    // console.log(nowTimeMoment);
    // console.log(endTimeMoment);

    // console.log(this.getYearOption(nowTimeMoment, endTimeMoment));
    // console.log(endTimeMoment.year());

    // this.setState({
    //   select_year_options: this.getYearOptionDom(this.state.now_time_moment, this.state.end_time_moment)
    // })
  };

  setMonthValue = () => {
    this.setState({
      select_month_show: this.getMonthSelectValue() + '월',
      select_month_value: this.getMonthSelectValue(),
      select_month_options: this.getMonthOptionDom()
    }, () => {
      // this.getDaysOptionDom();
      this.setDaysValue();
    })
  }

  getYearOptionDom = (nowTimeMoment, endTimeMoment) => {
    let years = [];

    years.push(<option key={0} value={nowTimeMoment.year()}>{nowTimeMoment.year()}</option>);

    if(nowTimeMoment.year() < endTimeMoment.year()){
      years.push(<option key={1} value={endTimeMoment.year()}>{endTimeMoment.year()}</option>);
    }

    return years;
  }

  getMonthSelectValue = () => {
    const nowYear = this.state.now_time_moment.year();
    const endYear = this.state.end_time_moment.year();

    let startMonth = 0;
    let endMonth = 0;

    const selectYear = Number(this.state.select_year_value);
    if(selectYear === nowYear){
      startMonth = this.state.now_time_moment.month();
      if(selectYear === endYear){
        //end가 같은 해면 endmonth 셋팅
        endMonth = this.state.end_time_moment.month();
      }else{
        endMonth = 12;
      }
    }else if(selectYear === endYear){
      startMonth = 0;
      endMonth = this.state.end_time_moment.month();
    }

    return startMonth + 1;
  }

  getMonthOptionDom = () => {

    const nowYear = this.state.now_time_moment.year();
    const endYear = this.state.end_time_moment.year();

    let startMonth = 0;
    let endMonth = 0;

    const selectYear = Number(this.state.select_year_value);
    if(selectYear === nowYear){
      startMonth = this.state.now_time_moment.month() + 1;
      if(selectYear === endYear){
        //end가 같은 해면 endmonth 셋팅
        endMonth = this.state.end_time_moment.month() + 1;
      }else{
        endMonth = 12;
      }
    }else if(selectYear === endYear){
      startMonth = 1;
      endMonth = this.state.end_time_moment.month() + 1;
    }

    let month_options_dom = [];
    for(let i = startMonth ; i <= endMonth ; i++){
      let _month = i;
      month_options_dom.push(<option key={_month} value={_month}>{_month}</option>);
    }

    // console.log(this.state.end_time_moment.format("YYYY-MM-DD"));

    return month_options_dom;

    // console.log(moment_timezone.duration(this.state.end_time_moment.diff(this.state.now_time_moment)).months());

    // moment_timezone.duration(this.state.end_time_moment.diff(this.state.now_time_moment)).months()
    /*
    const nowYear = this.state.now_time_moment.year();

    // const nextMonthMoment = moment_timezone(this.state.now_time_moment).add(1, 'month').format("YYYY-MM-01");
    const nextMonthMoment = moment_timezone('2020-02-03').add(1, 'month').format("YYYY-MM-01");
    const nowMaxData = moment_timezone(nextMonthMoment).add(-1, 'day').format("YYYY-MM-DD");
    console.log(nowMaxData);
    if(this.state.select_year_value === nowYear){

    }
    */
    
  }

  getDaysValue = () => {
    let selectYear = Number(this.state.select_year_value);
    let selectMonth = Number(this.state.select_month_value);

    let selectMM = Number(this.state.select_month_value);
    if(selectMM < 10){
      selectMM = '0'+selectMM;
    }

    const selectYYYYMM = selectYear+'-'+selectMM;
    const daysInMonth = moment_timezone(selectYYYYMM).daysInMonth();

    const nowYear = this.state.now_time_moment.year();
    const endYear = this.state.end_time_moment.year();

    const nowMonth = this.state.now_time_moment.month() + 1;
    const endMonth = this.state.end_time_moment.month() + 1;

    let startDay = 0;
    let endDay = 0;
    if(selectYear === nowYear && selectMonth === nowMonth){
      //현재 년도와 월이 선택한 날과 똑같다면, now_time_moment 의 날짜가 start 한다.
      startDay = this.state.now_time_moment.date();
      endDay = daysInMonth;
    }
    else if(selectYear === endYear && selectMonth === endMonth){
      startDay = 1;
      endDay = this.state.end_time_moment.date();
    }
    else{
      startDay = 1;
      endDay = daysInMonth;
    }

    return startDay;
  }

  getDaysOptionDom = () => {
    let selectYear = Number(this.state.select_year_value);
    let selectMonth = Number(this.state.select_month_value);

    let selectMM = Number(this.state.select_month_value);
    if(selectMM < 10){
      selectMM = '0'+selectMM;
    }

    const selectYYYYMM = selectYear+'-'+selectMM;
    const daysInMonth = moment_timezone(selectYYYYMM).daysInMonth();

    const nowYear = this.state.now_time_moment.year();
    const endYear = this.state.end_time_moment.year();

    const nowMonth = this.state.now_time_moment.month() + 1;
    const endMonth = this.state.end_time_moment.month() + 1;

    let startDay = 0;
    let endDay = 0;
    if(selectYear === nowYear && selectMonth === nowMonth){
      //현재 년도와 월이 선택한 날과 똑같다면, now_time_moment 의 날짜가 start 한다.
      startDay = this.state.now_time_moment.date();
      endDay = daysInMonth;
    }
    else if(selectYear === endYear && selectMonth === endMonth){
      startDay = 1;
      endDay = this.state.end_time_moment.date();
    }
    else{
      startDay = 1;
      endDay = daysInMonth;
    }

    let day_options_dom = [];
    for(let i = startDay ; i <= endDay ; i++){
      day_options_dom.push(<option key={i} value={i}>{i}</option>);
    }

    return day_options_dom;

    
    // console.log(this.state.select_year_value+'-'+month);
    // console.log(moment_timezone(this.state.select_year_value+'-'+month).daysInMonth());
  }

  setDaysValue = () => {
    this.setState({
      select_day_value: this.getDaysValue(),
      select_day_show: this.getDaysValue() + '일',
      select_day_options: this.getDaysOptionDom()
    }, () => {
      this.setTimeStartValue();
    })
  }

  setTimeStartValue = () => {
    this.setState({
      select_hour_start_show: this.getTimeStartShow(),
      select_hour_start_value: this.getTimeStartValue(),
      select_hour_start_options: this.getTimeStartOptionDom()
    }, () => {
      this.setTimeEndValue();
    })
  }

  getTimeStartShow = () => {
    
    let selectYear = Number(this.state.select_year_value);
    let selectMonth = Number(this.state.select_month_value);
    let selectDay = Number(this.state.select_day_value);

    const nowYear = this.state.now_time_moment.year();
    const nowMonth = this.state.now_time_moment.month() + 1;
    const nowDay = this.state.now_time_moment.date();
    const nowHour = this.state.now_time_moment.hour();

    let startTimeStart = 1;
    let endTimeStart = 23;
    if(selectYear === nowYear && selectMonth === nowMonth && selectDay === nowDay){
      startTimeStart = nowHour;
    }

    let start_at = '오전';
    if(startTimeStart > 12){
      start_at = '오후';
      startTimeStart = startTimeStart - 12;
    }

    if(startTimeStart < 10){
      startTimeStart = '0'+startTimeStart;
    }

    return start_at + ' ' + startTimeStart + '시';
  }

  getTimeStartValue = () => {
    let selectYear = Number(this.state.select_year_value);
    let selectMonth = Number(this.state.select_month_value);
    let selectDay = Number(this.state.select_day_value);

    const nowYear = this.state.now_time_moment.year();
    const nowMonth = this.state.now_time_moment.month() + 1;
    const nowDay = this.state.now_time_moment.date();
    const nowHour = this.state.now_time_moment.hour();

    let startTimeStart = 1;
    if(selectYear === nowYear && selectMonth === nowMonth && selectDay === nowDay){
      startTimeStart = nowHour;
    }

    return startTimeStart;
  }

  getTimeStartOptionDom = () => {
    let selectYear = Number(this.state.select_year_value);
    let selectMonth = Number(this.state.select_month_value);
    let selectDay = Number(this.state.select_day_value);

    const nowYear = this.state.now_time_moment.year();
    const nowMonth = this.state.now_time_moment.month() + 1;
    const nowDay = this.state.now_time_moment.date();
    const nowHour = this.state.now_time_moment.hour();

    let startTimeStart = 1;
    let endTimeStart = 23;
    if(selectYear === nowYear && selectMonth === nowMonth && selectDay === nowDay){
      startTimeStart = nowHour;
    }

    let time_start_options_dom = [];
    for(let i = startTimeStart ; i <= endTimeStart ; i++){
      let _time = i;
      let start_at = '오전';
      if(_time > 12){
        start_at = '오후';
        _time = _time - 12;
      }

      if(_time < 10){
        _time = '0'+_time;
      }

      _time = start_at + ' ' + _time;

      time_start_options_dom.push(<option key={i} value={i}>{_time}</option>);
    }

    return time_start_options_dom;
  }

  setTimeEndValue = () => {
    this.setState({
      select_hour_end_show: this.getTimeEndShow(),
      select_hour_end_value: this.getTimeEndValue(),
      select_hour_end_options: this.getTimeEndOptionDom()
    })
  }

  getTimeEndShow = () => {
    let startTimeEnd = Number(this.state.select_hour_start_value) + 1;

    let start_at = '오전';
    if(startTimeEnd > 12){
      start_at = '오후';
      startTimeEnd = startTimeEnd - 12;
    }

    if(startTimeEnd < 10){
      startTimeEnd = '0'+startTimeEnd;
    }

    return start_at + ' ' + startTimeEnd + '시';
  }

  getTimeEndValue = () => {
    let startTimeEnd = Number(this.state.select_hour_start_value) + 1;

    return startTimeEnd;
  }

  getTimeEndOptionDom = () => {
    let startTimeEnd = Number(this.state.select_hour_start_value);
    let endTimeEnd = 23;

    let time_end_options_dom = [];
    for(let i = startTimeEnd ; i <= endTimeEnd ; i++){
      let _time = i;
      let start_at = '오전';
      if(_time > 12){
        start_at = '오후';
        _time = _time - 12;
      }

      if(_time < 10){
        _time = '0'+_time;
      }

      _time = start_at + ' ' + _time;

      time_end_options_dom.push(<option key={i} value={i}>{_time}</option>);
    }

    return time_end_options_dom;
  }

  componentWillUnmount(){
  };

  componentDidUpdate(){
    
  }

  handleChange(value) {
  }

  onClickExit = (e) => {
    e.preventDefault();

    // let targetElement = document.querySelector('#react_root');
    // enableBodyScroll(targetElement);

    this.props.closeCallback();
  }

  onChangeInput(e){
    e.preventDefault();

    // this.setState({
    //   title: e.target.value
    // })
  }

  onChangeYearChange = (event) => {
    this.setState({
      // card_mm: event.target.value,
      select_year_value: event.target.value,
      select_year_show: event.target.value + '년'
    }, () => {
      this.setMonthValue();
    })
  }

  onChangeMonthChange = (event) => {
    this.setState({
      // card_mm: event.target.value,
      select_month_value: event.target.value,
      select_month_show: event.target.value + '월'
    }, () => {
      this.setDaysValue();
    })
  }

  onChangeDayChange = (event) => {
    this.setState({
      // card_mm: event.target.value,
      select_day_value: event.target.value,
      select_day_show: event.target.value + '일'
    }, () => {
      this.setTimeStartValue();
    })
  }

  onChangeTimeStartChange = (event) => {

    let value = event.target.value;
    
    let start_at = '오전';
    if(value > 12){
      start_at = '오후';
      value = value - 12;
    }

    if(value < 10){
      value = '0'+value;
    }

    this.setState({
      select_hour_start_value: event.target.value,
      select_hour_start_show: start_at + ' ' + value + '시'
    }, () => {
      this.setTimeEndValue();
    })
  }

  onChangeTimeEndChange = (event) => {
    let value = event.target.value;
    
    let start_at = '오전';
    if(value > 12){
      start_at = '오후';
      value = value - 12;
    }

    if(value < 10){
      value = '0'+value;
    }

    this.setState({
      select_hour_end_value: event.target.value,
      select_hour_end_show: start_at + ' ' + value + '시'
    })
  }

  onClickSetTime = (e) => {
    e.preventDefault();

    if(this.state.select_year_value === ''){
      alert("년도 선택 오류");
      return;
    }
    else if(this.state.select_month_value === ''){
      alert("월 선택 오류");
      return;
    }
    else if(this.state.select_day_value === ''){
      alert("일 선택 오류");
      return;
    }
    else if(this.state.select_hour_start_value === ''){
      alert("시작 시간 선택 오류");
      return;
    }
    else if(this.state.select_hour_end_value === ''){
      alert("끝 시간 선택 오류");
      return;
    }

    let _month = this.state.select_month_value;
    if(Number(this.state.select_month_value) < 10){
      _month = '0'+_month;
    }

    let _day = this.state.select_day_value;
    if(Number(this.state.select_day_value) < 10){
      _day = '0'+_day;
    }

    let _start_time = this.state.select_hour_start_value;
    if(Number(this.state.select_hour_start_value) < 10){
      _start_time = '0'+_start_time;
    }

    let _end_time = this.state.select_hour_end_value;
    if(Number(this.state.select_hour_end_value) < 10){
      _end_time = '0' + _end_time;
    }


    let _start_full_time = this.state.select_year_value+'-'+_month+'-'+_day+' '+_start_time+':00';
    let _end_full_time = this.state.select_year_value+'-'+_month+'-'+_day+' '+_end_time+':00';

    const selectTimeData = {
      key: this.props.selectTimeData.key,
      start_time: _start_full_time,
      end_time: _end_full_time,
      select_time: null
    }

    this.props.setCallback(selectTimeData);
  }

  render(){    
    return(
      <div className={'Popup_SelectTime'}>
        <div className={'popup_select_time_container'}>

          <div className={'days_container'}>
            <div className={'select_box'}>
              {this.state.select_year_show}
              <img src={icon_box} />

              <select className={'select_tag'} value={this.state.select_year_value} onChange={this.onChangeYearChange}>
                {this.state.select_year_options}
              </select>
            </div>

            <div className={'select_box'}>
              {this.state.select_month_show}
              <img src={icon_box} />

              <select className={'select_tag'} value={this.state.select_month_value} onChange={this.onChangeMonthChange}>
                {this.state.select_month_options}
              </select>
            </div>

            <div className={'select_box'}>
              {this.state.select_day_show}
              <img src={icon_box} />

              <select className={'select_tag'} value={this.state.select_day_value} onChange={this.onChangeDayChange}>
                {this.state.select_day_options}
              </select>
            </div>
          </div>
          
          <div className={'time_container'}>
            <div className={'select_box_time_container'}>
              <div className={'select_box select_box_time'}>
                {this.state.select_hour_start_show}
                <img src={icon_box} />

                <select className={'select_tag'} value={this.state.select_hour_start_value} onChange={this.onChangeTimeStartChange}>
                  {this.state.select_hour_start_options}
                </select>
              </div>
              <div className={'select_box_time_label_text'}>
                부터
              </div>
            </div>

            <div className={'select_box_time_container'}>
              <div className={'select_box select_box_time'}>
                {this.state.select_hour_end_show}
                <img src={icon_box} />

                <select className={'select_tag'} value={this.state.select_hour_end_value} onChange={this.onChangeTimeEndChange}>
                  {this.state.select_hour_end_options}
                </select>
              </div>
              <div className={'select_box_time_label_text'}>
                사이
              </div>
            </div>
          </div>
          

          <div className={'button_container'}>
            <button onClick={(e) => {this.onClickExit(e)}} className={'button_close'}>
              닫기
            </button>

            <button onClick={(e) => {this.onClickSetTime(e)}}  className={'button_set'}>
              적용
            </button>
          </div>
        </div>
        
      </div>
    )
  }
};

Popup_SelectTime.defaultProps = {
  // store_order_id: null
  // previewURL: ''
  // state: Types.file_upload_state.NONE,
  // id: -1,
  // store_item_id: -1,
  // thumbUrl: '',
  // name: '',
  // title: '',
  // price: 0
}

export default Popup_SelectTime;