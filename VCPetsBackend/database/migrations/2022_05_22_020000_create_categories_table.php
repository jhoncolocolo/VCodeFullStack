<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB; 
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return    void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->comment("Category's Table name");
            $table->timestamps();
        
        });

        //Sqlite not Supports Table's Comment this line is in order to avoid error in testings 
        if (env("DB_CONNECTION") != "sqlite") DB::statement("ALTER TABLE `categories` comment 'Table for Pets Categories'");
    }

    /**
     * Reverse the migrations.
     *
     * @return    void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};