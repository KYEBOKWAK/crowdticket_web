var scripts = document.getElementsByTagName('script');

var myScript = scripts[ scripts.length - 1 ];

var queryString = myScript.src.replace(/^[^\?]+\??/,'');

var params = parseQuery( queryString );

var g_facebookAccessId = params['fbid'];
var g_facebookAccessVer = params['fbver'];

var g_googleAccessId = params['ggid'];

var googleLogoURL = $("#asset_url").val() + 'img/app/g-logo.png';

var radioSelectImg = $("#asset_url").val() + 'img/icons/svg/radio-btn-s.svg';
var radioUnSelectImg = $("#asset_url").val() + 'img/icons/svg/radio-btn-n.svg';

var checkboxSelectImg = $("#asset_url").val() + 'img/icons/svg/ic-checkbox-btn-s.svg';
var checkboxUnSelectImg = $("#asset_url").val() + 'img/icons/svg/ic-checkbox-btn-n.svg';

var iconboxImg = $("#asset_url").val() + 'img/icons/svg/icon-box.svg';

const REGISTER_AGE_NONE_TYPE_OPTION = 9999;//선택되지 않은 년생 option 값

//asset('/img/icons/svg/radio-btn-s.svg')
//asset('/img/icons/svg/radio-btn-n.svg')
var jQuery_loginPopup = null;
var loginCallback = null;

// 'id' : socialId,
//         'name' : socialName,
//         'email' : socialEmail,
//         'profile_photo_url' : socialPhotoUrl,
//         'type' : 'FACEBOOK'
//Login Javascript
jQuery_loginPopup = $;

$(document).ready(function() {  
  // jQuery_loginPopup = $;

  $('#g_login').click(function(){
    loginPopup(null, null);
  });

  $('#g_register').click(function(){
    registerPopup(null, null);
  });
});

//social login start

function loginAjaxSuccess(request){
  if(request.state == 'success')
  {
    reStartDocumentScroll();
    setLoginID(request.user_id);

    //데이터 수집 코드 START
    window.dataLayer = window.dataLayer || []
    dataLayer.push({
      memberType: request.user_id,
      memberAge: '',
      memberGender: '',
      event: 'loginComplete'
    });
    //데이터 수집 코드 END

    if(loginCallback)
    {
      // loginCallback();
      $('.login_react_callback').trigger('click');
    }
    else
    {
      // window.location.reload();
      $('.login_react').trigger('click');
    }
  }
  else if(request.state == 'fail')
  {
    $('#login_error_message').show();
    $('#login_error_message').text(request.message);
    //console.error("fail " + result.message);
  }
  else
  {
    $('#login_error_message').show();

    //$('#login_error_message').text('이미 로그인 되어 있습니다. 창을 닫고 새로고침 해주세요.');
    $('#login_error_message').text('이미 가입 되어 있는 이메일 입니다. 로그인 해주세요.');
  }
}

function goSocialLogin(data){
  var url = '/social/gologin';
  var method = 'post';

  var success = function(result) {
    //console.error("로그인완료 !" + JSON.stringify(result));
    loginAjaxSuccess(result);
  };

  var error = function(request, status) {
    swal("로그인 실패", "", "error")
  };

  if(jQuery_loginPopup)
  {
    jQuery_loginPopup.ajax({
      'url': url,
      'method': method,
      'data': data,
      'success': success,
      'error': error
    });
  }
};

//facebook Login START
function statusChangeCallback(response) {
  //console.error(response);
  if (response.status === 'connected') {
    // Logged into your app and Facebook.

    var url = '/me?fields=id,name,email';
    FB.api(url, function(responseMe) {

      var socialId = responseMe.id;
      var socialName = responseMe.name;
      var socialEmail = responseMe.email;
      var socialPhotoUrl = "https://graph.facebook.com/"+socialId+"/picture?type=normal";

      goSocialLogin({
        'id' : socialId,
        'name' : socialName,
        'email' : socialEmail,
        'profile_photo_url' : socialPhotoUrl,
        'type' : 'FACEBOOK'
      });
    });

  } else {
    // The person is not logged into your app or we are unable to tell.
    FB.login(function(response) {
      if (response.status === 'connected') {
        statusChangeCallback(response);
      }
    });
  }
}

function checkLoginState() {
  FB.getLoginStatus(function(response) {
    //console.error(respose);
  });
}

//register test
//Login Javascript END

function startFacebookLogin(){
  FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
  });
}

