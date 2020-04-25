<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;
use \Cviebrock\EloquentSluggable\Services\SlugService;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->sentence();
    return [
        'name' => $name,
        'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'votes' => $faker->randomDigit(),
        'active' => $faker->randomElement(['yes', 'no']),
        'slug' => SlugService::createSlug(App\Category::class, 'slug', $name),

    ];
});
