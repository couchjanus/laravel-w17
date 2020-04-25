<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tag;
use Faker\Generator as Faker;
use \Cviebrock\EloquentSluggable\Services\SlugService;

$factory->define(Tag::class, function (Faker $faker) {
    $name = $faker->sentence();
    return [
        'name' => $name,
        'slug' => SlugService::createSlug(App\Tag::class, 'slug', $name),
    ];
});
