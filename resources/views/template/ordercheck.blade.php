@extends('app')

@section('css')
    <style>
        .first-container .row {
            padding: 30px;
        }

        .ps-ticket-order {
            margin-bottom: 60px;
        }

        .table thead {
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    @include('helper.btn_admin', ['project' => $project])
    <div class="first-container container">
        <div class="row">
            <img src="{{ asset('/img/app/img_update_project_reward.png') }}" class="center-block"/>
            <h2 class="text-center text-important">오더 체크</h2>
        </div>
    </div>
    <div class="container">
      <div class="row ps-ticket-order">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <td>이름(order)</td>
                    <td>유저id(order)</td>
                    <td>customer_uid(IamPort)</td>
                    <td>merchant_uid(IamPort)</td>
                    <td>schedule_status(IamPort)</td>
                    <td>amount(IamPort)</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($resultOrders as $resultOrder)
                    <tr>
                        @if($resultOrder['order'])
                          <td>{{ $resultOrder['order']->name }}</td>
                          <td>{{ $resultOrder['order']->user_id }}</td>
                        @else
                          <td>{{ 오더정보없음 }}</td>
                          <td>{{ 오더정보없음 }}</td>
                        @endif
                        <td>{{ $resultOrder['iamport']->customer_uid }}</td>
                        <td>{{ $resultOrder['iamport']->merchant_uid }}</td>
                        <td>{{ $resultOrder['iamport']->schedule_status }}</td>
                        <td>{{ $resultOrder['iamport']->amount }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>

@endsection
