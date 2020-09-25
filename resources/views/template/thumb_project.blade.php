@if($index % 2 === 0 )
<div class="welcome_thumb_container thumb_container_right_is_mobile">
@else
<div class="welcome_thumb_container">
@endif
<a href="{{ $project->getProjectURLWithIdOrAlias() }}">
    <div class="welcome_thumb_img_wrapper">
        <img src="{{ $project->getPosterUrl() }}" class='project-img-bg-blur'/>
        <div class="welcome_thumb_img_resize">
            <img src="{{ $project->getPosterUrl() }}" onload="imageResize_new($('.welcome_thumb_img_resize')[0], this);" class="project-img"/>
        </div>
    </div>
    <div class="welcome_thumb_content_container">
        <h5 class="text-ellipsize welcome_thumb_content_disc">
            {{$project->description}}
        </h5>

        <h4 class="text-ellipsize-2 welcome_thumb_content_title">
            {{$project->title}}
        </h4>

        <p class="welcome_thumb_content_date_place">
            {{$project->getTicketDateFormattedSlash()}} · @if($project->thumb_place === "온라인 이벤트")<span style="color:#43c9f0;font-weight: bold;">{{$project->thumb_place}}</span>@else{{$project->thumb_place}}@endif
        </p>

        <div class="welcome_thumb_content_type_wrapper isMobileDisable" style="@if($project->project_type === 'artist')width:54px;@endif">
            <p class="welcome_thumb_content_type">
                {{$project->project_type}}
            </p>
        </div>
    </div>
</a>
</div>
