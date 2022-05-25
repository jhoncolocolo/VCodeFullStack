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
        Schema::create('tag_by_pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id')->comment("Pets Table Id ");
            $table->unsignedBigInteger('tag_id')->comment("Tags Table Id ");
            $table->timestamps();
    
            $table->foreign('pet_id')
                ->references('id')
                ->on('pets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
    
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        
        });
        
        //Sqlite not Supports Table's Comment this line is in order to avoid error in testings 
        if (env("DB_CONNECTION") != "sqlite") DB::statement("ALTER TABLE `tag_by_pets` comment 'Tags By Pets'");
    }

    /**
     * Reverse the migrations.
     *
     * @return    void
     */
    public function down()
    {
        Schema::dropIfExists('tag_by_pets');
    }
};