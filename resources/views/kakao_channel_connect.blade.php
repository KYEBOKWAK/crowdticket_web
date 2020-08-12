<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="naver-site-verification" content="8bce253ce1271e2eaa22bd34b508b72cc60044a5"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>

    <title>크티 : 크라우드티켓 - 팬과 크리에이터가 함께 즐기는 이벤트 플랫폼</title>
    <!-- 카카오톡 sdk -->
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
</head>
<body>

카카오톡 채널과 연결합니다... 자동으로 넘어가지 않을 경우 상담 시작하기 버튼을 눌러주세요.
<a href="javascript:void plusFriendChat()">
  <button id="kakao_talk">상담 시작하기</button>
</a>

<script type='text/javascript'>
    Kakao.init('0e5457b479dfe84c5e52e6de84d6d684');
    function plusFriendChat() {
      Kakao.PlusFriend.chat({
        plusFriendId: '_JUxkxjM' // 플러스친구 홈 URL에 명시된 id로 설정합니다.
      });
    }

    // plusFriendChat();
</script>

</body>
</html>
