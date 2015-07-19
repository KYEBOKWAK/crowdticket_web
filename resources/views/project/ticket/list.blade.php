@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10">
			<h3>주문</h3>
			<ul class="list-group">
				@foreach ($project->tickets as $ticket)
					<li class="ticket list-group-item">
						<a href="{{ url('/tickets/') }}/{{ $ticket->id }}/orders">
							<h4>{{ $ticket->price }}원 이상 후원, 티켓 {{ $ticket->real_ticket_count }}매 포함</h4>
						</a>
						<p>{{ $ticket->reward }}</p>
						<p>예상 실행일 : {{ date('Y-m-d', strtotime($ticket->delivery_date)) }}</p>
						<p>{{ $ticket->audiences_count }}명이 선택중 / {{ $ticket->audiences_limit }}명 제한</p>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection
