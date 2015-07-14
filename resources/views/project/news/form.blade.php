@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/editor.css') }}"/>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10">
			<h3>업데이트 작성</h3>
			<div class="form-horizontal">
				<div class="form-group">
					<label for="title" class="col-sm-2 control-label">제목</label>
					<div class="col-sm-8">
						@if ($news)
							<input id="title" type="text" name="title" class="form-control" value="{{ $news->title }}" />
						@else
							<input id="title" type="text" name="title" class="form-control" />
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">내용</label>
					<div class="col-sm-10">
						<input type="hidden" id="tx_image_params" value="url={{ url() }}/projects/{{ $project->id }}/news/images&csrf_token={{ csrf_token() }}" />
						@if ($news)
							<textarea id="tx_load_content" style="display: none">{{ $news->content }}</textarea>
						@endif
						@include('editor')
					</div>
				</div>
				@if ($news)
					<button id="update_news" class="btn btn-success pull-right">수정하기</button>
					<input type="hidden" id="method" value="put" />
				@else
					<button id="update_news" class="btn btn-success pull-right">만들기</button>
					<input type="hidden" id="method" value="post" />
				@endif
				<input type="hidden" id="ajax_url" value="{{ $ajax_url }}" />
				<input type="hidden" id="project_id" value="{{ $project->id }}" />
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
	<script src="{{ asset('/js/project/news/form.js') }}"></script>
@endsection
