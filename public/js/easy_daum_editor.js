(function(document) {
	var baseUrlElem = document.getElementById('base_url');
	var assetUrlElem = document.getElementById('asset_url');
	var baseUrl = '';
	var assetUrl = '';
	if (baseUrlElem) {
		baseUrl = baseUrlElem.value;
	}
	if (assetUrlElem) {
		assetUrl = assetUrlElem.value;
	}
	
	var config = {
		txHost : baseUrl,
		txPath : '/',
		txService : 'sample', /* 수정필요없음. */
		txProject : 'sample', /* 수정필요없음. 프로젝트가 여러개일 경우만 수정한다. */
		initializedId : "", /* 대부분의 경우에 빈문자열 */
		wrapper : "tx_trex_container", /* 에디터를 둘러싸고 있는 레이어 이름(에디터 컨테이너) */
		form : 'tx_editor_form' + "", /* 등록하기 위한 Form 이름 */
		txIconPath : "../../../images/icon/editor/", /*에디터에 사용되는 이미지 디렉터리, 필요에 따라 수정한다. */
		txDecoPath : assetUrl + '/images/deco/contents', /*본문에 사용되는 이미지 디렉터리, 서비스에서 사용할 때는 완성된 컨텐츠로 배포되기 위해 절대경로로 수정한다. */
		canvas : {
			exitEditor : {
				/*
				 desc:'빠져 나오시려면 shift+b를 누르세요.',
				 hotKey: {
				 shiftKey:true,
				 keyCode:66
				 },
				 nextElement: document.getElementsByTagName('button')[0]
				 */
			},
			styles : {
				color : "#123456", /* 기본 글자색 */
				fontFamily : "굴림", /* 기본 글자체 */
				fontSize : "10pt", /* 기본 글자크기 */
				backgroundColor : "#fff", /*기본 배경색 */
				lineHeight : "1.5", /*기본 줄간격 */
				padding : "8px" /* 위지윅 영역의 여백 */
			},
			showGuideArea : false
		},
		events : {
			preventUnload : false
		},
		sidebar : {
			attachbox : {
				show : true,
				confirmForDeleteAll : true
			}
		},
		size : {
			contentWidth : 700 /* 지정된 본문영역의 넓이가 있을 경우에 설정 */
		}
	};
	
	var EditorHelper = {
		'getConfig': function() {
			return config;
		},
		'save': function(l) {
			EditorHelper.onSubmit = l;
			Editor.save();
		},
		'load': function(content) {
			Editor.modify({
				'content': content
			});
		},
		'onValidateForm': function(editor) {
			var validator = new Trex.Validator();
			var content = editor.getContent();
			if (!validator.exists(content)) {
				alert('내용을 입력하세요');
				return false;
			}
			
			EditorHelper.onSubmit(content);
			return false;
		},
		'onSubmit': function(content) {
			// interface
		},
		'initializeAttachPopUp': function() {
			var opener = PopupUtil.getOpener();
		    if (!opener) {
		        alert('잘못된 경로로 접근하셨습니다.');
		        return;
		    }
		    
		    var attacher = getAttacher('image', opener);
		    registerAction(attacher);
		},
		'attach': function(image) {
			if (typeof(execAttach) == 'undefined') {
				console.log("execAttach is undefined");
		        return;
		    }
		    
			execAttach({
				'width': image.image_width,
				'height': image.image_height,
				'imageurl': image.image_url,
				'filename': image.image_url,
				'filesize': 0,
				'imagealign': 'C',
				'originalurl': image.image_url,
				'thumburl': image.image_url
			});
			closeWindow();
		}
	};
	
	window.EasyDaumEditor = EditorHelper;
})(document);
