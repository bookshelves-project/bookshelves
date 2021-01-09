<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epubs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->string('size')->nullable();
            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('epub_id')->index()->nullable()->after('serie_number');
            $table->foreign('epub_id')
                ->references('id')
                ->on('epubs')
                ->onDelete('cascade');
        });

        Schema::table('epubs', function (Blueprint $table) {
            $table->foreignId('book_id')->index()->nullable()->after('size');
            $table->foreign('book_id')
                ->references('id')
                ->on('books')
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
        Schema::dropIfExists('epub');
    }
}
