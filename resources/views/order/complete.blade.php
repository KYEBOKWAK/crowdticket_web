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

        .ps-info {
            margin-top: 40px;
            margin-bottom: 40px;
            font-size: 14px;
        }
    </style>
@endsection

@section('content')
    <div class="container first-container">
        @include ('order.header', ['project' => $project, 'step' => 3])
        <div class="row ps-box">
            <div class="col-md-12">
                <h2 class="text-center"><strong>THANK YOU!</strong></h2>
                <h3 class="text-center"><strong>참여가 완료되었습니다.</strong></h3>

                @if ($order->price > 0)
                    <div class="text-center text-danger">
                        오른쪽 상단 '결제확인' 탭에서 관리하세요!
                    </div>
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
