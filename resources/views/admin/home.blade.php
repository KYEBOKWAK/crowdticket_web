@extends('app')

@section('css')
    <style>
        .list-group-item-heading {
            font-weight: bold
        }

        .list-group-item-text {
            margin-bottom: 1em
        }
    </style>
@endsection

@section('navbar')
    <nav class="navbar navbar-default">
        <a class="navbar-brand" href="{{ url('/') }}">CROWD TICKET</a>
        <p class="navbar-text">관리 콘솔 :P</p>
    </nav>
@endsection

@section('content')
    <div class="container first-container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <ul role="tablist" class="nav nav-tabs">
                    <li role="presentation" class="active"><a href="#blueprint" aria-controls="blueprint" role="tab"
                                                              data-toggle="tab">제안서</a></li>
                    <li role="presentation"><a href="#blueprint-approved" aria-controls="blueprint-approved" role="tab"
                                               data-toggle="tab">제안서 (승인완료)</a></li>
                    <li role="presentation"><a href="#blueprint-project-created"
                                               aria-controls="blueprint-project-created" role="tab" data-toggle="tab">제안서
                            (공연생성)</a></li>
                    <li role="presentation"><a href="#project" aria-controls="project" role="tab"
                                               data-toggle="tab">프로젝트</a></li>
                    <li role="presentation"><a href="#order" aria-controls="order" role="tab" data-toggle="tab">펀딩취소</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <ul id="blueprint" role="tabpanel" class="tab-pane active list-group">
                        @foreach ($blueprints as $blueprint)
                            @if (!$blueprint->hasApproved())
                                <li class="list-group-item">
                                    <form action="{{ url('/admin/blueprints/') }}/{{ $blueprint->id }}/approval"
                                          method="post">
                                        <p class="list-group-item-text">아이디 : {{ $blueprint->user->id }}, 이메일
                                            : {{ $blueprint->user->email }}, 이름 : {{ $blueprint->user->name }}</p>
                                        <h4 class="list-group-item-heading">자신 소개</h4>
                                        <p class="list-group-item-text">{{ $blueprint->user_introduction }}</p>
                                        <h4 class="list-group-item-heading">공연 종류</h4>
                                        <p class="list-group-item-text">{{ $blueprint->project_introduction }}</p>
                                        <h4 class="list-group-item-heading">공연 스토리</h4>
                                        <p class="list-group-item-text">{{ $blueprint->story }}</p>
                                        <h4 class="list-group-item-heading">예상 공연 비용</h4>
                                        <p class="list-group-item-text">{{ $blueprint->estimated_amount }}</p>
                                        <h4 class="list-group-item-heading">연락처</h4>
                                        <p class="list-group-item-text">{{ $blueprint->contact }}</p>
                                        <h4 class="list-group-item-heading">요청 날짜</h4>
                                        <p class="list-group-item-text">{{ $blueprint->created_at }}</p>
                                        <p class="list-group-item-text">프로젝트 생성 주소 : {{ url('/projects/form/' . $blueprint->code) }}</p>
                                        <button type="submit" class="btn btn-primary">승인하기</button>
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </form>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <ul id="blueprint-approved" role="tabpanel" class="tab-pane list-group">
                        @foreach ($blueprints as $blueprint)
                            @if ($blueprint->hasApproved())
                                @if (!$blueprint->hasProjectCreated())
                                    <li class="list-group-item">
                                        <p class="list-group-item-text">아이디 : {{ $blueprint->user->id }}, 이메일
                                            : {{ $blueprint->user->email }}, 이름 : {{ $blueprint->user->name }}</p>
                                        <h4 class="list-group-item-heading">자신 소개</h4>
                                        <p class="list-group-item-text">{{ $blueprint->user_introduction }}</p>
                                        <h4 class="list-group-item-heading">공연 종류</h4>
                                        <p class="list-group-item-text">{{ $blueprint->project_introduction }}</p>
                                        <h4 class="list-group-item-heading">공연 스토리</h4>
                                        <p class="list-group-item-text">{{ $blueprint->story }}</p>
                                        <h4 class="list-group-item-heading">예상 공연 비용</h4>
                                        <p class="list-group-item-text">{{ $blueprint->estimated_amount }}</p>
                                        <h4 class="list-group-item-heading">연락처</h4>
                                        <p class="list-group-item-text">{{ $blueprint->contact }}</p>
                                        <h4 class="list-group-item-heading">요청 날짜</h4>
                                        <p class="list-group-item-text">{{ $blueprint->created_at }}</p>
                                        <p class="list-group-item-text">프로젝트 생성 주소 : {{ url('/projects/form/' . $blueprint->code) }}</p>
                                        <span class="label label-success">승인완료</span>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                    <ul id="blueprint-project-created" role="tabpanel" class="tab-pane list-group">
                        @foreach ($blueprints as $blueprint)
                            @if ($blueprint->hasProjectCreated())
                                <li class="list-group-item">
                                    <p class="list-group-item-text">아이디 : {{ $blueprint->user->id }}, 이메일
                                        : {{ $blueprint->user->email }}, 이름 : {{ $blueprint->user->name }}</p>
                                    <h4 class="list-group-item-heading">자신 소개</h4>
                                    <p class="list-group-item-text">{{ $blueprint->user_introduction }}</p>
                                    <h4 class="list-group-item-heading">공연 종류</h4>
                                    <p class="list-group-item-text">{{ $blueprint->project_introduction }}</p>
                                    <h4 class="list-group-item-heading">공연 스토리</h4>
                                    <p class="list-group-item-text">{{ $blueprint->story }}</p>
                                    <h4 class="list-group-item-heading">예상 공연 비용</h4>
                                    <p class="list-group-item-text">{{ $blueprint->estimated_amount }}</p>
                                    <h4 class="list-group-item-heading">연락처</h4>
                                    <p class="list-group-item-text">{{ $blueprint->contact }}</p>
                                    <h4 class="list-group-item-heading">요청 날짜</h4>
                                    <p class="list-group-item-text">{{ $blueprint->created_at }}</p>
                                    <p class="list-group-item-text">프로젝트 생성 주소 : {{ url('/projects/form/' . $blueprint->code) }}</p>
                                    <span class="label label-success">공연 생성됨!</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <ul id="project" role="tabpanel" class="tab-pane">
                        @foreach ($investigation_projects as $project)
                            <li class="list-group-item">
                                <a href="{{ url('/projects/') }}/{{ $project->id }}" target="_blank"><p
                                            class="list-group-item-text">{{ $project->title }}</p></a>
                                <form action="{{ url('/admin/projects/') }}/{{ $project->id }}/approval" method="post">
                                    <button type="submit" class="btn btn-primary">승인하기</button>
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                                <form action="{{ url('/admin/projects/') }}/{{ $project->id }}/rejection" method="post">
                                    <button type="submit" class="btn btn-primary">반려하기</button>
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            </li>
                        @endforeach
                    </ul>
                    <ul id="order" role="tabpanel" class="tab-pane">
                        @foreach($funding_projects as $project)
                            <li class="list-group-item">
                                {{ $project->title }}
                                <form action="{{ url(sprintf('/admin/projects/%d/cancel', $project->id)) }}" method="post">
                                    <button type="submit" class="btn btn-danger">주문 취소</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
