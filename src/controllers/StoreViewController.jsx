
import React, { Component } from 'react';

import * as AppKeys from '../AppKeys';
import { connect } from 'react-redux';
import * as actions from '../actions/index';

import StoreHome from '../pages/StoreHome';

'use strict';

class StoreViewController extends Component {
  
  constructor(props) {
    super(props);
    this.state = { 
      viewKey: AppKeys.WEB_PAGE_KEY_HOME
    };
  }

  componentDidMount(){
    
  }

  render() {
    let view = <></>;
    return (
      <>
        {view}
      </>
    );
  }
}



const mapStateToProps = (state) => {
  return {
    pageKey: state.page.pageKey
  }
};


// const mapDispatchToProps = (dispatch) => {
//   return {
//     handleSetUserName: (name) => {
//       dispatch(actions.setUserName(name));
//     }
//   }
// };

// export default connect(mapStateToProps, mapDispatchToProps)(PageController);
export default connect(mapStateToProps, null)(StoreViewController);

// export default PageController;
// export default TestButton;