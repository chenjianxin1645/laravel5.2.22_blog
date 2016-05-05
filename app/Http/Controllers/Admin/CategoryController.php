<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    /*
     * 分类列表首页
     * */
    public function getIndex(){
        $categorys = (new Category())->tree();
//        dd($categorys);
        $data = [
            'categorys'=>$categorys
        ];
        return view('admin.category.index',$data);
    }

    /*
     * 修改排序
     * */
    public function postOrder(){
//        return 'dsd';
//        $data = Input::all();
        $order_id = Input::get('order_id');
        $order_value = Input::get('order_value');
        $category = Category::find($order_id);
        $category->cate_order = $order_value;
        $res = $category->update();
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
     *添加文章页
     * */
    public function getCreate(){
        //获取顶级分类
        $top_cates = Category::where('pid',0)->get();
        $data = [
            'top_cates'=>$top_cates
        ];
        return view('admin.category.create',$data);
    }

    /*
     * 提交新增文章
     * */
    public function postStore(Request $request){
//        return $request->all();
        //验证数据
        $rules = [
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'keywords' => 'max:255',
            'description' => 'required',
        ];
        $messages = [
            'name.required' => '分类名称必须填写',
            'description.required' => '文章描述必须填写',
            'title.required' => '文章标题必须填写',
        ];
        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $messages);
        //验证是否通过
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }else{
            $res = Category::create($data);
            if($res){
                return redirect('admin/category/index');
            }else{
                return back()->withErrors("添加文章分类失败")->withInput();
            }
        }
    }

    /*
     *添加文章页
     * */
    public function getEdit(){
        $cate_id = Input::get('id');
        //获取顶级分类
        $top_cates = Category::where('pid',0)->get();
        $category = Category::find($cate_id);
//        dd($category);
        $data = [
            'top_cates'=>$top_cates,
            'category'=>$category
        ];
        return view('admin.category.edit',$data);
    }

    /*
     * 提交新增文章
     * */
    public function postUpdate(Request $request){
//        return $request->all();
        //验证数据
        $rules = [
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'keywords' => 'max:255',
            'description' => 'required',
            'cate_order' => 'numeric',
        ];
        $messages = [
            'name.required' => '分类名称必须填写',
            'description.required' => '文章描述必须填写',
            'title.required' => '文章标题必须填写',
            'cate_order.numeric' => '文章排序必须是数字',
        ];
        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $messages);
        //验证是否通过
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }else{
            $res = Category::where('id',$request->get('id'))->update($data);
            if($res){
                return redirect('admin/category/index');
            }else{
                return back()->withErrors("添加文章分类失败");
            }
        }
    }

    /*
     * 删除分类
     * */
    public function postDestroy(){
        /* 删除分类 还需判定所删除的分类是否是顶级分类 因为分类列表显示是基于顶级分类
         * 若是顶级分类，有两种操作
         * 一是禁止删除顶级分类（因顶级分类下有其他的分类）
         * 二是将删除后的顶级分类下的分类一起设置为顶级分类（采用该操作）
         * */
        $cate_id = Input::get('cate_id');
//        dd($cate_id) ;
        $res = Category::destroy($cate_id);//删除分类
        Category::where('pid',$cate_id)->update(['pid'=>0]);//修改已删除分类下的子类的父类id
        if($res){
            $data= [
                'status'=>0,
                'msg'=>'删除分类成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'删除分类失败'
            ];
        }
        return $data;
    }


}
