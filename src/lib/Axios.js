import _axios from 'axios';

import Storage from './Storage';
import * as storageType from  '../StorageKeys';

import Types from '../Types';

function postCall(url, data, callback, errorCallback) {
  let apiURL = process.env.REACT_APP_API_SERVER_URL;
  if(process.env.NODE_ENV === 'development'){
    apiURL = process.env.REACT_APP_API_SERVER_URL_LOCAL;
  }

  const app_type_key = document.querySelector('#g_app_type');
  if(app_type_key){
    if(app_type_key.value === 'qa'){
      apiURL = process.env.REACT_APP_API_SERVER_URL_QA;
    }
  }

  _axios.post(apiURL+url,{
    data: data
  })
  .then( (response) => {

    // Store.dispatch(actions.setLoadingView(false));
    // console.log(response.data.result.toastType);
    if(response.data.result !== undefined && response.data.result.toastType !== undefined){
      // console.log(response.data.result.toastMessage);
      alert(response.data.result.toastMessage);
      // Store.dispatch(actions.addToastMessage(response.data.result.toastType, response.data.result.toastMessage, response.data.result.toastMessageData));
    }

    if(response.data.state > Types.res.RES_ERROR && response.data.state < Types.res.RES_ERROR_END){
      //처음엔 state가 string 형태였는데, 너무 많아서.. 나중에 리팩토링함
      
      if(response.data.state === Types.res.RES_ERROR){
        alert(response.data.message);
        errorCallback(response.data.state);
      }else{
        console.log(response.data);
        errorCallback(response.data);
      }
      
      return;
    }
    else if(response.data.state > Types.res.RES_SUCCESS_START && response.data.state < Types.res.RES_SUCCESS_END){
      callback(response.data.result);
    }
    else if(response.data.state === 'error'){
      alert(response.data.message);
      errorCallback(response.data.error_type);
      return;
    }
    else if(response.data.result.state === 'call_refresh_token'){
      //accesstoken 만료로 refresh토큰으로 accesstoken을 재발급 받는다.
      Storage.load(storageType.REFRESH_TOKEN, function(result){
        if(result.state === 'success'){
          let _data = {
            ...data,
            refresh_token: result.value
          };
          postCall(url, _data, callback, errorCallback);
        }
      });
    }
    else if(response.data.result.state === 'expireRefreshToken'){
      
      Storage.delete(storageType.ACCESS_TOKEN, function(result){
        Storage.delete(storageType.REFRESH_TOKEN, function(result){
          alert("장시간 미접속으로 로그아웃 되었습니다. 재로그인 해주세요.");
          window.location.reload()
        });
      });

      /*
      Alert.alert("에러", "장시간 미접속으로 로그아웃 되었습니다. 재로그인 해주세요.", 
      [
        {text: '확인', onPress: () => 
          {
            Storage.delete(storageType.ACCESS_TOKEN, function(result){
              Storage.delete(storageType.REFRESH_TOKEN, function(result){
                RNRestart.Restart()
              });
            });
          }
        },
      ]
      );
      */
      return;
    }
    else if(response.data.result.state === 'setReAccessToken'){
      if(response.data.result.access_token){
        Storage.save(storageType.ACCESS_TOKEN, response.data.result.access_token, function(result){        
          let _data = {
            ...data,
            access_token: response.data.result.access_token,
            refresh_token: ''
          }
          // console.log(_data);
          postCall(url, _data, callback, errorCallback);
        });
      }
    }
    else if(response.data.result.state === 'setAllAccessToken'){
      if(response.data.result.refresh_token){
        Storage.save(storageType.REFRESH_TOKEN, response.data.result.refresh_token, function(result){
          // console.log('save refresh token');
          // console.log(result);
        });
      }

      if(response.data.result.access_token){
        Storage.save(storageType.ACCESS_TOKEN, response.data.result.access_token, function(result){
          // console.log('save access token');
          // console.log(result);

          let _data = {
            ...data,
            access_token: response.data.result.access_token,
            refresh_token: ''
          }
          // console.log(_data);
          postCall(url, _data, callback, errorCallback);

        });
      }
    }else{
      callback(response.data.result);
    }
  })
  .catch( (error) => {
    // Store.dispatch(actions.setLoadingView(false, Types.loading.DEFAULT));
    // console.log("ERROR POST CALL : " + url);
    // console.log(error);
    
    errorCallback(error);
  });
}

