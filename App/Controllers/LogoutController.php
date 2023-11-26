<?php
namespace App\Controllers;
use App\Controllers\Controller;
use App\Services\Authentication;


class LogoutController extends Controller{

    public function index(){
       $auth = new Authentication();
       $auth->logout();
       header("Location:?page=home");
    }

}
