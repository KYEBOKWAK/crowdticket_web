<script type="text/template" id="template-comments">
    <li class="comment-list">
        <a href="{{ url('/users') }}/<%= data.user.id %>" target="_blank">
			<% if (data.user.profile_photo_url) { %>
			<div class="user-photo-comment bg-base pull-left" style="background-image: url('<%= data.user.profile_photo_url %>');"></div>
			<% } else { %>
			<div class="user-photo-comment bg-base pull-left" style="background-image: url('{{ asset('/img/app/default-user-image.png') }}');"></div>
			<% } %>
		</a>
		<div class="comment-section-right">
			<a href="{{ url('/users') }}/<%= data.user.id %>" target="_blank"><span class="comment-username"><strong><%= data.user.name %></strong></span></a>
			<span class="comment-created-at"><%= data.created_at %></span>
			<span class="toggle-reply">답글달기</span>
      <% if(isMyOrMasterComment(data.user.id)) { %>
      <span class="delete-comment" data-comment-id="<%= data.id %>">삭제하기</span>
			<% } %>

			<p class="comment-content"><%= data.contents.split("\n").join("<br />") %></p>
		</div>
		<div class="clear"></div>
		<div class="reply-wrapper">
			@if(Auth::user())
			<form action="{{ url('/comments') }}/<%= data.id %>/comments" method="post" data-toggle="validator" role="form" class="form-horizontal">
				<div class="form-group">
					<div class="col-md-2">
						<div class="bg-base user-photo-reply" style="background-image: url('{{ Auth::user()->profile_photo_url }}');"></div>
					</div>
					<div class="col-md-7 reply-textarea">
						<textarea name="contents" class="form-control" rows="3" placeholder="답글을 입력하세요" required></textarea>
					</div>
					<div class="col-md-2 reply-button">
						<button class="btn btn-success pull-right">답글달기</button>
					</div>
				</div>
				@include('csrf_field')
			</form>
			@endif

			<% if (data.comments.length > 0) { %>
			<ul>
				<% for (var i = data.comments.length - 1, l = 0; i >= l; i--) { %>
				<% var reply = data.comments[i]; %>
				<li>
					<a href="{{ url('/users') }}/<%= reply.user.id %>" target="_blank">
						<% if (reply.user.profile_photo_url) { %>
						<div class="user-photo-reply bg-base pull-left" style="background-image: url('<%= reply.user.profile_photo_url %>');"></div>
						<% } else { %>
						<div class="user-photo-reply bg-base pull-left" style="background-image: url('{{ asset('/img/app/default-user-image.png') }}');"></div>
						<% } %>
					</a>
					<div class="comment-section-right">
						<a href="{{ url('/users') }}/<%= reply.user.id %>" target="_blank"><span class="comment-username"><strong><%= reply.user.name %></strong></span></a>
						<span class="comment-created-at"><%= reply.created_at %></span>
            <% if(isMyOrMasterComment(reply.user.id)) { %>
            <span class="delete-comment" data-comment-id="<%= reply.id %>">삭제하기</span>
      			<% } %>
						<p class="comment-content"><%= reply.contents.split("\n").join("<br />") %></p>
					</div>
					<div class="clear"></div>
				</li>
				<% } %>
			</ul>
			<% } %>
		</div>
	</li>
</script>
