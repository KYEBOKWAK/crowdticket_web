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

function isCheckEmail(email){
  var regExpEmail = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
  if(!regExpEmail.test(email))
  {
    alert("이메일이 잘못입력되었습니다.");
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
      alert(' 공백만 입력되었습니다 ');
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

    outputNode.text(numChar+'/'+maxNum);
    if(charRemain < 0){

      swal("아차! 글자 수 제한ㅠㅠ", "", "warning");
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

function imageResize(imgWrapDiv, img){
  var div = imgWrapDiv; // 이미지를 감싸는 div
  //var img = image // 이미지
  //오차범위 0.01
  var divAspect = (90 / 120) + 0.01; // div의 가로세로비는 알고 있는 값이다
  var imgAspect = img.height / img.width;
  if(img.height == 0 || img.width == 0)
  {
    //imgAspect = 0;
    return false;
  }

  if (imgAspect <= divAspect) {
      // 이미지가 div보다 납작한 경우 세로를 div에 맞추고 가로는 잘라낸다
      var imgWidthActual = div.offsetHeight / imgAspect;
      var imgWidthToBe = div.offsetHeight / divAspect;
      var marginLeft = -Math.round((imgWidthActual - imgWidthToBe) / 2);
      //img.style.cssText = 'width: auto; height: 100%; margin-left: '
      //                  + marginLeft + 'px;'
      img.style.cssText = 'width: auto; height: 100%;'
  } else {
      // 이미지가 div보다 길쭉한 경우 가로를 div에 맞추고 세로를 잘라낸다
      img.style.cssText = 'width: 100%; height: auto; margin-left: 0;';
  }

  return true;
}

function utilcalltest(){
  alert("isInUtilJS");
}
