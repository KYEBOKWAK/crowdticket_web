<?php namespace App\Http\Controllers;

use App\Models\Blueprint as Blueprint;

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
        return view('blueprint.welcome');
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
