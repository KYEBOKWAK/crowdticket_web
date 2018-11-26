<div class="project_form_poster_img_bg">
  <img id="title_img_preview_{{ $img_num }}" class="title_img_preview" style="display:none;">
  <a href="javascript:void(0);" id="title_img_file_fake_{{ $img_num }}" data-poster-id="{{ $project->posters()->firstOrFail()->id }}" data-img-number="{{ $img_num }}" class="title_img_file_fake"><img style="margin-top: 82px;" src="https://img.icons8.com/windows/40/EF4D5D/plus-2-math.png"></a>
  <input id="title_img_file_{{ $img_num }}" class="title_img_file" type="file" name="title_img_file_{{ $img_num }}" data-poster-id="{{ $project->posters()->firstOrFail()->id }}" data-img-number="{{ $img_num }}" style="height: 0; visibility: hidden"/>
</div>

<div class="project_form_poster_trash_container">
  <a href="javascript:void(0);" id="title_img_file_sub_{{ $img_num }}" data-img-number="{{ $img_num }}" data-poster-id="{{ $project->posters()->firstOrFail()->id }}" class="project_form_poster_trash" style="display: none;"><img style="width:27px; height:27px;" src="https://img.icons8.com/windows/50/EF4D5D/trash.png"></a>
</div>
