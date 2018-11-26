function addComma(num) {
  var regexp = /\B(?=(\d{3})+(?!\d))/g;
   return num.toString().replace(regexp, ',');
}

function isMobile(){
  return $('#isMobile').is(":visible");
};

function getAmountTicket(limiteCount, nowCount){
  return limiteCount - nowCount;
};

function getAmountTicketText(limiteCount, nowCount){
  var ticketAmount = getAmountTicket(limiteCount, nowCount);
  if(ticketAmount < 0)
  {
    return "티켓 수량 에러";
  }
  else if(ticketAmount == 0)
  {
    return "매진";
  }
  else
  {
    return "구매 가능한 티켓 수량 " + ticketAmount + " 매";
  }
};

$.browser={};(function(){
    jQuery.browser.msie=false;
    $.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)\./)){
    $.browser.msie=true;jQuery.browser.version=RegExp.$1;}
})();

function isCheckPhoneNumber(phoneNumber){
  var regExp = /^[0-9]+$/;
  if(!regExp.test(phoneNumber))
  {
   alert("전화번호에 숫자만 입력해주세요.(공백 혹은 - 이 입력되었습니다.)");
   return false;
  }

  return true;
}

function isCheckEmail(email){
  var regExpEmail = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
  if(!regExpEmail.test(email))
  {
    alert("이메일이 잘못입력되었습니다.");
    return false;
  }

  return true;
}
