<?php
$i = 0;
?>

@foreach ($projects as $project)
    @if ($i % 4 === 0)
        <div class="item @if ($i === 0) active @endif">
            <div class="row @if (isset($colOnly)) carousel_resize_width @endif">
    @endif
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 project-grid @if (isset($colOnly)) carousel_resize_container @endif">
                    <div class="project-grid-wrapper">
                        <div>
                          @if (isset($colOnly))
                            <div class="bg-base project-thumbnail">
                              <img src="{{ $project->getPosterUrl() }}" class="project-img">
                                <div class="white-mask"></div>
                            </div>
                          @else
                            <a href="{{ url('/projects') }}/{{ $project->id }}">
                                <div class="bg-base project-thumbnail">
                                  <img src="{{ $project->getPosterUrl() }}" class="project-img">
                                    <div class="white-mask"></div>
                                </div>
                            </a>
                          @endif
                        </div>
                        <div class="project-category">
                            <h5>
                              @if ($project->project_type === 'creator')
                                <span class="project-category-c">creator</span>
                              @else
                                <span class="project-category-a">artist</span>
                              @endif

                              <span class="ct-percent">
                              @if($project->isFundingType())
                                @if($project->isReady())
                                @elseif($project->isFinished())
                                  {{ $project->getProgress() }}% 펀딩종료
                                @else
                                  {{ $project->getProgress() }}% 펀딩중
                                @endif
                              @else
                                  @if($project->isReady())
                                  @elseif($project->isFinished())
                                    판매종료
                                  @else
                                    판매중
                                  @endif
                              @endif
                              </span>
                            </h5>
                        </div>

                        <div>
                            <h4 class="text-ellipsize project-title"><a href="{{ url('/projects') }}/{{ $project->id }}">{{ $project->title }}</a></h4>
                            <h6 class="text-ellipsize-2 project-description">{{ $project->description }}</h6>
                        </div>

                        <div class="project-info">
                            <h6><span class="project_carousel_date">{{ $project->getConcertDateFormatted() }}</span><span class="project_carousel_conerthall">{{ $project->concert_hall }}</span></h6>
                        </div>

                        @if ($project->type === 'funding')

                        @else

                        @endif
                    </div>
                </div>

            @if (($i % 4 === 3) || ($i === count($projects) - 1))
            </div>
        </div>
    @endif

    <?php
    $i++;
    ?>
@endforeach
