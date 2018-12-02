<div class="flex_layer">
  <div class="project_form_poster_img_bg">
    <div class="project_form_poster_origin_size_ratio">
      <div class="project_form_poster_origin_size">
        @if($img_num == 1)
          <p style="position: absolute; color: #aaaaaa; margin-left: 5px; margin-top: 2px;">대표이미지(미리보기)</p>
        @else
          <p style="position: absolute; color: #aaaaaa; margin-left: 5px; margin-top: 2px;">{{ $img_num }}번 이미지</p>
        @endif

        <img id="title_img_preview_{{ $img_num }}" class="title_img_preview" style="display:none;">

        <a href="javascript:void(0);" id="title_img_file_fake_{{ $img_num }}" data-poster-id="{{ $project->posters()->firstOrFail()->id }}" data-img-number="{{ $img_num }}" class="title_img_file_fake">
          <div class="title_img_add_btn_wrapper">
            <img src="https://img.icons8.com/windows/40/EF4D5D/plus-2-math.png">
          </div>
        </a>

        <input id="title_img_file_{{ $img_num }}" class="title_img_file" type="file" name="title_img_file_{{ $img_num }}" data-poster-id="{{ $project->posters()->firstOrFail()->id }}" data-img-number="{{ $img_num }}" style="height: 0; visibility: hidden"/>
      </div>
    </div>
  </div>

  <div class="project_form_poster_trash_container">
    <a href="javascript:void(0);" id="title_img_file_sub_{{ $img_num }}" data-img-number="{{ $img_num }}" data-poster-id="{{ $project->posters()->firstOrFail()->id }}" class="project_form_poster_trash" style="display: none;"><img style="width:27px; height:27px;" src="https://img.icons8.com/windows/50/EF4D5D/trash.png"></a>
  </div>
</div>
