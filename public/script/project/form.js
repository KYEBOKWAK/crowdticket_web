$(document).ready(function() {
	var mergeContact = function() {
		var contactFirst = $('#contact_first').val();
		var contactMiddle = $('#contact_middle').val();
		var contactLast = $('#contact_last').val();
		
		$('#contact').val(contactFirst + contactMiddle + contactLast);
	};
	
	var checkAliasDuplicate = function() {
		var alias = $('#alias').val();
		var url = '/projects/' + alias + '/validity';
		var method = 'get';
		var success = function() {
			alert('사용가능한 이름입니다.');
		};
		var error = function(request) {
			if (request.status === 409) {
				alert('이미 존재하는 이름입니다. 다른 이름을 사용해주세요.');
			} else if (request.status === 422) {
				alert('잘못된 형식의 이름입니다.');
			}
		};
		
		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
	};
	
	var updateDefault = function() {
		updateProject({
			'title': $('#title').val(),
			'alias': $('#alias').val(),
			'category_id': $('#category').val(),
			'city_id': $('#city').val(),
			'pledged_amount': $('#pledged_amount').val(),
			'funding_closing_at': $('#funding_closing_at').val()
		});
	};
	
	var updateProject = function(data) {
		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId;
		var method = 'put';
		var success = function() {
			alert('저장되었습니다.');
		};
		var error = function() {
			alert('저장에 실패하였습니다.');
		};
		
		$.ajax({
			'url': url,
			'method': method,
			'data': data,
			'success': success,
			'error': error
		});
	};
	
	var createTicket = function() {
		
	};
	
	var updateTicket = function() {
		
	};
	
	var deleteTicket = function() {
		
	};
	
	var updatePoster = function() {
		
	};
	
	var updateStory = function() {
		
	};
	
	var updateOrganization = function() {
		
	};
	
	$('.contact').bind('change', mergeContact);
	$('#check_alias').bind('click', checkAliasDuplicate);
	$('#update_default').bind('click', updateDefault);
});
