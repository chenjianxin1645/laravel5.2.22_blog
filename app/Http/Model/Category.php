<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    //保护字段
    protected $guarded = [];

    /*
     * 获取分类
     * */
    public function tree(){
        $data = $this::orderBy('cate_order','asc')->get();
//        dd($data);
        return $this->getTree($data,'name','id','pid',0);
    }

    /*
     * 获取分类
     * */
    public function getTree($data,$field_name,$field_id='id',$field_pid='pid',$pid=0){
        $arr = array();
        if(count($data)>0){
            foreach($data as $k=>$v){
                if($v->$field_pid==$pid){
                    $data[$k]['_'.$field_name] = $data[$k][$field_name];
                    $arr[] = $data[$k];
//                    dd($arr);
                    foreach($data as $m=>$n){
                        if($n->$field_pid==$v->$field_id){
                            $data[$m]['_'.$field_name] = '├─ '.$data[$m][$field_name];
                            $arr[] = $data[$m];
//                            dd($arr);
                        }
                    }
                }
            }
        }
//        dd($arr);
        return $arr;
    }

}
