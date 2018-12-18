<script type="text/javascript">
    //jQuery(document).ready(function ($) {
    $(document).ready(function(){

        var options = { $AutoPlay: 1,
                          $ArrowNavigatorOptions: {
                              $Class: $JssorArrowNavigator$
                          },
                          $BulletNavigatorOptions: {
                            $Class: $JssorBulletNavigator$
                          }
                      };
        var jssor_2_slider = new $JssorSlider$("jssor_1", options);

        //var MAX_WIDTH = 584;
        var MAX_WIDTH = 755;

        function ScaleSlider() {
            var containerElement = jssor_2_slider.$Elmt.parentNode;
            var containerWidth = containerElement.clientWidth;

            if (containerWidth) {
                var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
                jssor_2_slider.$ScaleWidth(expectedWidth);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }
        }

        ScaleSlider();

        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);


/*
        var options = { $AutoPlay: 1,
                          $ArrowNavigatorOptions: {
                              $Class: $JssorArrowNavigator$
                          },
                          $BulletNavigatorOptions: {
                            $Class: $JssorBulletNavigator$
                          }
                      };
        var jssor_2_slider = new $JssorSlider$("jssor_1", options);
        //make sure to clear margin of the slider container element
        jssor_2_slider.$Elmt.style.margin = "";

            var MAX_WIDTH = 584;
            //var MAX_HEIGHT = 500;
            var MAX_HEIGHT = 437;
            //var MAX_BLEEDING = 0.5;
            var MAX_BLEEDING = 0.5;

            function ScaleSlider() {
                //var containerElement = jssor_2_slider.$Elmt.parentNode;
                var containerElement = jssor_2_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if($(".detail_main_container_grid").css('display') == 'block')
                {
                  MAX_WIDTH = 650;
                  MAX_HEIGHT = 500;
                  MAX_BLEEDING = 0.5;
                }
                else
                {
                  MAX_WIDTH = 584;
                  MAX_HEIGHT = 437;
                  MAX_BLEEDING = 0.5;
                }

                if (containerWidth) {
                  var originalWidth = jssor_2_slider.$OriginalWidth();
                  var originalHeight = jssor_2_slider.$OriginalHeight();

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

                  //console.error("expectedWidth : " + expectedWidth + " / " + "expectedHeight" +expectedHeight);
                  //scale the slider to expected size
                  jssor_2_slider.$ScaleSize(expectedWidth, expectedHeight, MAX_BLEEDING);

                  //position slider at center in vertical orientation
                  //jssor_2_slider.$Elmt.style.top = ((containerHeight - expectedHeight) / 2) + "px";

                  //position slider at center in horizontal orientation
                  //jssor_2_slider.$Elmt.style.left = ((containerWidth - expectedWidth) / 2) + "px";
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
*/
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

        .carousel_detail_main_title_img_wrapper{

        }

        .carousel_detail_main_title_img{
          
        }
    </style>
<div style="width:100%;">
<div id="jssor_1" class="detail_carousel_wrapper detail_carousel_size" style="position:relative;top:0px;left:0px;overflow:hidden;visibility:hidden;">
    <div data-u="slides" class="detail_carousel_size" style="cursor:default;position:relative;top:0px;left:0px;overflow:hidden;">
      @if($project->poster_url)
        <div class="carousel_detail_main_title_img_wrapper">
          <img class="carousel_detail_main_title_img" data-u="image" src="{{ $project->poster_url }}"/>
        </div>
      @else
        @for($i = 0 ; $i < 4 ; $i++)
          <?php
            $imgNum = $i+1;
            $imgName = 'title_img_file_'.$imgNum;
          ?>
          @if($posters[$imgName]['isFile'])
            <div>
                <img data-u="image" src="{{ $posters[$imgName]['img_url'] }}">
            </div>
          @endif
        @endfor
      @endif
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
</div>
