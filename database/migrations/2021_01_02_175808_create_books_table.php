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
            $table->string('title_sort')->nullable();
            $table->string('slug')->nullable();
            $table->string('unique_identifier')->nullable();
            $table->string('contributor')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('rights')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('page_count')->nullable();
            $table->string('maturity_rating')->nullable();
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
