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
	.box-container .form-group label.error {
		color: #d9534f;
	}
	#input-user-name,
	.ps-password-group input {
		width: 50%;
	}
	.ps-password-group input {
		margin-bottom: 10px;
	}
	.user-photo-middle {
		margin-bottom: 15px;
	}
	#upload-photo-fake {
		margin-top: 35px;
	}
	#input-contact {
		width: 50%;
	}
</style>
@endsection

@section('content')
<div class="first-container">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 box-container">
				<h2>내 정보 수정</h2>
				<form action="{{ url('/users') }}/{{ $user->id }}" method="post" data-toggle="validator" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label for="input-user-name">이름</label>
						<input id="input-user-name" name="name" type="text" class="form-control" maxlength="64" required value="{{ $user->name }}" placeholder="실명을 입력해주세요" />
					</div>
					<div class="form-group ps-password-group">
						<label for="input-user-password">비밀번호 변경</label>
						<input id="input-user-password" name="old_password" type="password" maxlength="32" class="form-control" placeholder="현재 비밀번호" />
						<input id="input-user-password-new" name="new_password" type="password" maxlength="32" class="form-control" placeholder="새로운 비밀번호" />
						<input id="input-user-password-re" name="new_password_confirmed" type="password" class="form-control" maxlength="32" placeholder="비밀번호 확인" />
					</div>
					<div class="form-group">
						<label for="input-user-intro">프로필 사진</label>
						<div>
							<div id="user-photo" class="user-photo-middle bg-base pull-left" style="background-image: url('{{ $user->getPhotoUrl() }}');"></div>
							<input id="input-user-photo" type="file" name="photo" style="height: 0; visibility: hidden" />
							<a href="#" id="upload-photo-fake" class="btn btn-default">변경하기</a>
						</div>
					</div>
					<div class="form-group clear">
						<label for="input-contact">연락처</label>
						<input id="input-contact" name="contact" type="tel" class="form-control" maxlength="11" value="{{ $user->contact }}" />
						<p class="help-block">
							참여한 공연 관련 정보나 각종 펀딩 보상품 수령을 위한 연락처를 입력하여 주세요
						</p>
					</div>
					<div class="form-group">
						<label for="input-website">웹사이트</label>
						<input id="input-website" name="website" type="url" class="form-control" value="{{ $user->website }}" placeholder="http://crowdticket.kr 형식으로 작성해주세요 :)" />
						<p class="help-block">
							회원님을 더 자세히 알고자 하는 사람들을 위하여 웹사이트를 입력해주세요
						</p>
					</div>
					<input type="submit" class="btn btn-success" value="확  인" />
					
					@if ($toast)
					<input type="hidden" id="toast" class="{{ $toast['level'] }}" value="{{ $toast['message'] }}" />
					@endif
					
					@include('form_method_spoofing', [
						'method' => 'put'
					])
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
	$(document).ready(function() {
		var performPhotoFileClick = function() {
			$('#input-user-photo').trigger('click');
		};
		
		var showPhotoPreview = function() {
			if (this.files && this.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#user-photo').css('background-image', "url('" + e.target.result + "')");
				};
				reader.readAsDataURL(this.files[0]);
			}
		};
		
		$('#input-user-photo').change(showPhotoPreview);
		$('#upload-photo-fake').bind('click', performPhotoFileClick);
		
		$("form").validate({
			rules: {
				"old_password": {
					minlength: 6
				},
				"new_password": {
					minlength: 6
				},
				"new_password_confirmed": {
					minlength: 6,
					equalTo: $('#input-user-password-new')
				},
				"contact": {
					minlength: 9,
					digits: true
				}
			},
			messages: {
				"old_password": {
					minlength: "6자 이상 입력해주세요",
					maxlength: "32자 이하로 입력해주세요"
				},
				"new_password": {
					minlength: "6자 이상 입력해주세요",
					maxlength: "32자 이하로 입력해주세요"
				},
				"new_password_confirmed": {
					minlength: "6자 이상 입력해주세요",
					maxlength: "32자 이하로 입력해주세요",
					equalTo: "비밀번호를 확인해주세요"
				},
				"contact": {
					minlength: "잘못된 번호입니다.",
					maxlength: "잘못된 번호입니다.",
					digits: "잘못된 번호입니다."
				}
			}
		});
		
		$.toast.config.align = 'center';
		$.toast.config.width = 400;
		var toast = $('#toast').val();
		if (toast) {
			var level = $('#toast').attr('class');
			switch (level) {
				default:
				case 'i':
					$.toast('<h4>' + toast + '</h4>', { duration: 2000, type: 'info' });
					break;
				case 's':
					$.toast('<h4>' + toast + '</h4>', { duration: 2000, type: 'success' });
					break;
				case 'e':
					$.toast('<h4>' + toast + '</h4>', { duration: 2000, type: 'danger' });
					break;
			}
		}
	});
</script>
@endsection
