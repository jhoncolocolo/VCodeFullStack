<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Enums\StatusesPets;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return    void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->comment("Categories Table Id ");
            $table->string('name',255)->comment("Pet's Table name");
            $table->string('photoUrls',255)->comment("Pet's Table photo Urls");
            $table->enum('status',StatusesPets::getValues())->nullable()->default(StatusesPets::AVAILABLE->value)->comment("Pet's status available, pending and sold.");
            $table->timestamps();
    
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        
        });
        
        //Sqlite not Supports Table's Comment this line is in order to avoid error in testings 
        if (env("DB_CONNECTION") != "sqlite") DB::statement("ALTER TABLE `pets` comment 'Table for Pets'");
    }

    /**
     * Reverse the migrations.
     *
     * @return    void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
};