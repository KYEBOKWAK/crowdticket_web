@extends('app')

@section('css')
@endsection

@section('content')
<div class="container first-container">
	@include ('order.header', ['project' => $project, 'step' => 3])
	<div class="row">
	</div>
</div>
@endsection
