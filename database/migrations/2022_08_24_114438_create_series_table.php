<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('title');
            $table->string('slug')->index();
            $table->text('description')->nullable();
            $table->text('is_audiobook')->nullable();
            $table->dateTime('parsed_at')->nullable();

            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignUlid('serie_id')->index()->nullable()->after('rights');
            $table->foreign('serie_id')
                ->references('id')
                ->on('series')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('series');
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('serie_id');
        });
    }
};
