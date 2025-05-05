<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantWorkinghoursTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_workinghours', function (Blueprint $table) {
            $table->id();
            $table->string('working_hours');
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_workinghours');
    }
}
