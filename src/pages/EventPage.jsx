'use strict';

import react from 'react';
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

// import test_bland from '../res/img/test_bland.png';

import moment_timezone from 'moment-timezone';
import axios from '../lib/Axios';
import Types from '../Types';

const ITEM_LINE_ITEM_COUNT_MAX = 2;

class EventPage extends Component{

  timerInterval = null;

  imgRefs = [];
  
  constructor(props){
    super(props);

    this.state = {
      untilTime: moment_timezone('2021-01-10 18:00:00'),
      durationMomentTime: null,
      
      heights: [],//layer 1의 height 를 저장한다.
      // height: 0,
      datas: [],

      itemDatas: [],

      isInit: false
    }

    this.updateDimensions = this.updateDimensions.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    // console.log(this.imgRefs[0].ref)
    // console.log(this.imgRefs[0].ref.current.clientHeight)

    window.addEventListener('resize', this.updateDimensions);


    // let unitlTime = moment_timezone('2020-12-17 16:00:00');

    // let nowTime_moment = moment_timezone('2020-12-17 15:00:00');

    // let seconds = nowTime_moment.format('X');

    // let test = moment_timezone.unix(seconds).format("YYYY-MM-DD HH:mm:ss");
    // console.log(test);


    this.initData();

    

    // console.log(nowTime_moment.format('X'));  //seconds

    // console.log(nowTime_moment.format('x'));  //miliseconds

    // console.log(moment_timezone.duration(this.state.untilTime.diff(nowTime_moment)).hours());
  };

