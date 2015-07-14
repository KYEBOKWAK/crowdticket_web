$(document).ready(function() {
	var projectId = $('#project_id').val();
	var ajaxUrl = $('#ajax_url').val();
	var method = $('#method').val();
	var success = function() {
		var baseUrl = $('#base_url').val();
		window.location.href = baseUrl + '/projects/' + projectId;
	};
	
	var error = function() {
		alert("저장에 실패하였습니다.");
	};
	
	var updateNews = function() {
		EasyDaumEditor.save(function(content) {
			var title = $('#title').val();
			if (!title) {
				alert("제목을 입력해주세요");
				return;
			}
			
			var data = {
				'title': title,
				'content': content
			};
			$.ajax({
				'url': ajaxUrl,
				'method': method,
				'data': data,
				'success': success,
				'error': error
			});
		});
	};
	
	$('#update_news').bind('click', updateNews);
});
