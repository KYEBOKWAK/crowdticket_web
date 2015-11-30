<div class="row box-creator-profile">
	<div class="col-md-12">
		<h6><strong>프로젝트 개설자</strong></h6>
	</div>
	<div class="col-md-4">
		<div class="user-photo-creator bg-base" style="background-image: url('{{ $user->getPhotoUrl() }}');"></div>
	</div>
	<div class="col-md-2">
		<p><strong>이 름</strong></p>
		<p><strong>연 락 처</strong></p>
		<p><strong>이 메 일</strong></p>
		<p><strong>웹사이트</strong></p>
	</div>
	<div class="col-md-6">
		<p>{{ $user->name }}</p>
		<p>{{ $user->name }}</p>
		<p>{{ $user->email }}</p>
		<p>{{ $user->email }}</p>
	</div>
</div>