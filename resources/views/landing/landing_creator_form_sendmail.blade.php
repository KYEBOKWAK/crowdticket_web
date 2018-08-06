<?php
header("Content-Type: text/html; charset=UTF-8");

$isCreatorSubmitFinal = $_COOKIE["isCreatorSubmitFinal"];

if($isCreatorSubmitFinal == "true")
{
  setcookie("isCreatorSubmitFinal","false", time()+604800);
  // 빈 필드가 있는지 확인하는 구문
  if(empty($_POST['name'])  		|| // post로 넘어온 name값이 비었는지 확인
      empty($_POST['messageChannel']) 		|| // 유투브 채널 값이 비었는지 확인
      empty($_POST['messageExplain']) 		|| // 설명값이 비었는지 확인
      empty($_POST['email']) 		|| // email값이 비었는지 확인
     empty($_POST['phone']) 		|| // phone값이 비었는지 확인
     !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) // 전달된 이메일 값이 유효한 이메일값인지 검증
     {
  	     echo "잘못된 이메일을 사용하였습니다.";
  	     return false;
     }
  // Cross-Site Scripting (XSS)을 방지하는 시큐어코딩
  // strip_tags() -> 문자열에서 html과 php태그를 제거한다
  // htmlspecialchars() -> 특수 문자를 HTML 엔터티로 변환
  // 악의적인 특수문자 삽입에 대비하기 위함

  $name = strip_tags(htmlspecialchars($_POST['name']));
  $messageChannel = strip_tags(htmlspecialchars($_POST['messageChannel']));
  $messageExplain = strip_tags(htmlspecialchars($_POST['messageExplain']));
  $messageIdea = strip_tags(htmlspecialchars($_POST['messageIdea']));
  $email_address = strip_tags(htmlspecialchars($_POST['email']));
  $phone = strip_tags(htmlspecialchars($_POST['phone']));

  // 이메일을 생성하고 메일을 전송하는 부분
  $to = 'contact@crowdticket.kr'; // 받는 측의 이메일 주소를 기입하는 부분
  $email_subject = "FROM: 크리에이터 신청 [$name]"; // 메일 제목에 해당하는 부분
  $email_body = "크라우드 티켓 크리에이터 사전신청\n\n\n\n".
                "크리에이터/인플루언서 활동 이름:\n $name\n\n주 콘텐츠 채널 주소:\n $messageChannel\n\n간단한 설명:\n $messageExplain\n\n오프라인 콘텐츠 아이디어:\n $messageIdea\n\nEmail:\n $email_address\n\nPhone:\n $phone\n\n";
  $headers = "Reply-To: $email_address\r"; // 답장 주소

  mail($to,'=?UTF-8?B?'.base64_encode($email_subject).'?=',$email_body,$headers);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
  <body>
    <style>
    .swal-icon--success__ring{
      border: 4px solid hsla(358, 65%,69%,.2);
    }

    .swal-icon--success{
      border-color: #ea535a;
    }

    .swal-icon--success__line{
      background-color: #ea535a;
    }

    .swal-button{
      background-color: #ea535a !important;
    }
    </style>
    <script>
      swal("신청 완료!", "", "success").then((value) => {
        var win = window.open("about:blank", "_self");
        win.close();
      });
    </script>
  </body>
</html>
