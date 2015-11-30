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
			<span><a href="#">답글달기</a></span>
			@endif
			<p class="comment-content"><%= data.contents %></p>
		</div>
		<div class="clear"></div>
	</li>
</script>