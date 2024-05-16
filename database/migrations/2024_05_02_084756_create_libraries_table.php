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
            $table->string('path_name')->nullable();
            $table->boolean('path_is_valid')->default(false);
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignUlid('library_id')
                ->after('added_at')
                ->nullable()
                ->constrained();
        });

        Schema::table('series', function (Blueprint $table) {
            $table->foreignUlid('library_id')
                ->after('link')
                ->nullable()
                ->constrained();
        });

        Schema::table('audiobooks', function (Blueprint $table) {
            $table->foreignUlid('library_id')
                ->after('added_at')
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
