<div class="magazine_thumbnail_container">
  <a href="{{ $magazine->getMagazineLinkURL() }}">
    <div class="flex_layer">
      <div class="magazine_thumbnail_image_wrapper">
        <div class="bg-base magazine-thumbnail">
          <img src="{{ $magazine->getThumbImgURL() }}" onload="imageFullResize($('.magazine-thumbnail')[0], this);" class="magazine-img"/>
        </div>
      </div>

      <div class="magazine_thumb_content_container">
        <div class="magazine_thumb_content_title">
          {{$magazine->title}}
        </div>
        <div class="magazine_thumb_date">
          <?php
            $updateDate = date('Y.m.d', strtotime($magazine->updated_at));
          ?>
          | {{$updateDate}}
        </div>

        <input type="hidden" id="ticket_notice" class="magazine_subtitle_data" data-magazine-id="{{$magazine->id}}" value="{{ $magazine->subtitle }}"/>
        <div class="magazine_thumb_content_content magazine_thumb_content_content_{{$magazine->id}}">
        </div>
      </div>
    </div>
  </a>
</div>
