<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataInUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pickup')->nullable();
            $table->string('destination')->nullable();
            $table->string('nop')->nullable();
            $table->string('nol')->nullable();
            $table->string('date')->nullable();
            $table->string('vehicle')->nullable();
            $table->string('plan')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
