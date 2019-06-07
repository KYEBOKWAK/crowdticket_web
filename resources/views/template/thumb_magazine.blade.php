@if($index % 2 === 0 )
<div class="welcome_thumb_container thumb_container_right_is_mobile">
@else
<div class="welcome_thumb_container">
@endif
<a href="{{ $magazine->getMagazineLinkURL() }}">
    <div class="welcome_thumb_img_wrapper">
        <div class="welcome_thumb_img_resize">
            <img src="{{ $magazine->thumb_img_url }}" onload="imageResize_new($('.welcome_thumb_img_resize')[0], this);" class="project-img"/>
        </div>
    </div>
    <div class="welcome_thumb_content_container">
        <h5 class="text-ellipsize welcome_thumb_content_disc">
            {{$magazine->subtitle}}
        </h5>

        <h4 class="text-ellipsize-2 welcome_thumb_content_title">
            {{$magazine->title}}
        </h4>
    </div>
</a>
</div>
