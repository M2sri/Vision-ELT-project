<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
            Schema::create('kids', function (Blueprint $table) {
            $table->id();

            $table->string('zone');        // zone1 or zone2
            $table->string('kid_name');
            $table->unsignedTinyInteger('age');
            $table->string('phone');
            $table->string('country');
            $table->string('city');

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('kids');
    }
};
