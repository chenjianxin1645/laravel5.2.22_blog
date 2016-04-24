@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{asset('public/admin/style/css/pagination.css')}}">
    @endsection

    @section('content')
            <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章列表
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
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="{{url('admin/article/all-delete')}}"><i class="fa fa-recycle"></i>批量删除</a>
                    <a href="{{url('admin/article/index')}}"><i class="fa fa-refresh"></i>全部文章</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr style="text-align: center">
                        <th class="tc" width="3%"><input type="checkbox" name=""></th>
                        <th class="tc">ID</th>
                        <th>分类id</th>
                        <th>作者</th>
                        <th>标题</th>
                        <th>关键字</th>
                        <th>描述</th>
                        <th>浏览量</th>
                        <th>时间</th>
                        <th>操作</th>
                    </tr>
                    @forelse($articles as $article)
                        <tr>
                            <td class="tc"><input type="checkbox" name="id[]" value=""></td>
                            <td class="tc">{{$article->id}}</td>
                            <td class="tc">{{$article->cate_id}}</td>
                            <td class="tc">{{$article->editor}}</td>
                            <td>
                                <a href="#">{{$article->title}}</a>
                            </td>
                            <td>{{$article->tags}}</td>
                            <td>{{$article->description}}</td>
                            <td>{{$article->view}}</td>
                            <td>创建:<br>{{$article->created_at}}<br>修改:<br>{{$article->updated_at}}</td>
                            <td>
                                <a href="{{url('admin/article/edit?id='.$article->id)}}">修改</a><br>
                                <a href="javascript:;" onclick="deleteCate('{{$article->id}}')">删除</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11"><h1 align="center">暂无相关的文章信息</h1></td>
                        </tr>
                    @endforelse
                </table>

                <div class="page_list">
                    {{-- <ul>
                        <li class="disabled"><a href="#">&laquo;</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>--}}
                    {!! $articles->links() !!}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
@endsection

@section('script')
    <script>
        //删除分类
        function deleteCate(art_id) {
            //询问框
            layer.confirm('确定删除该文章？', {
                btn: ['确定', '取消'] //按钮
            }, function () {
//                alert(cate_id);
                var post_data = {'_token': '{{csrf_token()}}', 'art_id': art_id};
                $.post('{{url('admin/article/destroy')}}', post_data, function (data) {
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


