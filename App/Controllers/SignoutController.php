<?php

namespace App\Controllers;

use App\Controllers\Controller;



class SignoutController extends Controller
{

    public function index()
    {
        session_destroy();
        header("Location:?page=user&action=login");
    }
    
}
