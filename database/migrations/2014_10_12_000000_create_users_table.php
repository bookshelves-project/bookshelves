<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kiwilan\Steward\Enums\GenderEnum;
use Kiwilan\Steward\Enums\UserRoleEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->string('username');
            $table->boolean('is_blocked')->default(0);
            $table->text('about')->nullable();
            $table->string('gender')->default(GenderEnum::notsay->value);
            $table->string('role')->default(UserRoleEnum::user->value);
            $table->string('pronouns')->nullable();
            $table->boolean('use_gravatar')->default(0);
            $table->boolean('display_favorites')->default(0);
            $table->boolean('display_reviews')->default(0);
            $table->boolean('display_gender')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
