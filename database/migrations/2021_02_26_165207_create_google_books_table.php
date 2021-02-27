<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoogleBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_books', function (Blueprint $table) {
            $table->id();
            $table->string('preview_link')->nullable();
            $table->string('buy_link')->nullable();
            $table->integer('retail_price')->nullable();
            $table->string('retail_price_currency')->nullable();
            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('google_book_id')->index()->nullable()->after('identifier_id');
            $table->foreign('google_book_id')
                ->references('id')
                ->on('google_books')
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
        Schema::dropIfExists('google_books');
    }
}
