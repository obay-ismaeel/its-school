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
        Schema::create('calendar_items', function (Blueprint $table) {
            $table->id();

            $table->dateTime('date');

            $table->string('title');
            $table->text('content');
            $table->enum('type',['meeting','holiday','event']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_items');
    }
};
