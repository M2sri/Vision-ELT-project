<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('test_attempt_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('question_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Student answer
            $table->text('answer');

            // ✅ REQUIRED FOR GRADING
            $table->boolean('is_correct')->default(false);

            $table->timestamps();

            // Prevent duplicate answers for same question per attempt
            $table->unique(['test_attempt_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
