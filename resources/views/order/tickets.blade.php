@extends('app')

@section('css')
<style>
	.order {
		cursor: pointer;
	}
	.order .col-md-9 {
		padding-right: 80px;
	}
	.order .form-group,
	.order .ps-submit-wrapper {
		display: none;
	}
	.order.show-form .form-group,
	.order.show-form .ps-submit-wrapper {
		display: block;
	}
	.ps-submit-wrapper {
		position: absolute;
		height: 100%;
		top: 0;
		right: 0;
	}
	.ps-submit-wrapper div {
		position: relative;
		height: 100%;
	}
	.ps-submit-wrapper div img {
		position: absolute;
		top: 0;
		bottom: 0;
		right: 0;
		margin: auto;
	}
	input[type="submit"] {
		display: none;
	}
</style>
@endsection

@section('content')
<div class="container first-container">
	@include ('order.header', ['project' => $project, 'step' => 1])
	<div class="row">
		@foreach ($project->tickets as $ticket)
		<div data-ticket-id="{{ $ticket->id }}" class="ticket order col-md-12 @if ((int) \Input::get('selected_ticket') === (int) $ticket->id) show-form @endif">
			<div class="ticket-wrapper">
				<form action="{{ url('/tickets/') }}/{{ $ticket->id }}/orders/form" method="post" class="ticket-body row display-table">
					@if ($project->type === 'funding')
					<div class="col-md-3 display-cell text-right">
						<span><strong class="text-primary ticket-price">{{ $ticket->price }}</strong> 원 이상</span>
					</div>
					@else
					<div class="col-md-3 display-cell">
						<span>
							<span class="text-primary">공연일시</span><br/> 
							<strong class="ps-strong-small">{{ date('Y.m.d H:m', strtotime($ticket->delivery_date)) }}</strong>
							<span class="pull-right">{{ $ticket->price }} 원</span>
						</span>
					</div>
					@endif
					<div class="col-md-9 display-cell">
						<div class="form-group stop-propagation">
							<div class="input-group col-sm-4">
								<input class="ticket_audiences_limit" type="hidden" value="{{ $ticket->audiences_limit }}" />
								<input class="available_ticket_count" type="hidden" value="{{ $ticket->audiences_limit - $ticket->audiences_count }}" />
								@if ($project->type === 'funding')
								<input name="request_price" type="number" class="form-control" value="{{ $ticket->price }}" min="{{ $ticket->price }}" />
								<input class="ticket_count" name="ticket_count" type="hidden" value="1" />
								<div class="input-group-addon">원</div>
								@else
								<input name="request_price" type="hidden" value="{{ $ticket->price }}" />
								<input name="ticket_count" type="number" class="form-control ticket_count" value="1" min="1" />
								<div class="input-group-addon">매</div>
								@endif
							</div>
							@if ($project->type === 'funding')
							<p class="help-block">후원하고자 하는 {{ $ticket->price }}원 이상의 금액을 자유롭게 입력해주세요.</p>
							@endif
						</div>
						@if ($project->type === 'funding')
							<p class="ticket-reward">{{ $ticket->reward }}</p>
							@if ($ticket->real_ticket_count > 0)
							<span class="ticket-real-count">
								<img src="{{ asset('/img/app/ico_ticket2.png') }}" />
								{{ $ticket->real_ticket_count }}매
							</span>
							@endif
							<span class="ticket-delivery-date">예상 실행일 : {{ date('Y년 m월 d일', strtotime($ticket->delivery_date)) }}</span>
						@else
							<p class="ticket-reward ps-no-margin">{{ $ticket->reward }}</p>
						@endif
					</div>
					<div class="ps-submit-wrapper stop-propagation">
						<div>
							<img src="{{ asset('/img/app/btn_next.png') }}" />
							<input type="submit" />
						</div>
					</div>
					@include('csrf_field')
				</form>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection

@section('js')
<script>
	$(document).ready(function() {
		$(".ticket").each(function() {
			$(this).bind('click', function() {
				$(this).toggleClass('show-form');
			});
		});
		$(".stop-propagation").each(function() {
			$(this).bind('click', function(event) {
				event.stopPropagation();
			});
		});
		$(".ps-submit-wrapper img").each(function() {
			$(this).bind('click', function() {
				var form = $(this).closest('form');
				var audiencesLimit = form.find('.ticket_audiences_limit').val();
				var availableTicketCount = form.find('.available_ticket_count').val();
				var ticketCount = form.find('.ticket_count').val();
				if (audiencesLimit === '0' || availableTicketCount >= ticketCount) {
					$(this).next().click();
				} else {
					alert("매수 제한으로 참여할 수 없습니다.");
				}
			});
		});
	});
	
</script>
@endsection
