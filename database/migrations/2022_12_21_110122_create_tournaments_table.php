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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('platform_id')->constrained();
            $table->foreignId('game_id')->constrained();
            $table->foreignId('tournament_status_id')->constrained();
            $table->foreignId('tournament_type_id')->constrained();
            $table->foreignId('currency_id')->constrained();
            $table->string('name')->unique();
            $table->longText('information');
            $table->integer('fee');
            $table->dateTimeTz('schedule_start');
            $table->dateTimeTz('schedule_end')->nullable();
            $table->string('registration_sequence');
            $table->integer('max_players');
            $table->integer('registered_count')->default(0);
            $table->string('slug');
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
        Schema::table('providers', function (Blueprint $table) {
            $table->dropForeign(['platform_id','game_id','tournament_status_id','tournament_type_id','currency_id']);
        });
        Schema::dropIfExists('tournaments');
    }
};
