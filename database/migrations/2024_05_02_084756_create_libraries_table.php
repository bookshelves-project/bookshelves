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
        Schema::create('libraries', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->nullable();
            $table->string('path')->nullable();
            $table->boolean('path_is_valid')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->integer('sort')->default(0);
            $table->dateTime('library_scanned_at')->nullable();
            $table->dateTime('library_modified_at')->nullable();

            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignUlid('library_id')
                ->after('slug')
                ->nullable()
                ->constrained();
        });

        Schema::table('series', function (Blueprint $table) {
            $table->foreignUlid('library_id')
                ->after('slug')
                ->nullable()
                ->constrained();
        });

        Schema::table('audiobook_tracks', function (Blueprint $table) {
            $table->foreignUlid('library_id')
                ->after('slug')
                ->nullable()
                ->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};
