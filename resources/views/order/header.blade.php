<div class="row order-header">
	<div class="col-md-12">
		<h2 class="text-center">{{ $project->title }}</h2>
	</div>
	@if ($step > 0)
	<div class="col-md-10 col-md-offset-1">
		<div class="col-md-4">
			<img src="{{ asset('img/app/ico_step_progress01.png') }}" class="center-block" />
			<h3 class="text-center @if ($step === 1) text-primary @endif text-important">
				@if ($project->type === 'funding')
					<strong>STEP 1</strong><br/>보상선택</h3>
				@else
					<strong>STEP 1</strong><br/>티켓선택</h3>
				@endif
		</div>
		<div class="col-md-4">
			<img src="{{ asset('img/app/ico_step_progress02.png') }}" class="center-block" />
			<h3 class="text-center @if ($step === 2) text-primary @endif text-important"><strong>STEP 2</strong>
			<br/>
			정보입력 및 결제</h3>
		</div>
		<div class="col-md-4">
			<img src="{{ asset('img/app/ico_step_progress03.png') }}" class="center-block" />
			<h3 class="text-center @if ($step === 3) text-primary @endif text-important"><strong>STEP 3</strong>
			<br/>
			확 인</h3>
		</div>
	</div>
	@endif
</div>