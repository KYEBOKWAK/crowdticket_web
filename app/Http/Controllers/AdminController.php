<?php namespace App\Http\Controllers;

use App\Models\Blueprint as Blueprint;
use App\Models\Project as Project;

use App\Models\Order as Order;

use Illuminate\Support\Facades\Mail;
use App\Services\SmsService;

class AdminController extends Controller
{

    public function getDashboard()
    {
        return view('admin.home', [

            'blueprints' => Blueprint::orderBy('id', 'desc')->get()->load('user'),

            'investigation_projects' => Project::where('state', '=', Project::STATE_UNDER_INVESTIGATION)->get(),

            'funding_projects' => $this->getFailedFundingProjects(),

            'funding_end_projects' => $this->getFundingEndProjects(),

            'eventProject' => $this->getEventProject()

        ]);
    }

    public function getEventProject()
    {
      return Project::findOrFail(285);
    }

    public function approveBlueprint($id)
    {
        $blueprint = Blueprint::find($id);
        $blueprint->approve();

        return redirect('/admin/');
    }

    public function rejectProject($id)
    {
        $project = Project::find($id);
        $project->reject();

        return redirect('/admin/');
    }

    public function approveProject($id)
    {
        $project = Project::find($id);
        $project->approve();

        return redirect('/admin/');
    }

    public function getOrders($id)
    {
        $project = Project::find($id);
        /*
        return view('project.orders', [
            'project' => $project,
            'tickets' => $project->tickets()->with(['orders' => function ($query) {
                $query->withTrashed();
            }, 'orders.user'])->get()
        ]);
        */

        return view('project.orders', [
            'project' => $project,
            'tickets' => $project->tickets()->with(['orders' => function ($query) {
                $query->withTrashed();
            }, 'orders.user'])->get(),
            'orders' => $project->ordersAll()->withTrashed()->get()
        ]);
    }

    public function cancelFundingProjectOrders($id)
    {
        $project = Project::find($id);
        if ($project->type === 'funding') {
            $orders = $project->orders()->get();
            foreach ($orders as $order) {
                app('App\Http\Controllers\OrderController')->deleteOrder($order->id, Order::ORDER_STATE_PROJECT_CANCEL,true);
            }
        }
    }

    private function getFailedFundingProjects()
    {
      return Project::where('type', 'funding')
          ->where('funding_closing_at', '<', date('Y-m-d H:i:s', time()))
          ->orderBy('id', 'desc')
          ->get();
      /*
        return Project::where('type', 'funding')
            ->where('funding_closing_at', '<', date('Y-m-d H:i:s', time()))
            ->where('funded_amount', '>', 0)
            ->whereRaw('funded_amount < pledged_amount')
            ->get();
            */
    }

    private function getFundingEndProjects()
    {
        return Project::where('type', 'funding')
            ->where('funding_closing_at', '<', date('Y-m-d H:i:s', time()))
            ->orderBy('id', 'desc')
            ->get();
    }

    public function sendSuccessFundingEmail($projectId)
    {
      $subject = '(크라우드티켓) 참여하신 프로젝트가 목표에 도달했습니다!';
      $project = Project::find($projectId);
      if ($project->type === 'funding') {
          $orders = $project->orders()->get();

          $sendedMails = [];
          foreach ($orders as $order) {
            $to = $order->email;

            $isSended = false;
            foreach($sendedMails as $sendedMail)
            {
              if($to == $sendedMail)
              {
                $isSended = true;
              }
            }

            if($isSended)
            {
              continue;
            }

            $data = [
              'title' => $project->title,
              'name' => $order->name,
              'payDate' => $project->getFundingOrderConcludeAt(),
              'gotoPayPageURL' => url('orders/'.$order->id),
              'gotoCelebrate' => url('projects/'.$project->id),
            ];

            Mail::send('template.emailform.email_funding_success', $data, function ($m) use ($subject, $to) {
                $m->from('contact@crowdticket.kr', '크라우드티켓');
                $m->to($to)->subject($subject);
            });

            array_push($sendedMails, $to);
          }
      }

      return \Redirect::back();
    }

