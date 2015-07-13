$(document).ready(function() {
	var projectId = $('#project_id').val();
	
	var newsLoader = new Loader('/projects/' + projectId + '/news', 8);
	newsLoader.setTemplate('#template_news');
	newsLoader.setContainer('#news_container');
	
	$('#news').data('loader', newsLoader);
	
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
