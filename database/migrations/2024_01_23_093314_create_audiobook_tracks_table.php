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
        Schema::create('audiobook_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('track_title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('slug')->nullable();

            $table->foreignUlid('book_id')
                ->constrained('books')
                ->cascadeOnDelete();

            $table->json('authors')->nullable();
            $table->json('narrators')->nullable();
            $table->text('description')->nullable();
            $table->string('publisher')->nullable();
            $table->date('publish_date')->nullable();
            $table->string('language')->nullable();
            $table->json('tags')->nullable();
            $table->string('serie')->nullable();
            $table->float('volume')->nullable();

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

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audiobook_tracks');
    }
};
