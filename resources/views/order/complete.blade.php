@extends('app')

@section('css')
<style>
	.ps-box {
		background-color: white;
		border: 1px #dad8cc solid;
		border-radius: 5px;
		padding: 25px;
		margin-bottom: 40px;
	}
	.ps-info {
		margin-top: 40px;
		margin-bottom: 40px;
		font-size: 14px;
	}
</style>
@endsection

@section('content')
<div class="container first-container">
	@include ('order.header', ['project' => $project, 'step' => 3])
	<div class="row ps-box">
		<div class="col-md-12">
			<h2 class="text-center"><strong>THANK YOU!</strong></h2>
			<h3 class="text-center"><strong>참여가 완료되었습니다.</strong></h3>
			
			@if ($order->price > 0)
			<div class="row ps-info">
				<div class="col-md-3 col-md-offset-2 text-right">
					<span>금액</span>
				</div>
				<div class="col-md-6">
					<span>{{ $order->price * $order->count }}원</span>
				</div>
				<div class="col-md-3 col-md-offset-2 text-right">
					<span>입금계좌</span>
				</div>
				<div class="col-md-6">
					<span>1005-002-918436 우리은행</span>
				</div>
				<div class="col-md-3 col-md-offset-2 text-right">
					<span>예금주</span>
				</div>
				<div class="col-md-6">
					<span>신효준(나인에이엠)</span>
				</div>
				<div class="col-md-3 col-md-offset-2 text-right">
					<span>입금하실 분의 성함</span>
				</div>
				<div class="col-md-6">
					<span>{{ $order->account_name }}</span>
				</div>
			</div>
			<div class="text-center text-danger">
				입금이 확인되면 SMS로 알려드립니다! <br/>
				위 입금 정보는 오른쪽 상단 '결제확인' 탭에서도 확인할 수 있습니다.
			</div>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			<a href="{{ url('/projects') }}" class="btn btn-success ">더 둘러보기</a>
		</div>
	</div>
</div>
@endsection
