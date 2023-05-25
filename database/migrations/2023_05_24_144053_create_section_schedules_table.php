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
        Schema::create('section_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained();
            $table->foreignId('grade_course_id')->constrained();

            $table->tinyInteger('order');
            $table->time('start_at');
            $table->time('end_at');
            $table->enum('day',['sunday','monday','tuesday','wednesday','thursday']);

            $table->unique(['day','section_id','order']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_schedules');
    }
};
