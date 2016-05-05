@extends('layouts.pc')
@section('styles')
    <link href="{{asset('public/pc/css/style.css')}}" rel="stylesheet">
@endsection
@section('content')
    <article class="blogs">
        <h1 class="t_nav"><span> 全部文章等着你品尝 </span>
            <a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('lists')}}" class="n2">所有文章</a></h1>
        <div class="newblog left">
            @foreach($new_arts as $new_art)
                <h2>{{$new_art->title}}</h2>
                <p class="dateview"><span>发布时间：{{date('Y-m-d',strtotime($new_art->updated_at))}}</span><span>作者：{{$new_art->editor}}</span><span>分类：[<a href="{{url('cates/'.$new_art->cate_id)}}">{{$new_art->belongsToCategory->name}}</a>]</span></p>
                <figure><img src="{{asset($new_art->thumb)}}"></figure>
                <ul class="nlist">
                    <p>{{$new_art->description}}</p>
                    <a title="{{$new_art->title}}" href="{{url('art/'.$new_art->id)}}" target="_blank" class="readmore">阅读全文>></a>
                </ul>
                <div class="line"></div>
            @endforeach
            <div class="blank"></div>
            <div class="ad">
                <img src="{{asset('public/pc/images/ad.png')}}">
            </div>
            <div class="page">
                <ul class="pagination">
                    {!! $new_arts->links() !!}
                   {{-- @if($new_arts->currentPage()!=1)
                        <li><a href="{{url('lists?page=1')}}">««</a></li>
                        <li><a href="{{url('lists?page='.($new_arts->currentPage()-1))}}">«</a></li>
                    @endif
                    <li class="active"><span>{{$new_arts->currentPage()}}</span></li>
                    @if($new_arts->currentPage()!=$new_arts->lastPage())
                        <li><a href="{{url('lists?page='.($new_arts->currentPage()+1))}}" rel="next">»</a></li>
                        <li><a href="{{url('lists?page='.$new_arts->lastPage())}}">»»</a></li>
                    @endif--}}
                </ul>
            </div>
        </div>
        <aside class="right">
            @if(!empty($categorys->all()))
            <div class="rnav">
                <ul>
                    @foreach($categorys as $k=>$v)
                        @if($k>3)
                        <li class="rnav{{$k%4+1}}"><a href="{{url('cates/'.$v->id)}}" target="_blank">{{$v->name}}</a></li>
                        @else
                            <li class="rnav{{$k+1}}"><a href="{{url('cates/'.$v->id)}}" target="_blank">{{$v->name}}</a></li>
                        @endif
                    @endforeach
               </ul>
            </div>
            @endif
            @parent
        </aside>
    </article>
@endsection
