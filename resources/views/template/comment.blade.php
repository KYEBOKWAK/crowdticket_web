<script type="text/template" id="template-comments">
	<li class="comment-list">
		<% if (data.user.profile_photo_url) { %>
		<div class="user-photo-comment bg-base pull-left" style="background-image: url('<%= data.user.profile_photo_url %>');"></div>
		<% } else { %>
		<div class="user-photo-comment bg-base pull-left" style="background-image: url('http://orig06.deviantart.net/ea2a/f/2010/213/6/d/facebook_default_picture_by_graffadetoart.jpg');"></div>
		<% } %>
		<div class="comment-section-right">
			<span class="comment-username"><strong><%= data.user.name %></strong></span>
			<span class="comment-created-at"><%= data.created_at %></span>
			@if ($is_master)
			<span class="toggle-reply">답글달기</span>
			@endif
			<p class="comment-content"><%= data.contents %></p>
		</div>
		<div class="clear"></div>
		<div class="reply-wrapper">
			@if ($is_master)
			<form action="{{ url('/comments') }}/<%= data.id %>/comments" method="post" data-toggle="validator" role="form" class="form-horizontal">
				<div class="form-group">
					<div class="col-md-2">
						<div class="bg-base user-photo-reply" style="background-image: url('<%= data.user.profile_photo_url %>');"></div>
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
				<% for (var i = 0, l = data.comments.length; i < l; i++) { %>
				<% var reply = data.comments[i]; %>
				<li>
					<% if (reply.user.profile_photo_url) { %>
					<div class="user-photo-reply bg-base pull-left" style="background-image: url('<%= reply.user.profile_photo_url %>');"></div>
					<% } else { %>
					<div class="user-photo-reply bg-base pull-left" style="background-image: url('http://orig06.deviantart.net/ea2a/f/2010/213/6/d/facebook_default_picture_by_graffadetoart.jpg');"></div>
					<% } %>
					<div class="comment-section-right">
						<span class="comment-username"><strong><%= reply.user.name %></strong></span>
						<span class="comment-created-at"><%= reply.created_at %></span>
						<p class="comment-content"><%= reply.contents %></p>
					</div>
					<div class="clear"></div>
				</li>
				<% } %>
			</ul>
			<% } %>
		</div>
	</li>
</script>