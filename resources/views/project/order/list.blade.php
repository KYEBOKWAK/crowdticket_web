@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10">
			<h3>주문</h3>
			<ul class="list-group">
				@foreach ($project->orders as $order)
					<li class="ticket list-group-item">
						<p>이름: {{ $order->user->name }}, 주소: {{ $order->address }}, 연락처: {{ $order->contact }} 등등등</p>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection
