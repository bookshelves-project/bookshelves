<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('slug')->unique()->index()->nullable();
            $table->string('name')->nullable();

            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignUlid('publisher_id')->index()->nullable()->after('volume');
            $table->foreign('publisher_id')
                ->references('id')
                ->on('publishers')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('publishers');
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('publisher_id');
        });
    }
};
