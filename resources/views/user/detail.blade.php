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
	@if (sizeof($creating) > 0)
	<h3 class="ps-detail-title"><strong>개설중인 공연</strong></h3>
	@include('template.project', ['projects' => $creating])
	@endif 
	
	@if (sizeof($created) > 0)
	<h3 class="ps-detail-title"><strong>개설한 공연</strong></h3>
	@include('template.project', ['projects' => $created])
	@endif 
	
	@if (sizeof($orders) > 0)
	<h3 class="ps-detail-title"><strong>참여한 공연</strong></h3>
	@include('template.project', ['projects' => $orders])
	@endif
</div>
@endsection
