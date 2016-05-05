<?php

namespace App\Http\Controllers\PC;

use App\Http\Model\Article;
use App\Http\Model\Link;
use App\Http\Model\Nav;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        //共享导航
        $navs =  Nav::orderBy('nav_order','asc')->get();

        //点击量最高的文章 6篇
        $hots = Article::orderBy('view','desc')->take(6)->get();

        //最新图文文章 分页
        $new_arts = Article::orderBy('updated_at','desc')->paginate(config('web.web_page'));

        view()->share('navs',$navs);
        view()->share('hots',$hots);
        view()->share('new_arts',$new_arts);
    }
}
