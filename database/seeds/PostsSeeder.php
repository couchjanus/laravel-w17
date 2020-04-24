<?php

use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Удаляем предыдущие данные
        DB::table('posts')->truncate();
        factory(App\Post::class, 50)->create();
    }
}