function facebookLibInit(){

  window.fbAsyncInit = function() {
    FB.init({
      appId      : g_facebookAccessId,
      cookie     : true,  // enable cookies to allow the server to access
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : g_facebookAccessVer // use graph api version 2.8
    });

    console.error("FB Init Success!!!!!");

    FB.getLoginStatus(function(response) {
        //console.error(response);
    });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  //facebook Login END
}

//facebook login END

//google login started

function attachSignin(element) {
  auth2.attachClickHandler(element, {},
      function(googleUser) {
        //console.error("google!! : " + googleUser.getBasicProfile().getName());
        //console.error(JSON.stringify(googleUser));
        var socialId = googleUser.getBasicProfile().getId();
        var socialName = googleUser.getBasicProfile().getName();
        var socialEmail = googleUser.getBasicProfile().getEmail();
        var socialPhotoUrl = googleUser.getBasicProfile().getImageUrl();;

        //console.error(socialId + socialName + socialEmail + " | " + socialPhotoUrl);

        goSocialLogin({
          'id' : socialId,
          'name' : socialName,
          'email' : socialEmail,
          'profile_photo_url' : socialPhotoUrl,
          'type' : 'GOOGLE'
        });

      }, function(error) {
        //alert(JSON.stringify(error, undefined, 2));
      });
}

function googleLibInit(){
  setTimeout(function(){
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: g_googleAccessId,
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
  
      var userAgent = window.navigator.userAgent;
      var isKakao = userAgent.indexOf('KAKAOTALK');
      //alert(isKakao);
      if(isKakao > 0)
      {
        $('#login_social_google_button_wrapper').click(function(){
          alert('카카오톡 브라우저에선 구글 로그인이 불가능합니다.');
        });
      }
      else
      {
        attachSignin(document.getElementById('login_social_google_button_wrapper'));
      }
    });
  }, 100);
    
  
  /*
  gapi.load('auth2', function(){
    // Retrieve the singleton for the GoogleAuth library and set up the client.
    auth2 = gapi.auth2.init({
      client_id: g_googleAccessId,
      cookiepolicy: 'single_host_origin',
      // Request scopes in addition to 'profile' and 'email'
      //scope: 'additional_scope'
    });

    var userAgent = window.navigator.userAgent;
    var isKakao = userAgent.indexOf('KAKAOTALK');
    //alert(isKakao);
    if(isKakao > 0)
    {
      $('#login_social_google_button_wrapper').click(function(){
        alert('카카오톡 브라우저에선 구글 로그인이 불가능합니다.');
      });
    }
    else
    {
      attachSignin(document.getElementById('login_social_google_button_wrapper'));
    }
  });
  */
};

//google login end
//social login end

