<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{{config('web.web_title')}}</title>
<meta name="keywords" content="{{config('web.web_keywords')}}" />
<meta name="description" content="{{config('web.web_description')}}" />
<link href="{{asset('public/pc/css/base.css')}}" rel="stylesheet">
  @yield('styles')
<!--[if lt IE 9]><!---->
<script src="{{asset('public/pc/js/modernizr.js')}}"></script>
{{--<![endif]-->--}}
</head>
<body>
<header>
  <div id="logo"><a href="{{url('/')}}"></a></div>
  <nav class="topnav" id="topnav">
    @foreach($navs as $nav)<a href="{{$nav->url}}"><span>{{$nav->name}}</span><span class="en">{{$nav->alias}}</span></a>@endforeach
  </nav>
  </nav>
</header>


@section('content')
  {{--共享部分--}}
{{--<!-- Baidu Button BEGIN -->--}}
<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a
          class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span
          class="bds_more"></span><a class="shareCount"></a></div>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585"></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
  document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date() / 3600000)
</script>
{{--<!-- Baidu Button END -->--}}
<div class="news" style="float: left">
  <h3>
    <p>最新<span>文章</span></p>
  </h3>
  <ul class="rank">
    @foreach($new_arts as $new_art)
      <li><a href="{{asset('art/'.$new_art->id)}}" title="{{$new_art->title}}"
             target="_blank">{{$new_art->title}}</a></li>
    @endforeach
  </ul>
  <h3 class="ph">
    <p>点击<span>排行</span></p>
  </h3>
  <ul class="paih">
    @foreach($hots as $k=>$v)
      @if($k!=5)
        <li><a href="{{asset('art/'.$v->id)}}" title="{{$v->title}}"
               target="_blank">{{$v->title}}</a></li>
      @endif
    @endforeach
  </ul>
</div>
@show

<footer>
  <p>Design by {{config('web.web_author')}} <a href="http://www.miitbeian.gov.cn/" target="_blank">{{config('web.web_url')}}</a> <a href="/">网站统计</a></p>
</footer>
<script src="{{asset('public/pc/js/silder.js')}}"></script>
@yield('scripts')
</body>
</html>