    public function sendFailFundingEmail($projectId)
    {
      $subject = '(크라우드티켓) 참여하신 프로젝트가 무산되었습니다.';
      $project = Project::find($projectId);
      if ($project->type === 'funding') {
          //$orders = $project->orders()->get();
          $orders = $project->ordersWithoutUserCancel()->get();

          $sendedMails = [];
          foreach ($orders as $order) {
            $to = $order->email;

            $isSended = false;
            foreach($sendedMails as $sendedMail)
            {
              if($to == $sendedMail)
              {
                $isSended = true;
              }
            }

            if($isSended)
            {
              continue;
            }

            $data = [
              'title' => $project->title,
              'gotoHomeURL' => url()
            ];

            Mail::send('template.emailform.email_funding_fail', $data, function ($m) use ($subject, $to) {
                $m->from('contact@crowdticket.kr', '크라우드티켓');
                $m->to($to)->subject($subject);
            });

            array_push($sendedMails, $to);
          }
      }

      return \Redirect::back();
    }

    public function sendSuccessFundingSms($projectId)
    {
      $sms = new SmsService();
      $project = Project::find($projectId);
      if ($project->type === 'funding') {
        $limit = $project->type === 'funding' ? 10 : 14;
        $titleLimit = str_limit($project->title, $limit, $end = '..');
        $datetime = date('Y/m/d H:i', strtotime($project->getFundingOrderConcludeAt()));
        $msg = sprintf('%s 펀딩 성공! %s 결제가 진행됩니다. ', $titleLimit, $datetime);

        $orders = $project->orders()->get();

        $sendedSMSs = [];
        foreach ($orders as $order) {
          $contact = $order->contact;

          $isSended = false;
          foreach($sendedSMSs as $sendedSMS)
          {
            if($contact == $sendedSMS)
            {
              $isSended = true;
            }
          }

          if($isSended)
          {
            continue;
          }

          $sms->send([$contact], $msg);

          array_push($sendedSMSs, $contact);
        }
      }

      return \Redirect::back();
    }

    public function sendFailFundingSms($projectId)
    {

    }

    public function sendFailEventEmail($projectId)
    {
      $subject = '(크라우드티켓) 초대권 이벤트에 응모해주셔서 감사합니다.';
      $project = Project::find($projectId);
      if ($project->type === 'funding') {
          $orders = $project->orders()->get();

          $sendedMails = [];
          foreach ($orders as $order) {
            $to = $order->email;

            //당첨자 제외
            if($to == 'lje110833@naver.com' ||
              $to == 'jiwun901@hanmail.net' ||
              $to == 'kimm1904@naver.com' ||
              $to == 'separk7447@naver.com' ||
              $to == 'cxz970516@naver.com' ||
              $to == 'jfla1004@naver.com' ||
              $to == 'thdcldcld@naver.com' ||
              $to == 'philipjrchoi@yahoo.com' ||
              $to == 'bananabean1@naver.com' ||
              $to == '0312alseud@naver.com' ||
              $to == 'ym9988@naver.com' ||
              $to == 'pp5353@naver.com' ||
              $to == 'poopoo21c@naver.com' ||
              $to == 'tjsdnaos603@hanmail.net' ||
              $to == 'jooju05@naver.com' ||
              $to == 'yubin463@hanmail.net' ||
              $to == 'rpddl053@naver.com' ||
              $to == 'sakura_mi@naver.com' ||
              $to == 'biking119@naver.com' ||
              $to == 'devilhi@naver.com' ||
              $to == 'goals9923@naver.com' ||
              $to == 's2y7715@gmail.com' ||
              $to == 'sarahkim0707@naver.com' ||
              $to == 'now950815@naver.com' ||
              $to == 'koj3453@naver.com' ||
              $to == 'anika33@hanmail.net' ||
              $to == 'umjh9741@naver.com' ||
              $to == 'rlaeodnjs921@naver.com' ||
              $to == 'gpwjd5245@naver.com' ||
              $to == 'jhl5201004@naver.com'
              )
            {
              continue;
            }

            $isSended = false;
            foreach($sendedMails as $sendedMail)
            {
              if($to == $sendedMail)
              {
                $isSended = true;
              }
            }

            if($isSended)
            {
              continue;
            }

            $data = [
              'title' => $project->title,
              'name' => $order->name,
              'payDate' => $project->getFundingOrderConcludeAt(),
              'gotoPayPageURL' => url('orders/'.$order->id),
              'gotoCelebrate' => url('projects/'.$project->id),
            ];

            Mail::send('template.emailform.email_event', $data, function ($m) use ($subject, $to) {
                $m->from('contact@crowdticket.kr', '크라우드티켓');
                $m->to($to)->subject($subject);
            });

            array_push($sendedMails, $to);
          }
      }

      return \Redirect::back();
    }
}
