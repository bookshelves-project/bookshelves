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
        Schema::create('files', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('path');
            $table->string('basename');
            $table->string('extension');
            $table->string('format')->nullable();
            $table->string('mime_type')->nullable();
            $table->integer('size')->nullable();
            $table->boolean('is_audiobook')->default(false);
            $table->foreignUlid('library_id')->constrained();

            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignUlid('file_id')
                ->after('library_id')
                ->nullable()
                ->constrained();
        });

        Schema::table('audiobooks', function (Blueprint $table) {
            $table->foreignUlid('file_id')
                ->after('library_id')
                ->nullable()
                ->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
