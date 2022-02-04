<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_sort')->nullable();
            $table->string('slug')->unique()->index()->nullable();
            $table->string('contributor')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('released_on')->nullable();
            $table->string('rights')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('page_count')->nullable();
            $table->string('maturity_rating')->nullable();
            $table->boolean('disabled')->default(0);
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
}
