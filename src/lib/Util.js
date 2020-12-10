const Util = {
  getUserName: (user) => {
    if(user.nick_name === ''){
      return user.name;
    }

    return user.nick_name;
  },

  getNumberWithCommas: (number) => {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  },

  getArrayRand: (array) => {
    let _array = array.concat();
    return _array.sort(function(){
      return Math.random() - Math.random();
    })
  },

  isAdmin: (user_id) => {
    if(!user_id){
      return false;
    }

    if(user_id === 0){
      return false;
    }


    const myID = Number(document.querySelector('#myId').value);
    if(myID === 0){
      //ID값이 0이면 로그인 안함.
      return false;
    }

    if(user_id === myID){
      return true;
    }
  }
}

export default Util;