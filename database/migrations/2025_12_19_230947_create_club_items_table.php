<?php

// database/migrations/xxxx_create_club_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('club_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_section_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->string('title');
            $table->string('duration')->nullable();
            $table->string('place')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_items');
    }
};
