@extends('app')

@section('css')
    <style>
        .first-container h3 {
            margin-bottom: 1em;
            padding-bottom: 1em;
            border-bottom: 1px #DAD8CC solid;
        }

        .first-container p {
            white-space: pre-wrap;
        }
    </style>
@endsection

@section('content')
    <div class="first-container container">
        <h3 class="text-center">
        @if(env('REVIEW_ON'))
            이용약관
        @else
            크라우드티켓 이용약관
        @endif
        </h3>
        <div class="row">
            <div class="col-md-12">
                <p>@include ('helper.terms_content')</p>
            </div>
        </div>
    </div>
@endsection
