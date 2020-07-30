<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>
  <body style="margin:0%">
    <table class="full-container" cellpadding="0" cellspacing="0" align="center" border="0" style="margin:0;padding:0;width:100%;background:none">
      <tbody><tr>
        <td style="width:100%;height:100%">
          <table class="main-container" cellpadding="0" cellspacing="0" align="center" border="0" style="margin:0px auto;padding:40px 0;width:100%;max-width:630px;background:rgb(255,255,255)">
            <tbody><tr style="margin:0;padding:0">
              <td style="width:100%;max-width:630px;border-collapse:separate;padding:0 20px;overflow:hidden">
                <table class="symbol-block" border="0" cellpadding="0" cellspacing="0" style="overflow:hidden;margin:0px auto;padding:4px 0px 48px;width:100%;max-width:630px;clear:both;background:none;">
                  <tbody><tr>
                    <td>
                      <img alt="크티 로고" src="https://crowdticket0.s3-ap-northeast-1.amazonaws.com/admin/mail/rebrand/ic-cti-symbol%403x.png" class="ic_cti_symbol" style="width:32px; height:36px; object-fit: contain;" />
                    </td>
                  </tr></tbody>
                </table>
                <table class="email-title" border="0" cellpadding="0" cellspacing="0" style="overflow:hidden;margin:0px auto;padding:0px;width:100%;max-width:630px;clear:both;background:none">
                  <tbody><tr>
                    <td style="font-family:'Noto Sans KR',sans-serif;font-size:24px;;font-weight:bold;font-stretch:normal;font-style:normal;line-height:normal;letter-spacing:normal;color:#212121">
                      <div style="text-align:left">축하합니다!<br/>이벤트에 당첨되셨어요!</div>
                    </td>
                  </tr></tbody>
                </table>
                <table class="email-content" border="0" cellpadding="0" cellspacing="0" style="overflow:hidden;margin:0px auto;padding:32px 0px;width:100%;max-width:630px;clear:both;background:none">
                  <tr>
                    <td>
                      <table class="info-block" border="0" cellpadding="0" cellspacing="0" style="overflow:hidden;width:100%;height:60px;padding:0px;margin:0 0 24px 0;align:center;background-color:#f9f9f9">
                        <tr>
                          <td style="padding:20px;text-align:center;font-family:'Noto Sans KR',sans-serif;font-size:14px;font-weight:500;font-stretch:normal;font-style:normal;line-height:normal;letter-spacing:normal;color:#262626;word-break:keep-all">
                          &#x1F389; <span style="font-weight:900;color:#43c9f0">{{$name}}</span>님은 <span style="font-weight:900;color:#43c9f0">{{$title}}</span>의 당첨자로 선정되셨습니다!
                          </td>
                        </tr>
                      </table>
                      <!-- 예약결제가 붙어있는 이벤트일 경우 아래 내용 표시 필요
                      <table class="attention" border="0" cellpadding="0" cellspacing="0" style="overflow:hidden;width:100%;height:24px;padding:12px;margin:8px 0 24px auto;align:left;background-color:#ecf9fd;border-left:4px solid #43c9f0">
                        <tr>
                          <td height="24px" width="24px" style="padding:0px;border:0px">
                            <img src="https://crowdticket0.s3-ap-northeast-1.amazonaws.com/admin/mail/rebrand/ic-circle-error-fill-24@3x.png" alt="!" style="width:24px;height:24px;margin-right:8px;display:block;border-width:0px"/>
                          </td>
                          <td style="align:left;vertical-align:middle;padding:3px 0px;font-family:'Noto Sans KR',sans-serif;font-size:12px;font-weight:normal;font-stretch:normal;font-style:normal;line-height:normal;letter-spacing:normal;color:#212121;word-break:keep-all">
                            티켓금액 결제가 {{$payDate}} <b>오후 1시</b>에 진행됩니다
                          </td>
                        </tr>
                      </table>
                      -->
                      <table class="explain-paragraph" border="0" cellpadding="0" cellspacing="0" style="overflow:hidden;margin:0px auto;padding:0px;width:100%;max-width:630px;clear:both;background:none">
                        <tr>
                          <td style="padding:0px 0px;font-family:'Noto Sans KR',sans-serif;font-size:14px;font-weight:normal;font-stretch:normal;font-style:normal;line-height:1.71;letter-spacing:normal;color:#575757;word-break:keep-all">
                            <div style="text-align:left">당첨자 명단이 크티 이벤트 페이지에 공지되었습니다.<br/>자세한 이벤트 참여내역과 진행결과는 크티 로그인 후 회원 메뉴에서 '결제확인' 탭으로 들어가거나 아래 버튼을 클릭해서 확인해주세요.</div>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
                <table class="button-block" border="0" cellpadding="0" cellspacing="0" style="overflow:hidden;margin:0px auto;padding:0px;width:100%;max-width:630px;clear:both;background:none">
                  <tbody><tr>
                    <td style="padding:0 0;border:0px" width="100%">
                      <table class="cti-button" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse:separate!important;background:#43c9f0;border-radius:5px;border:0;margin:0 auto;table-layout:fixed" align="left">
                        <tbody><tr>
                          <td style="padding:12px 20px" align="center">
                            <a href="{{ $gotoPayPageURL }}" target="_blank" style="font-size:14px;display:block;color:#ffffff;text-decoration:none;font-family:'Noto Sans KR',sans-serif;text-align:center">이벤트 참여내역 확인하기</a>
                          </td>
                        </tr></tbody>
                      </table>
                    </td>
                  </tr></tbody>
                </table>
                <hr width="100%" size="1px" align="center" color="#ebebeb" style="margin:24px 0px 24px 0px"/>
                <table class="explain-paragraph" border="0" cellpadding="0" cellspacing="0" style="overflow:hidden;margin:0px auto;padding:0px;width:100%;max-width:630px;clear:both;background:none">
                  <tr>
                    <td style="padding:0px 0px;font-family:'Noto Sans KR',sans-serif;font-size:14px;font-weight:normal;font-stretch:normal;font-style:normal;line-height:1.71;letter-spacing:normal;color:#575757;word-break:keep-all">
                      <div style="text-align:left">별도 결제가 필요하거나 이벤트 관련 특이사항 및 요청사항이 있을 경우 신청 당시 입력해주신 연락처로 크티가 문자 또는 전화를 드립니다. 궁금한 사항이 있을 경우 이메일 하단의 연락처를 참고해주세요.</div>
                    </td>
                  </tr>
                </table>
                <table class="paragraph-title" border="0" cellpadding="0" cellspacing="0" style="overflow:hidden;margin:0px auto;padding:24px 0 32px 0;width:100%;max-width:630px;clear:both;background:none">
                  <tbody><tr>
                    <td style="font-family:'Noto Sans KR',sans-serif;font-size:14px;font-weight:500;font-stretch:normal;font-style:normal;line-height:normal;letter-spacing:normal;color:#575757">
                      <div style="text-align:left">크리에이터와 다른 팬들에게 당첨의 기쁨을 알려주세요!</div>
                    </td>
                  </tr></tbody>
                </table>
                <table class="cti-button" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse:separate!important;background:#43c9f0;border-radius:5px;border:0;margin:0 auto;table-layout:fixed" align="left">
                  <tbody><tr>
                    <td style="padding:12px 20px" align="center">
                      <a href="{{$gotoProjectURL}}" target="_blank" style="font-size:14px;display:block;color:#ffffff;text-decoration:none;font-family:'Noto Sans KR',sans-serif;text-align:center">이벤트 댓글 남기러 가기</a>
                    </td>
                  </tr></tbody>
                </table>
              </td>
            </tr></tbody>
          </table>
          <table class="email-footer" border="0" cellpadding="0" cellspacing="0" align="center" style="overflow:hidden;margin:0 0 0 0;width:100%;clear:both;background-color:#f9f9f9">
            <tbody><tr>
              <td>
                <table class="footer-container" border="0" cellpadding="0" cellspacing="0" align="center" style="margin:40px auto;width:100%;max-width:630px;background:none">
                  <tbody><tr style="margin:0;padding:0">
                    <td style="width:100%;max-width:630px;border-collapse:collapse;padding:0 20px;overflow:hidden">
                      <table class="sns-block" border="0" cellpadding="0" cellspacing="0" align="left" style="overflow:hidden;margin:0px auto;padding:0;max-width:630px;clear:both;background:none">
                        <tbody><tr>
                          <td style="padding:0;align:left;margin:0 auto 0 auto">
                            <div class="wrap-sns" style="margin:0 auto">
                              <span style="list-style:none;padding:0;margin:0px">
                                <a href="https://facebook.com/crowdticket" style="padding:0;border-width:0px;display:inline-block" title="페이스북" target="_blank"><span style="display:inline-block"><img height="28px" src="https://crowdticket0.s3-ap-northeast-1.amazonaws.com/admin/mail/rebrand/ic-footer-social-01-facebook%403x.png" alt="페이스북" style="width:18px;height:28px;display:block;border-width:0px"/></span></a>
                              </span>
                              <span style="list-style:none;padding:0;margin:0px">
                                <a href="https://instagram.com/k.haem" style="padding:0;border-width:0px;display:inline-block" title="인스타그램" target="_blank"><span style="display:inline-block"><img height="28px" src="https://crowdticket0.s3-ap-northeast-1.amazonaws.com/admin/mail/rebrand/ic-footer-social-02-instagram%403x.png" alt="인스타그램" style="width:28px;height:28px;display:block;border-width:0px"/></span></a>
                              </span>
                              <span style="list-style:none;padding:0;margin:0px">
                                <a href="http://blog.naver.com/crowdticket" style="padding:0;border-width:0px;display:inline-block" title="블로그" target="_blank"><span style="display:inline-block"><img height="28px" src="https://crowdticket0.s3-ap-northeast-1.amazonaws.com/admin/mail/rebrand/ic-footer-social-03-naver%403x.png" alt="블로그" style="width:28px;height:28px;display:block;border-width:0px"/></span></a>
                              </span>
                              <span style="list-style:none;padding:0;margin:0px">
                                <a href="http://pf.kakao.com/_JUxkxjM" style="padding:0;border-width:0px;display:inline-block" title="카카오채널" target="_blank"><span style="display:inline-block"><img height="28px" src="https://crowdticket0.s3-ap-northeast-1.amazonaws.com/admin/mail/rebrand/ic-footer-social-04-kakao-channel%403x.png" alt="카톡채널" style="width:28px;height:28px;display:block;border-width:0px"/></span></a>
                              </span>
                            </div>
                          </td>
                        </tr></tbody>
                      </table>
                      <table class="contact-info-block" border="0" cellpadding="0" cellspacing="0" align="left" style="padding:20px 0;table-layout:fixed" width="100%">
                        <tbody><tr>
                          <td style="width:100%">
                            <div style="text-align:left;line-height:1.71;font-size:14px;font-family:'Apple SD Gothic Neo','AppleSDGothicNeo','Noto Sans KR',sans-serif;font-weight:500;font-stretch:normal;font-style:normal;letter-spacing:normal;color:#808080;">
                              (주)나인에이엠 / 서울시 마포구 백범로 31길 21 서울창업허브 본관 611호 / 고객센터 <a href="tel:070-8819-4308" style="color:#43c9f0" target="_blank"><font color="#43c9f0">070-8819-4308</font></a> / 이메일 <a href="mailto:contact@crowdticket.kr" style="color:#43c9f0;text-decoration:underline" target="_blank">contact@crowdticket.kr</a> / 카카오톡 <a href="http://pf.kakao.com/_JUxkxjM/chat" style="color:#43c9f0;text-decoration:underline">@크라우드티켓</a>
                            </div>
                          </td>
                        </tr></tbody>
                      </table>
                      <table class="customer-service-block" border="0" cellpadding="0" cellspacing="0" align="left" style="padding:0;table-layout:fixed" width="100%">
                        <tbody><tr>
                          <td>
                            <div style="text-align:left;line-height:1.67;font-size:12px;font-family:'Apple SD Gothic Neo','AppleSDGothicNeo','Noto Sans KR',sans-serif;font-weight:500;font-stretch:normal;font-style:normal;letter-spacing:normal;color:#808080">
                              카카오톡을 통한 실시간 상담이 가능하며, 영업시간 외에도 최대한 빠른 시간 내에 답변 드리도록 하겠습니다.(영업시간 10:00-19:00)
                            </div>
                          </td>
                        </tr></tbody>
                      </table>
                      <table class="copyright-block" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:20px 0 0 0">
                        <tbody><tr>
                          <td>
                            <div style="text-align:left;line-height:2;font-size:12px;font-family:'Apple SD Gothic Neo','AppleSDGothicNeo','Noto Sans KR',sans-serif;font-weight:500;font-stretch:normal;font-style:normal;letter-spacing:normal;color:#808080">
                              COPYRIGHT ⓒ CROWDTICKET ALL RIGHTS RESERVED.
                            </div>
                          </td>
                        </tr></tbody>
                      </table>
                    </td>
                  </tr></tbody>
                </table>
              </td>
            </tr></tbody>
          </table>
        </td>
      </tr></tbody>
    </table>
  </body>
</html>
