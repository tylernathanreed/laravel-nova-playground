<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {

            // Identification
            $table->increments('id');

            // Attributes
            $table->string('address_line_1', 255);
            $table->string('address_line_2', 255)->nullable();
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('postal_code', 255);
            $table->string('country', 255);

            // Revision tracking
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
