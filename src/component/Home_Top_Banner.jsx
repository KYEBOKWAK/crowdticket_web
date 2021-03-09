'use strict';

import React, { Component, createRef } from 'react';

import CountUp from 'react-countup';
import Carousel from '../component/Carousel';



import Lottie from './Lottie';

import axios from '../lib/Axios';
import Types from '../Types';

import ic_right from '../res/img/ic-white-right.svg';
import ic_left from '../res/img/ic-wihte-left.svg';


class Home_Top_Banner extends Component{

  COORDS = {
    xDown: null,
    xUp: null
  }

  Carousel = React.createRef();

  constructor(props){
    super(props);

    this.state = {
      items: [],

      nowIndex: 0
    }
  };

  componentDidMount(){
    this.requestCarousels();
  };

  componentWillUnmount(){
    this.Carousel = null;
  };

  componentDidUpdate(){
  }

  onClickPrev = (e) => {
    e.preventDefault();
    this.Carousel.onClickPrev(e);
  }

  onClickNext = (e) => {
    e.preventDefault();
    this.Carousel.onClickNext(e);
  }

  requestCarousels = () => {
    axios.post("/main/any/carousels", {}, 
    (result) => {
      // console.log(result);
      let _items = [];

      for(let i = 0 ; i < result.list.length ; i++){
        const data = result.list[i];
        
        let bgStyle = {
          backgroundColor: data.bg_color
        }

        let imageDom = <></>;

        if(data.bg_img_type === Types.carousel_bg_img_type.lottie){
          imageDom = <Lottie url={data.bg_img_url}></Lottie>;
        }else{
          imageDom = <img className={'item_img'} src={data.bg_img_url} />;
        }

        
        let title = data.title;
        let sub_title = data.sub_title;

        
        if(title !== null){
          let mapKey = 0;
          title = title.split('\n').map( (line) => {
                                                      mapKey++;
                                                      return (<div key={mapKey}>{line}</div>)
                                                    })
        }

        if(sub_title !== null){
          let mapKey = 0;
          sub_title = sub_title.split('\n').map( (line) => {
                                                              mapKey++;
                                                              return (<div key={mapKey}>{line}</div>)
                                                            })
        }
        
        
        const itemDom = <div className={'carousel_item_container'} style={bgStyle}>
                          <div 
                            onDragStart={(e) => {e.preventDefault();}} 
                            onMouseDown={(e) => {this.handleOnMouseDown(e)}}
                            onMouseUp={(e) => {this.handleMouseUp(e)}} 
                            onClick={(e) => {this.onClickImg(e)}} 
                            className={'right_contents'}
                          >
                            {imageDom}
                          </div>

                          <div className={'carousel_item_title_container'}>
                            <div className={'carousel_item_title_box'}>
                              <div className={'carousel_item_title'}>
                                {title}
                              </div>
                              <div className={'carousel_item_sub_title'}>
                                {sub_title}
                              </div>
                            </div>
                          </div>
                        </div>

        _items.push(itemDom);
      }

      this.setState({
        items: _items.concat()
      })
    }, (error) => {

    })
  }

  handleOnMouseDown = (e) => {
    e.preventDefault()
    this.COORDS.xUp = null
    this.COORDS.xDown = null
    
    this.COORDS.xDown = e.clientX
  }
  
  handleMouseUp = (e) => {
    e.preventDefault()
    this.COORDS.xUp = e.clientX
  }

  onClickImg = (e) => {
    e.preventDefault();
    // if (this.COORDS.xDown !== this.COORDS.xUp) {
      
    // } else {
      
    // }
  }

  render(){

    let nowIndex = this.state.nowIndex + 1;
    if(nowIndex < 10){
      nowIndex = '0'+nowIndex;
    }

    let totalCount = this.state.items.length;
    if(totalCount < 10){
      totalCount = '0'+totalCount;
    }
    return(
      <div className={'Home_Top_Banner'}>
        <Carousel 
          ref={(el) => (this.Carousel = el)} 
          items={this.state.items} 
          pc_show_item_count={1}
          autoPlay={false}
          autoPlayInterval={4000}
          animationDuration={600}
          infinite={true}
          onSlideChanged={(isNextSlideDisabled, isPrevSlideDisabled, index) => {
            this.setState({
              nowIndex: index
            })
          }}></Carousel>
          <div className={'carousel_buttons_container'}>
            <div className={'carousel_buttons_box'}>
              <button onClick={(e) => {this.onClickPrev(e)}} className={'carousel_button_left'}>
                <img src={ic_left} />
              </button>
              <button onClick={(e) => {this.onClickNext(e)}} className={'carousel_button_right'}>
                <img src={ic_right} />
              </button>
              <div className={'carousel_index_container'}>
                <div className={'carousel_index_text'}>
                  {nowIndex}
                </div>
                <div className={'carousel_total_text'}>
                  /{totalCount}
                </div>
              </div>
            </div>
          </div>
      </div>
    )
  }
};

export default Home_Top_Banner;