function isLogin()
{
  var myId = Number($('#myId').val());
	if(myId == 0)
	{
		return false;
	}

	return true;
}

function setLoginID(id)
{
  $('#myId').val(id);
}

function showLoadingPopup(message){
  var title = "처리중입니다.";

  if(message)
  {
    title = message;
  }

  var elementPopup = document.createElement("div");
  elementPopup.innerHTML =
  "<div><b>" + title + "</b></div>" +
  "<div class='loadingcontent'>" +
  "<b>" +
  "잠시만 기다려주세요." + "<br>" +
  "페이지를 닫을 경우 오류가 발생할 수 있습니다." +
  "</b></div>" +
  "<div id='loading_options'></div>" +
  "<div class='loading loading_util'>" +
  "</div>";

  swal({
    //title: title,
    content: elementPopup,
    closeOnClickOutside: false,
    closeOnEsc: false,
    button: false,
    //timer: 10000,
    //timer: 2000,
  }).then(function(value){
    /*
    if(!value)
    {
      swal({
        title: "처리 시간 초과",
        text:"인터넷 오류로 인해 처리되지 않았습니다. 다시 한번 시도해주세요",
      })
    }
    */
  });
}

function stopLoadingPopup(){
  swal.close();
}

function loadingProcess(thisElement){
  thisElement.hide();

  var elementParent = thisElement.parent();
  var loadingDiv = document.createElement('div');
  loadingDiv.className = 'loading';
  elementParent.append(loadingDiv);
}

function loadingProcessWithSize(thisElement){
  thisElement.hide();

  var elementParent = thisElement.parent();
  var loadingDiv = document.createElement('div');
  loadingDiv.className = 'loading_size_20';
  elementParent.append(loadingDiv);
}

function loadingProcessStop(thisElement){
  $('.loading').each(function(){
    $(this).remove();
  });

  thisElement.show();
}

function loadingProcessStopWithSize(thisElement){
  $('.loading_size_20').each(function(){
    $(this).remove();
  });

  thisElement.show();
}

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

