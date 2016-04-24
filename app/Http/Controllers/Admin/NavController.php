<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Nav;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavController extends Controller
{
    /*
     * 自定义导航首页
     * */
    public function getIndex(){
        $navs = Nav::orderBy('nav_order','asc')->paginate(10);
        $data = [
            'navs'=>$navs
        ];
        return view('admin.nav.index',$data);
    }

    /*
     * 修改排序
     * */
    public function postOrder(){
//        return 'dsd';
//        $data = Input::all();
        $order_id = Input::get('order_id');
        $order_value = Input::get('order_value');
        $Nav = Nav::find($order_id);
        $Nav->Nav_order = $order_value;
        $res = $Nav->save();
        if($res){
            $data= [
                'status'=>0,
                'msg'=>'修改排序成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'修改排序成功'
            ];
        }
        return $data;
    }

    /*
     *添加自定义导航
     * */
    public function getCreate(){
        return view('admin.nav.create');
    }

    /*
     * 提交自定义导航
     * */
    public function postStore(Request $request){
//        return $request->all();
        //验证数据
        $rules = [
            'name' => 'required|max:255',
            'url' => 'required|max:255',
            'alias' => 'max:255',
            'nav_order' => 'numeric',
        ];
        $messages = [
            'name.required' => '自定义导航标题必须填写',
            'url.required' => '自定义导航URL必须填写',
            'alias.max' => '自定义导航别名长度不能超过255',
            'nav_order.numeric' => '自定义导航排序必须为数字',
        ];
        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $messages);
        //验证是否通过
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }else{
            $res = Nav::create($data);
            if($res){
                return redirect('admin/nav/index');
            }else{
                return back()->withErrors("添加自定义导航失败")->withInput();
            }
        }
    }

    /*
     *修改自定义导航
     * */
    public function getEdit(){
        $nav_id = Input::get('id');
        $nav = Nav::find($nav_id);
        $data = [
            'nav'=>$nav
        ];
        return view('admin.nav.edit',$data);
    }

    /*
     * 提交新增文章
     * */
    public function postUpdate(Request $request){
//        return $request->all();
        //验证数据
        $rules = [
            'name' => 'required|max:255',
            'url' => 'required|max:255',
            'alias' => 'max:255',
            'nav_order' => 'numeric',
        ];
        $messages = [
            'name.required' => '自定义导航标题必须填写',
            'url.required' => '自定义导航URL必须填写',
            'alias.max' => '自定义导航别名长度不能超过255',
            'nav_order.numeric' => '自定义导航排序必须为数字',
        ];
        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $messages);
        //验证是否通过
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }else{
            $res = Nav::where('id',$request->get('id'))->update($data);
            if($res){
                return redirect('admin/nav/index');
            }else{
                return back()->withErrors("添加自定义导航失败");
            }
        }
    }

    /*
     * 删除自定义导航
     * */
    public function postDestroy(){
        $Nav_id = Input::get('nav_id');
//        dd($cate_id) ;
        $res = Nav::destroy($Nav_id);
       if($res){
            $data= [
                'status'=>0,
                'msg'=>'删除自定义导航成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'删除自定义导航失败'
            ];
        }
        return $data;
    }

}
