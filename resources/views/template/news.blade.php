<script type="text/template" id="template-news">
	<li class="list-group-item news-list">
		<div class="news-title-wrapper">
			<h5 class="text-ellipsize"><%= data.title %></h5>
			<span><%= data.created_at %></span>
		</div>
		<p><%= data.content %></p>
		@if ($is_master)
		<div class="text-right">
			<a href="{{ url('/news/') }}/<%= data.id %>/form" class="btn btn-default">수정</a>
			<a href="{{ url('/news/') }}/<%= data.id %>/form" class="btn btn-default">삭제</a>
		</div>
		@endif
	</li>
</script>