//data로 넘기는게 아니라 body에 넘기는 함수
function postCallWithOriData(url, data, callback, errorCallback) {
  let apiURL = process.env.REACT_APP_API_SERVER_URL;
  if(process.env.NODE_ENV === 'development'){
    apiURL = process.env.REACT_APP_API_SERVER_URL_LOCAL;
  }

  _axios.post(apiURL+url, 
    data).then( (response) => {

    // Store.dispatch(actions.setLoadingView(false));
    // console.log(response.data.result.toastType);
    if(response.data.result !== undefined && response.data.result.toastType !== undefined){
      // console.log(response.data.result.toastMessage);
      alert(response.data.result.toastMessage);
      // Store.dispatch(actions.addToastMessage(response.data.result.toastType, response.data.result.toastMessage, response.data.result.toastMessageData));
    }

    if(response.data.state === 'error'){
      alert(response.data.message);
      errorCallback('');
      // Alert.alert('error', response.data.message, 
      // [
      //   {text: '확인', onPress: () => 
      //     {
      //       errorCallback('');
      //     }
      //   },
      // ]);
      return;
    }
    else if(response.data.result.state === 'call_refresh_token'){
      //accesstoken 만료로 refresh토큰으로 accesstoken을 재발급 받는다.
      Storage.load(storageType.REFRESH_TOKEN, function(result){
        if(result.state === 'success'){
          let _data = {
            ...data,
            refresh_token: result.value
          };
          postCall(url, _data, callback, errorCallback);
        }
      });
    }
    else if(response.data.result.state === 'expireRefreshToken'){

      Storage.delete(storageType.ACCESS_TOKEN, function(result){
        Storage.delete(storageType.REFRESH_TOKEN, function(result){
          alert("장시간 미접속으로 로그아웃 되었습니다. 재로그인 해주세요.");
          window.location.reload();
          return;
        });
      });

      return;
    }
    else if(response.data.result.state === 'setReAccessToken'){
      if(response.data.result.access_token){
        Storage.save(storageType.ACCESS_TOKEN, response.data.result.access_token, function(result){
          // console.log('save access token');
          // console.log(result);
          // let _data = {
          //   // ...data,
          //   access_token: data.access_token
          // }
          
          let _data = {
            ...data,
            access_token: response.data.result.access_token,
            refresh_token: ''
          }
          // console.log(_data);
          postCall(url, _data, callback, errorCallback);
        });
      }
    }
    else if(response.data.result.state === 'setAllAccessToken'){
      if(response.data.result.refresh_token){
        Storage.save(storageType.REFRESH_TOKEN, response.data.result.refresh_token, function(result){
          // console.log('save refresh token');
          // console.log(result);
        });
      }

      if(response.data.result.access_token){
        Storage.save(storageType.ACCESS_TOKEN, response.data.result.access_token, function(result){
          // console.log('save access token');
          // console.log(result);

          let _data = {
            ...data,
            access_token: response.data.result.access_token,
            refresh_token: ''
          }
          // console.log(_data);
          postCall(url, _data, callback, errorCallback);

        });
      }
    }else{
      callback(response.data.result);
    }
  })
  .catch( (error) => {
    // Store.dispatch(actions.setLoadingView(false, Types.loading.DEFAULT));
    // console.log("ERROR POST CALL : " + url);
    // console.log(error);
    errorCallback(error);
  });
}

const axios = {
  post: (url, data, callback, errorCallback) => {
    // console.log(url);
    // localStorage.setItem('myValueInLocalStorage', 'change value');
    
    //토큰 불러오기.
    let indexAnyString = url.indexOf('/any/');
    if(indexAnyString < 0){
      //any가 포함 안됨.
      Storage.load(storageType.ACCESS_TOKEN, function(result){
        if(result.state === 'error'){
          //에러가 나면 accesstoken을 재요청
          //accesstoken이 에러나면 아예 초기화
          Storage.delete(storageType.ACCESS_TOKEN, function(result){
            Storage.delete(storageType.REFRESH_TOKEN, function(result){
              alert("로그인 정보가 없습니다. 다시 로그인 해주세요.");
              window.location.reload();
            });
          });

          return;
        }else{
          //있으면 서버에 accesstoken 을 같이 보냄
          // result.value
          let _data = {
            ...data,
            access_token: result.value
          }
          postCall(url, _data, callback, errorCallback);
        }
      });

    }else{
      //any가 포함되서 토큰 확인 안함.
      // Alert.alert('', 'ㅁㅇㅇㅇ');
      postCall(url, data, callback, errorCallback);
    }
  },
  postWithOriData: (url, data, callback, errorCallback) => {
    //토큰 불러오기.
    let indexAnyString = url.indexOf('/any/');
    if(indexAnyString < 0){
      //any가 포함 안됨.
      Storage.load(storageType.ACCESS_TOKEN, function(result){
        if(result.state === 'error'){
          //에러가 나면 accesstoken을 재요청
          //accesstoken이 에러나면 아예 초기화
          Storage.delete(storageType.ACCESS_TOKEN, function(result){
            Storage.delete(storageType.REFRESH_TOKEN, function(result){
              alert("로그인 정보가 없습니다. 다시 로그인 해주세요.");
              window.location.reload();
              // RNRestart.Restart()
            });
          });
          return;
        }else{
          //있으면 서버에 accesstoken 을 같이 보냄
          // result.value
          let _data = {
            ...data,
            access_token: result.value
          }

          postCallWithOriData(url, _data, callback, errorCallback);
        }
      });

    }else{
      //any가 포함되서 토큰 확인 안함.
      // Alert.alert('', 'ㅁㅇㅇㅇ');
      postCallWithOriData(url, data, callback, errorCallback);
    }
  },


  get: (url, callback, errorCallback) => {
    console.log('GET 으로 옴!!' + url);
    // debugger;
  },
};

export default axios;