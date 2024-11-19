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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('issue'); // Column for the ticket issue
            $table->string('priority')->nullable(); // Priority, nullable
            $table->enum('status', ['pending', 'open', 'solved'])->default('pending'); // Enum status with default value
            $table->text('feedback')->nullable(); // Feedback, nullable
            $table->string('image')->nullable(); // Image column, nullable
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
