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
        Schema::create('audiobooks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('parsed_title')->nullable();
            $table->string('track_title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('slug')->nullable();
            $table->json('authors')->nullable();
            $table->json('narrators')->nullable();
            $table->text('description')->nullable();
            $table->string('publisher')->nullable();
            $table->date('publish_date')->nullable();
            $table->string('language')->nullable();
            $table->json('tags')->nullable();
            $table->string('serie')->nullable();
            $table->float('volume')->nullable();
            $table->string('format')->nullable();

            $table->string('track_number')->nullable();
            $table->string('comment')->nullable();
            $table->string('creation_date')->nullable();
            $table->string('composer')->nullable();
            $table->string('disc_number')->nullable();
            $table->boolean('is_compilation')->nullable();
            $table->string('encoding')->nullable();
            $table->text('lyrics')->nullable();
            $table->string('stik')->nullable();
            $table->float('duration')->nullable();
            $table->json('chapters')->nullable();

            $table->dateTime('added_at')->nullable();

            $table->foreignUlid('book_id')
                ->nullable()
                ->constrained('books')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audiobooks');
    }
};
