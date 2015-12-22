<script type="text/template" id="template-supporter">
	<li class="supporter-list">
		<a href="{{ url('/users') }}/<%= data.user.id %>" target="_blank">
			<% if (data.user.profile_photo_url) { %>
			<div class="user-photo-support bg-base pull-left" style="background-image: url('<%= data.user.profile_photo_url %>');"></div>
			<% } else { %>
			<div class="user-photo-support bg-base pull-left" style="background-image: url('http://orig06.deviantart.net/ea2a/f/2010/213/6/d/facebook_default_picture_by_graffadetoart.jpg');"></div>
			<% } %>
		</a>
		<div class="supporter-text">
			<% if (data.ticket.real_ticket_count > 0) { %>
			<span><a class="text-important" href="{{ url('/users') }}/<%= data.user.id %>" target="_blank"><%= data.user.name %></a> 님이 티켓 <%= data.ticket.real_ticket_count %>매와 함께 후원하였습니다.</span>
			<% } else { %>
			<span><a class="text-important" href="{{ url('/users') }}/<%= data.user.id %>" target="_blank"><%= data.user.name %></a> 님이 후원하였습니다.</span>
			<% } %>
		</div>
		<div class="clear"></div>
	</li>
</script>