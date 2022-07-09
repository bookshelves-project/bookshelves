<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsHomePageHighlightsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cms_home_page_highlights', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->string('slug')->nullable();
            $table->json('text')->nullable();
            $table->json('cta_text')->nullable();
            $table->json('cta_link')->nullable();
            $table->json('quote_text')->nullable();
            $table->json('quote_author')->nullable();
            $table->foreignId('home_page_id')->index()->nullable();
            $table->foreign('home_page_id')
                ->references('id')
                ->on('cms_home_pages')
                ->nullOnDelete()
            ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cms_home_page_highlights');
    }
}
