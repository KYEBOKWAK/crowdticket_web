'use strict';

import React, { Component } from 'react';

import ImageUploader from "react-images-upload";

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



class StoreAddItemPage extends Component{

  constructor(props){
    super(props);

    this.state = {
      pictures: [],
      testImg: ''
    }

    this.onDrop = this.onDrop.bind(this);
  };

  onDrop(pictureFiles, pictureDataURLs) {
    console.log(pictureFiles);
    console.log(pictureDataURLs);
    this.setState({
      pictures: this.state.pictures.concat(pictureFiles),
      testImg: pictureDataURLs[0]
    });
  }

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){    
  };

  componentWillUnmount(){
    console.log(this.state.pictures);
  };

  componentDidUpdate(){
  }

  render(){
    return(
      <>
      <div>
        상품 등록
      </div>
      <div>
        이미지 등록
      </div>
      <button onClick={() => {
        // chooseFileButton
        document.querySelector('.chooseFileButton').click();

      }}>
        이미지 추가 버튼
      </button>
      <ImageUploader
        withIcon={false}
        buttonText="Choose images"
        onChange={this.onDrop}
        imgExtension={[".jpg", ".gif", ".png", ".gif"]}
        maxFileSize={5242880}
      />
      <img style={{width: 300, height: 300}} src={this.state.testImg} />
      <div>
        상품명
      </div>
      <div>
        콘텐츠 설명명
      </div>
      <button>상품 등록</button>
      </>
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
export default StoreAddItemPage;