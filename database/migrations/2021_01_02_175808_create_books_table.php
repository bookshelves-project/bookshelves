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
            $table->string('slug_sort')->nullable();
            $table->string('slug')->unique()->index()->nullable();
            $table->string('contributor')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('released_on')->nullable();
            $table->string('rights')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('page_count')->nullable();
            $table->string('maturity_rating')->nullable();
            $table->boolean('disabled')->default(0);
            $table->string('type')->default('novel');
            $table->string('identifier_isbn')->nullable();
            $table->string('identifier_isbn13')->nullable();
            $table->string('identifier_uuid')->nullable();
            $table->string('identifier_doi')->nullable();
            $table->string('identifier_amazon')->nullable();
            $table->string('identifier_google')->nullable();
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
