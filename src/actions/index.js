// import * as actionTypes from '../actions/ActionTypes';
import * as actionTypes from './ActionTypes';

// export function setUserName(name){
//   return {
//     type: actionTypes.SET_USER_INFO_NAME,
//     name: name
//   }
// }

export function setUserInfo(name, nick_name, contact, email, user_id){
  return {
    type: actionTypes.SET_USER_INFO,
    name: name,
    contact: contact,
    email: email,
    user_id: user_id,
    nick_name: nick_name
  }
}

export function setUserID(user_id){
  return {
    type: actionTypes.SET_USER_INFO_ID,
    user_id: user_id
  }
}

export function setPageKey(pageKey){
  return {
    type: actionTypes.SET_WEB_PAGE_KEY,
    pageKey: pageKey
  }
}