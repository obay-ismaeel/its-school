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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();;
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();;
            $table->foreignId('grade_course_id')->nullable()->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->text('content');
            $table->date('due_date');
            $table->enum('type',['homework','assignment']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
