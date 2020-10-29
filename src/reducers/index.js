import { combineReducers } from 'redux';

import user from '../reducers/user';
import page from '../reducers/page';
//import state from '@'

const reducers = combineReducers({
  user,
  page
});

export default reducers;