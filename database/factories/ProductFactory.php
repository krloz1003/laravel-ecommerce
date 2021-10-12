<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'          => $faker->words(3, true),
        //'slug'          => SlugService::createSlug(Post::class, 'slug', $request->name),
        'description'   => $faker->realText(200),
        'price'         => $faker->randomFloat(2, 10, 100),
        'status'        => 1,
    ];
});
