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
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('name')->nullable();
            $table->string('authors')->nullable();
            $table->string('format')->nullable();
            $table->boolean('is_series')->default(0);

            $table->foreignUlid('file_id')
                ->nullable()
                ->cascadeOnDelete();

            $table->foreignUlid('book_id')
                ->nullable()
                ->cascadeOnDelete();

            $table->foreignUlid('serie_id')
                ->nullable()
                ->cascadeOnDelete();

            $table->foreignUlid('library_id')
                ->nullable()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('downloads');
    }
};
