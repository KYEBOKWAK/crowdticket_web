$(document).ready(function() {
	var projectId = $('#project_id').val();
	
	var commentsLoader = new Loader('/projects/' + projectId + '/comments', 20);
	commentsLoader.setTemplate("#template-comments");
	commentsLoader.setContainer("#comments-container");
	commentsLoader.setCompleteListener(function() {
		$(".toggle-reply").each(function() {
			$(this).bind('click', function() {
				var list = $(this).closest('.comment-list');
				list.find("form").toggle();
			});
		});
	});
	
	var newsLoader = new Loader('/projects/' + projectId + '/news', 8);
	newsLoader.setTemplate('#template-news');
	newsLoader.setContainer('#news-container');
	
	var supportersLoader = new Loader('/projects/' + projectId + '/supporters', 20);
	supportersLoader.setTemplate('#template-supporter');
	supportersLoader.setContainer('#supporters-container');
	
	$('#tab-comments').data('loader', commentsLoader);
	$('#tab-news').data('loader', newsLoader);
	$('#tab-supporters').data('loader', supportersLoader);
	
	var loadContents = function(e) {
		var href = $(e.target).attr('href');
		var target = $(href);
		if (target.hasClass('loadable')) {
			var loader = target.data('loader');
			if (loader) {
				loader.load();
			}
			target.removeClass('loadable');
		}
	};
	
	var listTickets = function() {
		var tickets = $('#ticket_list').data('tickets');
		if (tickets.length > 0) {
			for (var i = 0, l = tickets.length; i < l; i++) {
				addTicketRow(tickets[i]);
			}
		}
	};
	
	var addTicketRow = function(ticket) {
		var template = $('#template_ticket').html();
		var compiled = _.template(template);
		var row = compiled({ 'ticket': ticket, 'type': $('#project_type').val(), 'style': 'normal' });
		var $row = $($.parseHTML(row));
		$row.data('ticketData', ticket);
		$('#ticket_list').append($row);
	};
	
	listTickets();
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', loadContents);
});
