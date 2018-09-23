<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Moraes
 * Date: 09/09/2018
 * Time: 22:44
 */

namespace App\Http\Controllers;


class DefaultResponseController extends DefaultController
{
    public function responseAjaxSuccess()
    {
        return response()->json(['success' => true]);
    }

    public function responseAjaxError()
    {
        return response()->json(['success' => false], 500);
    }

    public function responseSuccessCustom($data)
    {
        return response()->json($data);
    }

    public function redirectWithError($message = 'Ocorreu um erro! Tente novamente')
    {
        return redirect()->back()->withErrors($message)->withInput();
    }
}