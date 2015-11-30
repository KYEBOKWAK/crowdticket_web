@extends('app')

@section('css')
<style>
	#main {
		background-image: url('{{ asset("/img/app/process_bg.jpg") }}');
		background-position: center;
		background-size: cover;
	}
	.box-container .btn[type="submit"] {
		width: 150px;
		display: block;
		margin: 10px auto 0 auto;
	}
	.box-container .user-photo-middle {
		margin-right: 30px;
	}
	#input-user-name,
	.ps-password-group input {
		width: 50%;
	}
	.box-container .contact {
		width: 30%;
	}
	.ps-password-group input {
		margin-bottom: 10px;
	}
	.user-photo-middle {
		margin-bottom: 15px;
	}
	.ps-modify-user-photo {
		margin-top: 35px;
	}
</style>
@endsection

@section('content')
<div class="first-container">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 box-container">
				<h2>내 정보 수정</h2>
				<form action="{{ url('/users') }}/{{ $user->id }}" method="post" data-toggle="validator" role="form">
					<div class="form-group">
						<label for="input-user-name">이름</label>
						<input id="input-user-name" name="name" type="text" class="form-control" maxlength="64" required value="{{ $user->name }}" placeholder="실명을 입력해주세요" />
					</div>
					<div class="form-group ps-password-group">
						<label for="input-user-password">비밀번호 설정</label>
						<input id="input-user-password" name="old_password" type="password" maxlength="32" class="form-control" required placeholder="현재 비밀번호" />
						<input id="input-user-password-new" name="new_password" type="password" maxlength="32" class="form-control" placeholder="새로운 비밀번호" />
						<input id="input-user-password-re" type="password" class="form-control" maxlength="32" placeholder="비밀번호 확인" />
					</div>
					<div class="form-group">
						<label for="input-user-intro">프로필 사진</label>
						<div>
							<div class="user-photo-middle bg-base pull-left" style="background-image: url('{{ $user->getPhotoUrl() }}');"></div>
							<a href="#" class="btn btn-default ps-modify-user-photo">변경하기</a>
						</div>
					</div>
					@include('helper.contact', [
						'label' => '연락처',
						'name' => 'contact',
						'help' => '참여한 공연 관련 정보나 각종 펀딩 보상품 수령을 위한 연락처를 입력하여 주세요'
					])
					<div class="form-group">
						<label for="input-contact">웹사이트</label>
						<input id="input-contact" name="contact" type="email" class="form-control" required />
						<p class="help-block">
							회원님을 더 자세히 알고자 하는 사람들을 위하여 웹사이트를 입력해주세요
						</p>
					</div>
					<input type="submit" class="btn btn-success" value="확  인" />
					<input type="hidden" name="type" value="{{ Input::get('type') }}" />
					@include('form_method_spoofing', [
						'method' => 'put'
					])
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
@endsection
