<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use App\Enums\PostStatusType;
use \Cviebrock\EloquentSluggable\Services\SlugService;

$factory->define(Post::class, function (Faker $faker) {
    $usersIds = \DB::table('users')->pluck('id');
    $title = $faker->sentence();

    return [
        'title' => $title,
        'content' => $faker->paragraph(20),
        'votes' => $faker->randomDigit(),
         
        'user_id' =>  $faker->randomElement($array = $usersIds),
        'status' => $faker->randomElement(PostStatusType::getValues()),
        'slug' => SlugService::createSlug(App\Post::class, 'slug', $title),
        "cover_path" => asset("storage/covers/cover.png"),
    ];
});
