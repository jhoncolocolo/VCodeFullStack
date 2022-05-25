<?php

namespace Tests\Feature\SystemtTj\Factory;
use Illuminate\Support\Facades\File;
use App\Models\PermissionRole;
use App\Models\Pet;

class TablesDependentFactory
{

    public $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public static function createTables($table_create_data): TablesDependentFactory
    {
        try {

           $table = $table_create_data;
           $tables = ['pets'];
            if (in_array($table_create_data, $tables))
            {
                foreach ($tables as $curren_table) {
                    if($curren_table == $table_create_data){

                        // pets
                        if($table == "pets"){
                            Pet::factory(10)->create();
                        }
                    }
                }
            }
            else
            {
                return false;
            }

        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            echo $e;
        }

        return new TablesDependentFactory($table);
    }
}