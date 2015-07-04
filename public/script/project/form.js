$(document).ready(function() {
	var mergeContact = function() {
		var contactFirst = $('#contact_first').val();
		var contactMiddle = $('#contact_middle').val();
		var contactLast = $('#contact_last').val();
		
		$('#contact').val(contactFirst + contactMiddle + contactLast);
	};
	
	var checkAliasDuplicate = function() {
		var alias = $('#alias').val();
		var url = '/projects/' + alias;
		var method = 'get';
		var success = function() {
			alert('이미 사용중인 이름입니다. 다른 이름을 사용해주세요.');
		};
		var error = function() {
			alert('사용가능한 이름입니다.');
		};
		
		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
	};
	
	var updateDefault = function() {
		
	};
	
	$('.contact').bind('change', mergeContact);
	$('#check_alias').bind('click', checkAliasDuplicate);
	$('#update_default').bind('click', updateDefault);
});
