<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清空整个articles表
        \App\Http\Model\Category::truncate();
        //执行填充数据  采用factory make
        $categorys = factory(App\Http\Model\Category::class)->times(10)->make();
        \App\Http\Model\Category::insert($categorys->toArray());
    }
}
