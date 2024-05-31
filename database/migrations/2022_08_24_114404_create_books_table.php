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
        Schema::create('books', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('title');
            $table->string('slug')->index();
            $table->string('contributor')->nullable();
            $table->text('description')->nullable();
            $table->date('released_on')->nullable();
            $table->json('audiobook_narrators')->nullable();
            $table->integer('audiobook_chapters')->nullable();
            $table->string('rights')->nullable();
            $table->float('volume')->nullable();
            $table->integer('page_count')->nullable();
            $table->boolean('is_hidden')->default(0);
            $table->string('isbn10')->nullable();
            $table->string('isbn13')->nullable();
            $table->json('identifiers')->nullable();
            $table->dateTime('added_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
