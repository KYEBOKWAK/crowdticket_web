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
    $goodsList = $project->goods;
    ?>
    @include('helper.btn_admin', ['project' => $project])
    <div class="first-container container">
        <div class="row">
            <img src="{{ asset('/img/app/img_update_project_reward.png') }}" class="center-block"/>
            <h2 class="text-center text-important">주문 관리</h2>
            <p class="text-center">조회수 {{ $project->view_count }} (아직 테스트 중인 페이지 입니다. 보기 조금 불편할 수 있으니 양해 부탁드립니다^^ *엑셀 정리가 필요하신 경우 언제든지 연락 주세요.)</p>
            <p class="text-center">** 아직까진 PC로만 봐주세요ㅠㅠ **</p>
        </div>
    </div>
    <div class="container">
        @foreach ($tickets as $ticket)
                @if (count($ticket->orders) > 0)
                  <div class="row ps-ticket-order">
                    <div class="ticket order col-md-12">
                        <div class="ticket-wrapper">
                            <div class="ticket-body row display-table">
                                @if ($project->type === 'funding')
                                    <div class="col-md-3 display-cell text-right">
                                        <span><strong class="text-primary ticket-price">{{ $ticket->price }}</strong> 원 티켓</span>
                                    </div>
                                    <div class="col-md-9 display-cell">
                                        <span class="ticket-delivery-date">
                                          @if($ticket->isPlaceTicket())
                                            시작일 : {{ date('Y년 m월 d일 H:i', strtotime($ticket->show_date)) }}
                                          @else
                                            날짜미정
                                          @endif
                                        </span>
                                    </div>
                                @else
                                    <div class="col-md-3 display-cell">
                          						<span>
                          							<span class="text-primary">공연일시</span><br/>
                          							<strong class="ps-strong-small">
                                          @if($ticket->isPlaceTicket())
                                            {{ date('Y.m.d H:i', strtotime($ticket->show_date)) }}
                                          @else
                                            날짜미정
                                          @endif
                                        </strong>
                          							<span class="pull-right">{{ $ticket->price }} 원</span>
                          						</span>
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
                                <td>할인권</td>
                                <td>상태</td>
                                <td>결제일</td>
                                <td>이메일</td>
                                <td>전화번호</td>
                                @if ( $project->isDelivery == "TRUE" )
                                <td>굿즈 수령 주소</td>
                                <td>기타 문의</td>
                                @endif

                                @foreach($goodsList as $goods)
                                  <td>{{ $goods->title }}</td>
                                @endforeach
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
                                    <!-- <td>{{ ($order->price * $order->count)+$supporterPrice }}</td> -->
                                    <td>{{ $order->getTotalPriceWithoutCommission() }}</td>
                                    <td>{{ $order->getDiscountText() }}</td>
                                    <td>{{ $order->state_string }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ $order->contact }}</td>
                                    @if ( $project->isDelivery == "TRUE" )
                                      <td>{{ $order->getDeliveryAddress() }}</td>
                                      <td>{{ $order->requirement }}</td>
                                    @endif
                                    @foreach($goodsList as $goods)
                                      <td>{{ $order->isBuyGoodsCount($goods->id) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                  </div>
                @endif
        @endforeach
    </div>

    <!-- 티켓 미구매 리스트 -->
    <div class="container">
      <div class="ticket order col-md-12">
          <div class="ticket-wrapper">
              <div class="ticket-body row display-table">
                      <div class="col-md-3 display-cell text-right">
                          <span><strong class="text-primary ticket-price">티켓 미구매(굿즈만 구매한 리스트)</strong></span>
                      </div>
                      <div class="col-md-9 display-cell">
                          <span class="ticket-delivery-date">
                            티켓 미구매(굿즈만 구매한 리스트)
                          </span>
                      </div>
              </div>
          </div>
      </div>

          <div class="row ps-ticket-order">
                  <div class="col-md-12">
                      <table class="table">
                          <thead>
                          <tr>
                            <td>이름</td>
                            <td>추가후원</td>
                            <td>결제금액</td>
                            <td>상태</td>
                            <td>결제일</td>
                            <td>이메일</td>
                            <td>전화번호</td>
                            @if ( $project->isDelivery == "TRUE" )
                            <td>굿즈 수령 주소</td>
                            <td>기타 문의</td>
                            @endif
                              @foreach($goodsList as $goods)
                                <td>{{ $goods->title }}</td>
                              @endforeach
                          </tr>
                          </thead>
                          <tbody>
                            @foreach ($orders as $order)
                              @if(!$order->ticket && $order->getIsGoodsCount() > 0)
                                <tr>
                                  <td>{{ $order->name }}</td>
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
                                  <td>{{ $order->getTotalPriceWithoutCommission() }}</td>
                                  <td>{{ $order->state_string }}</td>
                                  <td>{{ $order->created_at }}</td>
                                  <td>{{ $order->email }}</td>
                                  <td>{{ $order->contact }}</td>
                                  @if ( $project->isDelivery == "TRUE" )
                                    <td>{{ $order->getDeliveryAddress() }}</td>
                                    <td>{{ $order->requirement }}</td>
                                  @endif
                                    @foreach($goodsList as $goods)
                                      <td>{{ $order->isBuyGoodsCount($goods->id) }}</td>
                                    @endforeach
                                </tr>
                              @endif
                            @endforeach
                          </tbody>
                      </table>
                  </div>
          </div>
    </div>

    <!-- 후원만 한사람 -->

    <div class="container">
      <div class="ticket order col-md-12">
          <div class="ticket-wrapper">
              <div class="ticket-body row display-table">
                      <div class="col-md-3 display-cell text-right">
                          <span><strong class="text-primary ticket-price">후원만 하신 분</strong></span>
                      </div>
                      <div class="col-md-9 display-cell">
                          <span class="ticket-delivery-date">
                            <!-- 티켓 미구매(굿즈만 구매한 리스트) -->
                          </span>
                      </div>
              </div>
          </div>
      </div>

          <div class="row ps-ticket-order">
                  <div class="col-md-12">
                      <table class="table">
                          <thead>
                          <tr>
                            <td>이름</td>
                            <td>추가후원</td>
                            <td>결제금액</td>
                            <td>상태</td>
                            <td>결제일</td>
                            <td>이메일</td>
                            <td>전화번호</td>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach ($orders as $order)
                              @if(!$order->ticket && $order->getIsGoodsCount() == 0)
                                <tr>
                                  <td>{{ $order->name }}</td>
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
                                  <td>{{ $order->getTotalPriceWithoutCommission() }}</td>
                                  <td>{{ $order->state_string }}</td>
                                  <td>{{ $order->created_at }}</td>
                                  <td>{{ $order->email }}</td>
                                  <td>{{ $order->contact }}</td>
                                </tr>
                              @endif
                            @endforeach
                          </tbody>
                      </table>
                  </div>
          </div>
    </div>

@endsection
