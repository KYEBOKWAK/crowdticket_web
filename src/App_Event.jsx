'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import axios from './lib/Axios';
import Types from './Types';

class App_Event extends Component{  
  constructor(props){
    super(props);

    let alias = null;
    const event_alias_dom = document.querySelector('#event_alias');
    if(event_alias_dom){
      alias = event_alias_dom.value;
    }

    this.state = {
      alias: alias
    }

    
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    if(this.state.alias === null){
      alert("진행되지 않는 이벤트 입니다");
    }

    alert("진행되지 않는 이벤트 입니다");

    // axios.post('/event/any/pages', {
    //   alias: this.state.alias
    // }, (result) => {
    //   console.log(result);
    // }, (error) => {

    // })
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){
  } 

  render(){
    // if(!this.state.isInit){
    //   return (
    //     <div>
    //     </div>
    //   )
    // }
    
    return(
      <div className={'App_Event'}>
        <div className={'images_container'}>
          {/* <img className={'images_pc'} src={'https://crowdticket0.s3.ap-northeast-1.amazonaws.com/local/test/test_bg_pc.png'} />
          <img className={'images_mobile'} src={'https://crowdticket0.s3.ap-northeast-1.amazonaws.com/local/test/test_bg_mobile.png'} /> */}
        </div>
      </div>
    )
  }
};

// export default App_Event;
let domContainer = document.querySelector('#react_app_event_page');
ReactDOM.render(<App_Event />, domContainer);