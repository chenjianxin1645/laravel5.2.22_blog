<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    /*
    * 网站配置首页
    * */
    public function getIndex(){
        $configs = Config::orderBy('config_order','asc')->paginate(10);
        //根据网站配置的类型 将配置内容呈现出来

        foreach($configs as $k=>$v){
            $type = $v->field_type;
            $v->data_html= '';
            if($type=='input'){
                $v->data_html = '<input name="content[]" class="lg" type="text" required value="'.$v->content.'" > ';
            }elseif ($type=='textarea'){
                $v->data_html = '<textarea required name="content[]" >'.$v->content.'</textarea> ';
            }elseif ($type=='radio'){
                //1|开启,0|关闭
                $arr = explode(',',$v->field_value);
                foreach ($arr as $m=>$n){
                    //1|开启
                    $arr1 = explode('|',$n);
                    if($arr1['0']==$v->content){
                        $v->data_html.= '<input type="radio" required name="content[]"  checked value="'.$v->content.'">'.$arr1['1'].'&nbsp;&nbsp;&nbsp;';
                    }else{
                        $v->data_html.= '<input type="radio" required name="content[]" value="'.$arr1['0'].'">'.$arr1['1'].'&nbsp;&nbsp;&nbsp;';
                    }
               }
                echo $v->date_html;
            }
        }
        $data = [
            'configs'=>$configs
        ];
        return view('admin.config.index',$data);
    }

    /*
     * 修改排序
     * */
    public function postOrder(){
//        return 'dsd';
//        $data = Input::all();
        $order_id = Input::get('order_id');
        $order_value = Input::get('order_value');
        $config = Config::find($order_id);
        $config->config_order = $order_value;
        $res = $config->save();
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
     *添加网站配置
     * */
    public function getCreate(){
        return view('admin.config.create');
    }

    /*
     * 提交网站配置
     * */
    public function postStore(Request $request){
//        return $request->all();
        //验证数据
        $rules = [
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'field_type' => 'required',
            'tips' => 'max:255',
            'config_order' => 'numeric',
        ];
        $messages = [
            'title.required' => '网站配置标题必须填写',
            'name.required' => '网站配置名称必须填写',
            'field_type.required' => '网站配置类型必须填写',
            'tips.max' => '网站配置描述长度不能超过255',
            'config_order.numeric' => '网站配置排序必须为数字',
        ];
        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $messages);
        //验证是否通过
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }else{
            $res = Config::create($data);
            if($res){
                return redirect('admin/config/index');
            }else{
                return back()->withErrors("添加网站配置失败")->withInput();
            }
        }
    }

    /*
     *修改网站配置
     * */
    public function getEdit(){
        $config_id = Input::get('id');
        $config = Config::find($config_id);
        $data = [
            'config'=>$config
        ];
        return view('admin.config.edit',$data);
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
            'field_type' => 'required',
            'tips' => 'max:255',
            'config_order' => 'numeric',
        ];
        $messages = [
            'title.required' => '网站配置标题必须填写',
            'name.required' => '网站配置名称必须填写',
            'field_type.required' => '网站配置类型必须填写',
            'tips.max' => '网站配置描述长度不能超过255',
            'config_order.numeric' => '网站配置排序必须为数字',
        ];
        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $messages);
        //验证是否通过
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }else{
           /* if(!$request->get('field_type')=='radio'){
                $request->get('field_value') = null;
            }*/
            $res = Config::where('id',$request->get('id'))->update($data);
            if($res){
                return redirect('admin/config/index');
            }else{
                return back()->withErrors("添加网站配置失败");
            }
        }
    }

    /*
     * 删除网站配置
     * */
    public function postDestroy(){
        $config_id = Input::get('config_id');
//        dd($cate_id) ;
        $res = config::destroy($config_id);
        if($res){
            $data= [
                'status'=>0,
                'msg'=>'删除网站配置成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'删除网站配置失败'
            ];
        }
        return $data;
    }

    /*
     *提交网站配置内容的修改
     * */
    public function postSetContent(Request $request){
//                return $request->all();
        //验证数据
        $rules = [
            'content' => 'required'

        ];
        $messages = [
            'content.required' => '网站配置内容必须填写',
        ];
        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $messages);
        //验证是否通过
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }else{
            $arr_id = $request->get('id');
            $arr_con = $request->get('content');
            foreach ($arr_con as $k=>$v){
                $res = Config::where('id',$arr_id[$k])->update(['content'=>$v]);
                if(!$res)
                    return back()->withErrors("设置网站配置内容失败");
            }
            //更新成功
            return redirect('admin/config/index')->withErrors("设置网站配置内容成功");;
        }
    }


}