//로그인 팝업 생성
function loginPopup(successFunc, closeFunc){
  console.log("loginPOP!!");
  if(jQuery_loginPopup == null)
  {
    return;
  }

  //if(successFunc)
  //{
    loginCallback = successFunc;
  //}
  
  if(isLogin())
  {
    if(loginCallback)
    {
      loginCallback();
    }
    
    return;
  }
  var elementPopup = document.createElement("div");
  elementPopup.innerHTML =
  "<div class='loginpopup_container'>"+
  "<h1>로그인</h1>" +
  "<div id='login_error_message' class='alert alert-danger' style='display:none;'></div>" +
  "<div style='width:100%; text-align:center;'>" +
  "</div>" +
  "<div id='login_social_button_container'>" +
    "<button id='login_social_facebook_button_wrapper'>" +
      "<img src='https://static.xx.fbcdn.net/rsrc.php/v3/yj/r/AHNFF9E2KeQ.png' style='width:30px;height:30px;margin-bottom:4px;margin-right:5px;'/>" +
      "<span style='font-weight:500;margin-right:5px;'>" + "페이스북 로그인" + "</span>" +
    "</button>" +

    //"<div class='g-signin2' data-onsuccess='onSignIn'></div>" +
    "<button id='login_social_google_button_wrapper'>" +
      "<img src="+googleLogoURL+" style='width:18px;height:18px;margin-bottom:4px;margin-right:5px;'/>" +
      //"<span class='icon'></span>" +
      "<span style='font-weight:500;margin-right:5px;'>" + "구글 로그인" + "</span>" +
    "</button>" +

    "<p>또는</p>" +
  "</div>" +

      "<div class='form-group'>" +
          "<label class='control-label'>이메일</label>" +
          "<input id='loginpopup_email' type='email' class='form-control' name='email' required='required'>" +
      "</div>" +

      "<div class='form-group'>" +
          "<label class='control-label'>비밀번호</label>" +
          "<input id='loginpopup_password' type='password' class='form-control' name='password' required='required'>" +
      "</div>" +

      "<div class='form-group text-center'>" +
        "<button id='login_button' type='button' class='btn btn-default center-block'>로그인</button>" +
      "</div>" +

      "<div style='border-bottom: 1px #dad8cc solid; margin-bottom:13px; text-align: center; padding-bottom:18px;'>" +
      "<p>크라우드티켓이 처음이세요?</p>" +
      "<a id='register_go' href='javascript:;' onclick=''><p style='font-weight: bold;'><u>10초 만에 가입하기!</u></p></a>" +
      "</div>" +

      "<div style='text-align:center;'>" +
        "<a id='forget_password' class='btn btn-link'>비밀번호가 기억나지 않나요?</a>" +
      "</div>" +

  "</div>";

  stopDocumentScroll();
  swal({
      //title: "로그인",
      content: elementPopup,
      confirmButtonText: "V redu",
      //allowOutsideClick: true,
      closeOnClickOutside: false,

      buttons: {
        close: {
          text: "닫기",
          value: "close",
        },
      },

  }).then(function(value){
    reStartDocumentScroll();
    if(closeFunc)
    {
      closeFunc();
    }
  });

  $('#forget_password').click(function(){
    var url = $('#base_url').val() + '/password/email';
    window.location.href = url;
  });

  $('#register_go').click(function(){
    registerPopup(successFunc, closeFunc);
  });

  $('#login_button').click(function(){
    $('#login_error_message').hide();
    var url = '/auth/login';
    var method = 'post';
    var data =
    {
      "email" : $('#loginpopup_email').val(),
      "password" : $('#loginpopup_password').val(),
      "ispopup" : 'TRUE',
    }

    var success = function(result) {
      console.error("로그인완료 !" + result);
      // $(".login_react").trigger('click');
      loginAjaxSuccess(result);
    };

    var error = function(request, status) {
      swal("로그인 실패", "", "error");
    };

    if(jQuery_loginPopup)
    {
      jQuery_loginPopup.ajax({
        'url': url,
        'method': method,
        'data': data,
        'success': success,
        'error': error
      });
    }
  });

  facebookLibInit();
  googleLibInit();

  $('#login_social_facebook_button_wrapper').click(function(){
    startFacebookLogin();
  });

  $('#login_social_google_button_wrapper').click(function(){
    //startApp();
  });
}

