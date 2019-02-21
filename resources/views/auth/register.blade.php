@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/project/form.css?version=6') }}"/>
<link rel="stylesheet" href="{{ asset('/css/project/form_body_required.css?version=9') }}"/>
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

        .form-body-default-container{
          width: 470px;
          margin-left: auto;
          margin-right: auto;
        }

        .project_form_title_wrapper{
          text-align: center;
        }

        .project-form-content{
          width: 100%;
          margin-left: 0px;
          padding: 0px 0px;
        }

        .project_form_content_container{
          width: 90%;
          margin-top: 30px;
        }

        .flex_layer_project{
          display: block !important;
        }

        .project-form-content-title{
          display: table;
          text-align: left;
          padding-left: 0px;
        }

        .error{
          font-size: 14px;
          color: red;
          margin-left: 5px;
          font-weight: bold;
        }

        .btn_register_wrapper{
          text-align: center;
          margin-top: 30px;
        }

        .btn_register{
          padding: 8px 44px;
          border-radius: 4px;
          font-size: 15px;
          background-color: #EF4D5D;
          border: 1px solid #EF4D5D;
          font-weight: 500;
          color: white;
        }

        .btn_register:hover{
          color: white;
        }

        .btn_register:focus{
          color: white;
        }

        .project_form_input_base{
          border: 1px solid #cccccc;
          border-radius: 4px;
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        }

        @media (max-width: 768px){
          .reset_wrapper{
            margin-left: auto;
            margin-right: auto;
            width: 100%;
          }
        }

        @media (max-width: 470px){
          .form-body-default-container{
            width: 100%;
          }
        }

        .loading{
          margin-top: 20px;
        }
    </style>

@endsection

@section('content')

<div class="form-body-default-container">
  <div class="project_form_title_wrapper">
    <h2 class="project_form_title"><span class="pointColor">회원</span> 가입</h2>
  </div>
  <div class="project_form_content_container">

    <form id="form_user_register" class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">이름(실명을 입력해주세요)*</p>
          <div class="project-form-content">
            <input id="name" name="name" type="text" class="project_form_input_base" maxlength="255" value="{{ old('name') }}"/>
            <div id="name-error" class="error" style="display:none;"></div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">닉네임(선택)</p>
          <div class="project-form-content">
            <input id="nick_name" name="nick_name" type="text" class="project_form_input_base" maxlength="255" value="{{ old('nick_name') }}"/>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">이메일*</p>
          <div class="project-form-content">
            <input id="email" name="email" type="email" class="project_form_input_base" maxlength="255"/>
            <div id="email-error" class="error" style="display:none;"></div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">비밀번호*</p>
          <div class="project-form-content">
            <input id="password" name="password" type="password" class="project_form_input_base" maxlength="255" required="required"/>
            <div id="password-error" class="error" style="display:none;"></div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">비밀번호 확인*</p>
          <div class="project-form-content">
            <input id="password_confirmation" name="password_confirmation" type="password" class="project_form_input_base" maxlength="255" required="required"/>
            <div id="password_confirmation-error" class="error" style="display:none;"></div>
          </div>
        </div>
      </div>

      <div style="width: 100%; text-align: center;">
        <div class="btn_register_wrapper">
          <button type="button" class="btn btn_register">가입</button>
        </div>
      </div>
      <div class="text-center ps-facebook-wrapper">
          <p style="font-size:15px; font-weight:bold;">또는</p>
          <div class="fb-login-button" scope="public_profile,email" onlogin="checkLoginState();" data-max-rows="1" data-size="large" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="true">
          </div>
      </div>

    </form>

  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('/js/fblogin.js') }}"></script>
