'use strict';

import React, { Component } from 'react';

import axios from '../lib/Axios';
import Util from '../lib/Util';

import _axios from 'axios';



class FileUploader extends Component{

  constructor(props){
    super(props);

    this.state = {
    }

    // this.requestMoreData = this.requestMoreData.bind(this);
  };

  // shouldComponentUpdate(nextProps: any, nextState: any) {
  //   return true;
  // }

  componentDidMount(){
    // this.requestStoreContents();
  };

  componentWillUnmount(){
    
  };

  componentDidUpdate(){ 
  }

  test(test){
    console.log("afefaefaf");
  }
  
  handleFromSubmit(e){
    e.preventDefault();
    console.log("asdfasdf");

    // console.log(e.target.file.files[0].path);
    // console.log(fileInput.)

    // let a = process.env.REACT_APP_API_SERVER_URL;

    // this.test(process.env.REACT_APP_API_SERVER_URL);

    // const formData = new FormData();
    // formData.append('file',e.target.file.files[0]);
    
    
    _axios.post()


    // axios.post("/uploader/file/save", {
    //   data: formData
    // })
  }

  itemClick(e){
    e.preventDefault();
    
    // let baseURL = 'https://crowdticket.kr'
    // const baseURLDom = document.querySelector('#base_url');
    // if(baseURLDom){
    //   // console.log(baseURLDom.value);
    //   baseURL = baseURLDom.value;
    // }

    // let goURL = baseURL + '/item/store/' + this.props.store_item_id;

    // window.location.href = goURL;
  }

  render(){
    return(
      <div className={'FileUploader'}>
        <form className='upload_form' encType='multipart/form-data' onSubmit={(e) => {this.handleFromSubmit(e)}}>
          <label>
            <input type='file' name='file' ref={this.fileInput} />
          </label>
          <button type='submit'>서브밋!</button>
        </form>
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

FileUploader.defaultProps = {
  // id: -1,
  // store_item_id: -1,
  // thumbUrl: '',
  // name: '',
  // title: '',
  // price: 0
}


// export default connect(mapStateToProps, mapDispatchToProps)(Templite);
export default FileUploader;