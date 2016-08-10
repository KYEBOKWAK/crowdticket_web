@extends('app')

@section('css')
    <style>
        .ps-box {
            background-color: white;
            border: 1px #dad8cc solid;
            border-radius: 5px;
            padding: 25px;
            margin-bottom: 40px;
        }

        .ps-text-detail {
            margin-top: 5em;
        }
        .ps-text-detail strong {
            font-size: 1.2em;
        }
    </style>
@endsection

@section('content')
    <div class="container first-container">
        @include ('order.header', ['project' => $project, 'step' => 3])
        <div class="row ps-box">
            <div class="col-md-12">
                <h2 class="text-center"><strong>THANK YOU!</strong></h2>
                @if ($project->type === 'funding')
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
                @else
                    <h3 class="text-center"><strong>결제가 완료되었습니다.</strong></h3>
                    <p class="text-center ps-text-detail">
                        <strong>오른쪽 상단 '결제확인' 탭에서 확인해보세요!</strong>
                    </p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{ url('/projects') }}" class="btn btn-success ">더 둘러보기</a>
            </div>
        </div>
    </div>
@endsection
