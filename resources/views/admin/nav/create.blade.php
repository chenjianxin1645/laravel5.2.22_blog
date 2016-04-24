@extends('layouts.admin')

@section('content')
    {{--<!--面包屑导航 开始-->--}}
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;
        <a href="{{url('admin/nav/index')}}">自定义导航管理</a> &raquo; 添加自定义导航
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/nav/create')}}"><i class="fa fa-plus"></i>添加自定义导航</a>
                <a href="{{url('admin/nav/index')}}"><i class="fa fa-refresh"></i>全部自定义导航</a>
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
        <form action="{{url('admin/nav/store')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>自定义导航标题：</th>
                    <td>
                        <input type="text"  name="name" size="45" required value="{{old('name')}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>自定义导航别名：</th>
                    <td>
                        <input type="text"  name="alias" size="45" required value="{{old('name')}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>自定义导航URL：</th>
                    <td>
                        <input type="text" class="lg" name="url" required value="@if(count($errors)==0)http://@else{{old('url')}}@endif">
                    </td>
                </tr>
                <tr>
                    <th>自定义导航排序：</th>
                    <td>
                        <input type="text" name="nav_order" value="{{old('nav_order')}}">
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
