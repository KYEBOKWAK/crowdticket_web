@if (\Auth::check() && \Auth::user()->isOwnerOf($project))
    <div class="btn-admin dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img
                    src="{{ asset('img/app/btn_admin_1.png') }}"/></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ $project->getProjectURLWithIdOrAlias() }}">프로젝트 보기</a></li>
            <li><a href="{{ url('/projects') }}/form/{{ $project->id }}">프로젝트 수정</a></li>
            <li><a href="{{ url('/projects') }}/{{ $project->id }}/orders">주문 관리</a></li>
            <li><a href="{{ url('/projects') }}/{{ $project->id }}/attend">출석 체크</a></li>
            @if($project->isPickType())
              <li><a href="{{ url('/projects') }}/{{ $project->id }}/picking">추첨 하기</a></li>
            @endif
        </ul>
    </div>
@endif
