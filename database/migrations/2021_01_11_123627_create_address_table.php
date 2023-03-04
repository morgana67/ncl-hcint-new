<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id');
            $table->string('phone',191)->nullable();;
            $table->integer('country_id')->nullable();;
            $table->string('state',191)->nullable();
            $table->string('city',191)->nullable();
            $table->string('address',191)->nullable();
            $table->string('address2',191)->nullable();
            $table->string('zip',50)->nullable();
            $table->string('addressType',50)->nullable()->default('billing');
            $table->integer('order_id')->nullable();
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
        Schema::dropIfExists('address');
    }
}
