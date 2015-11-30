$(document).ready(function() {
	var projectId = $('#project_id').val();
	
	var commentsLoader = new Loader('/projects/' + projectId + '/comments', 20);
	commentsLoader.setTemplate("#template-comments");
	commentsLoader.setContainer("#comments-container");
	
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
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', loadContents);
});
