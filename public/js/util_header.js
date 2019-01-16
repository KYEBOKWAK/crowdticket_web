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
/*
function copyToClipboard(val) {
  var t = document.createElement("textarea");
  document.body.appendChild(t);
  t.value = val;
  t.select();
  document.execCommand('copy');
  document.body.removeChild(t);
}
*/

function select_all_and_copy(el)
{
    // Copy textarea, pre, div, etc.
	if (document.body.createTextRange) {
        // IE
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.select();
        textRange.execCommand("Copy");
        //tooltip(el, "Copied!");
  }
	else if (window.getSelection && document.createRange) {
        // non-IE
        var editable = el.contentEditable; // Record contentEditable status of element
        var readOnly = el.readOnly; // Record readOnly status of element
       	el.contentEditable = true; // iOS will only select text on non-form elements if contentEditable = true;
       	el.readOnly = false; // iOS will not select in a read only form element
        var range = document.createRange();
        range.selectNodeContents(el);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range); // Does not work for Firefox if a textarea or input
        if (el.nodeName == "TEXTAREA" || el.nodeName == "INPUT")
        	el.select(); // Firefox will only select a form element with select()
        if (el.setSelectionRange && navigator.userAgent.match(/ipad|ipod|iphone/i))
        	el.setSelectionRange(0, 999999); // iOS only selects "form" elements with SelectionRange
        el.contentEditable = editable; // Restore previous contentEditable status
        el.readOnly = readOnly; // Restore previous readOnly status
	    if (document.queryCommandSupported("copy"))
	    {
  			var successful = document.execCommand('copy');
        //document.execCommand('copy');
        if(!successful)
        {
          alert("복사 실패");
        }
  		    //if (successful) tooltip(el, "Copied to clipboard.");
  		    //else tooltip(el, "Press CTRL+C to copy");
  		}
  		else
  		{
  			if (!navigator.userAgent.match(/ipad|ipod|iphone|android|silk/i))
        {
          //alert("복사가 지원되지 않는 단말기 입니다. 주소를 직접 복사해주세요");
          //tooltip(el, "Press CTRL+C to copy");
        }
  		}
    }
} // end function select_all_and_copy(el)
