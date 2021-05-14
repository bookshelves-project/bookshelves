<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('title_sort')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('description_link')->nullable();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('serie_id')->index()->nullable()->after('rights');
            $table->foreign('serie_id')
                ->references('id')
                ->on('series')
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
        Schema::dropIfExists('series');
    }
}
