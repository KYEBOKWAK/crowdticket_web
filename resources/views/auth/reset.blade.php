@extends('app')

@section('css')
    <style>
        .first-container .panel {
            margin-top: 5em;
        }
    </style>
@endsection

@section('content')
    <div class="first-container container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">비밀번호 초기화</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="resetPasswordForm" class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            @include('form_method_spoofing', ['method' => 'post'])

                            <div class="form-group">
                                <label class="col-md-4 control-label">이메일 주소</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">새로운 비밀번호</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">비밀번호 확인</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <!-- <button type="submit" class="btn btn-primary">
                                        비밀번호 변경
                                    </button> -->
                                    <input id="password-reset-button" type="button" class="btn btn-primary" value="비밀번호 변경"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

<script>
  $(document).ready(function() {

    var resetAjaxOption = {
		'beforeSerialize': function($form, options) {
			$goods_img_file = $('#goods_img_file');

		},
		'success': function(result) {
            loginCallback = function(){
                var base_url = window.location.origin;
                window.location.href = base_url;
            }
            loginAjaxSuccess(result);
			// loadingProcessStop($("#password-reset-button"));
		},
		'error': function(data) {
            alert("비밀번호 초기화에 실패했습니다.");
            loadingProcessStop($("#password-reset-button"));
		}
    };
    
    $('#resetPasswordForm').ajaxForm(resetAjaxOption);

    $("#password-reset-button").click(function(){
        loadingProcess($("#password-reset-button"));

        $('#resetPasswordForm').submit();
        
    })
  });
</script>

@endsection