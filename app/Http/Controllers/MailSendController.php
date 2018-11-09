<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailSendController extends Controller {
	public function sendEmail(){

		$isCreatorSubmitFinal = $_COOKIE["isCreatorSubmitFinal"];
		if($isCreatorSubmitFinal == "true")
		{
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

			setcookie("isCreatorSubmitFinal","false", time()+604800);

		  $name = strip_tags(htmlspecialchars($_POST['name']));
		  $messageChannel = strip_tags(htmlspecialchars($_POST['messageChannel']));
		  $messageExplain = strip_tags(htmlspecialchars($_POST['messageExplain']));
		  $messageIdea = strip_tags(htmlspecialchars($_POST['messageIdea']));
		  $email_address = strip_tags(htmlspecialchars($_POST['email']));
		  $phone = strip_tags(htmlspecialchars($_POST['phone']));

		  // 이메일을 생성하고 메일을 전송하는 부분
		  $to = 'contact@crowdticket.kr'; // 받는 측의 이메일 주소를 기입하는 부분
		  $email_subject = "FROM: 크리에이터 신청자 [$name]"; // 메일 제목에 해당하는 부분
		  $email_body = ['content' => "\n\n크리에이터/인플루언서 활동 이름:\n\n $name\n\n주 콘텐츠 채널 주소:\n\n $messageChannel\n\n간단한 설명:\n\n $messageExplain\n\n오프라인 콘텐츠 아이디어:\n\n $messageIdea\n\nEmail:\n\n $email_address\n\nPhone:\n\n $phone\n\n"];


			Mail::send('landing.landing_email_form', $email_body, function ($m) use ($email_subject, $to) {
								$m->from('contact@crowdticket.kr', '크리에이터신청자');
								$m->to($to)->subject($email_subject);
						});
		}

		return view('landing.landing_creator_form_sendmail');
	}

	public function sendQuestionEmail(){

		//$isSendMailSubmitFinal = $_COOKIE["isSendMailSubmitFinal"];
		//if($isSendMailSubmitFinal == "true")
		{
		  // 빈 필드가 있는지 확인하는 구문
		  if(empty($_POST['user_introduction'])  		|| // post로 넘어온 name값이 비었는지 확인
		      empty($_POST['project_introduction']) 		|| // 유투브 채널 값이 비었는지 확인
		      empty($_POST['contact']) 		|| // email값이 비었는지 확인
		     empty($_POST['tel']) 		|| // phone값이 비었는지 확인
		     !filter_var($_POST['contact'],FILTER_VALIDATE_EMAIL)) // 전달된 이메일 값이 유효한 이메일값인지 검증
		     {
		  	     echo "잘못된 이메일을 사용하였습니다.";
		  	     return false;
		     }
		  // Cross-Site Scripting (XSS)을 방지하는 시큐어코딩
		  // strip_tags() -> 문자열에서 html과 php태그를 제거한다
		  // htmlspecialchars() -> 특수 문자를 HTML 엔터티로 변환
		  // 악의적인 특수문자 삽입에 대비하기 위함

			setcookie("isSendMailSubmitFinal","false", time()+604800);

		  $name = strip_tags(htmlspecialchars($_POST['user_introduction']));
		  $messageExplain = strip_tags(htmlspecialchars($_POST['project_introduction']));
		  $email_address = strip_tags(htmlspecialchars($_POST['contact']));
		  $phone = strip_tags(htmlspecialchars($_POST['tel']));

		  // 이메일을 생성하고 메일을 전송하는 부분
		  $to = 'contact@crowdticket.kr'; // 받는 측의 이메일 주소를 기입하는 부분
		  $email_subject = "FROM: 제휴문의 [$name]"; // 메일 제목에 해당하는 부분
		  $email_body = ['content' => "\n\n프로젝트 개설자:\n\n $name\n\n문의 내용:\n\n $messageExplain\n\nEmail:\n\n $email_address\n\nPhone:\n\n $phone\n\n"];


			Mail::send('landing.landing_email_form', $email_body, function ($m) use ($email_subject, $to) {
								$m->from('contact@crowdticket.kr', '제휴 문의');
								$m->to($to)->subject($email_subject);
						});
		}

		return view('landing.landing_creator_form_sendmail');
	}

	public function sendEmailRegister(Request $request)
	{
		$from = 'contact@crowdticket.kr';
		$fromName = '크라우드티켓';
		$to = \Input::get('email'); // 받는 측의 이메일 주소를 기입하는 부분
		$redirectPath = \Input::get('redirectPath');
		$email_subject = "크라우드티켓 회원이 되어 주셔서 감사합니다!"; // 메일 제목에 해당하는 부분
		$email_body = [];
		Mail::send('template.emailform.email_register', $email_body, function ($m) use ($email_subject, $to, $from, $fromName)
		{
							$m->from($from, $fromName);
							$m->to($to)->subject($email_subject);
		});


		return redirect($redirectPath);
	}
/*
	public function sendEmailCompliteSchedule(Request $request)
	{

	}
*/
}
