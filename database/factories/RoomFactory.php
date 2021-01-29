<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    $randCapacity=[1,2,5];
    return [
        'code'=>strtoupper($faker->lexify('?')).'-'.$faker->numberBetween(1,100),
        'capacity'=>$randCapacity[$faker->numberBetween(0,2)],
        'price'=>$randCapacity[$faker->numberBetween(0,2)]*100,
        'status'=>$faker->boolean(),
    ];
});
