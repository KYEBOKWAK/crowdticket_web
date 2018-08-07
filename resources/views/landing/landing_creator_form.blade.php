@extends('app')
@section('meta')
<!-- ie 호환성보기 무시 -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- 모바일을 위한 viewport설정 -->
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
   <title>CROWDTICKET CREATORS 사전등록 신청 페이지</title>
@endsection
@section('css')
  <style>
  .navbar{
    display: none;
  }
  body{
    background-color: #ea535a;
    word-break: keep-all;
  }

      .contact_form input[type=text],
      .contact_form select,
      .contact_form textarea,
      .contact_form input[type=email],
      .contact_form input[type=tel] {
          width: 100%;
          padding: 12px;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
          margin-top: 6px;
          margin-bottom: 16px;
          resize: vertical;
      }

      .contact_form>h3 {
          text-align: center;
          color: white;
      }

      .contact_form>h5 {
        color: white;
      }

      .contact_form textarea {
          height: 100px;
          resize: none;
      }

      .contact_form #name {
          height: 100px;
          resize: none;
      }

      .contact_form input[type=submit] {
          background-color: #ea535a;
          color: white;
          padding: 12px 20px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          transition: 0.3s;

          border: 2px solid white;
          font-size: 15px;
          text-align: center;
      }

      .contact_form input[type=submit]:hover {
          /*background-color: #aaa;*/
      }

      .contact_form {
          width: 90%;
          margin: 0 auto;
          margin-top: 50px;
          border-radius: 5px;
          padding: 20px;
          color: black;
      }

      .contact_form>h3 {
          font-size: 30px;
          padding-bottom: 50px;
      }

      .title_img{
        text-align: center;
      }

      .contact_form label{
        color: white;
        margin-top: 20px;
        font-weight: bold;
      }

      .contact_form form{
        margin-top: 20px;
      }

      .checkbox{
        margin-left: 10px;
      }

      .warning{
        color: white;
      }

      .btn-submit-wrapper{
        width: 100%;
        text-align: center;
        margin-top: 30px;
      }

      .contact_form input[type=email]{
        width: 30%;
        display: block;
      }

      .contact_form input[type=tel]{
        width: 30%;
        display: block;
      }

      @media (max-width: 768px){
        .contact_form input[type=email]{
          width: 50%;
          display: block;
        }

        .contact_form input[type=tel]{
          width: 50%;
          display: block;
        }

        .contact_form>h5 {
          line-height: 1.5;
        }
      }
  </style>
@endsection

@section('content')
    <?php
    setcookie("isCreatorSubmitFinal","true", time()+604800);
    ?>
<!-- 폼태그 -->
 <section class="contact_form" id="contact_form">
   <h3>CROWDTICKET CREATORS 사전등록 신청 페이지</h3>
   <h5>2018년 9월, 오직 크리에이터/인플루언서들을 위한 티켓팅 서비스, 크라우드티켓 크리에이터스가 오픈됩니다.</h5>
   <h5>여러분의 오프라인 이벤트 페이지 개설을 위한 기본적인 정보만 알려주세요!</h5>
   <h5>벌써 100건이 넘는 공연을 진행해 온 크라우드티켓팀이, 여러분의 팬들과 직접 만날, 재밌는 이벤트 기획에 함께합니다.</h5>
   <form action="{{ url('/landing/sendmail') }}" method="post" onsubmit="return submitCheck()">
     <label for="name">크리에이터/인플루언서 활동 이름 (필수)</label>
     <textarea id="name" name="name" placeholder="유투브 00채널 크리에이터 000 / 페이스북 000페이지 운영자 / 인스타그램 피트니스 인플루언서 000 / 게임 스트리머 000 등 자신을 자유롭게 표현 해 주세요. " required></textarea>

     <label for="messageChannel">주 콘텐츠 채널 주소 (필수)</label>
     <textarea id="messageChannel " name="messageChannel" placeholder="사용하고 있는 온라인 주 채널의 주소를 알려주세요. 여러 개를 사용하고 있다면 모두 적어주세요! " required></textarea>

     <label for="messageExplain">간단한 설명 (필수)</label>
     <textarea id="messageExplain " name="messageExplain" placeholder="팬들과 어떤 콘텐츠를 공유하는 크리에이터/인플루언서 인지 간단한 설명을 적어주세요." required></textarea>

     <label for="messageIdea">오프라인 콘텐츠 아이디어(선택)</label>
     <textarea id="messageIdea " name="messageIdea" placeholder="혹시 기획하고 있는 이벤트 안이 있다면 자유롭게 적어주세요. 예) 팬미팅, 파티, 각종 강습, 공연 및 강연 등"></textarea>

     <label for="email">이메일 (필수)</label>
     <input type="email" id="email" name="email" placeholder="이메일" required>
     <label for="phone">전화번호 (필수)</label>
     <input type="tel" id="phone" name="phone" placeholder="전화번호" required>

     <div class="warning">
       <p class="checklabel">*입력하신 모든 정보는 오프라인 이벤트 개설 프로모션을 위해 크라우드티켓 내부에서만 사용되는 정보입니다. <br>신청 후 1일 이내로 연락을 드리도록 하겠습니다.</p>
       <span>위 내용 확인</span>
       <input type="checkbox" id="checkbox" name="checkbox" required>
     </div>
     <div class="btn-submit-wrapper">
       <input type="submit" value="사전 등록 신청">
     </div>
     @include('csrf_field')
   </form>
 </section>
@endsection

@section('js')
<script>
function submitCheck(){
  var email = $('#email').val();
  if(emailValiedCheck(email) == false){
    alert("올바른 이메일 주소를 입력하세요 "+email);
    return false;
  }

  return true;
}

function emailValiedCheck(email){
  var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
  return re.test(email);
}
</script>
@endsection
