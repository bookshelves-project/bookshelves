<?php

use App\Enums\BookTypeEnum;
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
        Schema::create('books', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('title');
            $table->string('uuid')->unique();
            $table->string('slug_sort')->nullable();
            $table->string('slug')->index();
            $table->string('contributor')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('released_on')->nullable();
            $table->string('rights')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('page_count')->nullable();
            $table->boolean('is_maturity_rating')->default(0);
            $table->boolean('is_hidden')->default(0);
            $table->enum('type', BookTypeEnum::toList())->nullable();
            $table->string('isbn10')->nullable();
            $table->string('isbn13')->nullable();
            $table->json('identifiers')->nullable();
            $table->dateTime('google_book_parsed_at')->nullable();
            $table->string('physical_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
