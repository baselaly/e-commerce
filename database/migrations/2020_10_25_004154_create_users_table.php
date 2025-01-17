<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email')->index()->unique();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->boolean('verified')->default(false);
            $table->string('image')->nullable();
            $table->string('verify_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
