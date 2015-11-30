@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/editor.css') }}"/>
<style>
	.container h2 {
		font-weight: bold;
		margin-top: 40px;
		margin-bottom: 30px;
	}
</style>
@endsection

@section('content')
<div class="first-container container">
	<div class="row">
		<h2 class="text-center">업데이트 작성</h2>
		<div class="col-md-10 col-md-offset-1">
			<div class="row">
				<div class="col-md-10">
					<div class="form-group">
						<label for="title" class="control-label">제목</label>
						@if ($news)
						<input id="title" type="text" name="title" class="form-control" value="{{ $news->title }}" />
						@else
						<input id="title" type="text" name="title" class="form-control" />
						@endif
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label">내용</label>
				<input type="hidden" id="tx_image_params" value="url={{ url() }}/projects/{{ $project->id }}/news/images&csrf_token={{ csrf_token() }}" />
				@if ($news)
				<textarea id="tx_load_content" style="display: none">{{ $news->content }}</textarea>
				@endif
				@include('editor')
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					@if ($news)
					<button id="update_news" class="btn btn-success">수정하기</button>
					<input type="hidden" id="method" value="put" />
					@else
					<button id="update_news" class="btn btn-success">작성하기</button>
					<input type="hidden" id="method" value="post" />
					@endif
				</div>
			</div>
			<input type="hidden" id="ajax_url" value="{{ $ajax_url }}" />
			<input type="hidden" id="project_id" value="{{ $project->id }}" />
		</div>
	</div>
</div>
@endsection

@section('js')
	<script src="{{ asset('/js/project/news/form.js') }}"></script>
@endsection
