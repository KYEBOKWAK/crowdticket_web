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

import testword from '../res/img/testword.png';
import testword2 from '../res/img/testword2.png';
import testbg from '../res/img/testbg.png';
import testlayer1 from '../res/img/testlayersnow.png';

import moment_timezone from 'moment-timezone';


class EventStorePlanning extends Component{

  timerInterval = null;

  imgRefs = 
  [
    {
      key: 1,
      // layer_1: 'https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/200224_corona_pc_2.png',
      ref: React.createRef()
    },
    {
      key: 2,
      // layer_1: 'https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/200224_corona_pc_2.png',
      ref: React.createRef()
    },
  ]

  
  constructor(props){
    super(props);

    this.state = {
      untilTime: moment_timezone('2021-01-10 18:00:00'),
      durationMomentTime: null,
      heights: 
      [
        {
          key: 1,
          height: 0
        },
        {
          key: 2,
          height: 0
        }
      ],
      // height: 0,
      datas: 
      [
        {
          key: 1,
          // layer_1: 'https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/200224_corona_pc_2.png',
          layer_1: testlayer1,
          layer_2: testword,
          background_url: testbg,
          // background_height: 325
        },
        // {
        //   key: 2,
        //   // layer_1: 'https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/200224_corona_pc_2.png',
        //   layer_1: testword2,
        //   layer_2: null,
        //   background_url: 'https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/191210_banner_africabj_bg_ver1.png',
        //   // background_height: 325
        // }
      ]
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

    this.startTimer();
    this.setDurationTimer();

    // console.log(nowTime_moment.format('X'));  //seconds

    // console.log(nowTime_moment.format('x'));  //miliseconds

    // console.log(moment_timezone.duration(this.state.untilTime.diff(nowTime_moment)).hours());
  };

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

    this.setState({
      heights: 
      [
        {
          key: 1,
          height: this.imgRefs[0].ref.current.clientHeight
        },
        // {
        //   key: 2,
        //   height: this.imgRefs[1].ref.current.clientHeight
        // }
        
      ]
    })
    // if(window.innerWidth > 520){
    //   //pc
    //   this.setState({
    //     bottom: 32,
    //     right: 32
    //   })
    // }else{
    //   //mobile
    //   this.setState({
    //     bottom: 77,
    //     right: 24
    //   })
      
    // }
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

  render(){
    let contents_array = [];
    for(let i = 0 ; i < this.state.datas.length ; i++){
      const data = this.state.datas[i];

      let layer_1_dom = <></>;
      let layer_2_dom = <></>;

      if(data.layer_1 !== null){
        layer_1_dom = <div className={'layer_1_container'}>
                        <img className={'layer_1_img'} src={data.layer_1} />
                      </div>
      }

      if(data.layer_2 !== null){
        layer_2_dom = <div className={'layer_container'}>
                        <img onLoad={this.onImgLoad} ref={this.imgRefs[i].ref} className={'layer_img'} src={data.layer_2} />
                      </div>
      }
      // const dom = <div className={'layer_container'} key={i} style={{height: data.background_height}}>
      const dom = <div className={'EventStoreContainer'} key={i} style={{height: this.state.heights[i].height}}>
                    <img className={'background_img'} src={data.background_url} />
                    {layer_2_dom}
                    {layer_1_dom}
                  </div>;
      
      contents_array.push(dom);
    }

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
      <div className={'EventStorePlanning'}>
        {contents_array}
        <div style={{display: 'flex', flexDirection: 'column', alignItems: 'center', fontSize: 20, paddingTop: 40, paddingBottom: 40}}>
          {untilTimeDom}
          {durationTimerDom}
        </div>
      </div>
    )
  }
};

export default EventStorePlanning;