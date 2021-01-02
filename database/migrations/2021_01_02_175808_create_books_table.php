<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->string('creator')->nullable();
            $table->text('description')->nullable();
            $table->string('language')->nullable();
            $table->string('date')->nullable();
            $table->string('contributor')->nullable();
            $table->string('identifier')->nullable();
            $table->string('subject')->nullable();
            $table->string('publisher')->nullable();
            $table->string('cover')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
