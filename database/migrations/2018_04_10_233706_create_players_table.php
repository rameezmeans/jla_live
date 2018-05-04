<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->integer('team_id');

            $table->integer('goals');
            $table->integer('assists');
            $table->integer('points');
            $table->integer('shots');
            $table->decimal('shots_percentage');
            $table->integer('sog');
            $table->decimal('sog_percentage');
            $table->integer('manup');
            $table->integer('down');
            $table->integer('ground_ball');
            $table->integer('TO');
            $table->integer('CTO');
            $table->integer('win');
            $table->integer('lose');
            $table->decimal('FO_percentage');
            $table->integer('allowed');
            $table->integer('saved');
            $table->decimal('save_percentage');

            $table->integer('number');
            $table->string('position');

            $table->boolean('is_published')->default(false);
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
        Schema::drop('players');

    }
}
