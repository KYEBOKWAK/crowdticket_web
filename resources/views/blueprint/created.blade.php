@extends('app')

@section('css')
<style>
	#main {
		background-image: url('{{ asset("/img/app/process_bg.jpg") }}');
		background-position: center;
		background-size: cover;
	}
	.box-container h1 {
		font-size: 35px;
		padding-bottom: 0;
		border-bottom: none;
	}
	.box-container h4 {
		font-size: 18px;
		text-align: center;
	}
	.box-container h5 {
		text-align: center;
		padding-bottom: 30px;
		margin-bottom: 35px;
		border-bottom: 1px #dad8cc solid;
	}
</style>
@endsection

@section('content')
<div class="first-container">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 box-container">
				<h1>
					<span class="text-primary">페이지 개설신청</span><span>이 완료되었습니다!</span>
				</h1>
				<h5>
					<strong>
						꿈에 그리던 무대에 한 발 더 가까워지셨네요!<br/>
						수일 이내로, 입력하신 이메일을 통해 답변을 드릴게요.
					</strong>
				</h5>
				<h4>
					<strong>
						크라우드티켓은 여러분의 성공적인 공연을 위하여 최선을 다하겠습니다.
					</strong>
				</h4>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
	setTimeout(function() {
		window.location.href = "{{ url('/') }}";
	}, 2000);
</script>
@endsection
