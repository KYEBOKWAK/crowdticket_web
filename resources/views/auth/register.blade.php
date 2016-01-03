@extends('app')

@section('css')
<style>
	.box-container form {
		padding-left: 2em;
		padding-right: 2em;
	}
	.box-container button[type="submit"] {
		margin-top: 1.5em;
		padding-left: 2em;
		padding-right: 2em;
	}
</style>
@endsection

@section('content')
<div class="first-container container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 box-container">
			<h1>회원가입</h1>
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					<li>
						{{ $error }}
					</li>
					@endforeach
				</ul>
			</div>
			@endif
			<div class="text-center">
				<a href="{{ url('/facebook') }}">페이스북으로 로그인</a>
			</div>
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="form-group">
					<label class="control-label">이름</label>
					<input type="text" class="form-control" name="name" value="{{ old('name') }}" required="required">
				</div>

				<div class="form-group">
					<label class="control-label">이메일</label>
					<input type="email" class="form-control" name="email" value="{{ old('email') }}" required="required">
				</div>

				<div class="form-group">
					<label class="control-label">비밀번호</label>
					<input type="password" class="form-control" name="password" required="required">
				</div>

				<div class="form-group">
					<label class="control-label">비밀번호 확인</label>
					<input type="password" class="form-control" name="password_confirmation" required="required">
				</div>

				<div class="form-group text-center">
					<button type="submit" class="btn btn-primary">JOIN</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
