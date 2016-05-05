<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    //保护字段
    protected $guarded = [];

    /*
     * 获取上一篇文章
     * */
    public function last_art(){
        $last_art = Article::where('updated_at','<',$this->updated_at)->orderBy('updated_at','desc')->first();
        return $last_art;
    }

    /*
     * 获取下一篇文章
     * */
    public function next_art(){
        $next_art = Article::where('updated_at','>',$this->updated_at)->orderBy('updated_at','asc')->first();
        return $next_art;
    }

    /*
     * 建立与分类的一对多的关系
     * */
    public function belongsToCategory(){
        return $this->belongsTo('App\Http\Model\Category','cate_id','id');
    }

}
