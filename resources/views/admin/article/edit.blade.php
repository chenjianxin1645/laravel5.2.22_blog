@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" type="text/css"
          href="{{asset('resources/views/vendor/uploadify/uploadify.css')}}">

    <style>
        /*
        * 编辑器的样式矫正
        */
        .edui-default {
            line-height: 28px;
        }

        div.edui-combox-body, div.edui-button-body, div.edui-splitbutton-body {
            overflow: hidden;
            height: 20px;
        }

        div.edui-box {
            overflow: hidden;
            height: 22px;
        }

        /*
        * 图片上传样式矫正
        */
        .uploadify {
            display: inline-block;
        }

        .uploadify-button {
            border: none;
            border-radius: 5px;
            margin-top: 8px;
        }

        table.add_tab tr td span.uploadify-button-text {
            color: #FFF;
            margin: 0;
        }

    </style>
@endsection

@section('content')
    {{--<!--面包屑导航 开始-->--}}
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;
        <a href="{{url('admin/article/index')}}">文章管理</a> &raquo; 编辑文章
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/article/index')}}"><i class="fa fa-refresh"></i>全部文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        @if(count($errors)>0)
            @foreach($errors->all() as $error )
                <p style="color:red">{{$error}}</p>
            @endforeach
        @endif
        <form action="{{url('admin/article/update')}}" method="post">
            {{csrf_field()}}
            <input hidden name="id" value="{{$article->id}}">
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>文章分类：</th>
                    <td>
                        <select name="cate_id" required>
                            @foreach($categorys as $category )
                                <option value="{{$category->id}}" @if($article->cate_id==$category->id) selected @endif>
                                    {{$category->_name}}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>文章作者：</th>
                    <td>
                        <input type="text" name="editor" size="50" required value="{{$article->editor}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>文章标题：</th>
                    <td>
                        <input type="text" class="lg" name="title" required value="{{$article->title}}">
                    </td>
                </tr>
                <tr>
                    <th>文章关键字：</th>
                    <td>
                        <input type="text" class="lg" name="tags" value="{{$article->tags}}">
                    </td>
                </tr>
                <tr>
                    <th>缩略图：</th>
                    <td>
                        <input type="text" size="50" name="thumb" value="@if(count($errors)>0){{old('thumb')}}@else{{$article->thumb}}@endif">
                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                    </td>
                </tr>
                <tr>
                    <th>缩略图预览：</th>
                    <td>
                        @if(!empty($article->thumb))
                            <img src="@if(count($errors)>0){{asset(old('thumb'))}}@else{{asset($article->thumb)}}@endif" alt="" id="art_thumb_img"
                                 style="max-width: 350px; max-height:100px;">
                            <img src="{{asset('resources/views/vendor/uploadify/uploadify-cancel.png')}}" alt=""
                                 title="取消上传" id="cancel_art_thumb_img" style="max-width: 350px; max-height:100px;">
                        @else
                            <img src="" alt="" id="art_thumb_img" style="max-width: 350px; max-height:100px;">
                            <img src="" alt="" title="取消上传" id="cancel_art_thumb_img"
                                 style="max-width: 350px; max-height:100px;">
                        @endif
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>文章描述：</th>
                    <td>
                        <textarea name="description" required>{{$article->description}}</textarea>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>文章内容：</th>
                    <td>
                        <script id="editor" name="content" type="text/plain" style="width:860px;height:400px;">{!! $article->content !!}</script>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection

@section('script')

    {{--ueditor的基本配置--}}
    <script type="text/javascript" charset="utf-8"
            src="{{asset('resources/views/vendor/ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8"
            src="{{asset('resources/views/vendor/ueditor/ueditor.all.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8"
            src="{{asset('resources/views/vendor/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <script type="text/javascript">
        //实例化编辑器的对象
        var ue = UE.getEditor('editor');
    </script>

    {{--uploadify的基本配置--}}
    {{--注意uploadify组件基于与jq 必须将jq文件放在其前面--}}
    <script src="{{asset('resources/views/vendor/uploadify/jquery.uploadify.min.js')}}"
            type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            //图片上传
            $('#file_upload').uploadify({
                'buttonText': '图片上传',
                'formData': {
                    'upload_dir': "article",
                    '_token': "{{csrf_token()}}"
                },
                'swf': "{{asset('resources/views/vendor/uploadify/uploadify.swf')}}",
                'uploader': "{{url('admin/article/upload')}}",
                'onUploadSuccess': function (file, data, response) {
                    $('input[name=thumb]').val(data);
                    $('#art_thumb_img').attr('src', data);
                    $('#cancel_art_thumb_img').attr('src', '{{asset('resources/views/vendor/uploadify/uploadify-cancel.png')}}');
//                    alert(data);
                }
            });

            //取消图片的上传
            $('#cancel_art_thumb_img').click(function () {
                //询问框
                layer.confirm('确定取消上传？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    //获取取消上传的图片路径
                    var path = $('input[name=thumb]').val();
//                    alert(path);
//                    return false;
                    var post_data = {'_token': '{{csrf_token()}}', 'path': path};
                    $.post('{{url('admin/article/cancel-upload')}}', post_data, function (data) {
                        //成功请求后的回调函数
                        if (data.status == 0) {
                            layer.msg(data.msg, {icon: 6});
                            $('input[name=thumb]').val('');
                            $('#art_thumb_img').attr('src', '');
                            $('#cancel_art_thumb_img').attr('src', '');
                        } else {
                            layer.msg(data.msg, {icon: 5});
                        }
                    });
                }, function () {
                    //取消不做提示
                });
            });

        });
    </script>

@endsection
