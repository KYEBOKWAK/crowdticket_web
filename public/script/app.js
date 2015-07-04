(function() {
	var jqueryAjax = $.ajax;
	var startsWith = function(string, needle) {
		return string.indexOf(needle) === 0;
	};
	
	$.ajax = function(form) {
		var csrfToken = $('meta[name="csrf-token"]').attr('content');
		if (form.hasOwnProperty('data')) {
			form.data['_token'] = csrfToken;
		} else {
			form.data = {
				'_token': csrfToken
			};
		}
		
		if (!startsWith(form.url, 'http')) {
			var baseUrl = $('#base_url').val();
			form.url = baseUrl + form.url;
		}
		
		jqueryAjax(form);
	};
})();
