<?php
$startItemIndex = 0;
$maxItemCountInLine = 4;  //한줄에 표시될 아이템 개수
$mobileOneLineItemCount = 2;  //모바일일때 한 라인에 보여질 아이템 개수
$maxItemCount = count($projects);
//$maxItemCount = 15;
?>
<!-- Swiper -->
@if($maxItemCount)
<div class="project_form_poster_origin_size_ratio project_form_poster_origin_size_ratio_pick">
  <div class="thumbnail-wrappper thumbnail-wrappper_pick">
    <div class="">
      <div class="">
        @for($i = 0 ; $i < $maxItemCount ; $i++)
          @if ($i % $maxItemCountInLine === 0)
            <div class="">
              @for($k = $i ; $k < $i+$maxItemCountInLine ; $k++)
              <!-- 4번을 돌면서 2번째 라인에  걸렸을 경우에만 아이템을 넣어준다-->
                @if ($k % $mobileOneLineItemCount === 0)
                <div class="flex_layer_most_mobile_main" style="margin-left: auto; margin-right: auto; width: 100%;">
                  <?php
                  for($j = $k ; $j < $k+$mobileOneLineItemCount ; $j++){

                    $projectArrayIndex = $j;

                    $project = '';
                    if($j > count($projects) - 1)
                    {
                      //$projectArrayIndex = count($projects) - 1;
                      //break;
                      $project = '';
                    }
                    else
                    {
                      $project = $projects[$projectArrayIndex];
                    }

                    //$project = $projects[$projectArrayIndex];
                    ?>

                    <div class="project_carousel_container project_carousel_container_pick @if(!$project) project_carousel_container_temp @endif">
                      <div class="project-grid-wrapper project-grid-wrapper_pick @if(!$project) project-grid-wrapper_temp @endif">
                        <div class="flex_layer">
                          @if($project)
                            <div class="project_thumbnail_image_wrapper project_thumbnail_image_wrapper_pick">
                              <a href="{{ url('/projects') }}/{{ $project->id }}">
                                  <div class="bg-base project-thumbnail">
                                    <img src="{{ $project->getPosterUrl() }}" onload="imageResize($('.project-thumbnail')[0], this);" class="project-img" img-data-name="welcomeThumbData"/>
                                      <div class="white-mask"></div>
                                  </div>
                              </a>
                            </div>
                            <div class="project_thumbnail_content_wrapper project_thumbnail_content_wrapper_pick">
                              <a href="{{ url('/projects') }}/{{ $project->id }}">
                                <div style="text-align: left;">
                                  <div class="project_thumb_title_wrapper_wrapper">
                                    <div class="project_thumb_title_wrapper">
                                      <h4 class="text-ellipsize project-title project-title_pick">{{ $project->title }}</h4>
                                    </div>
                                  </div>
                                    <h6 class="text-ellipsize-2 project-description">{{ $project->description }}</h6>
                                </div>

                                <div class="project-category project-category_pick">
                                    <h5 style="margin-top: 0px; margin-bottom: 0px;">
                                      <div class="flex_layer">
                                        @if ($project->project_type === 'creator')
                                          <span class="project-category-c">creator</span>
                                        @elseif($project->project_type === 'artist')
                                          <span class="project-category-a">artist</span>
                                        @elseif($project->project_type === 'culture')
                                          <span class="project-category-culture">culture</span>
                                        @else
                                          <span class="project-category-a">artist</span>
                                        @endif

                                        <span class="text-ellipsize-2 main_thumb_hash_wrapper">
                                          @if($project->hash_tag1)
                                            #{{ $project->hash_tag1 }}
                                          @endif
                                          @if($project->hash_tag2)
                                            #{{ $project->hash_tag2 }}
                                          @endif
                                        </span>
                                      </div>
                                    </h5>
                                </div>
                              </a>
                            </div>
                          @endif
                        </div>
                      </div>
                    </div>
                  <?php
                    } //for문 닫기
                  ?>
                </div>
                @endif
              @endfor
            </div>
          @endif
        @endfor
      </div>
    </div>
  </div>
</div>
@endif
