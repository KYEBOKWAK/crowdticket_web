import * as actionTypes from '../actions/ActionTypes';

const initialState = {
  name: '',
  nick_name: '',
  contact: '',
  email: '',
  user_id: null
}

export default function user(state = initialState, action) {
  switch(action.type){
    case actionTypes.SET_USER_INFO:
      return{
        ...state,
        name: action.name,
        contact: action.contact,
        email: action.email,
        nick_name: action.nick_name,
        user_id: action.user_id
      }

      case actionTypes.SET_USER_INFO_ID:
        return {
          ...state,
          user_id: action.user_id
        }

    default:
      return state;
  }
}