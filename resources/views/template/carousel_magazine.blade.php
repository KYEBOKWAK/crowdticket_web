<div class="swiper-magazine-container">
  <h4 style="float:left">크라우드티켓 매거진</h4>
  <div class="swiper-wrapper">
    @foreach($magazines as $magazine)
      <div class="swiper-slide">
        @include('template.magazine_thumb', ['magazine' => $magazine])
      </div>
    @endforeach
  </div>
  <!-- Add Pagination -->

  <div class="swiper-magazine-pagination"></div>

  <!-- Add Arrows -->

</div>
