<div id="title_img_preview_{{ $img_num }}" class="project-form-poster-img-wrapper" style="background-image: url('{{ $project->getDefaultImgUrl() }}');"
     class="bg-base">
    <div class="middle">
        <a href="#" id="title_img_file_fake_{{ $img_num }}" data-img-number="{{ $img_num }}" class="btn btn-primary">찾아보기</a>
    </div>
    <input id="title_img_file_{{ $img_num }}" type="file" data-img-number="{{ $img_num }}" name="title_img_file_{{ $img_num }}" style="height: 0; visibility: hidden"/>
    <button id="delete-poster-title-img{{ $img_num }}" type="button" data-poster-id="" data-img-number="{{ $img_num }}" class="btn btn-primary delete-poster-title-img">삭제</button>
</div>
