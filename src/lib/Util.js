// import moment_timezone from 'moment-timezone';

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
  },

  timeBefore(targetDate){
    //현재시간
    let now = new Date(); 
    // console.log(now);
    //글쓴 시간 
    let writeDay = new Date(targetDate);
    let minus;
    if(now.getFullYear() > writeDay.getFullYear()){
        minus= now.getFullYear()-writeDay.getFullYear();
        // document.getElementsByClassName("sub")[0].innerHTML = minus+"년 전";
        return minus+"년전";
        // console.log(minus+"년전");
    }else if(now.getMonth() > writeDay.getMonth()){
        minus= now.getMonth()-writeDay.getMonth();
        // document.getElementsByClassName("sub")[0].innerHTML = minus+"달 전";
        return minus+"달전";
        // console.log(minus+"달전");
    }else if(now.getDate() > writeDay.getDate()){
        minus= now.getDate()-writeDay.getDate();
        // document.getElementsByClassName("sub")[0].innerHTML = minus+"일 전";
        return minus+"일전";
        // console.log(minus+"일전");
    }else if(now.getDate() == writeDay.getDate()){
      let nowTime = Number(now.getTime());
      let writeTime = Number(writeDay.getTime());
      if(nowTime>writeTime){
        let sec = Math.floor((nowTime - writeTime) / 1000);
        let day  = Math.floor((sec/60/60/24));
        
        sec = Math.floor((sec - (day * 60 * 60 * 24)));
        let hour = Math.floor((sec/60/60));
        sec = Math.floor((sec - (hour*60*60)));
        let min = Math.floor((sec/60));
        sec = Math.floor((sec-(min*60)));
        if(hour>0){
          return hour+"시간전";
            // document.getElementsByClassName("sub")[0].innerHTML = hour+"시간 전";
            // console.log(hour+"시간 전");
        }else if(min>0){
          return min+"분전";
            // document.getElementsByClassName("sub")[0].innerHTML = min+"분 전";
            // console.log(min+"분 전");
        }else if(sec>0){
          return sec+"초전";
            // document.getElementsByClassName("sub")[0].innerHTML = sec+"초 전";
            // console.log(sec+"초 전");
        }
      }
    }
  },
}

export default Util;