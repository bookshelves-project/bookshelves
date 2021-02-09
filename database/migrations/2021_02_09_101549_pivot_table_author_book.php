<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotTableAuthorBook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_book', function (Blueprint $table): void {
            $table->foreignId('book_id')->index();
            $table->foreign('book_id')
                   ->references('id')
                   ->on('books')
                   ->onDelete('cascade');
            $table->foreignId('author_id')->index();
            $table->foreign('author_id')
                   ->references('id')
                   ->on('authors')
                   ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('author_book');
    }
}
