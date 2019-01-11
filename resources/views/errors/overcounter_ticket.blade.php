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
    </style>
@endsection

@section('content')
    <div class="container first-container">
        <div class="row ps-box">
            <div class="col-md-12">
                <h2 class="text-center"><strong>결제 실패</strong></h2>
                    <h3 class="text-center">
                      <strong>
                        수량이 초과 되었습니다.
                      </strong>
                    </h3>
                    <p class="text-center ps-text-detail">
                        <strong>
                            ㅠ.ㅠ 안타깝게 티켓팅에 실패하셨네요... 다음기회를 노려보세요!
                        </strong>
                    </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{ url() }}" class="btn btn-success ">더 둘러보기</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
