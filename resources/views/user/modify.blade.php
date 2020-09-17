@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/project/form.css?version=8') }}"/>
<link rel="stylesheet" href="{{ asset('/css/project/form_body_required.css?version=13') }}"/>
    <style>
    /*
        #main {
            background-image: url('{{ asset("/img/app/process_bg.jpg") }}');
            background-position: center;
            background-size: cover;
        }
*/

        .box-container .btn[type="submit"] {
            width: 150px;
            display: block;
            margin: 10px auto 0 auto;
        }

        .box-container .user-photo-middle {
            margin-right: 30px;
        }

        .box-container .form-group label.error {
            color: #d9534f;
        }

        #input-user-name,
        .ps-password-group input {
            width: 50%;
        }

        .ps-password-group input {
            margin-bottom: 10px;
        }

        .user-photo-middle {
            margin-bottom: 15px;
        }

        #upload-photo-fake {
            margin-top: 35px;
        }

        #input-contact {
            width: 50%;
        }


        /*new modify*/
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

        .btn_user_info_update_wrapper{
          text-align: center;
          margin-top: 30px;
        }

        .btn_user_info_update{
          padding: 8px 44px;
          border-radius: 4px;
          font-size: 15px;
          background-color: #EF4D5D;
          border: 1px solid #EF4D5D;
          font-weight: 500;
          color: white;
        }

        .btn_user_info_update:hover{
          color: white;
        }

        .btn_user_info_update:focus{
          color: white;
        }

        .password_form_custom{
          margin-bottom: 10px;
        }

        .project_form_input_base{
          border: 1px solid #cccccc;
          border-radius: 4px;
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        }

        .modify_popup_user_gender_input[type="radio"]{
          width: 20px;
          margin-right: 0px;
          position: relative;
          opacity: 0;
          zoom: 1;
        }

        #modify_popup_user_age_text{
          margin-left: 16px;
          margin-right: auto;
          font-size: 14px;
        }

        .modify_age_user_select{
          width: 100%;
          height: 100%;
          opacity: 0;
        }

        @media (max-width: 470px){
          .form-body-default-container{
            width: 100%;
          }
        }
    </style>
@endsection