  initData = () => {

    const event_alias_dom = document.querySelector('#event_alias');
    if(!event_alias_dom){
      alert("잘못된 접근입니다");
      return;
    }

    axios.post("/event/any/pages", {
      alias: event_alias_dom.value
    }, (result) => {

      let _heights = [];
      let _datas = [];
      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];

        const eventData = {
          key: i,
          layer_1: data.layer_1,
          layer_2: data.layer_2,
          background_url: data.background_url,
        }
        const heightData = {
          key: i,
          height: 0
        }
  
        const imgRefData = {
          key: i,
          ref: React.createRef()
        }
  
        _datas.push(eventData);
        _heights.push(heightData);
  
        this.imgRefs.push(imgRefData);
      }

      this.setState({
        heights: _heights.concat(),
        datas: _datas.concat(),
        isInit: true
      }, () => {
        this.startTimer();
        this.setDurationTimer();
      })
    }, (error) => {

    })

    axios.post("/event/any/items", {
      alias: event_alias_dom.value
    }, (result) => {
      this.setState({
        itemDatas: result.list.concat()
      })
    }, (error) => {

    })
  }

  setDurationTimer = () => {
    let nowTime_moment = moment_timezone();

    let durationMomentTime = moment_timezone.duration(this.state.untilTime.diff(nowTime_moment));

    this.setState({
      durationMomentTime: durationMomentTime
    })
  }

  startTimer = () => {
    this.stopTimer();
    
    this.timerInterval = setInterval(() => {

      this.setDurationTimer();

     }, 1000);
  }

  stopTimer = () => {
    clearInterval(this.timerInterval);
    this.timerInterval = null;
  };

  updateDimensions(){

    // console.log(this.imgRefs[0].ref.current.clientHeight);

    let _heights = this.state.heights.concat();

    for(let i = 0 ; i < this.imgRefs.length ; i++){
      const refData = this.imgRefs[i];
      const layer_height = refData.ref.current.clientHeight;

      let heightData = _heights.find((value) => {return value.key === refData.key});

      heightData.height = layer_height;
    }

    // console.log(this.imgRefs[0].ref.current.clientHeight);

    this.setState({
      heights: _heights.concat()
    })
  }

  componentWillUnmount(){
    this.stopTimer();
  };

  componentDidUpdate(){
  }

  onImgLoad = (img) => {
    this.updateDimensions();
    // console.log(img.target.offsetHeight);
    // console.log(this.imgRefs[0].ref.current.clientHeight)
    // this.setState({dimensions:{height:img.offsetHeight,
    //                            width:img.offsetWidth}});
  }

  onClickItem = (e, target_type, target_id) => {
    e.preventDefault();

    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    if(target_type === Types.event_target_type.store_item){
      baseURL = baseURL + '/item/store/'+target_id;
    }
    
    window.location.href = baseURL;
  }

  render(){
    if(!this.state.isInit){
      return (
        <div>
        </div>
      )
    }

    let contents_array = [];
    for(let i = 0 ; i < this.state.datas.length ; i++){
      const data = this.state.datas[i];

      const heightData = this.state.heights.find((value) => {return value.key === data.key});
      let refData = this.imgRefs.find((value) => {return value.key === data.key});

      let layer_1_dom = <></>;
      let layer_2_dom = <></>;

      if(data.layer_1 !== null){
        layer_1_dom = <div className={'layer_container'}>
                        <img onLoad={this.onImgLoad} ref={refData.ref} className={'layer_img'} src={data.layer_1} />
                      </div>
      }

      if(data.layer_2 !== null){
        layer_2_dom = <div className={'layer_2_container'}>
                        <img className={'layer_2_img'} src={data.layer_2} />
                      </div>
      }
      
      const dom = <div className={'EventStoreContainer'} key={i} style={{height: heightData.height}}>
                    <img className={'background_img'} src={data.background_url} />
                    {layer_1_dom}
                    {layer_2_dom}
                  </div>;
      
      contents_array.push(dom);
    }

    //총 나와야 하는 줄 수
    let lineCountMax = Math.ceil(this.state.itemDatas.length / ITEM_LINE_ITEM_COUNT_MAX);
    // console.log(lineCountMax);

    let itemIndex = 0;
    let item_list_array = [];
    for(let i = 0 ; i < lineCountMax ; i++){

      if(itemIndex >= this.state.itemDatas.length){
        break;
      }

      let items_array = [];
      
      for(let j = 0 ; j < ITEM_LINE_ITEM_COUNT_MAX ; j++){

        if(itemIndex >= this.state.itemDatas.length){
          break;
        }

        const data = this.state.itemDatas[itemIndex];

        const dom = <button key={itemIndex} onClick={(e) => {this.onClickItem(e, data.target_type, data.target_id)}} className={'item_container'}>
                      <img className={'item_img'} src={data.thumb_img_url} />

                      <div className={'item_first_text text-ellipsize'}>
                        {data.first_text}
                      </div>
                      <div className={'item_second_text text-ellipsize-2'}>
                        {data.second_text}
                      </div>
                      <div className={'item_third_text text-ellipsize'}>
                        {data.third_text}
                      </div>
                    </button>;
        
        items_array.push(dom);

        itemIndex++;
      }

      let container_dom = <div key={i} className={'item_list_container'}>
                            {items_array}
                          </div>

      item_list_array.push(container_dom)
    }

    

    /*
    let items_array = [];
    for(let i = 0 ; i < this.state.itemDatas.length ; i++){

      // const itemListContainerClassName = 'item_list_container_flex';
      // if(i % 2 === 0 ){

      // }

      const data = this.state.itemDatas[i];
      console.log(data);

      
      const dom = <div key={i}>
                    <img className={'item_img'} src={data.thumb_img_url} />

                    <div className={'item_first_text text-ellipsize'}>
                      {data.first_text}
                    </div>
                    <div className={'item_second_text text-ellipsize-2'}>
                      {data.second_text}
                    </div>
                    <div className={'item_third_text text-ellipsize'}>
                      {data.third_text}
                    </div>
                  </div>;
      
      items_array.push(dom);
    }
    */
    

    let untilTimeDom = <></>;
    let durationTimerDom = <></>;
    if(this.state.durationMomentTime !== null){
      untilTimeDom = <div>
                      {moment_timezone(this.state.untilTime).format("YYYY년 MM월 DD일 HH:mm 까지")}
                    </div>
      
      let hour = this.state.durationMomentTime.hours();
      if(hour < 10){
        hour = '0'+hour;
      }
      let min = this.state.durationMomentTime.minutes();
      if(min < 10){
        min = '0'+min;
      }
      let sec = this.state.durationMomentTime.seconds();
      if(sec < 10){
        sec = '0'+sec;
      }

      durationTimerDom = <div style={{display: 'flex', flexDirection: 'column', alignItems: 'center'}}>
                          남은시간
                          <div style={{display: 'flex'}}>
                            {this.state.durationMomentTime.days()}일 
                            {hour}:
                            {min}:
                            {sec}
                          </div>
                        </div>
    }
    
    return(
      <div className={'EventPage'}>
        {contents_array}
        <div style={{display: 'flex', flexDirection: 'column', alignItems: 'center', fontSize: 20, paddingTop: 40, paddingBottom: 40}}>
          {untilTimeDom}
          {durationTimerDom}
        </div>

        {item_list_array}        
      </div>
    )
  }
};

export default EventPage;