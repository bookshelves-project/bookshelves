<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComicBooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('comic_books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_sort')->nullable();
            $table->string('slug')->unique()->index()->nullable();
            $table->text('description')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('rights')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('comic_books');
    }
}
