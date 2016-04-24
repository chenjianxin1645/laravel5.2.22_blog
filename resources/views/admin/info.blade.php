@extends('layouts.admin')

@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 后台信息页
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
    <div class="result_title">
        <h3>系统基本信息</h3>
    </div>
    <div class="result_content">
        <ul>
            <li>
                <label>操作系统</label><span>{{PHP_OS}}</span>
            </li>
            <li>
                <label>运行环境</label><span><?PHP echo $_SERVER ['SERVER_SOFTWARE']; ?></span>
            </li>
            <li>
                <label>版本</label><span>v-1.0</span>
            </li>
            <li>
                <label>上传附件限制</label><span> <?PHP echo get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件"; ?></span>
            </li>
            <li>
                <label>北京时间</label><span>{{date("Y-m-d G:i:s")}}</span>
            </li>
            <li>
                <label>服务器域名/IP</label><span><?PHP echo $_SERVER ['SERVER_NAME' ]; ?>[ <?PHP echo $_SERVER ['SERVER_ADDR']; ?> ]</span>
            </li>
            <li>
                <label>Host</label><span><?PHP echo $_SERVER ['SERVER_ADDR']; ?></span>
            </li>
        </ul>
    </div>
</div>


<div class="result_wrap">
    <div class="result_title">
        <h3>使用帮助</h3>
    </div>
    <div class="result_content">
        <ul>
            <li>
                <label>官方交流网站：</label><span><a href="#">http://bbs.houdunwang.com</a></span>
            </li>
            <li>
                <label>官方交流QQ群：</label><span><a href="#"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png"></a></span>
            </li>
        </ul>
    </div>
</div>
<!--结果集列表组件 结束-->
@endsection
