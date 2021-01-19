const Util = {
  getPayStoreNewMerchant_uid: function(store_id, user_id){
    //이 함수를 수정하려면 서버쪽 코드와 동일 해아함.
    const timestamp = Math.floor(new Date().getTime() / 1000)

    let type_tail = 'r';
    const app_type_key = document.querySelector('#g_app_type');
    if(app_type_key){
      if(app_type_key.value === 'local'){
        type_tail = 'local';
      }else if(app_type_key.value === 'qa'){
        type_tail = 'qa';
      }
    }

    let _appType = '_'+type_tail;;

    return 's_'+store_id+'_u_'+user_id+'_'+timestamp+_appType;
  },

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
  },

  matchYoutubeUrl(url) {
    if(url === null || url === ''){
      return false;
    }
    
    var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
    if(url.match(p)){
        // return url.match(p)[1];
        return true
    }

    return false;
}
}

export default Util;