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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('google_id')->nullable();
            $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('status')->nullable()->default(4);
            $table->integer('role')->default(1);
            $table->integer('store_id')->nullable();
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->integer('province_id')->nullable();
            $table->string('province_name')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('district_name')->nullable();
            $table->string('ward_id')->nullable();
            $table->string('ward_name')->nullable();
            $table->string('address_detail')->nullable();
            $table->timestamp('last_online')->nullable();
            // $table->rememberToken();
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
};
