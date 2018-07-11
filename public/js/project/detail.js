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
		var row = compiled({
			'ticket': ticket,
			'type': $('#project_type').val(),
			'style': 'normal',
			'projectId': projectId,
			'buyable': $('#buyable').val() === "1"
		});
		var $row = $($.parseHTML(row));
		$row.data('ticketData', ticket);
		$row.bind('click', function () {
			var parseDate = function(input) {
				var dash = '-';
				var whitespace = ' ';
				var colon = ':';
				if (input.indexOf(dash) !== -1) {
					var parts = input.split(dash);
					var year = parts[0];
					var month = parts[1] - 1; // Note: months are 0-based
					var day = parts[2];
					if (day.indexOf(whitespace) !== -1) {
						var details = day.split(whitespace);
						day = details[0];
						var times = details[1].split(colon);
						return new Date(year, month, day, times[0], times[1], times[2]);
					}
					return new Date(year, month, day);
				}
				return Date.parse(input);
			};

			var form = $(this).closest('form');
			var limit = ticket.audiences_limit;
			var count = ticket.audiences_count;
			if (parseInt(limit) === 0 || parseInt(limit) > parseInt(count)) {
				var delivery = ticket.delivery_date;
				if (Date.now() < parseDate(delivery)) {
					$(this).next().click();
				} else {
					alert("이미 지난 공연입니다.");
					return false;
				}
			} else {
				alert("매수 제한으로 참여할 수 없습니다.");
				return false;
			}
		});
		$('#ticket_list').append($row);
	};

	listTickets();

	$('a[data-toggle="tab"]').on('shown.bs.tab', loadContents);
});
