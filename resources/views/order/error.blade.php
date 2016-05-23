@extends('app')

@section('css')
    <style>
        .ps-box {
            background-color: white;
            border: 1px #dad8cc solid;
            border-radius: 5px;
            padding: 25px;
            margin-top: 5em;
            margin-bottom: 40px;
        }
    </style>
@endsection

@section('content')
    <div class="container first-container">
        <div class="row ps-box">
            <div class="col-md-12">
                <h5 class="text-center"><strong>{{ $message }}</strong></h5>
            </div>
        </div>
    </div>
@endsection
