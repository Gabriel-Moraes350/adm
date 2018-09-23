<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Moraes
 * Date: 27/08/2018
 * Time: 23:30
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\View;

class DefaultController extends Controller
{
    protected $layout = 'default';
    protected $data = [];

    public function __construct()
    {

    }

    protected function renderView($view)
    {
        if(View::exists($view))
        {
            $this->layout = $view;
        }

        return view($this->layout, $this->data);
    }

    public function getAuthenticateUser()
    {
        if(\Auth::check())
        {
            return \Auth::user();
        }
        return false;
    }


    public function logoutUser()
    {
        if($user = $this->getAuthenticateUser())
        {
            \Auth::logout();
            return true;
        }

        return false;
    }

}