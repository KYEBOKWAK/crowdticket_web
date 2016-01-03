<script type="text/template" id="template_ticket">
	<div data-ticket-id="<%= ticket.id %>" class="ticket col-md-12">
		<% if (style === 'normal' && !finished) { %>
		<a href="{{ url('/projects/') }}/<%= projectId %>/tickets?selected_ticket=<%= ticket.id %>">
		<% } %>
		
		<div class="ticket-wrapper <% if (style === 'modifyable') { %> col-md-11 <% } %>">
			<div class="ticket-body">
				<% if (type === 'funding') { %>
					<span class="text-primary">
						<span class="ticket-price"><%= ticket.price %></span>원 이상 후원
					</span>
					<% if (ticket.real_ticket_count > 0) { %>
						<span class="pull-right">
							<img src="{{ asset('/img/app/ico_ticket2.png') }}" />
							티켓
							<span class="ticket-real-count"><%= ticket.real_ticket_count %></span>매 포함
						</span>
					<% } %>
				<% } else if (type === 'sale') { %>
					<%
						var rawDate = ticket.delivery_date.split(" ");
						var d = rawDate[0].split("-");
						var t = rawDate[1].split(":");
						var date = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
						var yyyy = date.getFullYear();
	    				var mm = date.getMonth() + 1;
						var dd = date.getDate();
	    				var H = date.getHours();
	    				var min = date.getMinutes();
	    				if (min < 10) {
	    					min = "0" + min;
	    				}
	    				var formatted = yyyy + "년 " + mm + "월 " + dd + "일 " + H + ":" + min;  
					%>
					<span class="text-primary ticket-delivery-date"><%= formatted %></span>
					<span class="pull-right">
						<span class="ticket-price"><%= ticket.price %></span>원
					</span>
				<% } %>
				<p class="ticket-reward"><%= ticket.reward %></p>
			</div>
			<div class="ticket-footer">
				<span>
					<span class="text-primary"><%= ticket.audiences_count %></span>명이 선택 중 /
				</span>
				<% if (ticket.audiences_limit > 0) { %>
					<span>
						<span class="ticket-audiences-limit"><%= ticket.audiences_limit %></span>개 제한
					</span>
				<% } else { %>
					<span>제한 없음</span>
				<% } %>
				<% if (type === 'funding') { %>
					<%
						var rawDate = ticket.delivery_date.split(" ");
						var d = rawDate[0].split("-");
						var t = rawDate[1].split(":");
						var date = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
	    				var mm = date.getMonth() + 1;
						var dd = date.getDate();
	    				var formatted = mm + "월 " + dd + "일";
					%>
					<span class="pull-right">예상 실행일 : <span class="ticket-delivery-date"><%= formatted %></span></span>
				<% } %>
			</div>
		</div>
		
		<% if (style === 'normal' && !finished) { %>
		</a>
		<% } %>
		
		<% if (style === 'modifyable' && ticket.audiences_count === 0) { %>
		<div class="col-md-1">
			<p>
				<button class="btn btn-primary modify-ticket">수정</button>
				<button class="btn btn-primary delete-ticket">삭제</button>
			</p>
		</div>
		<% } %>
	</div>
</script>