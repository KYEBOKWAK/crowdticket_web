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
            <h2 class="text-center text-important">후원자 관리</h2>
            <p class="text-center">조회수 {{ $project->view_count }}</p>
        </div>
    </div>
    <div class="container">
        @foreach ($tickets as $ticket)
            <div class="row ps-ticket-order">
                @if (count($ticket->orders) > 0)
                    <div class="ticket order col-md-12">
                        <div class="ticket-wrapper">
                            <div class="ticket-body row display-table">
                                @if ($project->type === 'funding')
                                    <div class="col-md-3 display-cell text-right">
                                        <span><strong class="text-primary ticket-price">{{ $ticket->price }}</strong> 원 이상</span>
                                    </div>
                                    <div class="col-md-9 display-cell">
                                        <p class="ticket-reward">{{ $ticket->reward }}</p>
                                        @if ($ticket->real_ticket_count > 0)
                                            <span class="ticket-real-count">
							<img src="{{ asset('/img/app/ico_ticket2.png') }}"/>
                                                {{ $ticket->real_ticket_count }}매
						</span>
                                        @endif
                                        <span class="ticket-delivery-date">예상 실행일 : {{ date('Y년 m월 d일', strtotime($ticket->delivery_date)) }}</span>
                                    </div>
                                @else
                                    <div class="col-md-3 display-cell">
						<span>
							<span class="text-primary">공연일시</span><br/>
							<strong class="ps-strong-small">{{ date('Y.m.d H:i', strtotime($ticket->show_date)) }}</strong>
							<span class="pull-right">{{ $ticket->price }} 원</span>
						</span>
                                    </div>
                                    <div class="col-md-9 display-cell">
                                        <p class="ticket-reward ps-no-margin">{{ $ticket->reward }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>이름</td>
                                <td>참여금액</td>
                                <td>구매수량</td>
                                <td>추가후원</td>
                                <td>결제금액</td>
                                <td>상태</td>
                                <td>결제일</td>
                                <td>이메일</td>
                                <td>전화번호</td>
                                @if ( $ticket->require_shipping ) <td>주소</td> @endif
                                @if ( !empty($ticket->question) ) <td>추가질문 답변</td> @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($ticket->orders as $order)
                                <tr>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->count }}</td>
                                    <td>
                                      <?php
                                      $supporterPrice = 0;
                                      if($order->supporter)
                                      {
                                        $supporterPrice = $order->supporter->price;
                                      }
                                      ?>
                                      {{ $supporterPrice }}
                                    </td>
                                    <td>{{ ($order->price * $order->count)+$supporterPrice }}</td>
                                    <td>{{ $order->state_string }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ $order->contact }}</td>
                                    @if ( $ticket->require_shipping )
                                        <td>{{ $order->postcode }} {{ $order->address_main }} {{ $order->address_detail }}</td>
                                    @endif
                                    @if ( !empty($ticket->question) ) <td>{{ $order->answer }}</td> @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
