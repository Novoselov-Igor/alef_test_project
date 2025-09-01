<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('class_lecture_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lecture_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('order');
            $table->timestamp('completed_at')->nullable()->after('order');
            $table->timestamps();

            // Один и тот же урок не может быть дважды в плане одного класса
            $table->unique(['school_class_id', 'lecture_id']);
            $table->index(['school_class_id', 'order']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_lecture_plans');
    }
};
