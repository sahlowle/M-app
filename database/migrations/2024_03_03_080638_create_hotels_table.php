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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->float('price')->default(0);
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('booking_url')->nullable();
            $table->integer('stars_count')->nullable();
            $table->integer('rate_stars_count')->nullable();
            $table->integer('users_ratings_count')->nullable();
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
        Schema::dropIfExists('hotels');
    }
};
