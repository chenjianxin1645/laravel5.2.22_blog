<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /*
     * Admin index
     * */
    public function index(){
//        return 'dsads';
        return view('admin.index');
    }

    /*
     * Admin info
     * */
    public function info(){
//        return 'dsads';
        return view('admin.info');
    }

    /*
     * 获取服务器相关信息
     * */
    public function server(){
        dd($_SERVER) ;
    }

}
