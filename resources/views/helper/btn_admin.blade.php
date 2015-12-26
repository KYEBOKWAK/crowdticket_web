@if (\Auth::check() && \Auth::user()->isOwnerOf($project))
<div class="btn-admin dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img src="{{ asset('img/app/btn_admin.png') }}" /></a>
	<ul class="dropdown-menu" role="menu">
		<li><a href="{{ url('/projects') }}/{{ $project->id }}" >프로젝트 보기</a></li>
		<li><a href="{{ url('/projects') }}/form/{{ $project->id }}" >프로젝트 수정</a></li>
		<li><a href="{{ url('/projects') }}/{{ $project->id }}/orders" >후원자 관리</a></li>
	</ul>
</div>
@endif