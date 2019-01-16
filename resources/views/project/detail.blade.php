@extends('app')

@section('meta')
    <meta property="og:image" content="{{ $project->getPosterUrl() }}"/>
    <meta name="description" content="{{ $project->description }}"/>
@endsection

@section('title')
    <title>{{ $project->title }}</title>
@endsection

@section('css')
    <style>
        .container h2 {
            margin-top: 60px;
            margin-bottom: 25px;
        }

        .ps-detail-category {
            margin-bottom: 30px;
        }

        .ps-detail-category span {
            font-size: 1.2em;
        }

        .project-video,
        .project-thumbnail {
            width: 100%;
            height: 450px;
        }

        .ps-detail-description p,
        .ps-detail-share-facebook span {
            width: 100%;
            height: 50px;
        }

        .ps-detail-description {
            padding-right: 0;
        }

        .ps-detail-description p {
            padding-left: 24px;
            background-color: #aaa;
            color: white;
            font-weight: bold;
            font-size: 18px;
            line-height: 50px;
        }

        .ps-detail-share-facebook {
            padding-left: 0;
        }

        .ps-detail-share-facebook span {
            border: none;
            border-radius: 0;
            color: white;
            font-size: 12px;
            background-color: #3a5795;
            padding-top: 15px;
        }

        .ps-detail-share-facebook span:hover {
            color: #eee;
        }

        .ps-detail-tabs {
            margin-top: 40px;
        }

        .ps-detail-tabs .nav-tabs {
            font-size: 14px;
            color: #8a8273;
        }

        .ps-detail-tabs .active {
            font-weight: bold;
        }

        .ps-detail-right-section {
            padding: 0px 10px 0px 10px;
        }

        .tab-pane {
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            border-left: 1px #ddd solid;
            border-right: 1px #ddd solid;
            border-bottom: 1px #ddd solid;
            background-color: white;
            padding: 27px 27px 40px 27px;
        }

        #news-container {
            margin-bottom: 20px;
        }

        .ps-detail-comment-wrapper {
            margin-bottom: 20px;
        }

        .ps-detail-comment-wrapper button {
            margin-top: 10px;
        }

        #comments-container {
            padding: 0;
        }

        #ticket_list {
            margin-top: 30px;
			      margin-right: 0px;
			      margin-left: 0px;
        }

        .ticket {
            padding: 0px;
        }

        .creator-wrapper {
            margin-top: 30px;
        }

        .newIcon{
          font-size: 10px;
          font-style: normal;
          font-weight: bold;
          position: relative;
          top: -6px;
          color: #7EC52A
        }
    </style>
@endsection

