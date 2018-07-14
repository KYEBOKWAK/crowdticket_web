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

        a.btn-link {
            color: #333;
        }

        .ps-facebook-wrapper {
            margin-top: 1em;
        }
    </style>
@endsection

@section('content')
    <div class="first-container container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 box-container">
                <h1>로그인</h1>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form role="form" method="POST" action="{{ url('/auth/login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="control-label">이메일</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                               required="required">
                    </div>

                    <div class="form-group">
                        <label class="control-label">비밀번호</label>
                        <input type="password" class="form-control" name="password" required="required">
                    </div>

                    <div class="form-group text-center">
                        <a class="btn btn-link" href="{{ url('/password/email') }}">비밀번호가 기억나지 않나요?</a>
                        <button type="submit" class="btn btn-default center-block">로그인</button>
                    </div>
                </form>
                <!--
                <div class="text-center ps-facebook-wrapper">
                                    <p>또는</p>
                                    <a href="{{ url('/facebook') }}" class="btn btn-primary">FACEBOOK으로 로그인</a>
                                </div>
                -->
                <div class="text-center ps-facebook-wrapper">
                    <p>또는</p>
                    <div class="fb-login-button" scope="public_profile,email" onlogin="checkLoginState();" data-max-rows="1" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="true"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('/js/fblogin.js') }}"></script>
@endsection
