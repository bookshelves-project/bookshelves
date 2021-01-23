<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('cover_id')->index()->nullable()->after('isbn');
            $table->foreign('cover_id')
                ->references('id')
                ->on('covers')
                ->onDelete('cascade');
        });

        Schema::table('covers', function (Blueprint $table) {
            $table->foreignId('book_id')->index()->nullable()->after('name');
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
        Schema::dropIfExists('covers');
    }
}
