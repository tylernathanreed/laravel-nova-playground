<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sails', function (Blueprint $table) {

            // Identification
            $table->increments('id');

            // Relations
            $table->belongsTo('ships', 'ship_id')->index();

            // Attributes
            $table->integer('inches')->unsigned();

            // Revision tracking
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
        Schema::dropIfExists('sails');
    }
}
