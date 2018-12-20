<div class="swiper-container">
  <div class="swiper-wrapper">
      @if($project->poster_url)
        <div class="swiper-slide">
          <div class="carousel_detail_main_title_img_wrapper">
            <div class="carousel_detail_main_title_img_origin_ratio_size">
              <div class="carousel_detail_main_title_img_origin_size">
                <img class="carousel_detail_main_title_img" onload="imageResize($('.carousel_detail_main_title_img_wrapper')[0], this);" data-u="image" src="{{ $project->poster_url }}"/>
              </div>
            </div>
          </div>
        </div>
      @else
        @for($i = 0 ; $i < 4 ; $i++)
          <?php
            $imgNum = $i+1;
            $imgName = 'title_img_file_'.$imgNum;
          ?>
          @if($posters[$imgName]['isFile'])
            <div class="swiper-slide">
              <div class="carousel_detail_main_title_img_wrapper">
                <div class="carousel_detail_main_title_img_origin_ratio_size">
                  <div class="carousel_detail_main_title_img_origin_size">
                    <img class="carousel_detail_main_title_img" onload="imageResize($('.carousel_detail_main_title_img_wrapper')[0], this);" data-u="image" src="{{ $posters[$imgName]['img_url'] }}">
                  </div>
                </div>
              </div>
            </div>
          @endif
        @endfor
      @endif
  </div>

  <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>
