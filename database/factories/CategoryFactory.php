<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Categories;
use Faker\Generator as Faker;

$factory->define(App\Categories::class, function (Faker $faker) {
    return [
        'name'=>$faker->text(20)
    ];
});
