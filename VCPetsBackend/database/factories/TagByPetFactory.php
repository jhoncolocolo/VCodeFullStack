<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pet;
use App\Models\Tag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TagByPet>
*/
class TagByPetFactory extends Factory
{ 
 
    /**
     * Define the model's default state.
     *
     * @return  array
     */
    public function definition()
    {   
        return[
            'pet_id' => Pet::inRandomOrder()->first()->id,
            'tag_id' => Tag::inRandomOrder()->first()->id,
        ];
    }
}