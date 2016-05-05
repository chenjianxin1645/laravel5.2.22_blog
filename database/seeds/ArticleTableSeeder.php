<?php

use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清空整个articles表
        \App\Http\Model\Article::truncate();
        //执行填充数据  采用factory make
        $articles = factory(App\Http\Model\Article::class)->times(20)->make();
        \App\Http\Model\Article::insert($articles->toArray());
    }
}
