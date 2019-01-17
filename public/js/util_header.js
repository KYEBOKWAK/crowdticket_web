//html이 로드되기 전에 자바스크립트 먼저 로드 되어야 하는 유틸들
function imageResize(imgWrapDiv, img){
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
      img.style.cssText = 'width: auto; height: 100%;'
  } else {
      // 이미지가 div보다 길쭉한 경우 가로를 div에 맞추고 세로를 잘라낸다
      img.style.cssText = 'width: 100%; height: auto; margin-left: 0;';
  }
}
