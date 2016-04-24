@extends('layouts.admin')

@section('style')
    <config rel="stylesheet" href="{{asset('public/admin/style/css/pagination.css')}}">
        @endsection

        @section('content')
                <!--面包屑导航 开始-->
        <div class="crumb_warp">
            <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
            <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 网站配置列表
        </div>
        <!--面包屑导航 结束-->

        <!--结果页快捷搜索框 开始-->
        {{--<div class="search_wrap">
            <form action="" method="post">
                <table class="search_tab">
                    <tr>
                        <th width="120">选择分类:</th>
                        <td>
                            <select onchange="javascript:location.href=this.value;">
                                <option value="">全部</option>
                                <option value="http://www.baidu.com">百度</option>
                                <option value="http://www.sina.com">新浪</option>
                            </select>
                        </td>
                        <th width="70">关键字:</th>
                        <td><input type="text" name="keywords" placeholder="关键字"></td>
                        <td><input type="submit" name="sub" value="查询"></td>
                    </tr>
                </table>
            </form>
        </div>--}}
                <!--结果页快捷搜索框 结束-->

        <!--搜索结果页面 列表 开始-->

        <div class="result_wrap">
            <div class="result_title">
                <h3>快捷操作</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>新增网站配置</a>
                    <a href="{{url('admin/config/all-delete')}}"><i class="fa fa-recycle"></i>批量删除</a>
                    <a href="{{url('admin/config/index')}}"><i class="fa fa-refresh"></i>全部网站配置</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                @if(count($errors)>0)
                    @foreach($errors->all() as $error )
                        <p style="color:red">{{$error}}</p>
                    @endforeach
                @endif
                <form action="{{url('admin/config/set-content')}}" method="post">
                    {{csrf_field()}}
                    <table class="list_tab">
                        <tr style="text-align: center">
                            <th class="tc" width="3%"><input type="checkbox" name=""></th>
                            <th class="tc">排序</th>
                            <th class="tc">ID</th>
                            <th width="12%">标题</th>
                            <th width="12%">名称</th>
                            <th width="12%">内容</th>
                            <th>描述</th>
                            <th width="13%">时间</th>
                            <th width="5%">操作</th>
                        </tr>
                        @forelse($configs as $config)
                            <tr>
                                <td class="tc"><input type="checkbox" name="id[]" value=""></td>
                                <td class="tc">
                                    <input type="text" onchange="onChangeOrder(this,'{{$config->id}}')"
                                           value="{{$config->config_order}}">
                                </td>
                                <td class="tc">{{$config->id}}</td>
                                <td class="tc">{{$config->title}}</td>
                                <td>{{$config->name}}</td>
                                <input type="hidden" name="id[]" value="{{$config->id}}">
                                <td >{!! $config->data_html !!}</td>
                                <td>{{$config->tips}}</td>
                                <td>创建:<br>{{$config->created_at}}<br>修改:<br>{{$config->updated_at}}</td>
                                <td width="7%">
                                    <a href="{{url('admin/config/edit?id='.$config->id)}}">修改</a><br>
                                    <a href="javascript:;" onclick="deleteconfig('{{$config->id}}')">删除</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11"><h1 align="center">暂无相关的列表页信息</h1></td>
                            </tr>
                        @endforelse

                        <tr>
                            {{--<th>相关操作</th>--}}
                            <td colspan="9">
                                <input type="submit" value="提交">
                                <input type="button" class="back" onclick="history.go(-1)" value="返回">
                            </td>
                        </tr>
                    </table>
                </form>

                <div class="page_list">
                    {{$configs->links()}}
                </div>
            </div>
        </div>

        <!--搜索结果页面 列表 结束-->
        @endsection

        @section('script')
            <script>
                //修改排序onChangeOrder
                function onChangeOrder(obj, id) {
//            alert();
                    var order_id = id;
                    var order_value = $(obj).val();
//            alert(order_id+order_value);
                    var post_data = {'_token': '{{csrf_token()}}', 'order_id': order_id, 'order_value': order_value};
                    $.post('{{url('admin/config/order')}}', post_data, function (data) {
                        //成功请求后的回调函数
                        if (data.status == 0) {
                            layer.msg(data.msg, {icon: 6});
                        } else {
                            layer.msg(data.msg, {icon: 5});
                        }
                    });
                }

                //删除分类
                function deleteconfig(config_id) {
                    //询问框
                    layer.confirm('确定删除该网站配置？', {
                        btn: ['确定', '取消'] //按钮
                    }, function () {
//                alert(cate_id);
                        var post_data = {'_token': '{{csrf_token()}}', 'config_id': config_id};
                        $.post('{{url('admin/config/destroy')}}', post_data, function (data) {
                            //成功请求后的回调函数
                            if (data.status == 0) {
                                //删除之后 再次重新刷新页面
                                location.href = location.href;
                                layer.msg(data.msg, {icon: 6});
//                        location.reload();
//                        alert(location.href);
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                        });
                    }, function () {
                        //取消不做提示
                    });
                }
            </script>
@endsection


