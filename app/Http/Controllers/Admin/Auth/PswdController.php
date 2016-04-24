<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Model\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PswdController extends Controller
{
    // admin密码修改
    public function getEdit(){
        return view('admin.auth.pass');
    }

    // 提交admin密码修改
    public function postUpdate(Request $request){
        $rules = [
            'password_o' => 'required|between:6,20',
            'password' => 'required|confirmed|between:6,20',
        ];
        $messages = [
            'password_o.required' => '原密码必须填写',
            'password_o.between' => '原密码的长度为6-20位',
            'password.between' => '新密码的长度为6-20位',
            'password.required' => '新密码必须填写',
            'password.confirmed' => '两次输入的新密码不一致',
        ];
        $validation = Validator::make($request->all(),$rules,$messages);
        //判断是否验证通过
        if($validation->fails()){
            return back()->withErrors($validation);
        }else{
            //用户输入的原密码
            $password_o = $request->get('password_o');
            //获取当前修改用户的原密码 并判断密码的一致性
            $old_password = Auth::guard('admin')->user()->password;
//            return ($old_password);
            //验证密码的hash 默认密码是经过hash加密的（bcrypt） 单向散列算法加密
            if(password_verify($password_o,$old_password)){
                //验证成功
                //修改用户的新密码
                $admin_id = Auth::guard('admin')->user()->id;
                //将用户输入的密码进行hash加密
                $new_password = bcrypt($request->get('password'));
                $res = Admin::where('id',$admin_id)->update(['password'=>$new_password]);
                if($res){
                    return back()->withErrors('修改密码成功');
                }else{
                    return back()->withErrors('修改密码失败');
                }
            }else{
                return back()->withErrors('输入的原密码不正确');
            }
        }
    }

}
