<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {

            // Identification
            $table->increments('id');

            // Relations
            $table->belongsTo('users', 'user_id');
            $table->belongsTo('roles', 'role_id');

            // Attributes
            $table->string('notes', 100)->nullable();

            // Composite indexes
            $table->index(['role_id', 'user_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
