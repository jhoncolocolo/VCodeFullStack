<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Enums\StatusesPets;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
*/
class PetFactory extends Factory
{ 
 
    /**
     * Define the model's default state.
     *
     * @return  array
     */
    public function definition()
    {   
        $category = Category::inRandomOrder()->first(); 
        return[
            'category_id' => $category->id,
            'name' => $this->faker->name(70),
            'photoUrls' => $this->faker->imageUrl(640, 480, $category->name, false),
            'status' => $this->faker->randomElement(StatusesPets::getValues()),
        ];
    }
}