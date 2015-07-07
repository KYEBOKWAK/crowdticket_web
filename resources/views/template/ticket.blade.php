<script type="text/template" id="template_ticket">
	<li data-ticket-id="<%= ticket.id %>" class="ticket list-group-item">
		<p><span class="ticket-price"><%= ticket.price %></span><span>원 이상을 후원하시는 분께</span></p>
		<p>
			<% if (ticket.real_ticket_count > 0) { %>
				<span>티켓 </span>
				<span class="ticket-real-count"><%= ticket.real_ticket_count %></span>
				<span> + </span>
			<% } %>
			<span class="ticket-reward"><%= ticket.reward %></span>
		</p>
		<p><span>보상 실행일 : </span><span class="ticket-delivery-date"><%= ticket.delivery_date %></span></p>
		<p>
			<% if (ticket.audiences_limit > 0) { %>
				<span class="ticket-audiences-limit">제한 없음</span>
			<% } else { %>
				<span class="ticket-audiences-limit"><%= ticket.audiences_limit %></span>
				<span>개 제한</span>
			<% } %>
			<span> / </span>
			<span class="ticket-audiences-count">0</span>
			<span>명이 선택 중</span>
		</p>
		<p>
			<button class="btn btn-primary modify-ticket">수정</button>
			<button class="btn btn-primary delete-ticket">삭제</button>
		</p>
		<input type="hidden" class="ticket-require-shipping" value="<%= ticket.require_shipping %>" />
	</li>
</script>
<script src="{{ asset('/script/project/form.js') }}"></script>