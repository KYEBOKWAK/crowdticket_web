@if($index % 2 === 0 )
<div class="welcome_thumb_container thumb_container_right_is_mobile">
@else
<div class="welcome_thumb_container">
@endif
<?php
 $link_url = $item->store->alias;
 if($item->store->alias === null){
  $link_url = $item->store->id;
 }

 $link_url = url().'/store'.'/'.$link_url
 
?>
<a href="{{ $link_url }}">
    <div class="welcome_thumb_img_wrapper" style="border-radius: 24px 24px 0 24px;">
        <div class="welcome_thumb_img_resize" style="border-radius: 0px;">
            <img src="{{ $item->thumb_img_url }}" onload="imageResize_new($('.welcome_thumb_img_resize')[0], this);" class="project-img project-img-border-radius-zero" style="border-radius: 0px;"/>
        </div>
    </div>
    <div class="welcome_thumb_content_container">
        <h5 class="text-ellipsize welcome_thumb_content_disc">
            {{$item->first_text}}
        </h5>

        <h4 class="text-ellipsize-2 welcome_thumb_content_title">
            {{$item->second_text}}
        </h4>

        <!-- <p class="welcome_thumb_content_date_place">
          <span style="color:#00bfff;font-weight: bold;font-size: 16px;">
           {{number_format($item->item->price)}}원 
          </span>
        </p> -->
    </div>
</a>
</div>
