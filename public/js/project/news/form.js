$(document).ready(function() {
	var projectId = $('#project_id').val();
	var ajaxUrl = $('#ajax_url').val();
	var method = $('#method').val();
	var baseUrl = $('#base_url').val();
	var success = function() {
		window.location.href = baseUrl + '/projects/' + projectId;
	};

	var error = function() {
		alert("저장에 실패하였습니다.");
	};
	/*
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
	*/
	var showDeleteConfirmModal = function() {
		var confirmed = confirm("정말 삭제하시겠습니까?");
		if (confirmed) {
			$.ajax({
				'url': ajaxUrl,
				'method': 'delete',
				'success': success,
				'error': function() {
					alert("삭제에 실패하였습니다.");
				}
			});
		}
	};

	var updateNews = function() {
		var title = $('#title').val();
		if (!title) {
			alert("제목을 입력해주세요");
			return;
		}

		loadingProcess($(".project_form_button_wrapper"));

		var markupStr = $('#summernote').summernote('code');

		var data = {
			'title': title,
			'content': markupStr
		};

		$.ajax({
			'url': ajaxUrl,
			'method': method,
			'data': data,
			'success': success,
			'error': error
		});

		/*
		var markupStr = $('#summernote').summernote('code');
		updateProject({
			'story': markupStr
		}, false);
		*/
	};

	$('#update_news').bind('click', updateNews);
	$('#delete_news').bind('click', showDeleteConfirmModal);
});
