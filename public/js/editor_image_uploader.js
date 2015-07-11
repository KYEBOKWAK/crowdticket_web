$(document).ready(function() {
	var showImagePreview = function() {
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#image_preview').attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
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
