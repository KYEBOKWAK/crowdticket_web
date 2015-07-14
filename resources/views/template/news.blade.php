<script type="text/template" id="template_news">
	<li class="list-group-item">
		<h4><%= data.title %></h4>
		<p><%= data.content %></p>
		@if ($is_master)
			<a href="{{ url('/news/') }}/<%= data.id %>/form" class="btn btn-default">수정하기</a>
		@endif
	</li>
</script>