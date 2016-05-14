<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    protected function messageError($message)
    {
        return [
            'level' => 'e',
            'message' => $message
        ];
    }

    protected function messageSuccess($message)
    {
        return [
            'level' => 's',
            'message' => $message
        ];
    }

    protected function messageInfo($message)
    {
        return [
            'level' => 'i',
            'message' => $message
        ];
    }

}
