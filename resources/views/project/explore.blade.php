@extends('app')

@section('css')
    <style>
        .ps-explore-tabs {
            margin-top: 48px;
            margin-bottom: 35px;
            margin-left: -4px;
            margin-right: -4px;
        }

        .ps-explore-tabs a {
            text-decoration: none;
        }

        .ps-explore-tabs .col-md-3 {
            padding-left: 4px;
            padding-right: 4px;
        }

        .ps-explore-tab {
            padding: 20px 0 20px 0;
            text-align: center;
            background-color: #eee;
            color: #384150;
        }

        .ps-explore-tab img {
            width: 24px;
            height: 25px;
        }

        .ps-explore-tab-selected {
            background-color: #384150;
            color: #fff;
        }

        .ps-explore-tab-title {
            display: inline;
            font-size: 15px;
            font-weight: bold;
            vertical-align: middle;
            margin-left: 8px;
        }

        .ps-explore-tab:hover {
            background-color: #ddd;
        }

        .ps-explore-tab-selected:hover {
            background-color: #384150;
        }
    </style>
    <link href="{{ asset('/css/welcome.css?version=5') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="first-container">
        <div class="container">
            <div class="row ps-explore-tabs">
                <?php
                $tabs = [
                        [
                                'key' => 'all',
                                'title' => '전체보기',
                                'selected_ico_url' => asset('/img/app/ico_list_on.png'),
                                'unselected_ico_url' => asset('/img/app/ico_list_out.png')
                        ],
                        [
                                'key' => 'funding',
                                'title' => '펀딩 중인 공연',
                                'selected_ico_url' => asset('/img/app/ico_progress_on.png'),
                                'unselected_ico_url' => asset('/img/app/ico_progress_out.png')
                        ],
                        [
                                'key' => 'sale',
                                'title' => '티켓팅 중인 공연',
                                'selected_ico_url' => asset('/img/app/ico_ticket_on.png'),
                                'unselected_ico_url' => asset('/img/app/ico_ticket_out.png')
                        ],
                        [
                                'key' => 'date',
                                'title' => '마감임박순',
                                'selected_ico_url' => asset('/img/app/ico_watch_on.png'),
                                'unselected_ico_url' => asset('/img/app/ico_watch_out.png')
                        ]
                ];
                ?>

                @foreach ($tabs as $tab)
                    <div class="col-md-3">
                        <a href="{{ url('/projects?tab=') }}{{ $tab['key'] }}">
                            <div class="ps-explore-tab @if ($tab['key'] === $selected_tab) ps-explore-tab-selected @endif">
                                @if ($tab['key'] === $selected_tab)
                                    <img src="{{ $tab['selected_ico_url'] }}"/>
                                @else
                                    <img src="{{ $tab['unselected_ico_url'] }}"/>
                                @endif
                                <h5 class="ps-explore-tab-title">{{ $tab['title'] }}</h5>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            @include('template.carousel_main_project', ['projects' => $projects ])
        </div>
    </div>

    <div style="width: 100%;">

    </div>
@endsection
