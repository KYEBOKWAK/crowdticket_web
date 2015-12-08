(function() {
	var jqueryAjax = $.ajax;
	var startsWith = function(string, needle) {
		return string.indexOf(needle) === 0;
	};
	var removeInvalidData = function(data) {
		if ($.isArray(data)) {
			$.each(data, function(key, value) {
				if (typeof value === 'string' || value instanceof String) {
					if (!value || value.length === 0) {
						delete data[key];
					}
				}
			});
		}
	};
	
	$.ajax = function(form) {
		var csrfToken = $('meta[name="csrf-token"]').attr('content');
		if (form.hasOwnProperty('data')) {
			if (form.data !== null) {
				form.data['_token'] = csrfToken;
			} else {
				form.data = {
					'_token': csrfToken
				};
			}
		} else {
			form.data = {
				'_token': csrfToken
			};
		}
		
		removeInvalidData(form.data);
		
		if (!startsWith(form.url, 'http')) {
			var baseUrl = $('#base_url').val();
			form.url = baseUrl + form.url;
		}
		
		jqueryAjax(form);
	};
})();


$(document).ready(function() {
	$('.concatable').each(function() {
		var parent = $(this);
		var sources = $(this).find('.concatable-source');
		var target = $(this).find('.concatable-target');
		sources.each(function() {
			$(this).bind('change', function() {
				var concat = '';
				sources.each(function() {
					concat += $(this).val();
				});
				target.val(concat);
			});
		});
	});
});
