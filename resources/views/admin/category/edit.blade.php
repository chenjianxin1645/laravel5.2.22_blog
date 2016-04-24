@extends('layouts.admin')

@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;
    <a href="{{url('admin/category/index')}}">文章分类列表页</a> &raquo; 编辑文章分类
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>快捷操作</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增文章</a>
            <a href="{{url('admin/category/index')}}"><i class="fa fa-refresh"></i>全部文章分类</a>
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
    <form action="{{url('admin/category/update')}}" method="post">
        {{csrf_field()}}
        <input hidden name="id" value="{{$category->id}}">
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>选择分类：</th>
                <td>
                    <select name="pid" required>
                        <option  value="0" @if($category->pid==0) selected @endif>==顶级分类==</option>
                        @foreach($top_cates as $top_cate )
                            <option value="{{$top_cate->id}}" @if($category->pid==$top_cate->id) selected @endif>{{$top_cate->name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>分类名：</th>
                <td>
                    <input type="text" class="lg" name="name" required value="{{$category->name}}" >
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>文章标题：</th>
                <td>
                    <input type="text" class="lg" name="title" required value="{{$category->title}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>文章关键字：</th>
                <td>
                    <input type="text" class="lg" name="keywords"  value="{{$category->keywords}}">
                </td>
            </tr>
            <tr>
                <th>文章描述：</th>
                <td>
                    <textarea name="description" required>{{$category->description}}</textarea>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>文章排序：</th>
                <td>
                    <input type="text" class="lg" name="cate_order"  value="{{$category->cate_order}}">
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
