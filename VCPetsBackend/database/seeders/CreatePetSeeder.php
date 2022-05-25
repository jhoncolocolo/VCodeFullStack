<?php

namespace Database\Seeders;
use App\Models\Pet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CreatePetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $json = File::get("database/data/pets.json");
            $data = json_decode($json);
            foreach ($data as $obj) {
                Pet::create([
                    "id" => $obj->id,
                    "category_id" => $obj->category_id,
                    "name" => $obj->name,
                    "photoUrls" => $obj->photoUrls,
                    "status" => $obj->status
                ]);
            }
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
        }
    }
}