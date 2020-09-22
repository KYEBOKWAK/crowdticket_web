@extends('app')

@section('css')
    <style>
        .ps-detail-header {
            background-color: #FFFFFF;
        }

        .ps-detail-user-wrapper {
            padding-top: 20px;
            padding-bottom: 10px;
            text-align: center;
        }

        .ps-detail-user-wrapper.user-photo-big {
            display: block;
            margin: 0 auto;
        }

        .ps-detail-user-wrapper h3 {
            font-size: 21px;
        }

        .ps-detail-title {
            margin-top: 48px;
            margin-bottom: 15px;
            padding-bottom: 13px;
            border-bottom: 1px #DEDEDE solid;
        }

        .swiper-slide{
          display: flex;
        }

        .project_form_poster_origin_size_ratio{
          padding-bottom: 0px !important;
        }
        .total_order_text{

        }
        .total_order_button{
            margin-top: 62px;
            margin-bottom: 15px;

            border-radius: 14px;
            border: solid 1px #b3b3b3;
            text-align: center;
        }
    </style>
    <link href="{{ asset('/css/welcome.css?version=13') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="first-container ps-detail-header">
        <div class="ps-detail-user-wrapper">
            <div class="user-photo-big bg-base center-block"
                 style="background-image: url('{{ $user->getPhotoUrl() }}');"></div>
            <h3><strong>{{ $user->name }}</strong></h3>
        </div>
    </div>
    <div class="container">

        @if (sizeof($super_projects) > 0)
            <div class="flex_layer" style="justify-content: space-between">
                <h3 class="ps-detail-title"><strong>관여하는 이벤트</strong></h3>
                
                <a href="{{ url('/superadmin/totalmanager') }}">
                <div class="total_order_button">
                    <span class="total_order_text" style="padding: 10px">통합 티켓 관리</span>
                </div>
                </a>
            </div>
            @include('template.carousel_new_main', ['projects' => $super_projects])
        @endif

        @if (sizeof($creating) > 0)
            <h3 class="ps-detail-title"><strong>개설중인 이벤트</strong></h3>
            @include('template.carousel_new_main', ['projects' => $creating])
        @endif

        @if (sizeof($created) > 0)
            <h3 class="ps-detail-title"><strong>개설한 이벤트</strong></h3>
            @include('template.carousel_new_main', ['projects' => $created])
        @endif

        @if (sizeof($orders) > 0)
            <h3 class="ps-detail-title"><strong>참여한 이벤트</strong></h3>
            @include('template.carousel_new_main', ['projects' => $orders])
        @endif

    </div>
@endsection

@section('js')
<script>
$(document).ready(function () {
    $('.total_order_button').click(function(){
        
    })
});
</script>
@endsection
