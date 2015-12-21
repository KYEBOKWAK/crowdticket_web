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
			<h5 class="text-center"><strong>참여하신 프로젝트의 결제관련 사항은 '내 페이지'에서 다시 확인할 수 있습니다.</strong></h5>
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
					<span>1002 547 856455 우리은행</span>
				</div>
				<div class="col-md-3 col-md-offset-2 text-right">
					<span>예금주</span>
				</div>
				<div class="col-md-6">
					<span>나인에이엠</span>
				</div>
				<div class="col-md-3 col-md-offset-2 text-right">
					<span>입금하실 분의 성함</span>
				</div>
				<div class="col-md-6">
					<span>{{ $order->account_name }}</span>
				</div>
			</div>
			<div class="text-center text-danger">
				5일 이내에 위의 입금자 성함으로 입금하지 않으시면 참여는 자동 취소됩니다. <br/>
				펀딩이 종료되는 날짜가 5일 이전이라면, 그 전에 입금을 해주셔야 반영됩니다.
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			<a href="{{ url('/projects') }}" class="btn btn-success ">더 둘러보기</a>
		</div>
	</div>
</div>
@endsection
