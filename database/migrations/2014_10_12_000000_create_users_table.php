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
            $table->id();
            $table->tinyInteger('type')
                ->comment('1: SuperAdmin, 2: SubAdmin, 3: Customer');

            $table->string('first_name');

            $table->string('last_name');

            $table->string('email')->unique();

            $table->timestamp('email_verified_at')->nullable();

            $table->string('phone_code', 5)->nullable();

            $table->string('phone', 15)->unique()->nullable();

            $table->timestamp('phone_verified_at')->nullable();

            $table->string('password');

            $table->rememberToken();
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
