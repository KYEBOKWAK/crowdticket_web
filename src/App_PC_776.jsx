'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import Page_pc_776_Controller from './controllers/Page_pc_776_Controller';


class App_PC_776 extends Component {

  constructor(props) {
    super(props);

    this.state = {
      
    }
  }

  componentDidMount(){
  }

  render() {
    return (
      <div>
        <Page_pc_776_Controller></Page_pc_776_Controller>
      </div>
    );
  }
}

let domContainer = document.querySelector('#react_App_PC_776');
ReactDOM.render(<App_PC_776 />, domContainer);