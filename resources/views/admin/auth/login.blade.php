<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="{{asset('public/admin/style/css/ch-ui.admin.css')}}">
	<link rel="stylesheet" href="{{asset('public/admin/style/font/css/font-awesome.min.css')}}">
</head>
<body style="background:#F3F3F4;">
	<div class="login_box">
		<h1>Blog</h1>
		<h2>欢迎使用博客管理平台</h2>
		<div class="form">
			@if(count($errors)>0)
				@foreach($errors->all() as $error )
					<p style="color:red">{{$error}}</p>
				@endforeach
			@endif

			<form action="{{url('admin/auth/login')}}" method="post">
				{{--添加csrf验证--}}
				{!! csrf_field() !!}
				<ul>
					<li>
					<input type="email" name="email" required class="text" value="{{old('email')}}"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="password" required  class="text" value="{{old('password')}}"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<input type="text" class="code" name="code" required/>
						<span><i class="fa fa-check-square-o"></i></span>
						{{--验证码的使用以及再次不重复刷新--}}
						<img src="{{url('admin/auth/make-code')}}" alt="点击刷新"
							 onclick="this.src='{{url('admin/auth/make-code')}}?'+Math.random()">
					</li>
					<li>
						<input type="submit" value="立即登陆"/>
					</li>
					<li>
						<a href="{{url('admin/auth/register')}}">马上注册</a>
					</li>
				</ul>
			</form>
			<p><a href="#">返回首页</a> &copy; 2016 Powered by <a href="http://www.houdunwang.com" target="_blank">http://www.houdunwang.com</a></p>
		</div>
	</div>
</body>
</html>