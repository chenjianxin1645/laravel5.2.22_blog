<?php

namespace App\Http\Controllers\PC;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Link;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends CommonController
{
    /*
     * index
     * */
    public function index(){
       //友情链接
        $links = Link::orderBy('link_order','asc')->get();

        $data = array(
            'links'=>$links,
        );

        return view('pc.index',$data);
    }

    /*
     * 所有文章
     * */
    public function lists(){
//        return 'index fro front';
        $categorys = Category::where('pid',0)->get();
        return view('pc.list',compact('categorys'));
    }

    /*
     * 分类显示
     * */
    public function cates($id){
//        return 'index fro front';
        //获取该分类下的所有文章
        $articles = Article::where('cate_id',$id)->paginate(config('web.web_page'));
        $categorys = Category::where('pid',$id)->get();
        $categroy = Category::findorFail($id);
        return view('pc.cates',compact('articles','categorys','categroy'));
    }

    /*
     * 文章详情
     * */
    public function art($id){
//        return 'index fro front';
//        return $id;
        //获取文章详情
        $art = Article::findorFail($id);
        //获取文章的分类
        $cate = Category::where('id',$art->cate_id)->first();
        //相关文章
        $rel_arts = Article::where('cate_id',$art->id)->get();
//        return $art->tags;
        $data  = array(
            'art'=>$art,
            'cate'=>$cate,
            'rel_arts'=>$rel_arts
        );
//        return $art->content;
        return view('pc.new',$data);
    }


}
