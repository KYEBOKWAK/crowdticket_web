<div class="row ps-update-creator">
	<img src="{{ asset('/img/app/img_update_project_creator.png') }}" class="center-block" />
	<h2>개설자소개</h2>
	<div class="col-md-12">
		<h5 class="bg-info">이 프로젝트를 개설하고자 하는 당신은 누구신가요?
		<br/>
		본인에 대해 명확히 할수록 펀딩에 대한 신뢰도가 올라가고 성공확률이 높아집니다.</h5>
	</div>
	<div class="col-md-12">
		<h3>프로젝트 개설자 박스가 완성되지 않았나요?
		<br/>
		마이페이지 <strong>'내 정보 수정'</strong>에서 프로필을 완성하세요</h3>
		<div class="text-center link-user-form">
			<a href="{{ url('/users') }}/{{ $user->id }}/form" target="_blank" class="btn btn-primary">개인정보 수정하러 가기</a>
		</div>
		<h5 class="text-center"><strong>수정된 프로필박스는 이렇게 보여요!</strong></h5>
		<div class="col-md-4 col-md-offset-4">
			@include('template.creator_profile', ['user' => $user])
		</div>
	</div>
</div>