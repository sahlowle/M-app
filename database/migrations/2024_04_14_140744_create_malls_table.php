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
        Schema::create('malls', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('mall_name');
            $table->unsignedBigInteger('category_id');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('website_url')->nullable();
            $table->timestamps();

            $table->foreign('category_id')
            ->references('id')
            ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('malls');
    }
};
