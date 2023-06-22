<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->index();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('name');
            $table->string('role')->nullable();
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->json('note')->nullable();

            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('author_main_id')
                ->index()
                ->nullable()
                ->after('serie_id')
                ->constrained('authors')
                ->nullOnDelete()
            ;
        });

        Schema::table('series', function (Blueprint $table) {
            $table->foreignId('author_main_id')
                ->index()
                ->nullable()
                ->after('link')
                ->constrained('authors')
                ->nullOnDelete()
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
};
