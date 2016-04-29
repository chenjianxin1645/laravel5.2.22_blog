<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /*
     * 文章管理列表首页
     * */
    public function getIndex()
    {
        //设置分页获取数据
        $articles = Article::paginate(10);
        $data = [
            'articles' => $articles
        ];
        return view('admin.article.index', $data);
    }

    /*
     * 添加文章
     * */
    public function getCreate()
    {
        //获取文章分类的所有分类
        $categorys = (new Category())->tree();
        $data = [
            'categorys' => $categorys
        ];
        return view('admin.article.create', $data);
    }

    /*
     * 提交文章
     * */
    public function postStore(Request $request)
    {
//        return $request->all();
        //验证数据
        $rules = [
            'editor' => 'required|max:255',
            'title' => 'required|max:255',
            'tags' => 'max:255',
            'description' => 'required',
            'content' => 'required',
        ];
        $messages = [
            'editor.required' => '作者名称必须填写',
            'title.required' => '文章标题必须填写',
            'description.required' => '文章描述必须填写',
            'content.required' => '文章内容必须填写',
        ];
        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $messages);
        //验证是否通过
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $res = Article::create($data);
            if ($res) {
                return redirect('admin/article/index');
//                return back()->withErrors("添加文章成功")->withInput();
            } else {
                return back()->withErrors("添加文章失败")->withInput();
            }
        }
    }

    /*
     *编辑文章
     * */
    public function getEdit(){
        $art_id = Input::get('id');
//        return $cate_id;
        //获取文章
        $article = Article::find($art_id);
        //获取文章分类的所有分类
        $categorys = (new Category())->tree();
        $data = [
            'categorys' => $categorys,
            'article'=>$article
        ];
        return view('admin.article.edit', $data);
    }

    /*
     * 提交修改文章
     * */
    public function postUpdate(Request $request){
//        return $request->all();
        //验证数据
        $rules = [
            'editor' => 'required|max:255',
            'title' => 'required|max:255',
            'tags' => 'max:255',
            'description' => 'required',
            'content' => 'required',
        ];
        $messages = [
            'editor.required' => '作者名称必须填写',
            'title.required' => '文章标题必须填写',
            'description.required' => '文章描述必须填写',
            'content.required' => '文章内容必须填写',
        ];
        $data = $request->except('_token');
        $validator = Validator::make($data, $rules, $messages);
        //验证是否通过
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }else{
            $res = Article::where('id',$request->get('id'))->update($data);
            if($res){
                return redirect('admin/article/index');
            }else{
                return back()->withErrors("修改文章失败");
            }
        }
    }

    /*
     * 删除文章
     * */
    public function postDestroy()
    {
        $art_id = Input::get('art_id');
        //删除文章  删除文章之前还要将已经上传的图片也一起删除
        //获取图片的上传路径
        $art_thumb_path = Article::where('id',$art_id)->value('thumb');
        $file_path = base_path().$art_thumb_path;
//        dd($file_path);
        $res = Article::destroy($art_id);
        if ($res) {
            //删除成功 再来删除图片
            if(file_exists($file_path)){
                unlink($file_path);
            }
            $data = [
                'status' => 0,
                'msg' => '删除文章成功'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '删除文章失败'
            ];
        }
        return $data;
    }

    /*
     * 上传文章的缩略图
     * */
    public function postUpload(Request $request)
    {
        //dd($request->all());
        //进行文件一般上传的操作
        $file = $request->file('Filedata');
//        return $file;
        $upload_dir = $request->get('upload_dir');
//        dd($file);
        //验证文件是否有效
        if ($file->isValid()) {
            $path = '/public/uploads/'.$upload_dir.'/'.date('Ym');
            $path_dir = base_path() . $path;
//            dd($path_dir);
//            if(!file_exists($path_dir)){
//                mkdir($path_dir);
//            }
            //文件重命名 并移动到相应的保存目录
            $entension = $file->getClientOriginalExtension(); //上传文件的后缀.
            $newName = date('YmdHis') . mt_rand(1000, 9999) . '.' . $entension;
            $file->move($path_dir, $newName);
            $filepath = $path.'/'. $newName;
            //返回文件保存的路径
            return $filepath;
        }

    }

    /*
     * 取消上传文章的缩略图
     * */
    public function postCancelUpload(Request $request)
    {
        $path = $request->get('path');
        $file_path = base_path().$path;
//        dd($path);
        //判断文件是否存在
        if(file_exists($file_path)){
            //若存在  将文件删除
            if(unlink($file_path)){
                $data = [
                    'status' => 0,
                    'msg' => '取消图片上传成功'
                ];
            }else{
                $data = [
                    'status' => 1,
                    'msg' => '取消图片上传失败'
                ];
            }
        }else{
            $data = [
                'status' => 1,
                'msg' => '图片不存在，请重新上传！'
            ];
        }
        return $data;
    }


}