@section('content')
<div class="form-body-default-container">
  <div class="project_form_title_wrapper">
    <h2 class="project_form_title"><span class="pointColor">내 정보</span> 수정</h2>
  </div>
  <div class="project_form_content_container">

    <form id="form_user_info_update" action="{{ url('/users') }}/{{ $user->id }}" method="post" data-toggle="validator" role="form"
          enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">프로필 사진</p>
          <div class="project-form-content">
            <div class="flex_layer">
              <div id="user-photo" class="user-photo-middle bg-base pull-left" style="background-image: url('{{ $user->getPhotoUrl() }}');">
              </div>
              <div id="user-default-photo" class="user-photo-middle bg-base pull-left" style="display: none; background-image: url('{{ asset('/img/app/default-user-image.png') }}');">
              </div>

              <div style="width: 60px; margin-top: 82px;">
                <a href="javascript:void(0);" style="cursor:pointer" id="profile-upload-photo-fake"><img src="https://img.icons8.com/windows/50/333333/pencil.png" class="ticket_tickets_button_wrapper"/></a>
                <a href="javascript:void(0);" style="cursor:pointer" id="profile-delete-photo"><img src="https://img.icons8.com/windows/50/EF4D5D/trash.png" class="ticket_tickets_button_wrapper"/></a>
              </div>

              <input id="input-user-photo" type="file" name="photo" style="width: 0px; height: 0px; visibility: hidden"/>
              <input id="isdeletephoto" type="hidden" name="isdeletephoto" value=""/>
            </div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">이름(실명을 입력해주세요)*</p>
          <div class="project-form-content">
            <input id="name" name="name" type="text" class="project_form_input_base" maxlength="255" value="{{ $user->name }}"/>
            <div id="name-error" class="error" style="display:none;"></div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">이메일(변경불가)</p>
          <div class="project-form-content">
            <input type="text" class="project_form_input_base" maxlength="255" value="{{ $user->email }}" readonly="readonly"/>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">닉네임(선택)</p>
          <div class="project-form-content">
            <input id="nick_name" name="nick_name" type="text" class="project_form_input_base" maxlength="255" value="{{ $user->nick_name }}"/>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">연락처</p>
          <div class="project-form-content">
            <input id="input-contact" name="contact" type="tel" class="project_form_input_base" maxlength="11" value="{{ $user->contact }}"/>
            <div id="input-contact-error" class="error" style="display:none;"></div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">성별*</p>
          <div class="project-form-content">
            <div class='register_popup_user_options_container flex_layer'>
              <div class='register_radio_wrapper'>
                <img src="{{ asset('/img/icons/svg/radio-btn-s.svg') }}" class='register_radio_img register_radio_img_select modify_radio_type_m_select' />
                <img src="{{ asset('/img/icons/svg/radio-btn-n.svg') }}" class='register_radio_img register_radio_img_unselect modify_radio_type_m_unselect' />
                <input class='modify_popup_user_gender_input' type='radio' name='modify_gender' value='m'/>
              </div>
              <p class='register_popup_user_option_gender_text' style='margin-right: 40px;'>남</p> 
              <div class='register_radio_wrapper'>
                <img src="{{ asset('/img/icons/svg/radio-btn-s.svg') }}" class='register_radio_img register_radio_img_select modify_radio_type_f_select' />
                <img src="{{ asset('/img/icons/svg/radio-btn-n.svg') }}" class='register_radio_img register_radio_img_unselect modify_radio_type_f_unselect' />
                <input class='modify_popup_user_gender_input' type='radio' name='modify_gender' value='f'/>
              </div>
              <p class='register_popup_user_option_gender_text'>여</p> 
            </div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">년생*</p>
          <div class="project-form-content">
            <div class='register_popup_user_age_container'> 
              <div class='register_popup_city_text_container flex_layer'>
                <p id='modify_popup_user_age_text'>년도 선택</p>
                <img src="{{ asset('/img/icons/svg/icon-box.svg') }}" style='margin-right: 16px;'>
              </div>
              <select class='modify_age_user_select' name='modify_age_user'>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="project_form_input_container">
        <div class="flex_layer_project">
          <p class="project-form-content-title">비밀번호 변경</p>
          <div class="project-form-content">
            <input id="input-user-password" name="old_password" type="password" maxlength="32"
                   class="project_form_input_base password_form_custom" placeholder="현재 비밀번호"/>
            <div id="input-user-password-error" class="error" style="display:none;"></div>

            <input id="input-user-password-new" name="new_password" type="password" maxlength="32"
                   class="project_form_input_base password_form_custom" placeholder="새로운 비밀번호"/>
            <div id="input-user-password-new-error" class="error" style="display:none;"></div>

            <input id="input-user-password-re" name="new_password_confirmed" type="password"
                   class="project_form_input_base password_form_custom" maxlength="32" placeholder="비밀번호 확인"/>
            <div id="input-user-password-re-error" class="error" style="display:none;"></div>
          </div>
        </div>
      </div>

      <div class="btn_user_info_update_wrapper">
        <button type="button" class="btn btn_user_info_update">변경하기</button>
      </div>
      @include('form_method_spoofing', [
          'method' => 'put'
      ])
    </form>

    @if ($toast)
        <input type="hidden" id="toast" class="{{ $toast['level'] }}"
               value="{{ $toast['message'] }}"/>
    @endif

  </div>
</div>

@endsection

