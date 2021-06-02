@extends('app')

@section('css')
    <link href="{{ asset('/css/terms.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    <div class='terms_container'>
        @include ('helper.terms_content_v3')
    </div>
@endsection
