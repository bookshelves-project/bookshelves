<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->string('slug')->unique()->index()->nullable();
            $table->string('name')->nullable();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->string('language_slug')->index()->nullable()->after('publisher_id');
            $table->foreign('language_slug')
                ->references('slug')
                ->on('languages')
                ->onDelete('cascade');
        });

        Schema::table('series', function (Blueprint $table) {
            $table->string('language_slug')->index()->nullable()->after('slug');
            $table->foreign('language_slug')
                ->references('slug')
                ->on('languages')
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
        Schema::dropIfExists('languages');
    }
}
