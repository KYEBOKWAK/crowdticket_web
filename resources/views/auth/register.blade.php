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

        .ps-facebook-wrapper {
            margin-top: 1em;
        }

        @media (max-width: 768px){
          .reset_wrapper{
            margin-left: auto;
            margin-right: auto;
            width: 100%;
          }
        }
    </style>
@endsection

@section('content')
    <div class="first-container container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 box-container reset_wrapper">
                <h1>회원가입</h1>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="control-label">이름</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                               required="required">
                    </div>

                    <div class="form-group">
                        <label class="control-label">이메일</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                               required="required">
                    </div>

                    <div class="form-group">
                        <label class="control-label">비밀번호</label>
                        <input type="password" class="form-control" name="password" required="required">
                    </div>

                    <div class="form-group">
                        <label class="control-label">비밀번호 확인</label>
                        <input type="password" class="form-control" name="password_confirmation" required="required">
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-default">가입</button>
                    </div>
                </form>
                <div class="text-center ps-facebook-wrapper">
                    <p>또는</p>
                    <div id="fb-login-button" class="fb-login-button" scope="public_profile,email" onlogin="checkLoginState();" data-max-rows="1" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="true"></div>
                    <!-- <a href="{{ url('/facebook') }}" class="btn btn-primary">FACEBOOK으로 가입</a> -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('/js/fblogin.js') }}"></script>
@endsection
