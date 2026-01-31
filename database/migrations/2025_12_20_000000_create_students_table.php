<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('country');
            $table->string('city');
            $table->enum('branch', ['Eldoge', 'Nasr City', 'Online']);
            $table->integer('age');
            $table->string('phone');
            $table->enum('prefer_time', ['Morning', 'Afternoon', 'Evening']);
            $table->integer('attempts')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};