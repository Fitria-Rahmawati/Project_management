<?php

namespace App\Controllers;

class ErrorController extends BaseController
{
    public function forbidden()
    {
        return view('errors/forbidden');
    }
}