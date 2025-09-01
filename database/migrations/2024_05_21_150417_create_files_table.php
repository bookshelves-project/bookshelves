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

            $table->foreignUlid('library_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('path', length: 1024);
            $table->string('basename');
            $table->string('extension');
            $table->string('mime_type')->nullable();
            $table->bigInteger('size')->nullable();
            $table->dateTime('date_added')->nullable();

            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignUlid('file_id')
                ->after('library_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
        });

        Schema::table('audiobook_tracks', function (Blueprint $table) {
            $table->foreignUlid('file_id')
                ->after('library_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
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
