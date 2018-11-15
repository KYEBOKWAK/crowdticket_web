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
<?php
$resultOrders = json_decode($resultOrderList, true);
 ?>
    @include('helper.btn_admin', ['project' => $project])
    <div class="first-container container">
        <div class="row">
            <img src="{{ asset('/img/app/img_update_project_reward.png') }}" class="center-block"/>
            <h2 class="text-center text-important">예약 오더 결과 셋팅 완료</h2>
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
                    <td>결제상태</td>
                    <td>실패메세지</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($resultOrders as $resultOrder)
                    <tr>
                        <td>{{ $resultOrder['name'] }}</td>
                        <td>{{ $resultOrder['user_id'] }}</td>
                        <td>{{ $resultOrder['orderstate'] }}</td>
                        <td>{{ $resultOrder['failmessage'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>

@endsection
