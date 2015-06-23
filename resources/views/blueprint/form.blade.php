@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>페이지 개설 신청</h1>
					@if (Input::get('type') === 'funding')
						<h4>(펀딩 후 티켓판매 방식)</h2>
					@else
						<h4>(단순 티켓판매 방식)</h2>
					@endif
				</div>
				<form class="panel-body" action="{{ url('/blueprints') }}" method="post" data-toggle="validator" role="form">
					<div class="form-group">
						<label for="user_introduction">당신은 누구십니까?</label>
						<input id="user_introduction" name="user_introduction" type="text" class="form-control" required />
						<p class="help-block">공연기획자 / 꿈꾸는 뮤지션 / 많은 사람들에게 희망을 주고픈 강연자 / 기획사 직원 등 자신을 자유롭게 표현해 주세요 :)</p>
					</div>
					<div class="form-group">
						@if (Input::get('type') === 'funding')
							<label for="project_introduction">어떤 종류의 공연을 기획하고 계세요?</label>
						@else
							<label for="project_introduction">어떤 종류의 공연입니까?</label>
						@endif
						<input id="project_introduction" name="project_introduction" type="text" class="form-control" required />
						<p class="help-block">인디밴드 '000'의 단독콘서트 / 극단 '000'의 정기공연 / 화가 '000'의 전시회 등</p>
					</div>
					<div class="form-group">
						<label for="story">공연에 담긴 자신만의 이야기가 있다면?</label>
						<input id="story" name="story" type="text" class="form-control" required />
						<p class="help-block">많은 사람에게 공감을 줄 수 있는 여러분만의 이야기는, 앞으로 진행할 펀딩과 공연이 더 많은 사람에게 전달되는 데 큰 도움이 됩니다.</p>
					</div>
					<div class="form-group">
						@if (Input::get('type') === 'funding')
							<label for="estimated_amount">어느 정도의 공연기획비용이 필요할까요?</label>
							<input id="estimated_amount" name="estimated_amount" type="text" class="form-control" required />
							<p class="help-block">목표달성이 용이하도록 최소로 필요한 대략의 공연기획비용을 책정해보세요.</p>
						@else
							<label for="estimated_amount">어느 정도의 규모의 공연입니까?</label>
							<input id="estimated_amount" name="estimated_amount" type="text" class="form-control" required />
							<p class="help-block">좌석규모, 공연기획예산 등 공연의 규모를 알 수 있도록 구체적으로 적어주세요!</p>
						@endif
					</div>
					<div class="form-group">
						<label for="contact_middle">연락 가능한 전화번호를 남겨주세요.</label>
						<div class="form-inline">
							<select id="contact_first" class="form-control contact">
								<option>010</option>
								<option>011</option>
								<option>016</option>
								<option>017</option>
								<option>018</option>
							</select>
							<input id="contact_middle"  type="text" maxlength="4" class="form-control contact" pattern="^\d{3,4}$" required />
							<input id="contact_last" type="text" maxlength="4" class="form-control contact" pattern="^\d{4}$" required />
							<input id="contact" type="hidden" name="contact" />
						</div>
					</div>
					<input type="submit" class="btn btn-success" value="신청하기" />
					<input type="hidden" name="_token" value="{{ csrf_token() }}" /> 
					<input type="hidden" name="type" value="{{ Input::get('type') }}" />
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$(document).ready(function() {
		$('.contact').bind('change', function() {
			var contactFirst = $('#contact_first').val();
			var contactMiddle = $('#contact_middle').val();
			var contactLast = $('#contact_last').val();
			
			$('#contact').val(contactFirst + contactMiddle + contactLast);
		});
	});
</script>
@endsection
