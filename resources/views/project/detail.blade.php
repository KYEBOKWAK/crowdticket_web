@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<p>{{ $project }}</p>
			<div class="panel panel-default">
				<div class="panel-body">{!! html_entity_decode($project->story) !!}</div>
			</div>
		</div>
	</div>
</div>
@endsection
