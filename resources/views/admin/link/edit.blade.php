@extends('layouts.admin')

@section('content')
    {{--<!--面包屑导航 开始-->--}}
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;
        <a href="{{url('admin/link/index')}}">友情链接列表</a> &raquo; 编辑友情链接
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/link/create')}}"><i class="fa fa-plus"></i>添加友情链接</a>
                <a href="{{url('admin/link/index')}}"><i class="fa fa-refresh"></i>全部友情链接</a>
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
        <form action="{{url('admin/link/update')}}" method="post">
            {{csrf_field()}}
            <input hidden name="id" value="{{$link->id}}">
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>友情链接标题：</th>
                    <td>
                        <input type="text" class="lg" name="name" size="50" required value="{{$link->name}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>友情链接URL：</th>
                    <td>
                        <input type="text" class="lg" name="url" required value="{{$link->url}}">
                    </td>
                </tr>
                <tr>
                    <th>友情链接描述：</th>
                    <td>
                        <textarea name="link_desc" required>{{$link->link_desc}}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>友情链接排序：</th>
                    <td>
                        <input type="text" name="link_order" value="{{$link->link_order}}">
                    </td>
                </tr>
                <tr>
                    <th>相关操作</th>
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

