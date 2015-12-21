@extends('app')

@section('css')
<style>
	.ps-detail-header {
		background-color: #FFFFFF;
	}
	.ps-detail-user-wrapper {
		padding-top: 20px;
		padding-bottom: 10px;
		text-align: center;
	}
	.ps-detail-user-wrapper.user-photo-big {
		display: block;
		margin: 0 auto;
	}
	.ps-detail-user-wrapper h3 {
		font-size: 21px;
	}
	.ps-detail-title {
		margin-top: 48px;
		margin-bottom: 15px;
		padding-bottom: 13px;
		border-bottom: 1px #DEDEDE solid;
	}
	.project-thumbnail {
		width: 140px;
		height: 140px;
	}
	.container .row a {
		display: block;
		background-color: white;
		border: 1px #dad8cc solid;
		border-radius: 5px;
		padding: 15px;
		margin-bottom: 15px;
	}
	.container a .row h3 {
		margin-top: 12px;
		margin-bottom: 15px;
	}
	.container .ps-text-box {
		display: inline-block;
		padding: 5px 10px 5px 10px;
		background-color: #eee;
		border: 1px #dad8cc solid;
		border-radius: 5px;
	}
</style>
@endsection

@section('content')
<div class="first-container ps-detail-header">
	<div class="ps-detail-user-wrapper">
		<div class="user-photo-big bg-base center-block" style="background-image: url('{{ $user->getPhotoUrl() }}');"></div>
		<h3><strong>{{ $user->name }}</strong></h3>
	</div>
</div>
<div class="container">
	@if (sizeof($orders) > 0)
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h3 class="ps-detail-title"><strong>주문내역</strong></h3>
		</div>
	</div>
	@foreach ($orders as $order)
	<div class="row">
		<a class="col-md-8 col-md-offset-2" href="{{ url('/orders') }}/{{ $order->id }}">
			<div class="row">
				<div class="col-md-3">
					<div class="bg-base project-thumbnail" style="background-image: url('{{ $order->project->getPosterUrl() }}')"></div>
				</div>
				<div class="col-md-9">
					<h3 class="text-ellipsize"><strong>{{ $order->project->title }}</strong></h3>
					<h5>입금자 : <strong>{{ $order->account_name }}</strong></h5>
					<h5>금액 : <strong>{{ $order->price * $order->count }}원</strong></h5>
					<span class="ps-text-box text-center pull-right">
						@if ($order->deleted_at)
							@if ($order->confirmed)
								환불요청
							@else
								취소됨
							@endif
						@else
							@if ($order->confirmed)
								입금완료
							@else
								입금 확인중
							@endif
						@endif
					</span>
				</div>
			</div>
		</a>
	</div>
	@endforeach
	@endif
</div>
@endsection
