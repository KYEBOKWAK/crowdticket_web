@extends('app')

@section('css')
    <style>
        .box-container form {
            padding-left: 2em;
            padding-right: 2em;
        }

        .box-container button[type="submit"] {
            margin-top: 1.5em;
            padding-left: 2em;
            padding-right: 2em;
        }
    </style>
@endsection

@section('content')
    <div class="first-container container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 box-container">
                <h1>비밀번호 찾기</h1>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <br>
                        <br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h5 class="text-center">가입하신 이메일을 입력하시면<br/>새로운 비밀번호를 전송해드립니다.</h5>
                <form role="form" method="POST" action="{{ url('/password/email') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="control-label">이메일</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">새 비밀번호 받기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    ㅇ
@endsection
