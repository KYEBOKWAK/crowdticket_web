'use strict';

import React, { Component } from 'react';

import Count_Up from 'react-countup';

class CountUp extends Component{

  _countUpRef = null;

  constructor(props){
    super(props);

    this.state = {
    }
  };

  componentDidMount(){
    this.countUpStart();
  };

  componentWillUnmount(){
  };

  componentDidUpdate(){
  }

  countUpStart = () => {
    this._countUpRef.start();
  }

  testStartTime = () => {

  }

  countUpReStart = () => {
    this._countUpRef.restart();
  }

  render(){
    
    return(
      <div>
        <Count_Up
          start={0}
          end={this.props.end}
          duration={this.props.duration}
          separator=","
          onEnd={() => {}}
          onStart={() => {}}
          ref={(ref) => {this._countUpRef = ref}}
        >
          {({ countUpRef }) => (
            <div>
              <span ref={countUpRef} />
            </div>
          )}
        </Count_Up>
      </div>
    )
    
  }
};

CountUp.defaultProps = {
  duration: 3,
  end: 0
}

export default CountUp;
