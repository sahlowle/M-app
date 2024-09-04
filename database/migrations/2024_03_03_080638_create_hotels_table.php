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
            $table->string('logo')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->float('price')->default(0);
            $table->integer('sort')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('booking_url')->nullable();
            $table->float('stars_count')->nullable();
            $table->float('rate_stars_count')->nullable();
            $table->float('users_ratings_count')->nullable();
            $table->float('booking_rate')->nullable();
            $table->float('tripadvisor_rate')->nullable();
            $table->float('agoda_rate')->nullable();
            $table->string('phone_one',20)->nullable();
            $table->string('phone_two',20)->nullable();
            $table->string('phone_three',20)->nullable();
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