function registerPopup(successFunc, closeFunc){
  if(jQuery_loginPopup == null)
  {
    return;
  }

  if(successFunc)
  {
    loginCallback = successFunc;
  }

  //option
  var registerAgeOptions = '';
  var nowYear = Number(new Date().getFullYear());
  for(var i = 1900 ; i <= nowYear ; i++ )
  {
    registerAgeOptions += "<option value='"+ i +"'>" + i + "</option>";
  }

  //마지막 옵션은 나이 선택란.
  registerAgeOptions += "<option value='"+ REGISTER_AGE_NONE_TYPE_OPTION +"' selected>" + "년도 선택" + "</option>";
  ///////

  var registerAgeUnderage = nowYear - 14;

  var elementPopup = document.createElement("div");
  elementPopup.innerHTML =
  "<div class='form-body-default-container'>" +
    "<div class='project_form_title_wrapper'>" +
      "<h1 style='font-size:32px; font-weight:500;'>회원가입</h1>" +
    "</div>" +
    "<div class='project_form_content_container'>" +
      "<div id='login_error_message' class='alert alert-danger' style='display:none;'></div>" +
        "<div class='project_form_input_container'>" +
            "<p class='project-form-content-title'>이름(실명을 입력해주세요)*</p>" +
            "<div class='project-form-content'>" +
              "<input id='name' name='name' type='text' class='form-control' maxlength='255'/>" +
              "<div id='name-error' class='error' style='display:none;'></div>" +
            "</div>" +
        "</div>" +

        "<div class='project_form_input_container_nm'>" +
            "<p class='project-form-content-title'>성별*</p>" +
            "<div class='project-form-content'>" +
              "<div class='register_popup_user_options_container flex_layer'>" + 
                "<div class='register_radio_wrapper'>" +
                  "<img src="+radioSelectImg+" class='register_radio_img register_radio_img_select register_radio_type_m_select' />" +
                  "<img src="+radioUnSelectImg+" class='register_radio_img register_radio_img_unselect register_radio_type_m_unselect' />" +
                  "<input class='register_popup_user_gender_input' type='radio' name='register_gender' value='m'/>" +
                "</div>" +
                "<p class='register_popup_user_option_gender_text' style='margin-right: 40px;'>남</p>" + 
                "<div class='register_radio_wrapper'>" +
                  "<img src="+radioSelectImg+" class='register_radio_img register_radio_img_select register_radio_type_f_select' />" +
                  "<img src="+radioUnSelectImg+" class='register_radio_img register_radio_img_unselect register_radio_type_f_unselect' />" +
                  "<input class='register_popup_user_gender_input' type='radio' name='register_gender' value='f'/>" +
                "</div>" +
                "<p class='register_popup_user_option_gender_text'>여</p>" + 
              "</div>" +
            "</div>" +
        "</div>" +

        "<div class='project_form_input_container'>" +
            "<p class='project-form-content-title'>출생 연도*</p>" +
            "<div class='project-form-content'>" +
              "<div class='register_popup_user_age_container'>" + 
                "<div class='register_popup_city_text_container flex_layer'>" +
                  "<p id='register_popup_user_age_text'>연도 선택</p>" +
                  "<img src="+iconboxImg+" style='margin-right: 16px; padding-bottom: 8px'>" +
                "</div>" +
                "<select class='register_age_user_select' name='register_age_user'>" +
                  registerAgeOptions +
                "</select>" +
              "</div>" +
            "</div>" +
        "</div>" +

        "<div class='project_form_input_container'>" +
          //"<div class='flex_layer_project'>" +
            "<p class='project-form-content-title'>닉네임(선택)</p>" +
            "<div class='project-form-content'>" +
              "<input id='nick_name' name='nick_name' type='text' class='form-control' maxlength='255'/>" +
            "</div>" +
          //"</div>" +
        "</div>" +

        "<div class='project_form_input_container'>" +
            "<p class='project-form-content-title'>이메일*</p>" +
            "<div class='project-form-content'>" +
              "<input id='email' name='email' type='email' class='form-control' maxlength='255'/>" +
              "<div id='email-error' class='error' style='display:none;'></div>" +
            "</div>" +
        "</div>" +

        "<div class='project_form_input_container'>" +
          //"<div class='flex_layer_project'>" +
            "<p class='project-form-content-title'>비밀번호*</p>" +
            "<div class='project-form-content'>" +
              "<input id='password' name='password' type='password' class='form-control' maxlength='255' required='required'/>" +
              "<div id='password-error' class='error' style='display:none;'></div>" +
            "</div>" +
          //"</div>" +
        "</div>" +

        "<div class='project_form_input_container'>" +
          //"<div class='flex_layer_project'>" +
            "<p class='project-form-content-title'>비밀번호 확인*</p>" +
            "<div class='project-form-content'>" +
              "<input id='password_confirmation' name='password_confirmation' type='password' class='form-control' maxlength='255' required='required'/>" +
              "<div id='password_confirmation-error' class='error' style='display:none;'></div>" +
            "</div>" +
          //"</div>" +
        "</div>" +

        "<div class='project_form_input_container'>" +
          "<div class='login-form-checklist flex_layer'>" +
            "<div class='meetup_checkbox_wrapper'>" +
              "<input id='overage_agreement' style='zoom: 1' type='checkbox' class='agreement_inputbox' value=''/>" +
              "<img class='overage_checkbox_img overage_checkbox_img_select' src="+checkboxSelectImg+">" +
              "<img class='overage_checkbox_img overage_checkbox_img_unselect' src="+checkboxUnSelectImg+">" +
              "만 14세 이상입니다 (필수)" +
          "</div>" +
          "</div>" +
          "<div class='login-form-checklist flex_layer'>" +
            "<div class='meetup_checkbox_wrapper'>" +
              "<input id='policy_agreement' style='zoom: 1' type='checkbox' class='agreement_inputbox' value=''/>" +
              "<img class='policy_checkbox_img policy_checkbox_img_select' src="+checkboxSelectImg+">" +
              "<img class='policy_checkbox_img policy_checkbox_img_unselect' src="+checkboxUnSelectImg+">" +
              "<a href='/terms' target='_blank'><u>크라우드티켓 이용약관</u></a> 동의 (필수)" +
            "</div>" +
          "</div>" +
          "<div class='login-form-checklist flex_layer'>" +
            "<div class='meetup_checkbox_wrapper'>" +
              "<input id='privacy_agreement' style='zoom: 1' type='checkbox' class='agreement_inputbox' value=''/>" +
              "<img class='privacy_checkbox_img privacy_checkbox_img_select' src="+checkboxSelectImg+">" +
              "<img class='privacy_checkbox_img privacy_checkbox_img_unselect' src="+checkboxUnSelectImg+">" +
              "<a href='/join_agree' target='_blank'><u>개인정보 수집이용</u></a> 동의 (필수)" +
            "</div>" +
          "</div>" +

          /* 추후 적용예정
          "<div class='login-form-checklist flex_layer'>" +
            "<div class='meetup_checkbox_wrapper'>" +
              "<input id='marketing_agreement' style='zoom: 1' type='checkbox' class='agreement_inputbox' value=''/>" +
              "<img class='marketing_checkbox_img marketing_checkbox_img_select' src="+checkboxSelectImg+">" +
              "<img class='marketing_checkbox_img marketing_checkbox_img_unselect' src="+checkboxUnSelectImg+">" +
              "<a href='/marketing_agree' target='_blank'><u>광고성 정보 수신</u></a> 동의 (선택)" +
            "</div>" +
          "</div>" +
          */
        "</div>" +

        "<div style='width: 100%; text-align: center;'>" +
          "<div class='btn_register_wrapper'>" +
            "<button id='register_button' type='button' class='btn btn_register'>가입</button>" +
          "</div>" +
          "<p style='margin-top:10px; margin-bottom:0px;'>또는</p>" +
        "</div>" +

        "<div id='login_social_button_container' style='margin-top:0px;'>" +
          "<button id='login_social_facebook_button_wrapper'>" +
            "<img src='https://static.xx.fbcdn.net/rsrc.php/v3/yj/r/AHNFF9E2KeQ.png' style='width:30px;height:30px;margin-bottom:4px;margin-right:5px;'/>" +
            "<span style='font-weight:500;margin-right:5px;'>" + "페이스북 로그인" + "</span>" +
          "</button>" +

          "<button id='login_social_google_button_wrapper'>" +
            "<img src="+googleLogoURL+" style='width:18px;height:18px;margin-bottom:4px;margin-right:5px;'/>" +
            //"<span class='icon'></span>" +
            "<span style='font-weight:500;margin-right:5px;'>" + "구글 로그인" + "</span>" +
          "</button>" +
        "</div>" +

        "<div class='agreement-SNS'>" +
          "SNS 가입시 <a href='/terms' target='_blank'><u>크라우드티켓 이용약관</u></a>, <a href='/privacy' target='_blank'><u>개인정보 수집이용에</u></a> 동의한 것으로 간주합니다" +
        "</div>" +


    "</div>" +
  "</div>";

  stopDocumentScroll();
  swal({
      //title: "회원가입",
      content: elementPopup,
      confirmButtonText: "V redu",
      allowOutsideClick: "true",

      closeOnClickOutside: false,
      closeOnEsc: false,

      buttons: {
        close: {
          text: "닫기",
          value: "close",
        },
      },

  }).then(function(value){
    reStartDocumentScroll();
    if(closeFunc)
    {
      closeFunc();
    }
  });
  
  var overageCheckboxImgToggle = function(isChecked){
    if(isChecked){
      $(".overage_checkbox_img_select").show();
      $(".overage_checkbox_img_unselect").hide();
    }
    else{
      $(".overage_checkbox_img_select").hide();
      $(".overage_checkbox_img_unselect").show();
    }
  }

  var policyCheckboxImgToggle = function(isChecked){
    if(isChecked){
      $(".policy_checkbox_img_select").show();
      $(".policy_checkbox_img_unselect").hide();
    }
    else{
      $(".policy_checkbox_img_select").hide();
      $(".policy_checkbox_img_unselect").show();
    }
  }

  var privacyCheckboxImgToggle = function(isChecked){
    if(isChecked){
      $(".privacy_checkbox_img_select").show();
      $(".privacy_checkbox_img_unselect").hide();
    }
    else{
      $(".privacy_checkbox_img_select").hide();
      $(".privacy_checkbox_img_unselect").show();
    }
  }

  var marketingCheckboxImgToggle = function(isChecked){
    if(isChecked){
      $(".marketing_checkbox_img_select").show();
      $(".marketing_checkbox_img_unselect").hide();
    }
    else{
      $(".marketing_checkbox_img_select").hide();
      $(".marketing_checkbox_img_unselect").show();
    }
  }

  $("#overage_agreement").change(function(){
    if($(this).is(":checked")){
      overageCheckboxImgToggle(true);
    }
    else{
      overageCheckboxImgToggle(false);
    }
  });

  $("#policy_agreement").change(function(){
    if($(this).is(":checked")){
      policyCheckboxImgToggle(true);
    }
    else{
      policyCheckboxImgToggle(false);
    }
  });

  $("#privacy_agreement").change(function(){
    if($(this).is(":checked")){
      privacyCheckboxImgToggle(true);
    }
    else{
      privacyCheckboxImgToggle(false);
    }
  });

  $("#marketing_agreement").change(function(){
    if($(this).is(":checked")){
      marketingCheckboxImgToggle(true);
    }
    else{
      marketingCheckboxImgToggle(false);
    }
  });

  //회원가입 팝업 키 동작 START

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

  $("#register_button").click(function(){
    if(!validCheck("name") || !validCheck("email") ||
        !validCheck("password") || !validCheck("password_confirmation"))
    {
      $('#login_error_message').show();
      $('#login_error_message').text("필수 입력 항목을 확인해주세요.");
      return;
    }

    if(!$('input:radio[name=register_gender]:checked').val()){
      alert("성별을 선택해주세요.");
      return;
    };

    if(Number($(".register_age_user_select").val()) === REGISTER_AGE_NONE_TYPE_OPTION){
      alert("생년을 선택해주세요.");
      return;
    };

    if(Number($(".register_age_user_select").val()) > registerAgeUnderage){
      alert("만 14세 이상부터 가입하실 수 있습니다.");
      return;
    };

    if(!$("#overage_agreement").is(":checked")){
      alert("만 14세 이상 확인이 필요합니다.");
      return;
    };

    if(!$("#policy_agreement").is(":checked")){
      alert("이용약관에 동의해주세요.");
      return;
    };

    if(!$("#privacy_agreement").is(":checked")){
      alert("개인정보 수집이용에 동의해주세요.");
      return;
    };

    loadingProcess($(".btn_register_wrapper"));
    $('.swal-button-container').hide();
    //ajax
    $('#login_error_message').hide();
    var url = '/auth/register';
    var method = 'post';
    var data =
    {
      "name" : $('#name').val(),
      "nick_name" : $('#nick_name').val(),
      "email" : $('#email').val(),
      "password" : $('#password').val(),
      "password_confirmation" : $('#password_confirmation').val(),
      "ispopup" : 'TRUE',
      "gender" : $('input:radio[name=register_gender]:checked').val(),
      "age" : $(".register_age_user_select").val(),
    }

    var success = function(result) {
      loadingProcessStop($(".btn_register_wrapper"));
      $('.swal-button-container').show();

      if(result.state != 'success')
      {
        var message = "알 수 없는 에러로 회원가입이 실패하였습니다.";
        if(result.message.email)
        {
          result.message = result.message.email[0];
        }
        else if(result.message.password)
        {
          result.message = result.message.password[0];
        }
      }

      loginAjaxSuccess(result);

    };

    var error = function(request, status) {
      swal("회원가입 실패", "", "error");
    };

    if(jQuery_loginPopup)
    {
      jQuery_loginPopup.ajax({
        'url': url,
        'method': method,
        'data': data,
        'success': success,
        'error': error
      });
    }

  });

  //회원가입 팝업 키 동작 END

  var setRegisterRadioInputImg = function(){
    if($('input:radio[name=register_gender]:checked').val() === 'm'){
      $('.register_radio_type_m_select').show();
      $('.register_radio_type_m_unselect').hide();

      $('.register_radio_type_f_select').hide();
      $('.register_radio_type_f_unselect').show();
    }
    else{
      $('.register_radio_type_m_select').hide();
      $('.register_radio_type_m_unselect').show();

      $('.register_radio_type_f_select').show();
      $('.register_radio_type_f_unselect').hide();
    }
  }

  $('.register_popup_user_gender_input').click(function(){
    setRegisterRadioInputImg();
  });

  $(".register_age_user_select").change(function(){
    if(Number($(this).val()) === REGISTER_AGE_NONE_TYPE_OPTION)
    {
      $("#register_popup_user_age_text").text("년도 선택");
    }
    else
    {
      $("#register_popup_user_age_text").text($(this).val());
    }
    
  });

  facebookLibInit();
  googleLibInit();

  $('#login_social_facebook_button_wrapper').click(function(){
    startFacebookLogin();
  });
}