@section('content')
    @include('helper.btn_admin', ['project' => $project])
    <div class="first-container container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center"><strong>{{ $project->title }}</strong></h2>
                <div class="text-center ps-detail-category">
                    <img src="{{ asset('/img/app/ico_map.png') }}" width="25px" height="25px"/>
                    @if ($project->city)
                        <span><strong>{{ $project->city->name }}</strong></span>
                    @endif
                    @if ($project->category)
                        <span><strong> / {{ $project->category->title }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="row ps-detail-left-page">
                    <div class="col-md-12 project-video">
                        @if ($project->video_url)
                            <iframe class="project-video" src="{{ $project->getValidYouTubeUrl() }}" frameborder="0"
                                    allowfullscreen></iframe>
                        @else ($project->poster_url)
                            <div class="bg-base project-thumbnail"
                                 style="background-image: url('{{ $project->getPosterUrl() }}')"></div>
                        @endif
                    </div>
                    <div class="col-md-9 ps-detail-description">
                        <p class="text-ellipsize">{{ $project->description }}</p>
                    </div>
                    <div class="col-md-3 ps-detail-share-facebook" id="BtnFBshare">
                        <span class="btn">페이스북 공유하기</span>
                    </div>
                    <div class="col-md-12 ps-detail-tabs">
                        @if ($project->type === 'funding')
                            @include('helper.nav', [
                                'nav_class' => 'nav-tabs nav-justified',
                                'tabs' => [
                                    0 => [
                                        'id' => 'tab-story',
                                        'class' => 'active',
                                        'title' => '공연소개',
                                        'isNew' => ''
                                    ],

                                    1 => [
                                        'id' => 'tab-news',
                                        'title' => '업데이트 (' . $project->news_count . ')',
                                        'isNew' => $isArrayNew['news']
                                    ],

                                    2 => [
                                        'id' => 'tab-comments',
                                        'title' => '응원&후기 (' . $project->comments_count . ')',
                                        'isNew' => $isArrayNew['comment']
                                    ],

                                    3 => [
                                        'id' => 'tab-supporters',
                                        'title' => '후원자 (' . $project->supporters_count . ')',
                                        'isNew' => $isArrayNew['support']
                                    ]
                                ]
                            ])
                        @else
                            @include('helper.nav', [
                                'nav_class' => 'nav-tabs nav-justified',
                                'tabs' => [
                                    0 => [
                                        'id' => 'tab-story',
                                        'class' => 'active',
                                        'title' => '공연소개',
                                        'isNew' => ''
                                    ],

                                    1 => [
                                        'id' => 'tab-news',
                                        'title' => '업데이트 (' . $project->news_count . ')',
                                        'isNew' => $isArrayNew['news']
                                    ],

                                    2 => [
                                        'id' => 'tab-comments',
                                        'title' => '응원&후기 (' . $project->comments_count . ')',
                                        'isNew' => $isArrayNew['comment']
                                    ]
                                ]
                            ])
                        @endif
                    </div>
                    <div class="col-md-12 tab-content">
                        <div id="tab-story" role="tabpanel" class="tab-pane active">
                            {!! html_entity_decode($project->story) !!}
                        </div>
                        <div id="tab-news" role="tabpanel" class="tab-pane loadable">
                            <ul id="news-container" class="list-group"></ul>
                            @if ($is_master)
                                <div class="text-center">
                                    <a href="{{ url('/projects') }}/{{ $project->id }}/news/form"
                                       class="btn btn-success">업데이트 작성</a>
                                </div>
                            @endif
                        </div>
                        <div id="tab-comments" role="tabpanel" class="tab-pane loadable">
                            <form action="{{ url('/projects') }}/{{ $project->id }}/comments" method="post"
                                  data-toggle="validator" role="form" class="ps-detail-comment-wrapper">
                                <textarea id="input_comment" name="contents" class="form-control" rows="3"
                                          placeholder="프로젝트 진행자에게 궁금한 사항, 혹은 응원의 한마디를 남겨주세요!" required></textarea>
                                <button class="btn btn-success pull-right">댓글달기</button>
                                <div class="clear"></div>
                                @include('csrf_field')
                            </form>
                            <ul id="comments-container"></ul>
                        </div>
                        <div id="tab-supporters" role="tabpanel" class="tab-pane loadable">
                            <ul id="supporters-container" class="list-group"></ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ps-detail-right-section">
                <div class="row">
                    <div class="col-md-12 project-detail">
                        <div class="project-body">
                            @if ($project->type === 'funding')
                                <p class="project-pledged-amount">
                                    <strong>목표금액 {{ number_format($project->pledged_amount) }}원 중 모인금액</strong></p>
                                <span class="project-funded-amount"><strong>{{ number_format($project->funded_amount) }}</strong>원</span>
                                <div class="project-progress-wrapper">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             aria-valuenow="{{ $project->getProgress() }}" aria-valuemin="0"
                                             aria-valuemax="100" style="width: {{ $project->getProgress() }}%;">
                                            <span class="sr-only">{{ $project->getProgress() }}</span>
                                        </div>
                                    </div>
                                    <span class="project-progress-number"><strong>{{ $project->getProgress() }}</strong>%</span>
                                    <div class="clear"></div>
                                </div>
                                <div class="col-md-6 project-half project-half-divider">
                                    <h5 class="text-center">후원자</h5>
                                    <span class="center-block text-center"><strong>{{ number_format($project->supporters_count) }}</strong>명</span>
                                </div>
                                <div class="col-md-6 project-half">
                                    <h5 class="text-center">티켓구매</h5>
                                    <span class="center-block text-center"><strong>{{ number_format($project->tickets_count) }}</strong>매</span>
                                </div>
                                <div class="project-button-box clear">
                                    @if ($project->isFinished())
                                        @if ($project->isSuccess())
                                            <span class="text-danger">성공했습니다!</span>
                                        @else
                                            <span class="text-danger">마감되었습니다</span>
                                        @endif
                                    @else
                                        <span>펀딩 마감까지 <strong>{{ $project->dayUntilFundingClosed() }}</strong>일</span>
                                        <a href="{{ url('/projects/') }}/{{ $project->id }}/tickets"
                                           @if ($project->isFinished()) disabled="disabled"
                                           @endif  class="btn btn-primary pull-right">후원하기</a>
                                        <div class="clear"></div>
                                    @endif
                                </div>
                            @else
                                <div class="col-md-12 project-label">
                                    <div class="col-md-4 project-label-title">
                                        <span>공연장</span>
                                    </div>
                                    <div class="col-md-8 project-label-body">
                                        <span><strong>{{ $project->concert_hall }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-12 project-label">
                                    <div class="col-md-4 project-label-title">
                                        <span>위치</span>
                                    </div>
                                    <div class="col-md-8 project-label-body">
                                        <span>{{ $project->detailed_address }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12 project-label last-child">
                                    <div class="col-md-4 project-label-title">
                                        <span>공연날짜</span>
                                    </div>
                                    <div class="col-md-8 project-label-body">
                                        <span><strong>{{ $project->getTicketDateFormatted() }}</strong></span>
                                    </div>
                                </div>
                                <div class="project-full-button">
                                    @if ($project->isFinished())
                                        <a href="#" disabled="disabled" class="btn btn-primary">마감된 공연</a>
                                    @else
                                        <a href="{{ url('/projects/') }}/{{ $project->id }}/tickets"
                                           class="btn btn-primary">티켓구매</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 creator-wrapper">
                        @include('template.creator_profile', ['user' => $project->user])
                    </div>
                </div>
                <div id="ticket_list" class="row" data-tickets="{{ $project->tickets }}"></div>
            </div>
        </div>
        <input type="hidden" id="buyable" value="{{ $project->canOrder() ? 1 : 0 }}"/>
        <input type="hidden" id="project_saleType" value="{{ $project->type }}"/>
        <input type="hidden" id="project_id" value="{{ $project->id }}"/>
    </div>
@endsection

@section('js')
    @include('template.comment')
    @include('template.news')
    @include('template.supporter')
    @include('template.ticket')
    @include('template.fbForm', ['project' => $project])
    <script src="{{ asset('/js/project/detail.js?version=15') }}"></script>
@endsection
