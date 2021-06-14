import moment_timezone from 'moment-timezone';
import Types from '../Types';

const Util = {
  arrayEquals: function(array1, array2){
    if(JSON.stringify(array1) === JSON.stringify(array2)){
      return true;
    }else{
      return false;
    }
  },
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
    if(number === undefined){
      return 0;
    }

    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  },

  getPriceCurrency: (price, price_usd, currency_code) => {
    let _price = price;
    if(currency_code === Types.currency_code.US_Dollar){
      _price = price_usd;
    }

    if(_price === undefined || _price === null){
      _price = 0;
    }

    let _priceText = _price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    if(currency_code === Types.currency_code.US_Dollar){
      _priceText = '$'+_priceText;
    }else{
      _priceText = _priceText+'원';
    }

    return _priceText;
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

    let nowMoment = moment_timezone();

    let writeMoment = moment_timezone(targetDate);

    let timeDiff = nowMoment.diff(writeMoment);
    let durationMomentTime = moment_timezone.duration(timeDiff);

    const diffDays = durationMomentTime.days();
    const diffMonths = durationMomentTime.months();
    const diffYears = durationMomentTime.years();

    const diffHours = durationMomentTime.hours();
    const diffMin = durationMomentTime.minutes();
    const diffSec = durationMomentTime.seconds();

    if(diffYears > 0){
      return diffYears+'년전';
    }
    else if(diffMonths > 0){
      return diffMonths+'달전';
    }
    else if(diffDays > 0){
      return diffDays+'일전';
    }
    else {
      if(diffHours > 0){
        return diffHours + '시간전';
      }
      else if(diffMin > 0){
        return diffMin + '분전';
      }
      else if(diffSec > 0){
        return diffSec + '초전';
      }
    }

    return '';
  },

  dataURLtoFile(dataurl, filename) {
    var arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]), 
        n = bstr.length, 
        u8arr = new Uint8Array(n);
        
    while(n--){
        u8arr[n] = bstr.charCodeAt(n);
    }
    
    return new File([u8arr], filename, {type:mime});
  },

  checkPatternSpecial(str){
    var pattern = /[~!@#$%^&*()_+|<>?:{}-]/;
    if((pattern.test(str))){
      return true
    }else{
      return false
    }
  },

  checkPatternSpecialInAlias(str){
    var pattern = /[~!@#$%^&*()+|<>?:{}-]/;
    if((pattern.test(str))){
      return true
    }else{
      
      return false
    }
  },

  checkPatternKor(str){
    var pattern = /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/; // 한글체크
    if((pattern.test(str))){
      return true
    }else{
      
      return false
    }
  },

  getTicketShowDate(start_date, end_date){
    let now_moment = moment_timezone();
    let start_date_moment = moment_timezone(start_date);

    let now_date_year = now_moment.year();

    let start_date_year = start_date_moment.year();
    let start_date_month = start_date_moment.month() + 1;
    let start_date_days = start_date_moment.date();

    if(end_date === null || start_date === end_date){
      let show_date_year = start_date_year + '/';
      if(now_date_year === start_date_year){
        show_date_year = '';
      }

      if(start_date_month < 10){
        start_date_month = '0'+start_date_month;
      }

      if(start_date_days < 10){
        start_date_days = '0'+start_date_days;
      }

      return show_date_year + start_date_month + '/' + start_date_days;
    }


    let end_date_moment = moment_timezone(end_date);

    let end_date_year = end_date_moment.year();
    let end_date_month = end_date_moment.month() + 1;
    let end_date_days = end_date_moment.date();

    let show_start_date_year = '';
    let show_start_date_month = '';
    let show_start_date_days = '';

    let show_end_date_year = '';
    let show_end_date_month = '';
    let show_end_date_days = '';

    if(start_date_year !== end_date_year){
      show_start_date_year = start_date_year;
      show_end_date_year = end_date_year;

      show_start_date_month = start_date_month;
      show_end_date_month = end_date_month;

      show_start_date_days = start_date_days;
      show_end_date_days = end_date_days;

      if(show_start_date_month < 10){
        show_start_date_month = '0' + show_start_date_month;
      }

      if(show_end_date_month < 10){
        show_end_date_month = '0' + show_end_date_month;
      }

      if(show_start_date_days < 10){
        show_start_date_days = '0' + show_start_date_days;
      }

      if(show_end_date_days < 10){
        show_end_date_days = '0' + show_end_date_days;
      }

      return show_start_date_year + '/' + show_start_date_month + '/' + show_start_date_days + '~' + show_end_date_year + '/' + show_end_date_month + '/' + show_end_date_days;
    }
    else if(start_date_month !== end_date_month){
      show_start_date_month = start_date_month;
      show_end_date_month = end_date_month;

      show_start_date_days = start_date_days;
      show_end_date_days = end_date_days;

      let show_date_year = start_date_year + '/';
      if(now_date_year === start_date_year){
        show_date_year = '';
      }

      if(show_start_date_month < 10){
        show_start_date_month = '0' + show_start_date_month;
      }

      if(show_end_date_month < 10){
        show_end_date_month = '0' + show_end_date_month;
      }

      if(show_start_date_days < 10){
        show_start_date_days = '0' + show_start_date_days;
      }

      if(show_end_date_days < 10){
        show_end_date_days = '0' + show_end_date_days;
      }

      return show_date_year + show_start_date_month + '/' + show_start_date_days + '~' + show_end_date_month + '/' + show_end_date_days;
    }
    else if(start_date_days !== end_date_days){
      show_start_date_month = start_date_month;

      show_start_date_days = start_date_days;
      show_end_date_days = end_date_days;

      let show_date_year = start_date_year + '/';
      if(now_date_year === start_date_year){
        show_date_year = '';
      }

      if(show_start_date_month < 10){
        show_start_date_month = '0' + show_start_date_month;
      }

      if(show_start_date_days < 10){
        show_start_date_days = '0' + show_start_date_days;
      }

      if(show_end_date_days < 10){
        show_end_date_days = '0' + show_end_date_days;
      }

      return show_date_year + show_start_date_month + '/' + show_start_date_days + '~' + show_end_date_days;
    }
    else {
      show_start_date_month = start_date_month;

      show_start_date_days = start_date_days;
      show_end_date_days = end_date_days;

      let show_date_year = start_date_year + '/';
      if(now_date_year === start_date_year){
        show_date_year = '';
      }

      if(show_start_date_month < 10){
        show_start_date_month = '0' + show_start_date_month;
      }

      if(show_start_date_days < 10){
        show_start_date_days = '0' + show_start_date_days;
      }

      if(show_end_date_days < 10){
        show_end_date_days = '0' + show_end_date_days;
      }

      return show_date_year + show_start_date_month + '/' + show_start_date_days;
    }
  },
  convertBytes(bytes) {
    const sizes = ["Bytes", "KB", "MB", "GB", "TB"]
  
    if (bytes == 0) {
      return "n/a"
    }
  
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1000)))
  
    if (i == 0) {
      return bytes + " " + sizes[i]
    }
  
    return (bytes / Math.pow(1000, i)).toFixed(1) + " " + sizes[i]
  },
  isLargeFile(bytes) {
    const sizes = ["Bytes", "KB", "MB", "GB", "TB"]
  
    if (bytes == 0) {
      return false
    }
  
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1000)))
  
    const value = Number((bytes / Math.pow(1000, i)).toFixed(1));

    if(i >= 3){
      if(value >= 2.0){
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  },
  regExp(_str){
    //####이부분은 프론트 엔드/백엔드 코드가 동일해야함!!! 수정할때 주의!!!!!####
    //특수문자 검증 start
    let str = _str.replace(/ /g,"_");
    let replaceStr = str;
    var regExp = /[\{\}\[\]\/?,;:|\)*~`!^\-+<>@\#$%&\\\=\(\'\"]/gi
    if(regExp.test(str)){
      //특수문자 제거
      replaceStr = str.replace(regExp, "")
    }
    
    return replaceStr;
  },
  getBaseURL(path = ''){
    let baseURL = 'https://crowdticket.kr'
    const baseURLDom = document.querySelector('#base_url');
    if(baseURLDom){
      // console.log(baseURLDom.value);
      baseURL = baseURLDom.value;
    }

    if(path === ''){
      return baseURL;
    }

    return baseURL+path;
  },
  isCheckEmailValid(email){

    var regExpEmail = /^[0-9a-zA-Z_]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
    if(!regExpEmail.test(email))
    {
      return false;
    }
  
    return true;
  },
  getMeta(metaName) {
    const metas = document.getElementsByTagName('meta');
  
    for (let i = 0; i < metas.length; i++) {
      if (metas[i].getAttribute('name') === metaName) {
        return metas[i].getAttribute('content');
      }
    }
  
    return '';
  },
  getWaitTimer: (sec) => {
    let gapMiliSecTime = Number(sec);

    if(gapMiliSecTime <= 0){
      gapMiliSecTime = 0;
    }

    let D = Math.floor(gapMiliSecTime / 86400);
    let H = Math.floor((gapMiliSecTime - D * 86400) / 3600 % 3600);
    let M = Math.floor((gapMiliSecTime - H * 3600) / 60 % 60);
    let S = Math.floor((gapMiliSecTime - M * 60) % 60);

    // console.log(M+"분"+S+"초");
    let sString = '';
    if(S < 10){
      // S = '0'+S;
      sString = '0'+S.toString();
    }else{
      sString = S.toString();
    }
    return M+":"+sString;
  },
}

export default Util;