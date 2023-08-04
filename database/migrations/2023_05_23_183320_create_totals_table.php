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
        Schema::create('totals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();;
            $table->foreignId('grade_course_id')->constrained('grade_courses')->cascadeOnDelete();

            $table->year('year');
            $table->integer('first_term_score');
            $table->integer('second_term_score');
            $table->integer('final_score');
            $table->boolean('has_failed');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('totals');
    }
};
