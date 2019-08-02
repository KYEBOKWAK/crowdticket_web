@extends('app')

@section('css')
    <style>
        #main{
          min-height: unset;
        }
        .ps-explore-tabs {
            margin-top: 0px;
            margin-bottom: 35px;
            margin-left: auto;
            margin-right: auto;
            width: 100%;

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
            font-size: 11px;
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

        .swiper-slide{
          display: flex;
        }

        .project_form_poster_origin_size_ratio{
          padding-bottom: 0px !important;
        }

        @media (max-width: 769px) {
          .ps-explore-tab{
            padding: 11px 0 11px 0;
          }
        }
    </style>
    <link href="{{ asset('/css/welcome.css?version=11') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="first-container">
        <div class="container">
            @include('template.carousel_new_main', ['projects' => $projects ])
        </div>
    </div>

    <div style="width: 100%;">

    </div>
@endsection

@section('js')
@endsection
