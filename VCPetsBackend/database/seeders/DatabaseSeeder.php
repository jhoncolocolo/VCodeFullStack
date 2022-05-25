<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return  void
     */
    public function run()
    {
        $this->call(CreateCategorySeeder::class);
        $this->call(CreateTagSeeder::class);
        $this->call(CreatePetSeeder::class);
        $this->call(CreateTagByPetSeeder::class);

        //In case that you need fake seeders
        //\App\Models\Category::factory(10)->create();
        //\App\Models\Tag::factory(7)->create();
        //\App\Models\Pet::factory(20)->create();
        //\App\Models\TagByPet::factory(40)->create();
    }
}