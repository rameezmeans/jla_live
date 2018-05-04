<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatGameRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_records', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('gp');
            $table->integer('gb');
            $table->integer('shots');
            $table->integer('spct');
            $table->integer('sog');
            $table->decimal('sogpct');
            $table->integer('fo');
            $table->decimal('fopct');
            $table->integer('player_id');
            $table->integer('game_id');
            $table->integer('team_id');
            $table->integer('opponent_id');
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
        Schema::drop('game_records');

    }
}