<script>
$(document).ready(function () {

  $('#form_user_register').ajaxForm({
    beforeSerialize: function(){
     // form을 직렬화하기전 엘레먼트의 속성을 수정할 수도 있다.
    },
    beforeSubmit : function() {
    //action에 걸어주었던 링크로 가기전에 실행 ex)로딩중 표시를 넣을수도 있다.
    },

    success : function(data) {
      //alert(data);
       //컨트롤러 실행 후 성공시 넘어옴
       loadingProcessStop($(".btn_register_wrapper"));
       if(data.request == 'success')
       {
         //swal("회원가입 성공되었습니다.", "", "success");
         swal("회원가입 성공되었습니다.", {
						  buttons: {
						    save: {
						      text: "확인",
						    },
						  },

							icon: "success",
						}).then(function(value){
							location.reload();
						});
         //location.reload();
       }
       else
       {
         var message = "알 수 없는 에러로 회원가입이 실패하였습니다.";
         if(data.message.email)
         {
           message = data.message.email[0];
         }
         else if(data.message.password)
         {
           message = data.message.password[0];
         }

         swal(message, "", "warning");
       }
    },

    error : function(data) {
        //console.error("에러 ! " + data);
    },
  });

  //valid check
  var validCheck = function(id){
    var element = $("#"+id);
    var value = element.val();
    var errorName = id + "-error";
    var errorElement = $("#" + errorName);

    if(value.length == 0)
    {
      errorElement.show();
      errorElement.text('필수 입력 항목입니다.');

      return false;
    }

    switch(id)
    {
      case "name":
      {
        if(isCheckOnlyEmptyValue(value))
        {
          errorElement.show();
          errorElement.text("공백만 입력되었습니다.");

          return false;
        }
        else
        {
          errorElement.hide();
          errorElement.text('');
        }
      }
      break;

      case "email":
      {
        if(!isCheckEmailWithoutAlert(value))
        {
          errorElement.show();
          errorElement.text("이메일 형식을 만들어주세요.");

          return false;
        }
        else
        {
          errorElement.hide();
          errorElement.text('');
        }
      }
      break;

      case "password":
      {
        if(value.length < 6)
        {
          errorElement.show();
          errorElement.text("비밀번호는 6글자 이상입력해주세요");

          return false;
        }
        else
        {
          errorElement.hide();
          errorElement.text('');
        }
      }
      break;

      case "password_confirmation":
      {
        var passwordValue = $("#password").val();
        if(value === passwordValue)
        {
          errorElement.hide();
          errorElement.text('');
        }
        else
        {
          errorElement.show();
          errorElement.text("비밀번호가 다릅니다.");

          return false;
        }
      }
      break;
    }

    return true;
  };

  $("#name").focusout(function(){
    validCheck($(this)[0].id);
  });

  $("#email").focusout(function(){
    validCheck($(this)[0].id);
  });

  $("#password").focusout(function(){
    validCheck($(this)[0].id);
  });

  $("#password_confirmation").focusout(function(){
    validCheck($(this)[0].id);
  });



  $("#name").keyup(function(){
    validCheck($(this)[0].id);
  });


  $("#email").keyup(function(){
    validCheck($(this)[0].id);
  });

  $("#password").keyup(function(){
    validCheck($(this)[0].id);
  });

  $("#password_confirmation").keyup(function(){
    validCheck($(this)[0].id);
  });

  $(".btn_register").click(function(){
    if(!validCheck("name") || !validCheck("email") ||
        !validCheck("password") || !validCheck("password_confirmation"))
    {
      swal("필수 입력 항목을 확인해주세요.", "", "error");
      return;
    }

    $("#form_user_register").submit();

    loadingProcess($(".btn_register_wrapper"));
  });

/*
  $("#email").focusout(function(){
    var value = $(this).val();
    var errorName = $(this)[0].id + "-error";
    var errorDiv = $("#" + errorName);

    if(!isCheckEmailWithoutAlert(value))
    {
      errorDiv.show();
      errorDiv.text("이메일이 잘못입력되었습니다.");
    }
  });

  $("#email").focus(function(){
    var value = $(this).val();
    var errorName = $(this)[0].id + "-error";
    var errorDiv = $("#" + errorName);
    errorDiv.hide();
  });
  */


});
</script>
@endsection
