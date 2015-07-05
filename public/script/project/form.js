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
		var projectId = $('#project_id').val();
		var url = '/projects/' + projectId + '/tickets';
		var method = 'post';
		var data = getTicketFormData();
		var success = function(result) {
			clearTicketForm();
			addTicketRow(result);
			// add row
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
	};
	
	var getTicketFormData = function() {
		return {
			'price': $('#ticket_price').val(),
			'real_ticket_count': $('#ticket_real_count').val(),
			'reward': $('#ticket_reward').val(),
			'require_shipping': $('#ticket_require_shipping').is(':checked') ? 1 : 0,
			'audiences_limit': $('#ticket_audiences_limit').val(),
			'delivery_date': $('#ticket_delivery_date').val()
		};
	};
	
	var clearTicketForm = function() {
		$('#ticket_price').val('');
		$('#ticket_real_count').val('');
		$('#ticket_reward').val('');
		$('#ticket_require_shipping').removeAttr('checked');
		$('#ticket_audiences_limit').val('');
		$('#ticket_delivery_date').val('');
	};
	
	var addTicketRow = function(ticket) {
		var template = $('#template_ticket').html();
		var compiled = _.template(template);
		var row = compiled({ 'ticket': ticket });
		$('#ticket_list').append(row);
		
		$(document).on('click', '.modify-ticket', modifyTicket);
		$(document).on('click', '.delete-ticket', deleteTicket);
	};
	
	var modifyTicket = function() {
		setCreateTicketButtonShown(false);
		
		var ticket = $(this).closest('.ticket');
		$('#ticket_price').val(ticket.find('.ticket-price').text());
		$('#ticket_real_count').val(ticket.find('.ticket-real-count').text());
		$('#ticket_reward').val(ticket.find('.ticket-reward').text());
		$('#ticket_audiences_limit').val(ticket.find('.ticket-audiences-limit').text());
		$('#ticket_delivery_date').val(ticket.find('.ticket-delivery-date').text());
		$('#ticket_require_shipping').prop('checked', ticket.find('.ticket-require-shipping').val() === '1');
		
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
		var success = function(result) {
			var ticket = $('.ticket[data-ticket-id=' + ticketId + ']');
			ticket.find('.ticket-price').text(result.price);
			ticket.find('.ticket-real-count').text(result.real_ticket_count);
			ticket.find('.ticket-reward').text(result.reward);
			ticket.find('.ticket-audiences-limit').text(result.audiences_limit);
			ticket.find('.ticket-delivery-date').text(result.delivery_date);
			ticket.find('.ticket-require-shipping').val(result.require_shipping);
			
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
	
	var updatePoster = function() {
		
	};
	
	var updateStory = function() {
		
	};
	
	var updateOrganization = function() {
		
	};
	
	$('.contact').bind('change', mergeContact);
	$('#check_alias').bind('click', checkAliasDuplicate);
	$('#update_default').bind('click', updateDefault);
	$('#funding_closing_at').datepicker({'dateFormat': 'yy-mm-dd'});
	$('#create_ticket').bind('click', createTicket);
	$('#update_ticket').bind('click', updateTicket);
	$('#cancel_modify_ticket').bind('click', cancelModifyTicket);
	$('.modify-ticket').bind('click', modifyTicket);
	$('.delete-ticket').bind('click', deleteTicket);
	$('#ticket_delivery_date').datepicker({'dateFormat': 'yy-mm-dd'});
	
	setCreateTicketButtonShown(true);
	
});
