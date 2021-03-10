'use strict';

import React, { Component } from 'react';

import AliceCarousel from 'react-alice-carousel';

class Carousel extends Component{

  Carousel = React.createRef();

  isNextSlideDisabled = false;
  isPrevSlideDisabled = true;

  constructor(props){
    super(props);

    this.state = {
      innerWidth: 0,
      isResizing: false,
    }
  };

  shouldComponentUpdate(nextProps, nextState) {
    if(this.state.isResizing !== nextState.isResizing){
      return true;
    }

    if(this.props.items === nextProps.items && this.state.innerWidth === nextState.innerWidth){
      return false;
    }

    return true;
  }

  componentDidMount(){
    window.addEventListener('resize', () => {this.updateDimensions(false)});
    this.updateDimensions(true);
  };

  updateDimensions = (isInit) => {

    let isResizing = true;
    if(isInit){
      isResizing = false;
    }

    this.setState({
      innerWidth: window.innerWidth,
      isResizing: isResizing
    })
  }

  componentWillUnmount(){
    window.removeEventListener('resize', () => {this.updateDimensions(false)});
    this.Carousel = null;
  };

  componentDidUpdate(){
  }

  onClickPrev = (e) => {
    e.preventDefault();

    if(this.isPrevSlideDisabled){
      return;
    }

    this.Carousel.slidePrev();
  }

  onClickNext = (e) => {
    e.preventDefault();
    
    if(this.isNextSlideDisabled){
      return;
    }

    this.Carousel.slideNext();
  }

  onSlideChange = (e) => {
    this.props.onSlideChange(e.item);
  }

  onSlideChanged = (e) => {
    this.props.onSlideChanged(e.isNextSlideDisabled, e.isPrevSlideDisabled, e.item);
  }

  onInitialized = (e) => {
    this.props.onInitialized(e.item);
  }

  render(){
    let isAutoWidth = false;
    let responsive = undefined;

    if(this.props.pc_show_item_count === 1){      
      if(this.state.innerWidth < 1176){
        isAutoWidth = true;
      }else{
        responsive = {
          1176: {
            items: this.props.pc_show_item_count,
          },
        }
      }
      
    }else{
      if(this.props.pc_show_item_count > this.props.items.length){
        isAutoWidth = true;
      }else{
        if(this.state.innerWidth < 1176){
          isAutoWidth = true;
        }else{
          responsive = {
            1176: {
              items: this.props.pc_show_item_count,
            },
          }
        }
      }
    }

    let isInfinite = this.props.infinite;
    if(isInfinite){
      if(this.state.isResizing){
        isInfinite = false;
      }
    }
    
    return(
      <div style={{width: '100%'}}>
        <AliceCarousel 
          ref={(el) => (this.Carousel = el)}
          // slideToIndex={this.state.slideToIndex}
          autoWidth={isAutoWidth}
          mouseTracking
          items={this.props.items}
          disableButtonsControls={true}
          disableDotsControls={true}
          touchMoveDefaultEvents={true}
          responsive={responsive}
          autoPlay={this.props.autoPlay}
          autoPlayInterval={this.props.autoPlayInterval}
          animationDuration={this.props.animationDuration}
          infinite={isInfinite}
          onInitialized={(e) => {
            this.onInitialized(e);
          }}
          onSlideChange={(e) => {
            this.onSlideChange(e);
          }}
          onSlideChanged={(e) => {
            this.isNextSlideDisabled = e.isNextSlideDisabled;
            this.isPrevSlideDisabled = e.isPrevSlideDisabled;
            this.onSlideChanged(e);
          }}
          onResized={(e) => {
            this.setState({
              isResizing: false
            })
          }}
        />
      </div>
    )
  }
};

Carousel.defaultProps = {
  onInitialized: (index) => {},
  onSlideChange: (index) => {},
  autoPlay: false,
  autoPlayInterval: 400,
  animationDuration: 400,
  infinite: false
}

export default Carousel;