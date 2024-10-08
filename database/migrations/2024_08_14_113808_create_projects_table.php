<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description')->nullable();
            $table->string('status',100)->default('available');
            $table->string('image',100)->nullable();
            $table->string('city',100);
            $table->string('type',100)->nullable();
            $table->float('building_area')->nullable();
            $table->float('number_of_podium_floors')->nullable();
            $table->float('investable_area')->nullable();
            $table->float('land_area')->nullable();
            $table->float('units_count')->nullable();
            // $table->bigInteger('models_count')->nullable();
            $table->bigInteger('floors')->nullable();
            $table->text('pdf_file')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
