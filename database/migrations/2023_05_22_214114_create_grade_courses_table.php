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
        Schema::create('grade_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')->constrained()->cascadeOnDelete();;
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->text('description');
            $table->integer('number_of_weekly_classes');
            $table->integer('top_mark');
            $table->integer('lower_mark');
            $table->unique(['grade_id', 'course_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_courses');
    }
};
