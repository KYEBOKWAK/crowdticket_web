<script type="text/javascript">
    //jQuery(document).ready(function ($) {
    $(document).ready(function(){
        var options = { $AutoPlay: 1,
                        $SlideDuration: 1300,
                        $Idle: 5000,
                          $ArrowNavigatorOptions: {
                              $Class: $JssorArrowNavigator$
                          },
                          $BulletNavigatorOptions: {
                            $Class: $JssorBulletNavigator$
                          }
                      };
        var jssor_1_slider = new $JssorSlider$("jssor_1", options);
        //make sure to clear margin of the slider container element
        jssor_1_slider.$Elmt.style.margin = "";

        /*#region responsive code begin*/

        /*
            parameters to scale jssor slider to fill a container

            MAX_WIDTH
                prevent slider from scaling too wide
            MAX_HEIGHT
                prevent slider from scaling too high, default value is original height
            MAX_BLEEDING
                prevent slider from bleeding outside too much, default value is 1
                0: contain mode, allow up to 0% to bleed outside, the slider will be all inside container
                1: cover mode, allow up to 100% to bleed outside, the slider will cover full area of container
                0.1: flex mode, allow up to 10% to bleed outside, this is better way to make full window slider, especially for mobile devices
        */

            var MAX_WIDTH = 10000;
            //var MAX_HEIGHT = 500;
            var MAX_HEIGHT = 500;
            //var MAX_BLEEDING = 0.5;
            var MAX_BLEEDING = 0.5;

            function ScaleSlider() {
                //var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {
                  var originalWidth = jssor_1_slider.$OriginalWidth();
                  var originalHeight = jssor_1_slider.$OriginalHeight();

                  var containerHeight = containerElement.clientHeight || originalHeight;

                  var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
                  var expectedHeight = Math.min(MAX_HEIGHT || containerHeight, containerHeight);

                  //constrain bullets, arrows inside slider area, it's optional, remove it if not necessary
                  if (MAX_BLEEDING >= 0 && MAX_BLEEDING < 1) {
                      var widthRatio = expectedWidth / originalWidth;
                      var heightRatio = expectedHeight / originalHeight;
                      var maxScaleRatio = Math.max(widthRatio, heightRatio);
                      var minScaleRatio = Math.min(widthRatio, heightRatio);

                      maxScaleRatio = Math.min(maxScaleRatio / minScaleRatio, 1 / (1 - MAX_BLEEDING)) * minScaleRatio;
                      expectedWidth = Math.min(expectedWidth, originalWidth * maxScaleRatio);
                      expectedHeight = Math.min(expectedHeight, originalHeight * maxScaleRatio);
                  }

                  //scale the slider to expected size
                  jssor_1_slider.$ScaleSize(expectedWidth, expectedHeight, MAX_BLEEDING);

                  //position slider at center in vertical orientation
                  //jssor_1_slider.$Elmt.style.top = ((containerHeight - expectedHeight) / 2) + "px";

                  //position slider at center in horizontal orientation
                  //jssor_1_slider.$Elmt.style.left = ((containerWidth - expectedWidth) / 2) + "px";
                }
                else {
                  window.setTimeout(ScaleSlider, 30);
                }
            }

            function OnOrientationChange() {
                ScaleSlider();
                window.setTimeout(ScaleSlider, 800);
            }

            ScaleSlider();

            //$(window).bind("load", ScaleSlider);
            //$(window).bind("resize", ScaleSlider);
            //$(window).bind("orientationchange", OnOrientationChange);

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", OnOrientationChange);

            /*#endregion responsive code end*/
    });
</script>
<style>
        /* jssor slider loading skin spin css */
        .jssorl-009-spin img {
            animation-name: jssorl-009-spin;
            animation-duration: 1.6s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes jssorl-009-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .jssorb052 .i {position:absolute;cursor:pointer;}
        .jssorb052 .i .b {fill:#fff;fill-opacity:0.3;}
        .jssorb052 .i:hover .b {fill-opacity:.7;}
        .jssorb052 .iav .b {fill-opacity: 1;}
        .jssorb052 .i.idn {opacity:.3;}

        .jssora053 {display:block;position:absolute;cursor:pointer;}
        .jssora053 .a {fill:none;stroke:#fff;stroke-width:640;stroke-miterlimit:10;}
        .jssora053:hover {opacity:.8;}
        .jssora053.jssora053dn {opacity:.5;}
        .jssora053.jssora053ds {opacity:.3;pointer-events:none;}
    </style>


    <div id="jssor_1" style="position:relative;top:0px;left:0px;width:1980px;height:600px;overflow:hidden;visibility:hidden;">
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1980px;height:600px;overflow:hidden;">
        @foreach($main_carousels as $main_carousel)
          <div>
            @if($main_carousel->link)
            <a href="{{ $main_carousel->link }}">
            @endif
              <img data-u="image" src="{{ $main_carousel->url }}">
              <div class="carousel-container welcome_main_carousel_content_container">
                  <div class="carousel-caption welcome_main_carousel_content_caption">
                    @if($main_carousel->type)
                      <h5>{{ $main_carousel->type }}</h5>
                    @endif
                    @if($main_carousel->title)
                      <h2>{{ $main_carousel->title }}</h2>
                    @endif
                    @if($main_carousel->subtitle)
                      <h4>{{ $main_carousel->subtitle }}</h4>
                    @endif
                  </div>
              </div>
            @if($main_carousel->link)
            </a>
            @endif
          </div>
          @endforeach
    </div>
    <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb052" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:16px;height:16px;">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                </svg>
            </div>
        </div>
    <!-- Arrow Navigator -->
        <div data-u="arrowleft" class="jssora053" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
            </svg>
        </div>
        <div data-u="arrowright" class="jssora053" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
            </svg>
        </div>
</div>
