<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstName',191);
            $table->string('lastName',191);
            $table->string('middleName',191)->nullable();
            $table->string('email',191)->unique();
            $table->string('password',191);
            $table->date('dob')->nullable();
            $table->string('remember_token',191)->nullable();
            $table->text('token')->nullable();
            $table->tinyInteger('role_id')->default('2')->comment('2: customer , 3:doctor');
            $table->tinyInteger('isVerified')->default(0);
            $table->string('gender',191)->nullable();
            $table->string('company',191)->nullable();
            $table->string('stripe_customer_id',191)->nullable();
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
        Schema::dropIfExists('customers');
    }
}
