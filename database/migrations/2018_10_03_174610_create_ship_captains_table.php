<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipCaptainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_captains', function (Blueprint $table) {

            // Identification
            $table->increments('id');

            // Relations
            $table->belongsTo('captains', 'captain_id');
            $table->belongsTo('ships', 'ship_id');

            // Attributes
            $table->string('notes', 100)->nullable();
            $table->string('contract', 100)->nullable();

            // Composite indexes
            $table->index(['captain_id', 'ship_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ship_captains');
    }
}
