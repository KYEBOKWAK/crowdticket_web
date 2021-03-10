'use strict';

import React, { Component, createRef } from 'react';

import Carousel from '../component/Carousel';

import Carousel_Item_Counting from '../component/Carousel_Item_Counting';

import Lottie from './Lottie';

import axios from '../lib/Axios';
import Types from '../Types';

import ic_right from '../res/img/ic-white-right.svg';
import ic_left from '../res/img/ic-wihte-left.svg';

import ic_go_store from '../res/img/img-go-store.svg';


class Home_Top_Banner extends Component{

  COORDS = {
    xDown: null,
    xUp: null
  }

  Carousel = React.createRef();

  CountUpStoresRefs = [];
  
  constructor(props){
    super(props);

    this.state = {
      items: [],

      nowIndex: 0,

      countUpStoreItemIndex: -1
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

  onClickItem = (e, target_id, target_type) => {
    if (this.COORDS.xDown !== this.COORDS.xUp) {
      e.preventDefault();
    } else {
      
      let baseURL = 'https://crowdticket.kr'
      const baseURLDom = document.querySelector('#base_url');
      if(baseURLDom){
        baseURL = baseURLDom.value;
      }

      let goURL = '';
      let isPopup = false;

      if(target_type === Types.carousel_target_type.store_event_info){
        goURL = 'https://forms.gle/vRiirC1mdfgUbZLt5';
        isPopup = true;
      }
      else if(target_type === Types.carousel_target_type.link_store){
        goURL = baseURL + '/store/'+target_id;
      }
      else if(target_type === Types.carousel_target_type.link_magazine){
        goURL = baseURL + '/magazine/'+target_id;
      }

      if(isPopup){
        window.open(goURL);
      }else{
        window.location.href = goURL;
      }
    }    
  }

  requestCarousels = () => {
    axios.post("/main/any/carousels", {}, 
    (result) => {
      // console.log(result);
      let _items = [];

      let countUpStoreItemIndex = this.state.countUpStoreItemIndex;

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

        let contentsBottomDom = <></>;
        let isButtonDisabled = false;
        if(data.target_type === Types.carousel_target_type.store_info_count){
          isButtonDisabled = true;
          countUpStoreItemIndex = i;

          contentsBottomDom = <div className={'carousel_counting_contents_container'}>
                                <Carousel_Item_Counting
                                  ref={(ref) => {                                    
                                    this.CountUpStoresRefs.push(ref);
                                  }}

                                  init={() => {
                                    this.CountUpStoresRefs = [];
                                  }}
                                >
                                </Carousel_Item_Counting>
                              </div>
          
        }else if(data.target_type === Types.carousel_target_type.link_store){
          contentsBottomDom = <div className={'carousel_go_store_img_container'}>
                                <img className={'carousel_go_store_img'} src={ic_go_store} />
                              </div>
        }
        else{
          contentsBottomDom = <div className={'carousel_item_sub_title'}>
                                {sub_title}
                              </div>
        }
        
        const itemDom = <button onDragStart={(e) => {e.preventDefault();}} 
                          onMouseDown={(e) => {this.handleOnMouseDown(e)}}
                          onMouseUp={(e) => {this.handleMouseUp(e)}} 
                          onClick={(e) => {this.onClickItem(e, data.target_id, data.target_type)}} 
                          className={'carousel_item_container'} 
                          style={bgStyle} 
                          disabled={isButtonDisabled}
                        >
                          <div className={'right_contents'}>
                            {imageDom}
                          </div>

                          <div className={'carousel_item_title_container'}>
                            <div className={'carousel_item_title_box'}>
                              <div className={'carousel_item_title'}>
                                {title}
                              </div>
                              {contentsBottomDom}
                            </div>
                          </div>
                        </button>

        _items.push(itemDom);
      }

      this.setState({
        items: _items.concat(),
        countUpStoreItemIndex: countUpStoreItemIndex
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

  reStartCarouselCountUpItem = () => {
    for(let i = 0 ; i < this.CountUpStoresRefs.length ; i++){
      if(this.CountUpStoresRefs[i] === null){
        continue;
      }

      this.CountUpStoresRefs[i].reStartCountUp();
    }
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
          autoPlay={true}
          autoPlayInterval={5000}
          animationDuration={600}
          infinite={true}
          onSlideChanged={(isNextSlideDisabled, isPrevSlideDisabled, index) => {
            this.setState({
              nowIndex: index
            }, () => {
              //스토어 카운팅 되는 아이템이 있다면
              if(this.state.countUpStoreItemIndex === this.state.nowIndex){
                this.reStartCarouselCountUpItem();
              }
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