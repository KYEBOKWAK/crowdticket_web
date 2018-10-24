<?php
$i = 0;
?>

@foreach ($projects as $project)
    @if ($i % 4 === 0)
        <div class="item @if ($i === 0) active @endif">
            <div class="row">
    @endif
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 project-grid">
                    <div class="project-grid-wrapper">
                        <div>
                          <a href="{{ url('/projects') }}/{{ $project->id }}">
                              <div class="bg-base project-thumbnail">
                                <img src="{{ $project->getPosterUrl() }}" class="project-img">
                                  <div class="white-mask"></div>
                              </div>
                          </a>
                        </div>
                        <div class="project-category">
                            <h5>
                              @if ($project->project_type === 'creator')
                                <span class="project-category-c">creator</span>
                              @else
                                <span class="project-category-a">artist</span>
                              @endif

                              @if($project->isFundingType())
                                <span class="ct-percent">{{ $project->getProgress() }}%</span></h5>
                              @else
                                <!-- <span class="ct-percent">{{ $project->getNowAmount() }}</span></h5> -->
                                <span class="ct-percent">판매중</span></h5>
                              @endif
                        </div>

                        <div>
                            <h4 class="text-ellipsize project-title"><a href="{{ url('/projects') }}/{{ $project->id }}">{{ $project->title }}</a></h4>
                            <h6 class="text-ellipsize-2 project-description">{{ $project->description }}</h6>
                        </div>

                        <div class="project-info">
                            <h6>{{ $project->getConcertDateFormatted() }}<span style="float:right;">{{ $project->concert_hall }}</span></h6>
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
