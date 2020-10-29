import * as actionTypes from '../actions/ActionTypes';
import * as appKey from '../AppKeys';
const initialState = {
  pageKey: appKey.WEB_PAGE_KEY_HOME
}

export default function page(state = initialState, action) {
  switch(action.type){
    case actionTypes.SET_WEB_PAGE_KEY:
      return{
        ...state,
        pageKey: action.pageKey
      }

    default:
      return state;
  }
}