@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-lite.css?version=1') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-crowdticket.css?version=3') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/project/form_body_required.css?version=12') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/project/form.css?version=8') }}"/>
    <style>
        .container h2 {
            font-weight: bold;
            margin-top: 40px;
            margin-bottom: 30px;
        }

        .project-form-content-container{
          background-color: white;
        }
    </style>
@endsection

@section('content')

<div class="project-form-content-container">
  <div class="form-body-default-container">
    <div class="project_form_title_wrapper">
      <h2 class="project_form_title"><span class="pointColor">업데이트</span> 작성</h2>
    </div>

    <div class="project_form_input_container">
      <div class="flex_layer_project">
        <p class="project-form-content-title">업데이트 제목</p>
        <div class="project-form-content">
          <div class="flex_layer">
            @if ($news)
                <input id="title" type="text" name="title" class="project_form_input_base"
                       value="{{ $news->title }}"/>
            @else
                <input id="title" type="text" name="title" class="project_form_input_base"/>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="project_form_content_container" style="margin-top: 30px;">
      <form id="editor_image_set_form" action="{{ url('/projects') }}/{{ $project->id }}/news/images" method="post" data-toggle="validator" role="form" enctype="multipart/form-data">
        <input id="editor_image" type="hidden" name="image"/>
        <input id="editor_image_name" type="hidden" name="image_name"/>
        @include('csrf_field')
      </form>
      <div id="story_form" class="col-md-12">
          <div class="form-group">
            @if ($news)
                <textarea id="tx_load_content" style="display: none">{{ $news->content }}</textarea>
            @endif
              @include('editor_summernote')
          </div>
          <div class="project_form_button_wrapper">
              @if ($news)
                  <button id="update_news" class="btn btn-success">수정하기</button>
                  <input type="hidden" id="method" value="put"/>
                  <a href="#" id="delete_news" class="btn btn-danger" style="margin-left: 10px;">삭제하기</a>
              @else
                  <button id="update_news" class="btn btn-success center-block">작성하기</button>
                  <input type="hidden" id="method" value="post"/>
              @endif

          </div>
          <input type="hidden" id="ajax_url" value="{{ $ajax_url }}"/>
          <input type="hidden" id="project_id" value="{{ $project->id }}"/>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js')
    <script src="{{ asset('/js/editor/summernote-lite.js?version=5') }}"></script>
    <script src="{{ asset('/js/project/news/form.js?version=24') }}"></script>
    <script src="{{ asset('/js/editor/summernote-lite-crowdticket.js?version=8') }}"></script>
@endsection
