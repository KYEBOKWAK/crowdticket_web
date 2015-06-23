@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<h1>BE ON STAGE</h1>
			<h2>JUST LIKE YOUR DREAM</h2>
			<h3>콘서트, 연극, 뮤지컬, 갤러리, 강연회<br/>어떤 무대든 좋습니다.<br/>지금 바로 기획하고 티켓을 판매하세요.</h3>
			<button type="button" class="btn btn-default">개설신청하기</button>
			<a role="button" href="{{ url('/blueprints/form?type=funding') }}" class="btn btn-default">크라우드펀딩으로 공인기획 후 티켓판매</a>
			<a role="button" href="{{ url('/blueprints/form?type=sale') }}" class="btn btn-default">지금 바로 공연 등록 후 티켓판매</a>
		</div>
	</div>
</div>
@endsection
