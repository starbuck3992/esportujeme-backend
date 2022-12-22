<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained();
            $table->bigInteger('team_home')->nullable()->unsigned();
            $table->foreign('team_home')->references('id')->on('teams');
            $table->bigInteger('team_guest')->nullable()->unsigned();
            $table->foreign('team_guest')->references('id')->on('teams');
            $table->bigInteger('user_home')->nullable()->unsigned();
            $table->foreign('user_home')->references('id')->on('users');
            $table->bigInteger('user_guest')->nullable()->unsigned();
            $table->foreign('user_guest')->references('id')->on('users');
            $table->bigInteger('screenshot_home')->nullable()->unsigned();
            $table->foreign('screenshot_home')->references('id')->on('images');
            $table->bigInteger('screenshot_guest')->nullable()->unsigned();
            $table->foreign('screenshot_guest')->references('id')->on('images');
            $table->integer('score_home')->nullable();
            $table->integer('score_guest')->nullable();
            $table->dateTimeTz('score_save_home')->nullable();
            $table->dateTimeTz('score_save_quest')->nullable();
            $table->integer('bracket_position');
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
        Schema::table('tournament_matches', function (Blueprint $table) {
            $table->dropForeign(['tournament_id','team_home','team_guest','user_home','user_guest','screenshot_home','screenshot_guest']);
        });
        Schema::dropIfExists('tournament_matches');
    }
};
