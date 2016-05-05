<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

/*
 * 填充文章
 * */
$factory->define(App\Http\Model\Article::class, function (Faker\Generator $faker) {
    $title = $faker->sentence(mt_rand(3, 10));
    $cate_id = \App\Http\Model\Category::lists('id');
    $thumb = array(
        '/public/uploads/article/201605/201605031719052438.jpg',
        '/public/uploads/article/201605/201605031722535449.jpg',
        '/public/uploads/article/201605/201605031723331864.jpg',
        '/public/uploads/article/201605/201605031723415502.jpg'
    );
    $tag = array();
    for ($i=0;$i<mt_rand(0,5);$i++){
        $tag[] = $faker->word;
    }
    if(empty($tag)){
        $tag = '';
    }else{
        $tag = implode(',',$tag);
    }
    return [
        'title' => $title,
        'editor' => $faker->word,
        'cate_id' => $cate_id[mt_rand(0,count($cate_id)-1)],
        'view' => mt_rand(10,100),
        'thumb' => $thumb[mt_rand(0,3)],
        'tags' => $tag,
        'description' => $faker->sentence(30,255),
        'content' => join('<br><br>',$faker->paragraphs(mt_rand(10,30))),
    ];
});

/*
 * 填充分类
 * */
$factory->define(App\Http\Model\Category::class, function (Faker\Generator $faker) {
    $title = $faker->sentence(mt_rand(3, 10));
    $name = $faker->word;
    return [
        'title' => $title,
        'name' => $name,
        'keywords' => $name,
        'view' => mt_rand(10,100),
        'cate_order' => mt_rand(0,10),
        'description' => $faker->sentence(30,255),
        'pid' => mt_rand(0,9)
    ];
});
