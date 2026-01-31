<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id();

            // =========================
            // RELATIONS
            // =========================

            // Adult student (nullable)
            $table->foreignId('student_id')
                  ->nullable()
                  ->constrained()
                  ->cascadeOnDelete();

            // Kid student (nullable)
            $table->foreignId('kid_id')
                  ->nullable()
                  ->constrained('kids')
                  ->cascadeOnDelete();

            // Test
            $table->foreignId('test_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // =========================
            // SCORES & EVALUATION
            // =========================
            $table->unsignedInteger('score')->default(0);
            $table->unsignedInteger('total_marks')->default(0);
            $table->decimal('percentage', 5, 2)->default(0.00);
            $table->string('level')->nullable(); // Foundation | Beginner | etc.

            // =========================
            // STATUS & TIMING
            // =========================
            $table->enum('status', ['in_progress', 'completed'])
                  ->default('in_progress');

            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            // =========================
            // INDEXES (performance)
            // =========================
            $table->index(['student_id', 'kid_id']);
            $table->index('test_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_attempts');
    }
};
