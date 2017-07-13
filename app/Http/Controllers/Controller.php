<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public $user;
    public $title;

    public function __construct()
    {
        $this->setTitle('Title not stated');
        if(Auth::check())
        {
            $this->user = Auth::user();
            view()->share('u', $this->user);
        }
    }

    public function  __destruct()
    {

    }

    public function setTitle($title)
    {
        $this->title = $title;
        view()->share('title', $this->title);
    }

}
