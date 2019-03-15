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
        <div class="magazine_thumb_content_content">
          {{$magazine->subtitle}}
        </div>
      </div>
    </div>
  </a>
</div>
