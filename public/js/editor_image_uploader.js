$(document).ready(function() {
	var showImagePreview = function() {
		if (this.files && this.files[0]) {
			var MAX_SIZE = 1 * 1024 * 1024;
			var image = this.files[0];
			if (image.size <= MAX_SIZE) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#image_preview').attr('src', e.target.result);
				};
				reader.readAsDataURL(this.files[0]);
			} else {
				$('#image').val('');
				$('#image_preview').attr('src', '');
				alert("1MB 이하의 이미지를 올려주세요.");
			}
		}
	};
	
	var imageAjaxOption = {
		'success': function(result) {
			EasyDaumEditor.attach(result);
		}, 
		'error': function() {
			alert("저장에 실패하였습니다.");
		}
	};
	
	$('#image').change(showImagePreview);
	$('#image_form').ajaxForm(imageAjaxOption);
	EasyDaumEditor.initializeAttachPopUp();
});
