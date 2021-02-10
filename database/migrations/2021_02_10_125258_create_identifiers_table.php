<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identifiers', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->nullable();
            $table->string('isbn13')->nullable();
            $table->string('doi')->nullable();
            $table->string('amazon')->nullable();
            $table->string('google')->nullable();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('identifier_id')->index()->nullable()->after('language_slug');
            $table->foreign('identifier_id')
                ->references('id')
                ->on('identifiers')
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
        Schema::dropIfExists('identifiers');
    }
}
