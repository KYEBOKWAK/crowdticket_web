@extends('app')

@section('css')
    <style>
    .magazine_title_wrapper{
      width: 100%;
      margin-bottom: 20px;
      position: relative;
    }

    .magazine_title{
      position: absolute;
      top: 80%;
      left: 20%;

      font-size: 18px;
      font-weight: bold;
      color: white;

    }

    .magazine_title_img{
      width:100%;
      max-height: 300px;
    }

    .magazine_container{
      width: 620px;
      margin-left: auto;
      margin-right: auto;
    }
    .magazine_thumbnail_container{
      /*width: 90%;*/
      width: 100%;
      margin-left: auto;
      margin-right: auto;
      margin-bottom: 20px;
    }
    .magazine_thumbnail_image_wrapper{
      /*width: 100%;*/
      width: 320px;
    }
    .magazine-thumbnail {
      position:relative;
      /*padding-top:75%;*/
      padding-top:40%;
      overflow:hidden;
      background-color: white;
    }

    .magazine-img {
      position:absolute;
      top:0;
      left:0;
      right:0;
      bottom:0;
      max-width:100%;
      margin: auto;
    }

    .magazine_thumb_content_container{
      width: 310px;
      padding: 0px 10px;
      word-break: break-all;
    }

    .magazine_thumb_content_title{
      font-weight: bold;
      font-size: 19px;

      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      line-height: 27px;     /* fallback */
      max-height: 51px;      /* fallback */
      -webkit-line-clamp: 2; /* number of lines to show */
      -webkit-box-orient: vertical;
      margin-top: 5px;
    }

    .magazine_thumb_content_content{
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      line-height: 18px;     /* fallback */
      max-height: 40px;      /* fallback */
      -webkit-line-clamp: 2; /* number of lines to show */
      -webkit-box-orient: vertical;
      margin-top: 30px;
    }

    .magazine_story_wrapper{

    }

    .magazine_story_wrapper{
      width: 100%;
      margin-left: auto;
      margin-right: auto;
    }

    .magazine_content_title{
      /*text-align: right;*/
      flex-basis: 200px;
      flex-shrink: 0;

      font-size: 18px;
      font-weight: bold;
      font-style: normal;
      font-stretch: normal;
      line-height: 2.78;
      letter-spacing: normal;
      color: black;
    }

    /*이미지 업로드 START*/
    #magazine_title_img_preview{
      /*max-width: 100%;*/
      /* 요게 매거진 타이틀 옵션*/
      /*
      position: absolute;
      top: 0px;
      left: 50%;
      transform:translateX(-50%);
      bottom: 0px;
      right: 0px;
      margin: auto;
      */

      max-width: 100%;
      position: absolute;
      top: 0px;
      left: 0px;
      bottom: 0px;
      right: 0px;
      margin: auto;

    }

    .magazine_title_img_preview_origin_size{
      position: absolute;
      width: 100%;
      height: 100%;
      overflow: hidden;
    }

    .magazine_title_img_preview_wrapper{
      display: none;
      width: 320px;
      /*height: 164px;*/
      position: relative;
      overflow: hidden;
    }

    .magazine_title_img_preview_ratio_wrapper{
      position: relative;
      width: 100%;
      padding-bottom: 56.25%;
    }
    /*이미지 업로드 END*/

    /*썸네일 이미지 업로드 START*/
    #magazine_thumb_img_preview{
      max-width: 100%;
      position: absolute;
      top: 0px;
      left: 0px;
      bottom: 0px;
      right: 0px;
      margin: auto;
    }

    .magazine_thumb_img_preview_origin_size{
      position: absolute;
      width: 100%;
      height: 100%;
      overflow: hidden;
    }

    .magazine_thumb_img_preview_wrapper{
      display: none;
      width: 320px;
      /*height: 164px;*/
      position: relative;
      overflow: hidden;
    }

    .magazine_thumb_img_preview_ratio_wrapper{
      position: relative;
      width: 100%;
      padding-bottom: 56.25%;
    }
    /*썸네일 이미지 업로드 END*/

    .magazine_form_container{
      margin: 0px 15px;
    }


    </style>
    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-lite.css?version=1') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/editor/summernote-crowdticket.css?version=3') }}"/>