@section('js')
    <script>
        const MODIFY_AGE_NONE_TYPE_OPTION = 9999;//선택되지 않은 년생 option 값
        $(document).ready(function () {
          var registerAgeOptions = '';
          var nowYear = Number(new Date().getFullYear());
          for(var i = 1900 ; i <= nowYear ; i++ )
          {
            registerAgeOptions += "<option value='"+ i +"'>" + i + "</option>";
          }

          //마지막 옵션은 나이 선택란.
          registerAgeOptions += "<option value='"+ MODIFY_AGE_NONE_TYPE_OPTION +"' selected>" + "년도 선택" + "</option>";
          ///////

          $('.modify_age_user_select').append(registerAgeOptions);
          

            var validCheck = function(id){
              var element = $("#"+id);
              var value = element.val();
              var errorName = id + "-error";
              var errorElement = $("#" + errorName);

              switch(id)
              {
                case "name":
                {
                  if(value.length == 0)
                  {
                    errorElement.show();
                    errorElement.text('필수 입력 항목입니다.');

                    return false;
                  }
                  else if(isCheckOnlyEmptyValue(value))
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

                case "input-user-password":
                case "input-user-password-new":
                {
                  if(value.length == 0)
                  {
                    errorElement.hide();
                    errorElement.text('');
                  }
                  else if(value.length < 6)
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

                case "input-user-password-re":
                {
                  var passwordValue = $("#input-user-password-new").val();
                  if(value === passwordValue)
                  {
                    errorElement.hide();
                    errorElement.text('');
                  }
                  else if(value.length == 0)
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

            $(".btn_user_info_update").click(function(){
              if(!validCheck("name") || !validCheck("input-user-password") ||
                !validCheck("input-user-password-new") || !validCheck("input-user-password-re"))
              {
                swal("필수 입력 항목을 확인해주세요.", "", "error");
                return;
              }

              if(!$('input:radio[name=modify_gender]:checked').val()){
                alert("성별을 선택해주세요.");
                return;
              };

              if(Number($(".modify_age_user_select").val()) === MODIFY_AGE_NONE_TYPE_OPTION){
                alert("생년을 선택해주세요.");
                return;
              };

              $("#form_user_info_update").submit();
            });



            $("#name").keyup(function(){
              validCheck($(this)[0].id);
            });

            $("#input-user-password").keyup(function(){
              validCheck($(this)[0].id);
            });

            $("#input-user-password-new").keyup(function(){
              validCheck($(this)[0].id);
            });

            $("#input-user-password-re").keyup(function(){
              validCheck($(this)[0].id);
            });


            $("#name").focusout(function(){
              validCheck($(this)[0].id);
            });

            $("#input-user-password").focusout(function(){
              validCheck($(this)[0].id);
            });

            $("#input-user-password-new").focusout(function(){
              validCheck($(this)[0].id);
            });

            $("#input-user-password-re").focusout(function(){
              validCheck($(this)[0].id);
            });


            var performProfileFileClick = function(){
          		$('#input-user-photo').trigger('click');
          	};

          	var onProfileChanged = function(){
          		if (this.files && this.files[0]) {
          			var reader = new FileReader();
          			reader.onload = function(e) {
          				$('#user-photo').show();
          				$('#user-default-photo').hide();
          				$('#isdeletephoto').val('');
          				$('#user-photo').css('background-image', "url('" + e.target.result + "')");
          			};
          			reader.readAsDataURL(this.files[0]);
          		}
          	};

          	var deleteProfileFile = function(){
          		if ($.browser.msie)
          		{
          	 		// ie 일때 input[type=file] init.
          			$("#input-user-photo").replaceWith( $("#input-user-photo").clone(true) );
          		}
          		else
          		{
          			// other browser 일때 input[type=file] init.
          			$("#input-user-photo").val("");
          		}

          		$('#isdeletephoto').val('TRUE');
          		$('#user-photo').hide();
          		$('#user-default-photo').show();
          	};

          	//$('#save_creator').bind('click', saveCreator);
          	$('#profile-upload-photo-fake').bind('click', performProfileFileClick);
          	$('#input-user-photo').change(onProfileChanged);
          	//$('#creator_form').ajaxForm(profileAjaxOption);

          	$('#profile-delete-photo').bind('click', deleteProfileFile);

            var toast = $('#toast').val();
            if(toast)
            {
              var level = $('#toast').attr('class');
              showToast(level, toast);
            }

            var setModifyRadioInputImg = function(){
              if($('input:radio[name=modify_gender]:checked').val() === 'm'){
                $('.modify_radio_type_m_select').show();
                $('.modify_radio_type_m_unselect').hide();

                $('.modify_radio_type_f_select').hide();
                $('.modify_radio_type_f_unselect').show();
              }
              else{
                $('.modify_radio_type_m_select').hide();
                $('.modify_radio_type_m_unselect').show();

                $('.modify_radio_type_f_select').show();
                $('.modify_radio_type_f_unselect').hide();
              }
            }

            if($("#user_gender").val())
            {
              console.log($("#user_gender").val());
              $('input:radio[name=modify_gender]:input[value=' + $("#user_gender").val() + ']').attr("checked", true); 
              setModifyRadioInputImg();
            }

            $('.modify_popup_user_gender_input').click(function(){
              setModifyRadioInputImg();
            });

            if($("#user_age").val())
            {
              $(".modify_age_user_select").val($("#user_age").val());
              $("#modify_popup_user_age_text").text($("#user_age").val());
            }

            $(".modify_age_user_select").change(function(){
              if(Number($(this).val()) === MODIFY_AGE_NONE_TYPE_OPTION)
              {
                $("#modify_popup_user_age_text").text("년도 선택");
              }
              else
              {
                $("#modify_popup_user_age_text").text($(this).val());
              }
              
            });

            $("#form_user_info_update").ajaxForm({
              beforeSerialize: function(){
              // form을 직렬화하기전 엘레먼트의 속성을 수정할 수도 있다.
              },
              beforeSubmit : function() {
              //action에 걸어주었던 링크로 가기전에 실행 ex)로딩중 표시를 넣을수도 있다.
              },

              success : function(data) {
                //alert(data);
                //컨트롤러 실행 후 성공시 넘어옴
                //window.location.reload();
                swal("정보 수정 완료", "", "success");
              },

              error : function(data) {
                  //console.error("에러 ! " + data);
              },
            })
        });
    </script>
@endsection
