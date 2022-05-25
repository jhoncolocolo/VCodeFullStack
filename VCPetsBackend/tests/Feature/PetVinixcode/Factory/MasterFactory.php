<?php

namespace Tests\Feature\PetVinixcode\Factory;

use Faker\Generator as Faker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Tag;

class MasterFactory
{

    public function __construct()
    {
    }

    public static function createBase(): MasterFactory
    {
        $faker = \Faker\Factory::create();
        try {

            //Categories
            Category::create([
                'name' => $faker->text(255),
            ]);

            Tag::factory(10)->create();

        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            echo $e;
        }

        return new MasterFactory();
    }
}