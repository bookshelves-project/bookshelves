<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWikipediaItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('wikipedia_items', function (Blueprint $table) {
            $table->id();
            $table->string('model')->nullable();
            $table->string('language')->nullable();
            $table->string('search_query')->index();
            $table->string('query_url')->nullable();
            $table->string('page_id')->nullable();
            $table->string('page_id_url')->nullable();
            $table->string('page_url')->nullable();
            $table->text('extract')->nullable();
            $table->text('picture_url')->nullable();
            $table->timestamps();
        });

        Schema::table('authors', function (Blueprint $table) {
            $table->foreignId('wikipedia_item_id')->index()->nullable()->after('note');
            $table->foreign('wikipedia_item_id')
                ->references('id')
                ->on('wikipedia_items')
                ->nullOnDelete()
            ;
        });

        Schema::table('series', function (Blueprint $table) {
            $table->foreignId('wikipedia_item_id')->index()->nullable()->after('link');
            $table->foreign('wikipedia_item_id')
                ->references('id')
                ->on('wikipedia_items')
                ->nullOnDelete()
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('wikipedia_items');
    }
}
