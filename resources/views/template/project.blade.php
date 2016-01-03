<?php
	$i = 0;
?>

@foreach ($projects as $project)
	@if ($i % 3 === 0)
	<div class="row">
	@endif
	
		<div class="@if (!isset($colOnly)) col-md-4 @endif project-grid">
			<div class="project-grid-wrapper">
				<div>
					@if ($project->isPublic())
					<a href="{{ url('/projects') }}/{{ $project->id }}">
						<div class="bg-base project-thumbnail" style="background-image: url('{{ $project->getPosterUrl() }}')">
							<div class="white-mask"></div>
						</div>
					</a>
					<h4 class="text-ellipsize project-title"><a href="{{ url('/projects') }}/{{ $project->id }}">{{ $project->title }}</a></h3>
					@else
					<a href="{{ url('/projects') }}/form/{{ $project->id }}">
						<div class="bg-base project-thumbnail" style="background-image: url('{{ $project->getPosterUrl() }}')"></div>
					</a>
					<h4 class="text-ellipsize project-title"><a href="{{ url('/projects') }}/form/{{ $project->id }}">{{ $project->title }}</a></h3>
					@endif
					<h6 class="text-ellipsize-2 project-description">{{ $project->description }}</h4>
				</div>
				
				@if ($project->type === 'funding')
				<div class="project-progress-wrapper">
					<div class="progress">
					  	<div class="progress-bar" role="progressbar" aria-valuenow="{{ $project->getProgress() }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $project->getProgress() }}%;">
					    	<span class="sr-only">{{ $project->getProgress() }}</span>
					  	</div>
				  	</div>
					<span class="project-progress-number"><strong>{{ $project->getProgress() }}</strong>%</span>
				  	@if ($project->isFinished())
				  		@if ($project->isSuccess())
					  	<span class="project-progress-dday text-danger">성공!</span>
				  		@else
				  		<span class="project-progress-dday">CLOSED</span>
				  		@endif
				  	@else
				  	<span class="project-progress-dday">{{ $project->dayUntilFundingClosed() }}일 남았어요!</span>
				  	@endif
				</div>
				@else
				<div class="project-ticket-concert text-center">
					<img src="{{ asset('/img/app/ico_map.png') }}" width="18px" height="18px" />
					<span>{{ $project->concert_hall }}</span>
				</div>
				<div class="project-ticket-date text-center">
					<span>{{ $project->getTicketDateFormatted() }}</span>
				</div>
				@endif
			</div>
		</div>
	
	@if (($i % 3 === 2) || ($i === count($projects) - 1))
	</div>
	@endif
	
	<?php
		$i++;
	?>
@endforeach