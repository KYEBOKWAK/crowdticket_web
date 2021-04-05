'use strict';

import React, { Component } from 'react';


// import { scale, verticalScale, moderateScale } from 'react-native-size-matters';
// import FontWeights from '@lib/fontWeights';

// import * as appKeys from '~/AppKeys';
// import Util from '@lib/Util';
// import * as GlobalKeys from '~/GlobalKeys';

//redux START
// import * as actions from '@actions/index';
// import { connect } from 'react-redux';
//redux END
// import Colors from '@lib/colors';
// import Types from '~/Types';



class LoginPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      test: 0
    }
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
  };

  componentWillUnmount(){
  };

  componentDidUpdate(){
  }
  
  testPlusButton = (e) => {
    // window.history.back();
    window.history.go(1);
  }

  testLoginCompliteButton = (e) => {

  }

  render(){
    return(
      <div className={'LoginPage'}>
        {this.state.test}

        <div>
          <button onClick={(e) => {this.testPlusButton(e)}}>더하기</button>
        </div>
        <div>
          <button onClick={(e) => {this.testLoginCompliteButton(e)}}>로그인 완료 테스트</button>
        </div>
      </div>
    )
  }
};

// props 로 넣어줄 스토어 상태값
// const mapStateToProps = (state) => {
//   // console.log(state);
//   return {
//     // pageViewKeys: state.page.pageViewKeys.concat()
//   }
// };

// const mapDispatchToProps = (dispatch) => {
//   return {
//     // handleAddPageViewKey: (pageKey: string, data: any) => {
//     //   dispatch(actions.addPageViewKey(pageKey, data));
//     // },
//     // handleAddToastMessage: (toastType:number, message: string, data: any) => {
//     //   dispatch(actions.addToastMessage(toastType, message, data));
//     // }
//   }
// };

// export default connect(mapStateToProps, mapDispatchToProps)(StoreItemDetailPage);
export default LoginPage;