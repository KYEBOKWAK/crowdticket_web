$(document).ready(function() {
	var checkAliasDuplicate = function() {
		var alias = $('#alias').val();
		if (alias.length === 0) {
			alert('주소를 입력해주세요.');
			return;
		}

		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId + '/alias/' + alias;
		var method = 'get';
		var success = function() {
			alert('사용가능한 주소입니다.');
		};
		var error = function(request) {
			if (request.status === 409) {
				alert('이미 존재하는 주소입니다. 다른 이름을 사용해주세요.');
			} else if (request.status === 422) {
				alert('잘못된 형식의 주소입니다.');
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
			'funding_closing_at': $('#funding_closing_at').val(),
			'detailed_address': $('#detailed_address').val(),
			'concert_hall': $('#concert_hall').val()
		});
	};
	
	var updateProject = function(data) {
		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId;
		var method = 'put';
		var success = function(e) {
			alert('저장되었습니다.');
		};
		var error = function(e) {
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
	
	var listOldTickets = function() {
		var ticketsJson = $('#tickets_json').val();
		if (ticketsJson) {
			var tickets = $.parseJSON(ticketsJson);
			if (tickets.length > 0) {
				for (var i = 0, l = tickets.length; i < l; i++) {
					addTicketRow(tickets[i]);
				}
			}
		}
	};
	
	var validateTicketData = function(ticket) {
		if (ticket.reward.length === 0) {
			alert("내용을 입력해주세요");
			return false;
		}
		return true;
	};
	
	var createTicket = function() {
		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId + '/tickets';
		var method = 'post';
		var data = getTicketFormData();
		
		if (validateTicketData(data)) {
			var success = function(result) {
				clearTicketForm();
				addTicketRow(result);
			};
			var error = function(request) {
				alert('보상 추가에 실패하였습니다.');
			};
			
			$.ajax({
				'url': url,
				'method': method,
				'data': data,
				'success': success,
				'error': error
			}); 
		}
	};
	
	var getTicketFormData = function() {
		var projectType = $('#project_type').val();
		var realTicketCount;
		var requireShipping;
		var deliveryDate;
		if (projectType === 'funding') {
			realTicketCount = $('#ticket_real_count').val();
			requireShipping = $('#ticket_require_shipping').is(':checked') ? 1 : 0;
			question = $('#ticket_question').val();
			deliveryDate = $('#ticket_delivery_date').val() + " 00:00:00";
		} else if (projectType === 'sale') {
			realTicketCount = 1;
			requireShipping = 0;
			var hour = Number($('#ticket_delivery_hour').val());
			var min = Number($('#ticket_delivery_min').val());
			if (hour < 10) {
				hour = "0" + hour;
			}
			if (min < 10) {
				min = "0" + min;
			}
			deliveryDate = $('#ticket_delivery_date').val() + " " + hour + ":" + min + ":00";
		} else {
			return;
		}
		
		return {
			'price': $('#ticket_price').val(),
			'reward': $('#ticket_reward').val(),
			'question': $('#ticket_question').val(),
			'audiences_limit': $('#ticket_audiences_limit').val(),
			'real_ticket_count': realTicketCount,
			'require_shipping': requireShipping,
			'delivery_date': deliveryDate
		};
	};
	
	var clearTicketForm = function() {
		$('#ticket_price').val('0');
		$('#ticket_real_count').val('0');
		$('#ticket_reward').val('');
		$('#ticket_question').val('');
		$('#ticket_require_shipping').removeAttr('checked');
		$('#ticket_audiences_limit').val('0');
		$('#ticket_delivery_date').val(getDateFormatted(new Date()));
	};
	
	var getDateFormatted = function(date) {
	    var dd = date.getDate();
	    var mm = date.getMonth() + 1;
	    var yyyy = date.getFullYear();
	    if(dd < 10) {
	        dd = '0' + dd;
	    } 
	    if(mm < 10) {
	        mm = '0' + mm;
	    }
	    return yyyy + '-' + mm + '-' + dd; 
	};
	
	var addTicketRow = function(ticket) {
		if (!ticket.audiences_count) {
			ticket.audiences_count = 0;
		}
		var template = $('#template_ticket').html();
		var compiled = _.template(template);
		var row = compiled({ 'ticket': ticket, 'type': $('#project_type').val(), 'style': 'modifyable' });
		var $row = $($.parseHTML(row));
		$row.data('ticketData', ticket);
		$('#ticket_list').append($row);
		
		$row.find('.modify-ticket').bind('click', modifyTicket);
		$row.find('.delete-ticket').bind('click', deleteTicket);
	};
	
	var modifyTicket = function() {
		setCreateTicketButtonShown(false);
		
		var ticket = $(this).closest('.ticket');
		var ticketData = ticket.data('ticketData');
		var rawDate = ticketData.delivery_date.split(" ");
		var d = rawDate[0].split("-");
		var t = rawDate[1].split(":");
		var deliveryDate = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
		
		$('#ticket_price').val(ticketData.price);
		$('#ticket_real_count').val(ticketData.real_ticket_count);
		$('#ticket_reward').val(ticketData.reward);
		$('#ticket_question').val(ticketData.question);
		$('#ticket_audiences_limit').val(ticketData.audiences_limit);
		$('#ticket_delivery_date').val(getDateFormatted(deliveryDate));
		$('#ticket_delivery_hour').val(deliveryDate.getHours());
		$('#ticket_delivery_min').val(deliveryDate.getMinutes());
		$('#ticket_require_shipping').prop('checked', ""+ticketData.require_shipping === '1');
				
		$('#update_ticket').attr('data-ticket-id', ticket.attr('data-ticket-id'));
	};
	
	var cancelModifyTicket = function() {
		setCreateTicketButtonShown(true);
		clearTicketForm();
	};
	
	var setCreateTicketButtonShown = function(shown) {
		if (shown) {
			$('#create_ticket').show();
			$('#update_ticket, #cancel_modify_ticket').hide();
		} else {
			$('#create_ticket').hide();
			$('#update_ticket, #cancel_modify_ticket').show();
		}
	};
	
	var updateTicket = function() {
		var ticketId = $(this).attr('data-ticket-id');
		var url = '/tickets/' + ticketId;
		var method = 'put';
		var data = getTicketFormData();
		
		if (validateTicketData(data)) {
			var success = function(result) {
				var ticket = $('.ticket[data-ticket-id=' + ticketId + ']');
				ticket.remove();
				addTicketRow(result);
				cancelModifyTicket();
			};
			var error = function(request) {
				alert('수정에 실패하였습니다.');
			};
			
			$.ajax({
				'url': url,
				'method': method,
				'data': data,
				'success': success,
				'error': error
			}); 
		}
	};
	
	var deleteTicket = function() {
		var ticket = $(this).closest('.ticket');
		var ticketId = ticket.attr('data-ticket-id');
		var url = '/tickets/' + ticketId;
		var method = 'delete';
		
		var success = function(result) {
			ticket.remove();
		};
		var error = function(request) {
			alert('삭제에 실패하였습니다.');
		};
		
		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		}); 
	};
	
	var posterAjaxOption = {
		'beforeSerialize': function($form, options) {
			$posterFile = $('#poster_file');
			if ($posterFile.val() === '') {
				$posterFile.prop("disabled", true);
			} else {
				$posterFile.prop("disabled", false);
			}
		},
		'success': function(result) {
			alert('저장되었습니다.');
		}, 
		'error': function(data) {
			alert("저장에 실패하였습니다.");
		}
	};
	
	var performPosterFileClick = function() {
		$('#poster_file').trigger('click');
	};
	
	var onPosterChanged = function() {
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#poster_preview').css('background-image', "url('" + e.target.result + "')");
				$('.project-thumbnail').css('background-image', "url('" + e.target.result + "')");
			};
			reader.readAsDataURL(this.files[0]);
		}
	};
	
	var onDescriptionChanged = function() {
		var description = $('#poster_description').val();
		$('.project-description').text(description);
	};
	
	var updateStory = function() {
		EasyDaumEditor.save(function(content) {
			updateProject({
				'video_url': $('#video_url').val(),
				'story': content
			});
		});
	};
	
	var submitProject = function() {
		if (window.confirm('정말 제출하시겠습니까?')) {
			var projectId = $('#project_id').val();
			var url = '/projects/' + projectId + '/submit';
			var method = 'put';
			var success = function(result) {
				alert('제출 성공'); 
			};
			var error = function(request, status) {
				alert('제출에 실패하였습니다.');
			};
			
			$.ajax({
				'url': url,
				'method': method,
				'success': success,
				'error': error
			}); 
		}
	};
	
	$('#check_alias').bind('click', checkAliasDuplicate);
	$('#update_default').bind('click', updateDefault);
	$('#funding_closing_at').datepicker({'dateFormat': 'yy-mm-dd'});
	$('#create_ticket').bind('click', createTicket);
	$('#update_ticket').bind('click', updateTicket);
	$('#cancel_modify_ticket').bind('click', cancelModifyTicket);
	$('#ticket_delivery_date').datepicker({'dateFormat': 'yy-mm-dd'});
	$('#poster_form').ajaxForm(posterAjaxOption);
	$('#update_story').bind('click', updateStory);
	$('#submit_project').bind('click', submitProject);
	$('#poster_file_fake').bind('click', performPosterFileClick);
	$('#poster_file').change(onPosterChanged);
	$('#poster_description').bind('input', onDescriptionChanged);
	
	setCreateTicketButtonShown(true);
	
	listOldTickets();
	
	$(window).bind('beforeunload', function() {
		// return '페이지를 나가기 전에 저장되지 않은 정보를 확인하세요';
	});
	
});

