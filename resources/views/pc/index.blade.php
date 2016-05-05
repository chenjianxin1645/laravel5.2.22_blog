@extends('layouts.pc',[
  'navs'=>$navs,
])
@section('styles')
    <link href="{{asset('public/pc/css/index.css')}}" rel="stylesheet">
    <link href="{{asset('public/pc/css/style.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="banner">
        <section class="box">
            <ul class="texts">
                <p>打了死结的青春，捆死一颗苍白绝望的灵魂。</p>
                <p>为自己掘一个坟墓来葬心，红尘一梦，不再追寻。</p>
                <p>加了锁的青春，不会再因谁而推开心门。</p>
            </ul>
            <div class="avatar"><a href="#"><span>后盾</span></a></div>
        </section>
    </div>
    <div class="template">
        <div class="box">
            <h3>
                <p><span>文章</span>推荐 Recommended</p>
            </h3>
            <ul>
                @foreach($hots as $hot)
                    <li>
                        <a href="{{url('art/'.$hot->id)}}" target="_blank"><img src="{{asset($hot->thumb)}}"></a>
                        <span>{{$hot->title}}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <article>
        <h2 class="title_tj">
            <p>最新<span>文章</span></p>
        </h2>

        <div class="bloglist left">
            @foreach($new_arts as $new_art)
                <h3>{{$new_art->title}}</h3>
                <figure><img src="{{asset($new_art->thumb)}}"></figure>
                <ul>
                    <p>{{$new_art->description}}</p>
                    <a title="{{$new_art->title}}" href="{{url('art/'.$new_art->id)}}" target="_blank" class="readmore">阅读全文>></a>
                </ul>
                <p class="dateview"><span> {{date('Y-m-d',strtotime($new_art->updated_at))}}</span><span>作者：{{$new_art->editor}}</span>
                    <span>分类：[<a href="{{url('cate'.$new_art->cate_id)}}">{{$new_art->belongsToCategory->name}}</a>]</span></p>
            @endforeach
            <div class="line"></div>
            <div class="page">
                <ul class="pagination">
                    {!! $new_arts->links() !!}
                    {{--@if($new_arts->currentPage()!=1)
                        <li><a href="{{url('?page=1')}}">««</a></li>
                        <li><a href="{{url('?page='.($new_arts->currentPage()-1))}}">«</a></li>
                    @endif
                    <li class="active"><span>{{$new_arts->currentPage()}}</span></li>
                    @if($new_arts->currentPage()!=$new_arts->lastPage())
                        <li><a href="{{url('?page='.($new_arts->currentPage()+1))}}" rel="next">»</a></li>
                        <li><a href="{{url('?page='.$new_arts->lastPage())}}">»»</a></li>
                    @endif--}}
                </ul>
            </div>
        </div>

        <aside class="right">
            <div class="weather" style="float: left">
                <iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true"
                        src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe>
            </div>
            @parent
            <h3 class="links">
                <p>友情<span>链接</span></p>
            </h3>
            <ul class="website">
                @foreach($links as $link)
                    <li><a href="{{$link->url}}">{{$link->name}}</a></li>
                @endforeach
            </ul>
        </aside>
    </article>
@stop


