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
					<a href="{{ url('/projects') }}/{{ $project->id }}">
						<div class="bg-base project-thumbnail" style="background-image: url('{{ $project->getPosterUrl() }}')"></div>
					</a>
					<h4 class="text-ellipsize project-title"><a href="{{ url('/projects') }}/{{ $project->id }}">{{ $project->title }}</a></h3>
					<h6 class="text-ellipsize-2 project-description">{{ $project->description }}</h4>
				</div>
				
				@if ($project->type === 'funding')
				<div class="project-progress-wrapper">
					<span class="project-progress-number"><strong>{{ $project->getProgress() }}</strong>%</span>
					<div class="progress">
					  	<div class="progress-bar" role="progressbar" aria-valuenow="{{ $project->getProgress() }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $project->getProgress() }}%;">
					    	<span class="sr-only">{{ $project->getProgress() }}</span>
					  	</div>
				  	</div>
				  	@if ($project->isFinished())
				  	<span class="project-progress-dday">CLOSED</span>
				  	@else
				  	<span class="project-progress-dday">D-{{ $project->dayUntilFundingClosed() }}</span>
				  	@endif
				</div>
				<img src="{{ asset('/img/app/img_funding_progress.png') }}" class="project-indicator-img" />
				@else
				<div class="project-ticket-info">
					<span>{{ $project->getTicketDateFormatted() }}</span>
					<span class="right">{{ $project->detailed_address }}</span>
				</div>
				<img src="{{ asset('/img/app/img_ticket_progress.png') }}" class="project-indicator-img" />
				@endif
				
				@if ($project->isFinished())
				<div class="project-mask">
					<a href="{{ url('/projects') }}/{{ $project->id }}" style="display: block; width: 100%; height: 100%">
						<div class="project-indicator-wrapper">
							<img src="{{ asset('/img/app/img_funding_finished.png') }}" class="project-indicator-img" />
						</div>
					</a>
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