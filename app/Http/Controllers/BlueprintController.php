<?php namespace App\Http\Controllers;

use App\Models\Blueprint as Blueprint;

//임시코드
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//임시코드 end

use Illuminate\Support\Facades\Mail;

class BlueprintController extends Controller
{

    public function createBlueprint()
    {
        $inputs = \Input::all();
        $inputs['user_introduction']
            = $inputs['user_introduction'] . ' (' . $inputs['tel'] . ')';

        //기존 데이터가 있어서 임시값으로 셋팅한다.
        $blueprint = new Blueprint($inputs);
        $blueprint->user()->associate(\Auth::user());
        $blueprint->setAttribute('code', $this->generateUniqueCode());
        //초반 동의 하는 화면이 없어졌기 때문에 수락하는 코드를 바로 넣어준다.
        $blueprint->setAttribute('approved', true);
        $blueprint->save();

        //host 가입 메일 보내기
        $subject = "[크티] 이벤트 개설을 신청해주셔서 감사합니다";
        $to = \Input::get('contact');
        $data = [
          'name' => \Input::get('user_introduction'),
          'goCreateProjectURL' => url("/projects/form/".$blueprint['code'])
        ];

        Mail::send('template.emailform.email_create_project_new', $data, function ($m) use ($subject, $to) {
            $m->from('contact@crowdticket.kr', '크라우드티켓');
            $m->to($to)->subject($subject);
        });

        //우리쪽에도 확인 메일 보내기
        // 이메일을 생성하고 메일을 전송하는 부분
        $name = strip_tags(htmlspecialchars($_POST['user_introduction']));
  		  $messageExplain = strip_tags(htmlspecialchars($_POST['project_introduction']));
  		  $email_address = strip_tags(htmlspecialchars($_POST['contact']));
  		  $phone = strip_tags(htmlspecialchars($_POST['tel']));

  		  $to = 'contact@crowdticket.kr'; // 받는 측의 이메일 주소를 기입하는 부분
  		  $email_subject = "개설 신청 [$name]"; // 메일 제목에 해당하는 부분
  		  $email_body = ['content' => "\n\n프로젝트 개설자:\n\n $name\n\n문의 내용:\n\n $messageExplain\n\nEmail:\n\n $email_address\n\nPhone:\n\n $phone\n\n"];


  			Mail::send('landing.landing_email_form', $email_body, function ($m) use ($email_subject, $to) {
  								$m->from('contact@crowdticket.kr', '개설 신청중');
  								$m->to($to)->subject($email_subject);
  						});


        return \Redirect::to(url("/projects/form/".$blueprint['code']));
    }

    private function generateUniqueCode()
    {
        $code = str_random(40);
        $blueprint = Blueprint::findByCode($code);
        if ($blueprint) {
            return $this->generateUniqueCode();
        } else {
            return $code;
        }
    }

    public function getBlueprintWelcome()
    {
      //return view('blueprint.welcome');
      return view('blueprint.welcome_new');
    }

    public function getCreateForm()
    {
        //return view('blueprint.form');
        $isProject = $_GET['isProject'];
        return view('blueprint.form', ['isProject' => $isProject]);
    }

    public function getBlueprints()
    {
        return Blueprint::all();
    }

    public function getBlueprint($id)
    {
        return Blueprint::findOrFail($id);
    }

    public function approveBlueprint($id)
    {
        $bluePrint = $this->getBlueprint($id);
        $bluePrint->approve();
        $code = $bluePrint->code;
        // send email
    }

}
