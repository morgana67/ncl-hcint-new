<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDrCcInfoColsToCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('customers', 'dr-cc-num')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('dr-cc-num');
            });
        }

        if (!Schema::hasColumn('customers', 'dr-cvc')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('dr-cvc-num');
            });
        }

        if (!Schema::hasColumn('customers', 'dr-expMonth')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('dr-expMonth');
            });
        }

        if (!Schema::hasColumn('customers', 'dr-expYear')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('dr-expYear');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->dropColumn('dr-cc-num');
            $table->dropColumn('dr-cvc');
            $table->dropColumn('dr-expMonth');
            $table->dropColumn('dr-expYear');
        });
    }
}
