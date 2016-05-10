@extends('app')

@section('css')
<style>
	#main {
		background-image: url('{{ asset("/img/app/process_bg.jpg") }}');
		background-position: center;
		background-size: cover;
	}
	.box-container h5 {
		padding-left: 2em;
		padding-right: 2em;
	}
	.box-container .btn[type="submit"] {
		width: 150px;
		display: block;
		margin: 10px auto 0 auto;
	}
	#input-amount:-moz-placeholder {
		direction: rtl;
	}
	#input-amount::-moz-placeholder {
		direction: rtl;
	}
	#input-amount:-ms-input-placeholder {
		direction: rtl;
	}
	#input-amount::-webkit-input-placeholder {
		direction: rtl;
	}
</style>
@endsection

@section('content')
<div class="first-container">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 box-container">
				@if (Input::get('type') === 'funding')
					<img src="{{ asset('/img/app/img_blueprint_funding.png') }}" class="img-blueprint" />
				@else
					<img src="{{ asset('/img/app/img_blueprint_ticket.png') }}" class="img-blueprint" />
				@endif
				<h1>
					@if (Input::get('type') === 'funding')
						<span class="text-primary">펀딩 프로젝트</span>
					@else
						<span class="text-primary">티켓팅 프로젝트</span>
					@endif
					<span> 개설신청</span>
				</h1>
				<h5>
					본 페이지는 운영진만이 열람할 수 있는 프로젝트 개설신청을 위한 기본정보를 입력하는 공간이기 때문에 자유롭게 입력해 주셔도 좋습니다! 하지만 운영진이 여러분과 여러분의 프로젝트에 대해 가늠할 수 있도록 최대한 구체적으로 질문에 답해주세요!
				</h5>
				<form action="{{ url('/blueprints') }}" method="post" data-toggle="validator" role="form">
					<div class="form-group">
						<label for="input-user-intro">프로젝트 개설자</label>
						<input id="input-user-intro" name="user_introduction" type="text" class="form-control" required />
						<p class="help-block">
							공연기획자(혹은 회사) '000' / 꿈꾸는 뮤지션 '000' / 많은 사람들에게 희망을 주고픈 강연자 '000' 등 여러분을 자유롭게 표현해 주세요.
						</p>
					</div>
					<div class="form-group">
						<label for="input-project-intro">어떤 종류의 공연을 기획하고 계세요?</label>
						<input id="input-project-intro" name="project_introduction" type="text" class="form-control" required />
						<p class="help-block">
							인디밴드 '000'의 단독콘서트 / 극단 '000'의 정기공연 / 화가 '000'의 전시회 등
						</p>
					</div>
					<div class="form-group">
						<label for="input-story">공연에 담긴 자신만의 이야기가 있다면?</label>
						<textarea id="input-story" name="story" class="form-control" required></textarea>
						<p class="help-block">
							많은 사람에게 공감을 줄 수 있는 여러분만의 이야기는, 앞으로 진행할 펀딩과 공연이 더 많은 사람에게 전달되는 데 큰 도움이 됩니다.
						</p>
					</div>
					<div class="form-group">
						@if (Input::get('type') === 'funding')
						<label for="input-amount">어느 정도의 공연기획비용이 필요할까요?</label>
						<input id="input-amount" name="estimated_amount" type="number" placeholder="원" class="form-control" required />
						<p class="help-block">
							목표달성이 용이하도록 최소로 필요한 대략의 공연기획비용을 책정해보세요.
						</p>
						@else
						<label for="input-amount">어느 정도의 규모의 공연입니까?</label>
						<input id="input-amount" name="estimated_amount" type="text" class="form-control" required />
						<p class="help-block">
							좌석규모, 공연기획예산 등 공연의 규모를 알 수 있도록 구체적으로 적어주세요!
						</p>
						@endif
					</div>
					<div class="form-group">
						<label for="input-contact">이메일을 남겨주세요</label>
						<input id="input-contact" name="contact" type="email" class="form-control" required />
					</div>
					@include('helper.contact', [
						'label' => '연락 가능한 전화번호를 남겨주세요',
						'name' => 'tel',
						'help' => '프로젝트 개설을 위한 연락 목적 외에는 절.대. 다른 용도로 사용되지 않습니다. 안심하세요',
						'required' => 'required'
					])
					<input type="submit" class="btn btn-success" value="신청하기" />
					<input type="hidden" name="type" value="{{ Input::get('type') }}" />
					@include('csrf_field')
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
@endsection
