<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Link;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinkController extends CommonController
{
    /*
     * 友情链接首页
     * */
    public function getIndex(){
        $links = Link::orderBy('link_order','asc')->paginate(10);
        $data = [
            'links'=>$links
        ];
        return view('admin.link.index',$data);
    }

    /*
     * 修改排序
     * */
    public function postOrder(){
//        return 'dsd';
//        $data = Input::all();
        $order_id = Input::get('order_id');
        $order_value = Input::get('order_value');
        $link = Link::find($order_id);
        $link->link_order = $order_value;
        $res = $link->save();
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
     *添加友情链接
     * */
    public function getCreate(){
        return view('admin.link.create');
    }

    /*
     * 提交友情链接
     * */
    public function postStore(Request $request){
//        return $request->all();
        //验证数据
        $rules = [
            'name' => 'required|max:255',
            'url' => 'required|max:255',
            'link_desc' => 'max:255',
            'link_order' => 'numeric',
        ];
        $messages = [
            'name.required' => '友情链接标题必须填写',
            'url.required' => '友情链接URL必须填写',
            'link_desc.max' => '友情链接描述长度不能超过255',
            'link_order.numeric' => '友情链接排序必须为数字',
        ];
        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $messages);
        //验证是否通过
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }else{
            $res = Link::create($data);
            if($res){
                return redirect('admin/link/index');
            }else{
                return back()->withErrors("添加友情链接失败")->withInput();
            }
        }
    }

    /*
     *修改友情链接
     * */
    public function getEdit(){
        $link_id = Input::get('id');
        $link = Link::find($link_id);
        $data = [
            'link'=>$link
        ];
        return view('admin.link.edit',$data);
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
            'link_desc' => 'max:255',
            'link_order' => 'numeric',
        ];
        $messages = [
            'name.required' => '友情链接标题必须填写',
            'url.required' => '友情链接URL必须填写',
            'link_desc.max' => '友情链接描述长度不能超过255',
            'link_order.numeric' => '友情链接排序必须为数字',
        ];
        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $messages);
        //验证是否通过
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }else{
            $res = Link::where('id',$request->get('id'))->update($data);
            if($res){
                return redirect('admin/link/index');
            }else{
                return back()->withErrors("添加友情链接失败");
            }
        }
    }

    /*
     * 删除友情链接
     * */
    public function postDestroy(){
        $link_id = Input::get('link_id');
//        dd($cate_id) ;
        $res = Link::destroy($link_id);
       if($res){
            $data= [
                'status'=>0,
                'msg'=>'删除友情链接成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'删除友情链接失败'
            ];
        }
        return $data;
    }

}
