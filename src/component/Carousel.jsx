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
    }
  };

  shouldComponentUpdate(nextProps, nextState) {

    if(this.props.items === nextProps.items && this.state.innerWidth === nextState.innerWidth){
      return false;
    }

    return true;
  }

  componentDidMount(){
    window.addEventListener('resize', this.updateDimensions);
    this.updateDimensions();
  };

  updateDimensions = () => {
    this.setState({
      innerWidth: window.innerWidth
    })
  }

  componentWillUnmount(){
    window.removeEventListener('resize', this.updateDimensions);
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

  onSlideChanged = (e) => {
    this.props.onSlideChanged(e.isNextSlideDisabled, e.isPrevSlideDisabled);
  }

  render(){
    let isAutoWidth = false;
    let responsive = undefined;
    if(this.state.innerWidth < 1176){
      isAutoWidth = true;
    }else{
      responsive = {
        1176: {
          items: this.props.pc_show_item_count,
        },
      }
    }
    return(
      <div style={{width: '100%'}}>
        <AliceCarousel 
          ref={(el) => (this.Carousel = el)}
          autoWidth={isAutoWidth}
          infinite={false}
          mouseTracking
          // touchTracking
          items={this.props.items}
          disableButtonsControls={true}
          disableDotsControls={true}
          touchMoveDefaultEvents={false}
          responsive={responsive}
          onSlideChange={(e) => {
          }}
          onSlideChanged={(e) => {
            this.isNextSlideDisabled = e.isNextSlideDisabled;
            this.isPrevSlideDisabled = e.isPrevSlideDisabled;

            this.onSlideChanged(e);
          }}
          />
      </div>
    )
  }
};

export default Carousel;