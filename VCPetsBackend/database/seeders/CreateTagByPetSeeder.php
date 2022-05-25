<?php

namespace Database\Seeders;
use App\Models\TagByPet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CreateTagByPetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $json = File::get("database/data/tag_by_pets.json");
            $data = json_decode($json);
            foreach ($data as $obj) {
                TagByPet::create([
                    "pet_id" => $obj->pet_id,
                    "tag_id" => $obj->tag_id,
                ]);
            }
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
        }
    }
}