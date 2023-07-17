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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained();

            $table->string('username')->unique();
            $table->string('password');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('phone_number');
            $table->string('image_url');
            $table->text('bio');
            $table->date('date_of_birth');
            $table->boolean('is_principle')->default(false);
            $table->enum('gender', ['male','female']);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
