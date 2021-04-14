import Storage from './Storage';
import * as storageType from  '../StorageKeys';

const Login = {
  start: (next_url = '') => {
    const login_dom = document.querySelector('#g_go_login_react');
    login_dom.click();
  },
  end: (user_id) => {
    if(user_id === undefined || user_id === null || user_id === ''){
      alert('유저 ID가 없습니다. 다시 로그인 해주세요');
      return;
    }
    
    setLoginID(user_id);

    //데이터 수집 코드 START
    window.dataLayer = window.dataLayer || []
    dataLayer.push({
      memberType: user_id,
      memberAge: '',
      memberGender: '',
      event: 'loginComplete'
    });
    
    const login_react_dom = document.querySelector('.login_react');
    login_react_dom.click();
  }
}

export default Login;