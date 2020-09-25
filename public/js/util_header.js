//html이 로드되기 전에 자바스크립트 먼저 로드 되어야 하는 유틸들
function imageResize(imgWrapDiv, img){
  //alert("aa");
  var div = imgWrapDiv; // 이미지를 감싸는 div
  //var img = image // 이미지
  //오차범위 0.01
  var divAspect = (90 / 120) + 0.01; // div의 가로세로비는 알고 있는 값이다
  // var divAspect = 0;
  var imgAspect = img.height / img.width;
  if(img.height == 0 || img.width == 0)
  {
    imgAspect = 0;
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
}

function imageResize_new(imgWrapDiv, img){
  //alert("aa");
  var div = imgWrapDiv; // 이미지를 감싸는 div
  //var img = image // 이미지
  //오차범위 0.01
  // var divAspect = (160 / 250) + 0.01; // div의 가로세로비는 알고 있는 값이다
  var divAspect = 0;
  var imgAspect = img.height / img.width;
  if(img.height == 0 || img.width == 0)
  {
    imgAspect = 0;
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
}

function imageResize_meetup_banner(imgWrapDiv, img){
  //alert("aa");
  var div = imgWrapDiv; // 이미지를 감싸는 div
  //var img = image // 이미지
  //오차범위 0.01
  var divAspect = (330 / 1920) + 0.01; // div의 가로세로비는 알고 있는 값이다
  var imgAspect = img.height / img.width;
  if(img.height == 0 || img.width == 0)
  {
    imgAspect = 0;
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
}

//DIV 풀 사이즈로 확대
function imageFullResize(imgWrapDiv, img){
  //alert("aa");
  var div = imgWrapDiv; // 이미지를 감싸는 div
  //var img = image // 이미지
  //오차범위 0.01
  var divAspect = (90 / 120) + 0.01; // div의 가로세로비는 알고 있는 값이다
  var imgAspect = img.height / img.width;
  if(img.height == 0 || img.width == 0)
  {
    imgAspect = 0;
  }

  if (imgAspect <= divAspect) {
      // 이미지가 div보다 납작한 경우 세로를 div에 맞추고 가로는 잘라낸다
      var imgWidthActual = div.offsetHeight / imgAspect;
      var imgWidthToBe = div.offsetHeight / divAspect;
      var marginLeft = -Math.round((imgWidthActual - imgWidthToBe) / 2);
      //img.style.cssText = 'width: auto; height: 100%; margin-left: '
      //                  + marginLeft + 'px;'
      //img.style.cssText = 'width: auto; height: 100%;'
      img.style.cssText = 'width: auto;'
  } else {
      // 이미지가 div보다 길쭉한 경우 가로를 div에 맞추고 세로를 잘라낸다
      img.style.cssText = 'width: 100%; height: auto; margin-left: 0;';
  }
}

function showToast(level, message){
  toastr.options = {
              positionClass: 'toast-bottom-center',
              onclick: null
          };
  toastr.options.showMethod = 'slideDown';

  switch (level) {
      default:
      case 'i':
          toastr.info(message);
          break;
      case 's':
          toastr.success(message);
          break;
      case 'e':
          toastr.error(message);
          break;
  }
}

function get_version_of_IE () {

	 var word;

	 var agent = navigator.userAgent.toLowerCase();

	 // IE old version ( IE 10 or Lower )
	 if ( navigator.appName == "Microsoft Internet Explorer" ) word = "msie ";

	 // IE 11
	 else if ( agent.search( "trident" ) > -1 ) word = "trident/.*rv:";

	 // Microsoft Edge
	 else if ( agent.search( "edge/" ) > -1 ) word = "edge/";

	 // 그외, IE가 아니라면 ( If it's not IE or Edge )
	 else return -1;

	 var reg = new RegExp( word + "([0-9]{1,})(\\.{0,}[0-9]{0,1})" );

	 if (  reg.exec( agent ) != null  ) return parseFloat( RegExp.$1 + RegExp.$2 );

	 return -1;
}

//이미지가 깨지는 이슈가 있어서 onload에 넣기 위해 임시로 넣는다.
var resizeBluePrintTitleImgOnload = function(){
  var parentData = $('.blueprint_title_image_container')[0];
  var imgData = $('.blueprint_title_img')[0];

  var targetWidth =  imgData.naturalWidth / (imgData.naturalHeight / parentData.clientHeight);

  if(targetWidth <= window.innerWidth)
  {
      $('.blueprint_title_img').css('width', '100%');
      $('.blueprint_title_img').css('height', 'auto');
  }
  else
  {
      $('.blueprint_title_img').css('width', targetWidth);
      $('.blueprint_title_img').css('height', parentData.clientHeight);
  }
};

//이미지가 깨지는 이슈가 있어서 onload에 넣기 위해 임시로 넣는다.
var resizeMagazineTitleImgOnLoad = function(){
  var parentData = $('.magazine_title_image_container')[0];
  var imgData = $('.magazine_title_img')[0];

  var targetWidth =  imgData.naturalWidth / (imgData.naturalHeight / parentData.clientHeight);

  if(targetWidth <= window.innerWidth)
  {
    $('.magazine_title_img').css('width', '100%');
    $('.magazine_title_img').css('height', 'auto');
  }
  else
  {
    $('.magazine_title_img').css('width', targetWidth);
    $('.magazine_title_img').css('height', parentData.clientHeight);
  }
};