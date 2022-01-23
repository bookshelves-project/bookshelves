<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->string('about')->nullable();
            $table->string('gender')->default('unknown');
            $table->string('role')->default('user');
            $table->string('pronouns')->nullable();
            $table->boolean('use_gravatar')->default(false);
            $table->boolean('display_favorites')->default(false);
            $table->boolean('display_comments')->default(false);
            $table->boolean('display_gender')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
