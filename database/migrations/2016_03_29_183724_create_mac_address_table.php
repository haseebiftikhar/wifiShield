<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMacAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('macaddreses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('mac_address');
            $table->string('device_name');
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
        Schema::drop('macaddreses');
    }
}
