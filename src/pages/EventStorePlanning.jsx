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


class EventStorePlanning extends Component{
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
          layer_1: testword,
          layer_2: null,
          background_url: 'https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/200224_corona_bg.png',
          // background_height: 325
        },
        {
          key: 2,
          // layer_1: 'https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/200224_corona_pc_2.png',
          layer_1: testword2,
          layer_2: null,
          background_url: 'https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/191210_banner_africabj_bg_ver1.png',
          // background_height: 325
        }
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
        {
          key: 2,
          height: this.imgRefs[1].ref.current.clientHeight
        }
        
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
      // const dom = <div className={'layer_container'} key={i} style={{height: data.background_height}}>
      const dom = <div className={'EventStoreContainer'} key={i} style={{height: this.state.heights[i].height}}>
                    <img className={'background_img'} src={data.background_url} />
                    <div className={'layer_container'}>
                      {/* <img ref={(ref) => {this.imgRefs[0].ref = ref}} className={'layer_img'} src={data.layer_1} /> */}
                      <img onLoad={this.onImgLoad} ref={this.imgRefs[i].ref} className={'layer_img'} src={data.layer_1} />
                    </div>
                  </div>;
      
      contents_array.push(dom);
    }
    return(
      <div className={'EventStorePlanning'}>
        {contents_array}
      </div>
    )
  }
};

export default EventStorePlanning;