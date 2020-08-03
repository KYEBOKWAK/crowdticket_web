@extends('app')

@section('css')
    <style>
        .ps-box {
            background-color: white;
            border: 1px #dad8cc solid;
            border-radius: 5px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .ps-text-detail {
            margin-top: 5em;
        }
        .ps-text-detail strong {
            font-size: 1.2em;
        }

        .ps-detail-comment-wrapper {
            padding-bottom: 0px;
        }

        .ps-detail-comment-wrapper button {
            margin-top: 10px;
        }

        .btn-facebook-Shar{
          color: white;
          background-color: #3a5795;
          margin-left:15px;
        }

        .btn-facebook-Shar span:hover{
          color: #eee;
        }

        .commentTitle{
          font-size: 25px;
          padding-bottom: 11px;
        }

        .mannayo_banner_img{
          width: 100%;
        }

        .mannayo_banner_container{
          width: 1030px;
          margin-top: 64px;
          margin-bottom: 44px;
          margin-left: auto;
          margin-right: auto;
        }

        .mannayo_banner_img_pc{
          border-radius: 10px;
        }

        .mannayo_banner_img_mobile{
          display: none;
        }

        .complete_account_info_container{
          text-align: center;
          font-size: 14px;
          margin-top: 32px;
          margin-bottom: 40px;
        }

        .pay_info_label{
          width: 100px;
          margin-right: 20px;
          text-align: right;
          margin-left: auto;
        }

        .pay_info_container{
          font-size: 16px;
          font-weight: bold;
        }

        .pay_account_wrapper{
          width: 355px;
          height: 64px;
          background-color: #f7f7f7;
          border-radius: 5px;
          text-align: center;
          margin-right: auto;
        }

        .pay_info_wrapper{
          margin-bottom: 12px;
        }

        .pay_info_wrapper_padding{
          padding-top: 20px;
          padding-bottom: 20px;
        }

        .pay_info_line{
          width: 100%;
          height: 1px;
          background-color: #cccccc;
          margin-top: 40px;
          margin-bottom: 20px;
        }

        .pay_info_bottom_label{
          text-align: center;
          font-size: 12px;
          color: #333333;
        }

        @media (max-width:1030px) {
          .mannayo_banner_container{
            width: 100%;
          }

          .mannayo_banner_img_pc{
            border-radius:0;
          }
        }

        @media (max-width:820px) {
          .mannayo_banner_container{
            margin-top: 40px;
            margin-bottom: 0px;
          }

          .mannayo_banner_img_pc{
            display: none;
          }
          .mannayo_banner_img_mobile{
            display: block;
          }
        }

        @media (max-width:525px){
          .pay_account_wrapper{
            height: 100%;
          }
        }
    </style>
@endsection

@section('content')
    @if($isComment === 'TRUE')
    <script>
      swal("등록 성공!", "프로젝트 응원&후기 에서 확인 할 수 있습니다.", "success");
    </script>
    @endif
    <!-- 데이터 수집 코드 START  -->
    <input id="data_project_title" type="hidden" value="{{$project->title}}">
    <input id="data_project_project_type" type="hidden" value="{{$project->project_type}}">
    <input id="data_order_id" type="hidden" value="@if($order!=''){{$order->id}}@endif">
    <input id="data_order_total_price" type="hidden" value="@if($order!=''){{$order->total_price}}@endif">
    <input id="data_order_supporter_id" type="hidden" value="@if($order!=''){{$order->supporter_id}}@endif">
    <input id="data_order_counter" type="hidden" value="@if($order!=''){{$order->count}}@endif">
    <input id="data_order_price" type="hidden" value="@if($order!=''){{$order->price}}@endif">
    <!-- 데이터 수집 코드 END  -->

    <div class="container first-container">
        @include ('order.header', ['project' => $project, 'step' => 3])
        <div class="row ps-box">
            <div class="col-md-12">
                <h2 class="text-center"><strong>THANK YOU!</strong></h2>
                @if ($project->type === 'funding')
                  @if($project->isPickType())
                    @if($project->isEventSubTypeSandBox())
                      <h3 class="text-center"><strong>참여가 성공적으로 완료되었습니다.</strong></h3>
                      <p class="text-center text-danger">입력하신 정보는 철저히 암호화 된 상태로 안전하게 다뤄집니다.</p>
                      <p class="text-center ps-text-detail" style="margin-top:30px;">
                          <strong>
                            아직 당첨이 확정된 것은 아니예요!<br/>
                            <br/>
                          </strong>
                          당첨된 분들에게는 발표 날짜에 맞춰 문자로 안내를 드립니다. <br/>
                          당첨 결과는 사이트 오른쪽 상단의 결제확인 탭에서 확인 할 수 있습니다.<br/><br/>
                      </p>
                    @else
                      <h3 class="text-center"><strong>결제가 성공적으로 예약되었습니다.</strong></h3>
                      <p class="text-center text-danger">입력하신 정보는 철저히 암호화 된 상태로 안전하게 다뤄집니다.</p>
                      <p class="text-center ps-text-detail" style="margin-top:30px;">
                          <strong>
                              지금 결제가 진행된 것이 아닙니다!<br/>
                              <br/>
                          </strong>
                          당첨되었을 경우에 한하여 결제가 진행됩니다. <br/>
                          당첨 결과는 오른쪽 결제 확인 탭에서 확인 할 수 있습니다. <br/><br/>
                          당첨되지 않으면 결제가 진행되지 않습니다.
                      </p>
                    @endif
                  @else
                    <h3 class="text-center"><strong>결제가 성공적으로 예약되었습니다.</strong></h3>
                    <p class="text-center text-danger">입력하신 정보는 철저히 암호화 된 상태로 안전하게 다뤄집니다.</p>
                    <p class="text-center ps-text-detail">
                        <strong>
                            펀딩이 성공하면, '완료일 익일'에 모든 후원자의 결제가 일괄 진행됩니다.<br/>
                            펀딩이 실패하면 결제되지 않습니다.<br/><br/>
                        </strong>
                        결제예약은 오른쪽 상단 '결제확인' 탭에서 취소할 수 있으며,<br/>
                        취소하면 펀딩의 후원이 자동 취소됩니다.<br/>
                        단, 펀딩이 완료되기 24시간 전부터는 취소할 수 없습니다.
                    </p>
                  @endif
                @else
                    <h3 class="text-center">
                      <strong>
                        @if($isComment === 'TRUE')
                          댓글 등록 완료!
                        @else
                          @if($order->isAccountOrder())
                            입금대기 상태입니다.
                          @elseif($project->isEventTypeDefault())
                            결제가 완료되었습니다.
                          @elseif($project->isEventTypeInvitationEvent())
                            초대권 신청이 완료되었습니다.
                          @elseif($project->isEventCustomType())
                            이벤트 신청이 완료되었습니다.
                          @endif
                        @endif
                      </strong>
                    </h3>
                    @if($isComment === 'FALSE')
                      @if($order->isAccountOrder())
                      <div class="complete_account_info_container">
                        <p style="margin-bottom: 5px;">
                          <b>아래 계좌로 24시간내</b> 입금해주세요. 크티에서 확인 후 결제완료 처리해드립니다.
                        </p>
                        <p>
                          입금 계좌번호 및 결제 진행 상태는 오른쪽 상단 ‘결제확인’ 탭에서 확인가능해요!
                        </p>
                      </div>
                      
                      <div class="pay_info_container">
                        <div class='flex_layer pay_info_wrapper'>
                          <p class="pay_info_label pay_info_wrapper_padding">
                            입금 계좌번호
                          </p>
                          <div class="pay_account_wrapper pay_info_wrapper_padding">
                            <p>
                              우리은행 1005-903-653846 (주)나인에이엠
                            </p>
                          </div>
                        </div>

                        <div class='flex_layer pay_info_wrapper'>
                          <p class="pay_info_label pay_info_wrapper_padding">
                            입금자명
                          </p>
                          <div class="pay_account_wrapper pay_info_wrapper_padding">
                            <p>
                              {{$order->account_name}}
                            </p>
                          </div>
                        </div>

                        <div class='flex_layer pay_info_wrapper'>
                          <p class="pay_info_label pay_info_wrapper_padding">
                            입금금액
                          </p>
                          <div class="pay_account_wrapper pay_info_wrapper_padding">
                            <p>
                            {{number_format($order->total_price)}}원
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="pay_info_line">
                      </div>
                      <div class="pay_info_bottom_label">
                        <p style="margin-bottom: 2px;">
                          - 연락처가 정확하지 않은 경우, 결제 확인 및 환불 처리가 어렵습니다.
                        </p>
                        <p>
                          - 현금영수증이 필요하신 분은 070-8819-4308로 문의부탁드립니다.
                        </p>
                      </div>
                      @else
                      <p class="text-center ps-text-detail">
                          <strong>
                            @if($project->isEventCustomType())
                              적어주신 내용 확인 후, 담당자가 연락드리도록 하겠습니다!
                            @else
                              오른쪽 상단 '결제확인' 탭에서 확인해보세요!
                            @endif  
                          </strong>
                      </p>
                      @endif
                    @endif
                @endif
            </div>
        </div>
        <!-- 응원하기 -->
        <div class="row ps-box">
          <p class="text-left commentTitle">
            <strong>
              @if($project->isEventTypeDefault())
                @if(env('REVIEW_ON'))
                  잠깐! 티켓 구매자의 한마디는 프로젝트 진행자에게 큰 힘이 됩니다!
                @else
                  잠깐! 후원자의 한마디는 프로젝트 진행자에게 큰 힘이 됩니다!
                @endif
              @elseif($project->isEventTypeInvitationEvent())
                잠깐! 여러분의 기대평이 프로젝트 진행자에게 큰 힘이 됩니다!
              @elseif($project->isEventCustomType())
                잠깐! 여러분의 기대평이 이벤트 진행자에게 큰 힘이 됩니다!
              @endif
            </strong>
          </p>
            <form action="{{ url('/tickets') }}/{{ $project->id }}/comments" method="post"
                  data-toggle="validator" role="form" class="ps-detail-comment-wrapper">
                <textarea id="input_comment" name="contents" class="form-control" rows="3"
                          placeholder="프로젝트 진행자에게 궁금한 사항, 혹은 응원의 한마디를 남겨주세요!" required></textarea>
                <button class="btn btn-success pull-right">등록하기</button>
                <div class="clear"></div>
                @include('csrf_field')
            </form>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
              @if(!env('REVIEW_ON'))
                <a href="{{ url('/projects') }}" class="btn btn-success ">더 둘러보기</a>
              @endif
                <span class="btn btn-facebook-Shar" id="BtnFBshare">페이스북 공유</span>
            </div>
        </div>
    </div>
    <div class='mannayo_banner_container'>
      <a href="{{url('/mannayo')}}" target='_blank'>
        <img class='mannayo_banner_img mannayo_banner_img_pc' src='https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/190806_meet_banner_wide.png'>
        <img class='mannayo_banner_img mannayo_banner_img_mobile' src='https://crowdticket0.s3-ap-northeast-1.amazonaws.com/banner/190806_meet_banner.png'>
      </a>
    </div>
@endsection

@section('js')
@include('template.fbForm', ['project' => $project])
<script>
//데이터 수집 코드 START
$(document).ready(function () {
  if($('#data_order_id').val() === ''){
    return;
  }

  var isSupport = 'Y';
  if($('#data_order_supporter_id').val() === ''){
    isSupport = 'N'
  }

  dataLayer.push({
    event: 'purchase',
    ecommerce: {
      purchase: { 
        actionField: {
          id: Number($('#data_order_id').val()), // 주문번호 { 구매정보 내 수집하는 id (서버변수 : id) }
          revenue: Number($('#data_order_total_price').val()), // 총 결제 금액 { 구매정보시 수집하는 가격정보 (서버변수 : total_price) 
        },

        dimension4: isSupport, // 후원여부 { 후원id (서버변수 : supporter_id) 존재 시 “Y”},
        products: [{
          name: $('#data_project_title').val(), 
          price: Number($('#data_order_price').val()),
          quantity: Number($('#data_order_counter').val()),
          category: $('#data_project_project_type').val()
        }]
      }
    }
  });
});

//데이터 수집 코드 END
</script>
@endsection
