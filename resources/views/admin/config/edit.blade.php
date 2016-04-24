@extends('layouts.admin')

@section('content')
    {{--<!--面包屑导航 开始-->--}}
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;
        <a href="{{url('admin/config/index')}}">网站配置管理</a> &raquo; 修改网站配置
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加网站配置</a>
                <a href="{{url('admin/config/index')}}"><i class="fa fa-refresh"></i>全部网站配置</a>
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
        <form action="{{url('admin/config/update?id='.$config->id)}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>网站配置标题：</th>
                    <td>
                        <input type="text" class="lg" name="title" size="50" required value="{{$config->title}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>网站配置名称：</th>
                    <td>
                        <input type="text" class="lg" name="name" size="50" required value="{{$config->name}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>网站配置名称类型：</th>
                    <td>
                        <input type="radio" class="lg" name="field_type" onclick="selectRadio()" @if($config->field_type=='input') checked @endif  value="input">input&nbsp;&nbsp;&nbsp;
                        <input type="radio" class="lg" name="field_type" onclick="selectRadio()" value="textarea" @if($config->field_type=='textarea') checked @endif >textarea&nbsp;&nbsp;&nbsp;
                        <input type="radio" class="lg" name="field_type" onclick="selectRadio()" value="radio"  @if($config->field_type=='radio') checked @endif>redio
                    </td>
                </tr>
                <tr class="field_value">
                    <th><i class="require">*</i>网站配置名称类型值：</th>
                    <td>
                        <input type="text" class="lg" name="field_value"  value="{{$config->field_value}}">
                        <p><i class="fa fa-exclamation-circle yellow"></i>当选择类型为radio时 设置其值 格式:1|开启,0|关闭</p>
                    </td>
                </tr>
                <tr>
                    <th>网站配置描述：</th>
                    <td>
                        <textarea name="tips" required>{{$config->tips}}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>网站配置排序：</th>
                    <td>
                        <input type="text" name="config_order" value="{{$config->config_order}}">
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

@section('script')
    <script>
        selectRadio();
        function selectRadio(){
            //alert('dasdas');
            var type = $('input[name=field_type]:checked').val();
//            alert(type);
            if(type=='radio'){
                $('.field_value').show();
            }else{
                $('.field_value').hide();
            }
        }

    </script>
@endsection
