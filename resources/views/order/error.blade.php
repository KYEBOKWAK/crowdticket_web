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

        <div class="row">
            <div class="col-md-12 text-center">
                <form action="{{ url('/tickets/') }}/{{ $ticket_id }}/orders/form" method="post">
                    @include('csrf_field')
                    <input type="hidden" name="request_price" value="{{ $request_price }}" />
                    <input type="hidden" name="ticket_count" value="{{ $ticket_count }}" />
                    <button class="btn btn-success ">다시 입력하기</button>
                </form>
            </div>
        </div>
    </div>
@endsection
