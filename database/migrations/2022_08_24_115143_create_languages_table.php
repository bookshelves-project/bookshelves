<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->string('slug')->unique()->index();
            $table->json('name')->nullable();
            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->string('language_slug')->index()->nullable()->after('publisher_id');
            $table->foreign('language_slug')
                ->references('slug')
                ->on('languages')
                ->nullOnDelete()
            ;
        });

        Schema::table('series', function (Blueprint $table) {
            $table->string('language_slug')->index()->nullable()->after('slug');
            $table->foreign('language_slug')
                ->references('slug')
                ->on('languages')
                ->nullOnDelete()
            ;
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
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('language_slug');
        });
        Schema::table('series', function (Blueprint $table) {
            $table->dropColumn('language_slug');
        });
    }
};
