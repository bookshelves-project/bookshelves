<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentifiersTable extends Migration
{
    /**
     * Run the migrations.
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
                ->onDelete('cascade')
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('identifiers');
    }
}
