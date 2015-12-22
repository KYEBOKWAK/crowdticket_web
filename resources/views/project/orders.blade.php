@extends('app')

@section('css')
<style>
	.first-container .row {
		padding: 30px;
	}
</style>
@endsection

@section('content')
@include('helper.btn_admin', ['project' => $project])
<div class="first-container container">
	<div class="row">
		<img src="{{ asset('/img/app/img_update_project_reward.png') }}" class="center-block" />
		<h2 class="text-center text-important">후원자 관리</h2>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<tr>
						<td>이름</td>
						<td>후원금액</td>
						<td>상태</td>
						<td>결제일</td>
						<td>이메일</td>
						<td>전화번호</td>
						<td>포함된티켓</td>
					</tr>
				</thead>
				<tbody>
					@foreach ($orders as $order)
					<tr>
						<td>{{ $order->account_name }}</td>
						<td>{{ $order->price }}</td>
						@if ($order->deleted_at)
							@if ($order->confirmed)
							<td>환불요청</td>
							@else
							<td>취소함</td>
							@endif
						@else
							@if ($order->confirmed)
							<td>입금완료</td>
							@else
							<td>미입금</td>
							@endif
						@endif
						<td>{{ $order->created_at }}</td>
						<td>{{ $order->email }}</td>
						<td>{{ $order->contact }}</td>
						<td>{{ $order->count }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

