
import React, { Component } from 'react';

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


export default TestButton;
// export default TestButton;