@extends('layouts.pc')
@section('styles')
    <link href="{{asset('public/pc/css/new.css')}}" rel="stylesheet">
@endsection
@section('content')
    <article class="blogs">
        <h1 class="t_nav">
            <span>您当前的位置：<a href="{{url('/')}}">首页</a>&nbsp;&gt;&nbsp;<a
                        href="{{url('cates/'.$cate->id)}}">{{$cate->name}}</a></span>
            <a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cates/'.$cate->id)}}"
                                                         class="n2">{{$cate->name}}</a></h1>
        <div class="index_about">
            <h2 class="c_titile">{{$art->title}}</h2>
            <p class="box_c">
                <span class="d_time">发布时间：{{date('Y-m-d',strtotime($art->updated_at))}}</span>
                <span>编辑：{{$art->editor}}</span>
                <span>查看次数：{{$art->view}}</span>
            </p>
            <ul class="infos">
                {!! $art->content !!}
            </ul>
            <div class="keybq">
                <p><span>关键字词</span>：{{$art->tags}}</p>

            </div>
            <div class="ad"></div>
            <div class="nextinfo">
                @if(!empty($art->last_art()))
                    <p>上一篇：<a href="{{url('art/'.$art->last_art()->id)}}">{{$art->last_art()->title}}</a></p>
                @else
                    <span>没有上一篇文章</span>
                @endif
                @if(!empty($art->next_art()))
                    <p>下一篇：<a href="{{url('art/'.$art->next_art()->id)}}">{{$art->next_art()->title}}</a></p>
                @else
                    <span>没有下一篇文章</span>
                @endif
            </div>
            <div class="otherlink">
                <h2>相关文章</h2>
                <ul>
                    @foreach($rel_arts as $rel_art)
                        <li><a href="{{url('art/'.$rel_art->id)}}" title="{{$rel_art->title}}">{{$rel_art->title}}</a></li>
                    @endforeach
               </ul>
            </div>
        </div>
        <aside class="right">
            @parent
        </aside>
    </article>
@endsection