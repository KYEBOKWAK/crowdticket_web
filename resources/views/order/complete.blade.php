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
    </style>
@endsection

@section('content')
    @if($isComment == TRUE)
    <script>
      swal("등록 성공!", "프로젝트 응원&후기 에서 확인 할 수 있습니다.", "success");
    </script>
    @endif
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
                        @if($project->isEventTypeDefault())
                          결제가 완료되었습니다.
                        @elseif($project->isEventTypeInvitationEvent())
                          초대권 신청이 완료되었습니다.
                        @endif
                      </strong>
                    </h3>
                    <p class="text-center ps-text-detail">
                        <strong>
                            오른쪽 상단 '결제확인' 탭에서 확인해보세요!
                        </strong>
                    </p>
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
@endsection
