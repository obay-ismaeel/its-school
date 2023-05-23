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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained();

            $table->string('username')->unique();
            $table->string('password');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('job');
            $table->string('email')->unique();
            $table->boolean('is_principle')->default(false);
            $table->enum('gender', ['male', 'female']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
