<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('public/admin/style/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('public/admin/style/font/css/font-awesome.min.css')}}">
    @yield('style')
</head>
<body>

@yield('content')

<script type="text/javascript" src="{{asset('public/admin/style/js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin/style/js/ch-ui.admin.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/views/vendor/layer/layer.js')}}"></script>

@yield('script')

</body>
</html>