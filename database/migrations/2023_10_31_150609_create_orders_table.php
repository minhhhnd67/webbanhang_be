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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->bigInteger('user_id');
            $table->integer('status');
            $table->integer('type');
            $table->string('name');
            $table->string('phone');
            $table->integer('province_id')->nullable();
            $table->string('province_name')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('district_name')->nullable();
            $table->integer('ward_id')->nullable();
            $table->string('ward_name')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