@endsection

@section('content')

<div class="magazine_container">
  <div class="magazine_form_container">
    <form id="magazine_form" action="" method="post" role="form">
      @include('csrf_field')
      @if(isset($magazine))
        <input type="hidden" id="magazineId" name="magazineId" value="{{$magazine->id}}"/>
        <input id="magazine_title_img_url" type="hidden" value="{{$magazine->title_img_url}}"/>
        <input id="magazine_thumb_img_url" type="hidden" value="{{$magazine->thumb_img_url}}"/>
      @else
        <input type="hidden" id="magazineId" name="magazineId" value=""/>
      @endif

      <div class="project_form_input_container">
          <p class="magazine_content_title">제목</p>
          <div class="project-form-content">
            @if(isset($magazine))
              <input id="title" name="title" type="text" class="form_input_base" value="{{$magazine->title}}"/>
            @else
              <input id="title" name="title" type="text" class="form_input_base" value=""/>
            @endif
          </div>
      </div>

      <div class="project_form_input_container">
          <p class="magazine_content_title">Sub Title</p>
          <div class="project-form-content">
            @if(isset($magazine))
              <input id="subtitle" name="subtitle" type="text" class="form_input_base" value="{{ $magazine->subtitle }}"/>
            @else
              <input id="subtitle" name="subtitle" type="text" class="form_input_base" value=""/>
            @endif

          </div>
      </div>

      <div class="project_form_input_container">
          <p class="magazine_content_title">상단 이미지(없을경우 썸네일 이미지가 상단이미지가 됨)-Height : 300px 고정</p>
          <div class="project-form-content">
              <a href="javascript:void(0);" id="magazine_title_file_fake"><img style="margin-left: -5px;" src="https://img.icons8.com/windows/40/EF4D5D/plus-2-math.png"></a>
              <a href="javascript:void(0);" id="magazine_title_file_sub" style="display: none;"><img style="margin-left: -5px;" src="https://img.icons8.com/windows/40/EF4D5D/minus-2-math.png"></a>
              <div class="magazine_title_img_preview_wrapper">
                <div class="magazine_title_img_preview_ratio_wrapper">
                  <div class="magazine_title_img_preview_origin_size">
                    <img id="magazine_title_img_preview" onload="imageFullResize($('.magazine_title_img_preview_wrapper')[0], this);"/>
                  </div>
                </div>
              </div>
                <input id="magazine_title_img_file" type="file" name="magazine_title_img_file" style="height: 0; visibility: hidden"/>
                <input id="magazine_title_image_name" type="hidden" name="magazine_title_image_name"/>
          </div>
      </div>

      <div class="project_form_input_container">
          <p class="magazine_content_title">썸네일 이미지(16:9)</p>
          <div class="project-form-content">
              <a href="javascript:void(0);" id="magazine_thumb_file_fake"><img style="margin-left: -5px;" src="https://img.icons8.com/windows/40/EF4D5D/plus-2-math.png"></a>
              <a href="javascript:void(0);" id="magazine_thumb_file_sub" style="display: none;"><img style="margin-left: -5px;" src="https://img.icons8.com/windows/40/EF4D5D/minus-2-math.png"></a>
              <div class="magazine_thumb_img_preview_wrapper">
                <div class="magazine_thumb_img_preview_ratio_wrapper">
                  <div class="magazine_thumb_img_preview_origin_size">
                    <img id="magazine_thumb_img_preview" onload="imageFullResize($('.magazine_thumb_img_preview_wrapper')[0], this);"/>
                  </div>
                </div>
              </div>
                <input id="magazine_thumb_img_file" type="file" name="magazine_thumb_img_file" style="height: 0; visibility: hidden"/>
                <input id="magazine_thumb_image_name" type="hidden" name="magazine_thumb_image_name"/>
          </div>
      </div>
    </form>
  </div>

  <div class="magazine_story_wrapper" style="margin-top: 20px;">
    <form id="editor_image_set_form" action="{{ url() }}/magazine/story/images" method="post" data-toggle="validator" role="form" enctype="multipart/form-data">
      <input id="editor_image" type="hidden" name="image"/>
      <input id="editor_image_name" type="hidden" name="image_name"/>
      @include('csrf_field')
    </form>
    <div id="story_form" class="col-md-12">
        <div class="form-group">

            <textarea id="tx_load_content" style="display: none">
              @if(isset($magazine))
                {{ $magazine->story }}
              @endif
            </textarea>
            @include('editor_summernote')
        </div>
        <div class="project_form_button_wrapper">
          <div class="flex_layer">
            <button id="update_story" type="button" class="btn btn-success center-block project_form_button">
              @if(isset($magazine))
                수정
              @else
                저장
              @endif
            </button>
          </div>
        </div>
    </div>
  </div>
