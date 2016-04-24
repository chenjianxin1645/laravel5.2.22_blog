<?php

/*
 * Admin/Auth
 * */
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'web'],function(){
    Route::controller('auth', 'Auth\AuthController');
    Route::controller('password', 'Auth\PasswordController');
});

/*
* Admin/Router
 * */
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['admin']],function(){
    //文章首页信息
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
//    Route::get('server1', 'IndexController@server');

    //文章分类管理
    Route::controller('category', 'CategoryController');
    //文章管理
    Route::controller('article', 'ArticleController');
    //友情链接管理
    Route::controller('link', 'LinkController');
    //自定义导航管理
    Route::controller('nav', 'NavController');
    //网站配置管理
    Route::controller('config', 'ConfigController');

    //管理员密码修改
    Route::controller('pswd', 'Auth\PswdController');

});
