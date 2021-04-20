'use strict';

import React, { Component } from 'react';


import event_timer_layer from '../res/img/event_timer_layer_1.png';

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
      untilTime: moment_timezone('2021-01-08 23:59:59'),
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

    let timeDiff = this.state.untilTime.diff(nowTime_moment);
    if(timeDiff < 0){
      timeDiff = 0;
      let durationMomentTime = moment_timezone.duration(timeDiff);
      this.setState({
        durationMomentTime: durationMomentTime
      })
      this.stopTimer();
      return;
    }

    let durationMomentTime = moment_timezone.duration(timeDiff);

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

    let untilTimeDom = <></>;
    let durationTimerDom = <></>;
    if(this.state.durationMomentTime !== null){
      untilTimeDom = <div className={'time_until_container'}>
                      <div className={'time_until_label_text'}>
                        진행 기간
                      </div>
                      <div className={'time_until_text'}>
                        {moment_timezone(this.state.untilTime).format("YYYY. MM. DD 까지")}
                      </div>
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

      durationTimerDom = <div className={'time_duration_container'}>
                          <div className={'time_until_label_text'}>
                            남은시간
                          </div>
                          <div className={'time_duration_text_container'}>
                            <div className={'time_duration_day_text'}>
                              {this.state.durationMomentTime.days()}일 
                            </div>
                            <div className={'time_duration_timer_text'}>
                              {hour}:
                              {min}:
                              {sec}
                            </div>
                          </div>
                        </div>
    }
    
    return(
      <div className={'EventPage'}>
        {contents_array}
        <div style={{display: 'flex', flexDirection: 'column', alignItems: 'center', backgroundColor: '#910000', fontSize: 20, paddingTop: 40, paddingBottom: 40, height: 440, position: 'relative', justifyContent: 'center'}}>
          <img style={{position: 'absolute', top: 0}} src={event_timer_layer} />
          <div className={'timer_container'}>
            {untilTimeDom}
            {durationTimerDom}
          </div>
        </div>

        <div className={'item_list_container_warpper'}>
          {item_list_array}
        </div>
      </div>
    )
  }
};

export default EventPage;