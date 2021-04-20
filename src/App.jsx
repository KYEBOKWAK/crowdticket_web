'use strict';

import React, { Component } from 'react';
import ReactDOM from 'react-dom';

// import TestButton from './component/TestButton';
import PageController from './controllers/PageController';

// import '/css/App.css'
import './res/css/App.css';

// import Templite from './pages/Templite';
import Footer_React from './component/Footer_React';

class App extends Component {
  
  constructor(props) {
    super(props);

    this.state = {
      isLoad: false
    }
    
  }

  componentDidMount(){
  }

  render() {
    return (
      <div>
        <PageController></PageController>
      </div>
    );
  }
}

let domContainer = document.querySelector('#react_root');
ReactDOM.render(<App />, domContainer);

let footerContainer = document.querySelector('#react_footer');
ReactDOM.render(<Footer_React />, footerContainer);