</div>


@endsection

@section('js')
  <script src="{{ asset('/js/editor/summernote-lite.js?version=4') }}"></script>
  <script src="{{ asset('/js/editor/summernote-lite-crowdticket.js?version=7') }}"></script>
<script>
$(document).ready(function () {

  var setMagazineImgPreview = function(url, filename){
    if(url)
    {
      $('#magazine_title_file_sub').show();

      //$('#goods_img_preview').show();
      $('.magazine_title_img_preview_wrapper').show();
      $('#magazine_title_img_preview').attr("src", url);
      $('#magazine_title_image_name').val(filename);
    }
    else
    {
      $('#magazine_title_file_sub').hide();

      $('.magazine_title_img_preview_wrapper').hide();
      $('#magazine_title_img_preview').attr("src", "");
      $('#magazine_title_image_name').val('');
    }
  };

  var setMagazineThumbImgPreview = function(url, filename){
    if(url)
    {
      $('#magazine_thumb_file_sub').show();

      //$('#goods_img_preview').show();
      $('.magazine_thumb_img_preview_wrapper').show();
      $('#magazine_thumb_img_preview').attr("src", url);
      $('#magazine_thumb_image_name').val(filename);
    }
    else
    {
      $('#magazine_thumb_file_sub').hide();

      $('.magazine_thumb_img_preview_wrapper').hide();
      $('#magazine_thumb_img_preview').attr("src", "");
      $('#magazine_thumb_image_name').val('');
    }
  };

  var onMagazineImgChanged = function() {
		if (this.files && this.files[0]) {
      var fileName = getRemoveExpWord(this.files[0].name);
			var reader = new FileReader();
			reader.onload = function(e) {
				setMagazineImgPreview(e.target.result, fileName);
			};
			reader.readAsDataURL(this.files[0]);
		}
	};

  var performMagazineFileClick = function() {
    $('#magazine_title_img_file').trigger('click');
  };

  var performMagazineThumbFileClick = function() {
    $('#magazine_thumb_img_file').trigger('click');
  };

  var onMagazineThumbImgChanged = function() {
    if (this.files && this.files[0]) {
      var fileName = getRemoveExpWord(this.files[0].name);
      var reader = new FileReader();
      reader.onload = function(e) {
        setMagazineThumbImgPreview(e.target.result, fileName);
      };
      reader.readAsDataURL(this.files[0]);
    }
  };

  var removePriviewLocalImg = function(){
    setMagazineImgPreview('', '');

    if ($.browser.msie)
    {
      // ie 일때 input[type=file] init.
      $("#magazine_title_img_file").replaceWith( $("#magazine_title_img_file").clone(true) );
    }
    else
    {
      // other browser 일때 input[type=file] init.
      $("#magazine_title_img_file").val("");
    }
  };

  var removePriviewLocalThumbImg = function(){
    setMagazineThumbImgPreview('', '');

    if ($.browser.msie)
    {
      // ie 일때 input[type=file] init.
      $("#magazine_thumb_img_file").replaceWith( $("#magazine_thumb_img_file").clone(true) );
    }
    else
    {
      // other browser 일때 input[type=file] init.
      $("#magazine_thumb_img_file").val("");
    }
  };

  var removePriviewServeImg = function(){
    showLoadingPopup('이미지 제거중..');

    var magazineId = $('#magazineId').val();
    var url = '/magazine/' + magazineId + '/deleteimg';
		var method = 'delete';

		var success = function(e) {
      stopLoadingPopup();
      //console.error(e);
      removePriviewLocalImg();
		};
		var error = function(e) {
      stopLoadingPopup();
			swal("이미지 삭제에 실패하였습니다.", "", "error");
		};

		$.ajax({
			'url': url,
			'method': method,
			'success': success,
			'error': error
		});
  };

  var removePriviewServeThumbImg = function(){
    showLoadingPopup('이미지 제거중..');

    var magazineId = $('#magazineId').val();
    var url = '/magazine/' + magazineId + '/deletethumbimg';
    var method = 'delete';

    var success = function(e) {
      stopLoadingPopup();
      //console.error(e);
      removePriviewLocalThumbImg();
    };
    var error = function(e) {
      stopLoadingPopup();
      swal("이미지 삭제에 실패하였습니다.", "", "error");
    };

    $.ajax({
      'url': url,
      'method': method,
      'success': success,
      'error': error
    });
  };

  $('#magazine_title_file_sub').click(function(){
    if($('#magazineId').val())
    {
      removePriviewServeImg();
    }
    else
    {
      removePriviewLocalImg();
    }
  });

  $('#magazine_thumb_file_sub').click(function(){
    if($('#magazineId').val())
    {
      removePriviewServeThumbImg();
    }
    else
    {
      removePriviewLocalThumbImg();
    }
  });

  var magazineAjaxOption = {
  'beforeSerialize': function($form, options) {
    //$goods_img_file = $('#goods_img_file');

  },
  'success': function(result) {
    stopLoadingPopup();
    swal("저장 성공!", "", "success");
  },
  'error': function(data) {
    stopLoadingPopup();
    alert("저장에 실패하였습니다.");
  }
};

  $('#magazine_title_file_fake').bind('click', performMagazineFileClick);
  $('#magazine_title_img_file').change(onMagazineImgChanged);

  $('#magazine_thumb_file_fake').bind('click', performMagazineThumbFileClick);
  $('#magazine_thumb_img_file').change(onMagazineThumbImgChanged);

  $('#magazine_form').ajaxForm(magazineAjaxOption);

  $('#update_story').bind('click', function(){
    showLoadingPopup('저장중입니다..');

    var markupStr = $('#summernote').summernote('code');
    var data =
    {
      'magazineId': $('#magazineId').val(),
      'story': markupStr,
    };

		var url = '/magazine/update/story';
		var method = 'post';

		var success = function(e) {
      //stopLoadingPopup();
      //console.error(e);
      if(e.state == 'success')
      {
        $('#magazineId').val(e.magazineId);

        var magazineId = $('#magazineId').val();

        $('#magazine_form').attr('action', "{{ url('magazine') }}" + '/' +magazineId + '/update');
        $('#magazine_form').submit();
      }
		};
		var error = function(e) {
      stopLoadingPopup();
			swal("저장에 실패하였습니다.", "", "error");
		};

		$.ajax({
			'url': url,
			'method': method,
			'data': data,
			'success': success,
			'error': error
		});
	});

  var init = function(){
    if($('#magazine_title_img_url'))
    {
       setMagazineImgPreview($('#magazine_title_img_url').val(), '');
    }

    if($('#magazine_thumb_img_url'))
    {
       setMagazineThumbImgPreview($('#magazine_thumb_img_url').val(), '');
    }

  };

  init();
});
</script>
@endsection
