(function() {
	// 숫자 타입에서 쓸 수 있도록 format() 함수 추가
	Number.prototype.format = function(){
	    if(this==0) return 0;
	 
	    var reg = /(^[+-]?\d+)(\d{3})/;
	    var n = (this + '');
	 
	    while (reg.test(n)) n = n.replace(reg, '$1' + ',' + '$2');
	 
	    return n;
	};
	 
	// 문자열 타입에서 쓸 수 있도록 format() 함수 추가
	String.prototype.format = function(){
	    var num = parseFloat(this);
	    if( isNaN(num) ) return "0";
	 
	    return num.format();
	};

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

        if (!(startsWith(form.url, 'http') || startsWith(form.url, '//'))) {
            var baseUrl = $('#base_url').val();
            form.url = baseUrl + form.url;
        }

		jqueryAjax(form);
	};

	$.fn.preventDoubleSubmission = function() {
		$(this).on('submit', function (e) {
			var $form = $(this);

			if ($form.data('submitted') === true) {
				e.preventDefault();
			} else {
				$form.data('submitted', true);
			}
		});

		return this;
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