function isCheckOnlyNumber(phoneNumber){
  var regExp = /^[0-9]+$/;
  if(!regExp.test(phoneNumber))
  {
   //alert("숫자만 입력해주세요.(공백 혹은 - 이 입력되었습니다.)");
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

function isCheckEmailWithoutAlert(email){
  var regExpEmail = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
  if(!regExpEmail.test(email))
  {
    return false;
  }

  return true;
}

function isCheckKorean(word){
  var regExpEnglish = /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/;
  if(regExpEnglish.test(word))
  {
    alert("URL에 한글이 있습니다. 영문, 숫자, -, _만 입력이 가능합니다");
    return true;
  }

  return false;
}

//공백만 있는지 체크
function isCheckOnlyEmptyValue(word){
  var blank_pattern = /^\s+|\s+$/g;
  if( word.replace( blank_pattern, '' ) == "" ){
      //alert(' 공백만 입력되었습니다 ');
      return true;
  }

  return false;
}

//글자에 공백이 들어가있는지 체크
function isCheckEmptyValue(word){
  if(word.search(/\s/) != -1)
  {
    alert(' 공백이 입력되었습니다 ');
    return true;
  }
  else
  {
    return false;
  }
}

function getRemoveExpWord(inputStr){
    //함수를 호출하여 특수문자 검증 시작.
    var str = inputStr;
    var regExp = /[\{\}\[\]\/?.,;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"]/gi;
    if(regExp.test(str)){
        var t = str.replace(regExp, "");
        //특수문자를 대체. ""
        //alert("특수문자 제거. ==>" + t);
        //특수문자 제거. ==>20171031
        str = t;
    }else{
        //alert("특수문자 없음 "+str);
    }

    return str;
}

function isWordLengthCheck(inputNode, outputNode){
  inputNode.keyup(function(){
    var numChar = $(this).val().length;
    var maxNum = $(this).attr('maxlength');
    maxNum = maxNum-1;
    var charRemain = maxNum - numChar;

    outputNode.text(numChar+'/'+(maxNum+1));
    if(charRemain < 0){

      alert("아차! 글자 수 제한ㅠㅠ", "", "warning");
    }
  });
}

function getConverterEnterString(inputString){
  if(!inputString){
    return inputString;
  }
  return inputString.replace(/\r?\n/g, '<br />');
}


function getTextWidth(text, font) {
    // re-use canvas object for better performance
    var canvas = getTextWidth.canvas || (getTextWidth.canvas = document.createElement("canvas"));
    var context = canvas.getContext("2d");
    context.font = font;
    var metrics = context.measureText(text);
    return metrics.width;
}

/* 업로드 체크 */
function isFileCheck( file )
{
  // 사이즈체크
  var maxSize  = 1048576;    //30MB
  var fileSize = 0;

	// 브라우저 확인
	var browser=navigator.appName;

	// 익스플로러일 경우
	if (browser=="Microsoft Internet Explorer")
	{
		var oas = new ActiveXObject("Scripting.FileSystemObject");
		fileSize = oas.getFile( file.value ).size;
	}
	// 익스플로러가 아닐경우
	else
	{
		fileSize = file.files[0].size;
	}


	//alert("파일사이즈 : "+ fileSize +", 최대파일사이즈 : 1MB");

  if(fileSize > maxSize)
  {
      swal("이미지 용량은 1MB 이내로 등록 가능합니다.", "", "warning");
      return false;
  }

  //alert("file Size : " + fileSize);

  return true;
}

function isFileCheckFromEditor( file )
{
  // 사이즈체크
  var maxSize  = 1048576;    //30MB
  var fileSize = 0;

	// 브라우저 확인
	var browser=navigator.appName;

	// 익스플로러일 경우
	if (browser=="Microsoft Internet Explorer")
	{
		var oas = new ActiveXObject("Scripting.FileSystemObject");
		fileSize = oas.getFile( file.value ).size;
	}
	// 익스플로러가 아닐경우
	else
	{
		fileSize = file.size;
	}


	//alert("파일사이즈 : "+ fileSize +", 최대파일사이즈 : 1MB");

  if(fileSize > maxSize)
  {
      swal("이미지 용량은 1MB 이내로 등록 가능합니다.", "", "warning");
      return false;
  }

  //alert("file Size : " + fileSize);

  return true;
}

function getTicketCategory(orderTicketCategory, ticketsCategory)
{
  var ticketCategoryTemp = orderTicketCategory;
	if(ticketsCategory.length > 0){
		var categoryNum = Number(orderTicketCategory);
		for (var i = 0; i < ticketsCategory.length; i++) {
			if(Number(ticketsCategory[i].id) === categoryNum){
				ticketCategoryTemp = ticketsCategory[i].title;
				break;
			}
		}
	}

  return ticketCategoryTemp;
}

//yyyy.mm.dd H:M  category
function getTicketDateFullInfo(ticketShowDate, orderTicketCategory, ticketsCategory, ticketCount)
{
  var rawDate = ticketShowDate.split(" ");
  var d = rawDate[0].split("-");
  var t = rawDate[1].split(":");

  var ticketDate = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);

  var yyyy = ticketDate.getFullYear();
  var mm = ticketDate.getMonth() + 1;
  var dd = ticketDate.getDate();
  var H = ticketDate.getHours();
  var min = ticketDate.getMinutes();

  if(mm < 10)
  {
    mm = "0"+mm;
  }

  if(dd < 10)
  {
    dd = "0"+dd;
  }

  if(H < 10){
    H = "0" + H;
  }
  if (min < 10) {
    min = "0" + min;
  }

  var ticketCategory = getTicketCategory(orderTicketCategory, ticketsCategory);

  //var ticketCount = $('#ticket_count').val();

  var fullTicketInfo = yyyy+'.'+mm+'.'+dd+' '+H+':'+min + ' ' + ticketCategory;

  if(d[0] == 0000){
    fullTicketInfo = ticketCategory;
  }

  return fullTicketInfo;
}

//yyyy.mm.dd H:M  category
function getTicketDateFullInfoWithCategoryText(ticketShowDate, ticketsCategoryText)
{
  var rawDate = ticketShowDate.split(" ");
  var d = rawDate[0].split("-");
  var t = rawDate[1].split(":");

  var ticketDate = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);

  var yyyy = ticketDate.getFullYear();
  var mm = ticketDate.getMonth() + 1;
  var dd = ticketDate.getDate();
  var H = ticketDate.getHours();
  var min = ticketDate.getMinutes();

  if(mm < 10)
  {
    mm = "0"+mm;
  }

  if(dd < 10)
  {
    dd = "0"+dd;
  }

  if(H < 10){
    H = "0" + H;
  }
  if (min < 10) {
    min = "0" + min;
  }

  var ticketCategory = ticketsCategoryText;

  //var ticketCount = $('#ticket_count').val();

  var fullTicketInfo = yyyy+'.'+mm+'.'+dd+' '+H+':'+min + ' ' + ticketCategory;

  if(d[0] == 0000){
    fullTicketInfo = ticketCategory;
  }

  return fullTicketInfo;
}

function utilcalltest(){
  alert("isInUtilJS");
}

function sortByKey(array, key) {
    return array.sort(function(a, b) {
        var x = a[key]; var y = b[key];
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    });
}

function getTwoNumberToOneNumber(number)
{
  number = Number(number);

  if(number < 10)
  {
    number = "0"+number;
  }

  return number;
}

function getSubStartDayEndDay(sDay, eDay)
{
  var _SDate = sDay; //yyyy-MM-dd or mm/dd/yyyy

  var _EDate = eDay; //yyyy-MM-dd or mm/dd/yyyy

  var	sDate = new Date(_SDate);

  var	eDate = new Date(_EDate);

  var oneDay = 24 * 60 * 60 * 1000;

  var diffDays = Math.round(Math.abs((sDate.getTime() - eDate.getTime()) / (oneDay)));

  return diffDays - 1;
  //console.error(diffDays);

}

function replaceName(str)
{
  //return str;

  var strLength = str.length;
  var resultStr = "";
  for(var i = 0 ; i < strLength ; i++)
  {
    if(i == 0)
    {
      if(strLength == 1)
      {
        resultStr += "*";
      }
      else
      {
        resultStr += str[i];
      }
    }
    else if(i == strLength - 1)
    {
      if(strLength == 2)
      {
        resultStr += "*";
      }
      else
      {
        resultStr += str[i];
      }
    }
    else
    {
      resultStr += "*";
    }
  }

  return resultStr;
}

function replaceEmail(str)
{
  //return str;

  var strLength = str.length;
  var resultStr = "";
  var atSignIdx = str.indexOf("@");
  if(atSignIdx > 0)
  {
    //str = str.substr(0, atSignIdx+3);
    //strLength = str.length;
  }

  for(var i = 0 ; i < strLength ; i++)
  {
    if(atSignIdx <= 0)
    {
      if(i == strLength-1)
      {
        resultStr += "*";
      }
      else
      {
        resultStr += str[i];
      }
    }
    else
    {
      if(i == atSignIdx - 1)
      {
        resultStr += "*";
      }
      else if(i == atSignIdx - 2)
      {
        resultStr += "*";
      }
      else if(i == atSignIdx - 3)
      {
        resultStr += "*";
      }
      else
      {
        resultStr += str[i];
      }
    }
  }

  return resultStr;
  //for()
}

// min (포함) 과 max (불포함) 사이의 임의 정수를 반환
// Math.round() 를 사용하면 고르지 않은 분포를 얻게된다!
function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}
// min (포함) 과 max (포함) 사이의 임의 정수를 반환
// Math.round() 를 사용하면 고르지 않은 분포를 얻게된다!
function getRandomIntInclusive(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function parseQuery ( query ) {
   var Params = new Object ();

   if ( ! query ) return Params; // return empty object

   var Pairs = query.split(/[;&]/);

   for ( var i = 0; i < Pairs.length; i++ ) {

      var KeyVal = Pairs[i].split('=');

      if ( ! KeyVal || KeyVal.length != 2 ) continue;

      var key = unescape( KeyVal[0] );

      var val = unescape( KeyVal[1] );

      val = val.replace(/\+/g, ' ');

      Params[key] = val;

   }
   return Params;
}

function requsetAjaxPartition(url, method, data, totalDataCount, func_success, func_error)
{
  var success = function(result){
    console.error(result);
    if(result.state === "error")
    {
      func_error(result);
      return;
    }

    if(!result.orders)
    {
      func_error(result);
      return;
    }

    totalDataCount+=result.orders.length;

    if($("#loading_options"))
    {
      //팝업에 로딩 옵션이 있다면 옵션 셋팅
      var optionText = totalDataCount + " / " + result.total_count;

      $("#loading_options").text(optionText);
    }

    if(result.orders.length === 0)
    {
      console.error("finish");
      func_success(result);
      return;
    }

    var startIndex = Number(result.start_index);
    startIndex++;
    var reData={
      "startindex" : startIndex
    }

    requsetAjaxPartition(url, method, reData, totalDataCount, func_success, func_error);
    //alert(result.orders.length);

    
  }

  var error = function(result){
    func_error(result);
  }

  $.ajax({
    'url': url,
    'method': method,
    'data' : data,
    'success': success,
    'error': error
  });
}