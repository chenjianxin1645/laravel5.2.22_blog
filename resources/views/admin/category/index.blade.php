@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{asset('public/admin/style/css/pagination.css')}}">
@endsection

@section('content')
    <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 分类列表
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
<form action="#" method="post">
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分类</a>
                <a href="{{url('admin/category/all-delete')}}"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="{{url('admin/category/index')}}"><i class="fa fa-refresh"></i>全部分类</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr style="text-align: center">
                    <th class="tc"  width="3%"><input type="checkbox" name=""></th>
                    <th class="tc">排序</th>
                    <th class="tc">ID</th>
                    <th width="10%">分类</th>
                    <th width="12%">标题</th>
                    <th width="7%">关键字</th>
                    <th >描述</th>
                    <th width="5%">点击</th>
                    <th width="5%">父类id</th>
                    <th width="13%">时间</th>
                    <th width="5%">操作</th>
                </tr>
                @forelse($categorys as $category)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value=""></td>
                        <td class="tc">
                            <input type="text" onchange="onChangeOrder(this,'{{$category->id}}')" value="{{$category->cate_order}}">
                        </td>
                        <td class="tc">{{$category->id}}</td>
                        <td class="tc">{{$category->_name}}</td>
                        <td>
                            <a href="#">{{$category->title}}</a>
                        </td>
                        <td>{{$category->keywords}}</td>
                        <td>{{$category->description}}</td>
                        <td>{{$category->view}}</td>
                        <td>{{$category->pid}}</td>
                        <td>创建:<br>{{$category->created_at}}<br>修改:<br>{{$category->updated_at}}</td>
                        <td>
                            <a href="{{url('admin/category/edit?id='.$category->id)}}">修改</a><br>
                            <a href="javascript:;" onclick="deleteCate('{{$category->id}}')">删除</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11"><h1 align="center">暂无相关的列表页信息</h1></td>
                    </tr>
                @endforelse
            </table>

            <div align="center">
                {{--{!! $categorys->render() !!}--}}
            </div>

{{--
            <div class="page_nav">
                <div>
                    <a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a>
                    <a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a>
                    <a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>
                    <a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>
                    <span class="current">8</span>
                    <a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>
                    <a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a>
                    <a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a>
                    <a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a>
                    <span class="rows">11 条记录</span>
                </div>
            </div>
--}}
            {{--<div class="page_list">
                <ul>
                    <li class="disabled"><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
                <span class="rows">11 条记录</span>
            </div>--}}
        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->
@endsection

@section('script')
    <script>
        //修改排序
        function onChangeOrder(obj,id){
//            alert();
            var order_id = id;
            var order_value = $(obj).val();
//            alert(order_id+order_value);
            var post_data = {'_token':'{{csrf_token()}}','order_id':order_id,'order_value':order_value};
            $.post('{{url('admin/category/order')}}',post_data,function(data){
                //成功请求后的回调函数
                if(data.status==0){
                    layer.msg(data.msg, {icon: 6});
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
        }

        //删除分类
        function deleteCate(cate_id){
            //询问框
            layer.confirm('确定删除该分类？', {
                btn: ['确定','取消'] //按钮
            }, function(){
//                alert(cate_id);
                var post_data = {'_token':'{{csrf_token()}}','cate_id':cate_id};
                $.post('{{url('admin/category/destroy')}}',post_data,function(data){
                    //成功请求后的回调函数
                    if(data.status==0){
                        //删除之后 再次重新刷新页面
                        location.href = location.href;
                        layer.msg(data.msg, {icon: 6});
//                        location.reload();
//                        alert(location.href);
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
                });
            }, function(){
                //取消不做提示
            });
        }
    </script>
@endsection


