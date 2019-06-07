@if($index % 2 === 0 )
<div class="welcome_thumb_container thumb_container_right_is_mobile">
@else
<div class="welcome_thumb_container">
@endif
<a href="{{ $project->getProjectURLWithIdOrAlias() }}">
    <div class="welcome_thumb_img_wrapper">
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
            {{$project->getTicketDateFormattedSlash()}} · {{$project->thumb_place}}
        </p>

        <div class="welcome_thumb_content_type_wrapper isMobileDisable">
            <p class="welcome_thumb_content_type">
                {{$project->project_type}}
            </p>
        </div>
    </div>
</a>
</div>
