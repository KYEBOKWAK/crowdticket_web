
import React, { Component } from 'react';

// import '../css/TestButton.css';

import { connect } from 'react-redux';
// import actions from '../actions/index.js';
import * as actions from '../actions/index';

'use strict';

class TestButton extends Component {
  
  constructor(props) {
    super(props);
    this.state = { 
      liked: false 
    };
  }

  componentDidMount(){
    console.log(this.props.name);
  }

  render() {
    if (this.state.liked) {
      return 'hihihihi';
    }

    return (
      <button className={'testButton'} onClick={() => this.setState({ liked: true }) }>
        흠
      </button>
    );
  }
}

const mapStateToProps = (state) => {
  console.log("리덕스 정상동작쓰!!?");
  console.log(state);
  return {
    name: state.user.name
    // isBackKey: state.backKey.isBackKey
  }
};


const mapDispatchToProps = (dispatch) => {
  return {
    // handleSetUserName: (name) => {
    //   dispatch(actions.setUserName(name));
    // }
  }
};

export default connect(mapStateToProps, mapDispatchToProps)(TestButton);

// export default TestButton;
// export default TestButton;