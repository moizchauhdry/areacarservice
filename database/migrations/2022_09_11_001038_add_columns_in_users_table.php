<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('flight_no', 100)->nullable();
            $table->float('actual_price')->nullable();
            $table->integer('no_of_vehicles')->nullable();
            $table->float('tip')->nullable();
            $table->float('toll')->nullable();
            $table->float('process_fee')->nullable();
            $table->string('pay_type', 100)->nullable();
            $table->text('addt_msg')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('flight_no');
            $table->dropColumn('actual_price');
            $table->dropColumn('no_of_vehicles');
            $table->dropColumn('tip');
            $table->dropColumn('toll');
            $table->dropColumn('process_fee');
            $table->dropColumn('pay_type');
            $table->dropColumn('addt_msg');
        });
    }
}
