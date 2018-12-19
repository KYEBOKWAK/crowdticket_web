<?php
$startItemIndex = 0;
$maxItemCountInLine = 4;  //한줄에 표시될 아이템 개수
$mobileOneLineItemCount = 2;  //모바일일때 한 라인에 보여질 아이템 개수
$maxItemCount = count($projects);

if(isset($colOnly))
{
  $maxItemCountInLine = 1;
  $mobileOneLineItemCount = 1;
}
//$maxItemCount = 15;
?>
<!-- Swiper -->
@if($maxItemCount)
<div class="project_form_poster_origin_size_ratio @if (isset($colOnly)) project_form_poster_origin_size_ratio_colOnly @endif">
  <div class="thumbnail-wrappper">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        @for($i = 0 ; $i < $maxItemCount ; $i++)
          @if ($i % $maxItemCountInLine === 0)
            <div class="swiper-slide">
              @for($k = $i ; $k < $i+$maxItemCountInLine ; $k++)
              <!-- 4번을 돌면서 2번째 라인에  걸렸을 경우에만 아이템을 넣어준다-->
                @if ($k % $mobileOneLineItemCount === 0)
                <div class="flex_layer" style="margin-left: auto; margin-right: auto; width: 100%;">
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

                    <div class="project_carousel_container @if (isset($colOnly)) project_carousel_container_colOnly @endif @if(!$project) project_carousel_container_temp @endif">
                      <div class="project-grid-wrapper @if(!$project) project-grid-wrapper_temp @endif">
                        @if($project)
                          <div class="project_thumbnail_image_wrapper">
                            @if (isset($colOnly))
                              <div class="bg-base project-thumbnail">
                                <img src="{{ $project->getPosterUrl() }}" onload="imageResize($('.project-thumbnail')[0], this);" class="project-img" img-data-name="welcomeThumbData"/>
                                  <div class="white-mask"></div>
                              </div>
                            @else
                              <a href="{{ url('/projects') }}/{{ $project->id }}">
                                  <div class="bg-base project-thumbnail">
                                    <img src="{{ $project->getPosterUrl() }}" onload="imageResize($('.project-thumbnail')[0], this);" class="project-img" img-data-name="welcomeThumbData"/>
                                      <div class="white-mask"></div>
                                  </div>
                              </a>
                            @endif
                          </div>
                          <div class="project_thumbnail_content_wrapper">
                            <div class="project-category">
                                <h5 style="margin-top: 0px; margin-bottom: 0px;">
                                  @if ($project->project_type === 'creator')
                                    <span class="project-category-c">creator</span>
                                  @elseif($project->project_type === 'artist')
                                    <span class="project-category-a">artist</span>
                                  @elseif($project->project_type === 'culture')
                                    <span class="project-category-culture">culture</span>
                                  @else
                                    <span class="project-category-a">artist</span>
                                  @endif

                                  <span class="ct-percent">
                                  @if($project->isEventTypeCrawlingEvent())
                                    진행중
                                  @else
                                    @if($project->isFundingType())
                                      @if($project->isReady())
                                      @elseif($project->isFinished())
                                        {{ $project->getProgress() }}% 펀딩종료
                                      @else
                                        {{ $project->getProgress() }}% 펀딩중
                                      @endif
                                    @else
                                        @if($project->isEventTypeInvitationEvent())
                                          초대권 이벤트중
                                        @elseif($project->isReady())
                                        @elseif($project->isFinished())
                                          판매종료
                                        @else
                                          판매중
                                        @endif
                                    @endif
                                  @endif
                                  </span>
                                </h5>
                            </div>

                            <div style="text-align: left;">
                              <div class="project_thumb_title_wrapper_wrapper">
                                <div class="project_thumb_title_wrapper">
                                  <h4 class="text-ellipsize project-title">
                                    @if (isset($colOnly))
                                      {{ $project->title }}
                                    @else
                                      <a href="{{ url('/projects') }}/{{ $project->id }}">
                                        {{ $project->title }}
                                      </a>
                                    @endif
                                  </h4>
                                </div>
                              </div>
                                <h6 class="text-ellipsize-2 project-description">{{ $project->description }}</h6>
                            </div>

                            <div class="project-info">
                                <h6><span class="project_carousel_date">{{ $project->getConcertDateFormatted() }}</span><span class="project_carousel_conerthall">{{ $project->concert_hall }}</span></h6>
                            </div>
                          </div>
                        @endif
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
