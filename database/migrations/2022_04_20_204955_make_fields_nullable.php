<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('youtubeId')->nullable()->change();
            $table->string('twitchId')->nullable()->change();
            $table->string('mp3Filename')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('youtubeId')->nullable(false)->change();
            $table->string('twitchId')->nullable(false)->change();
            $table->string('mp3Filename')->nullable(false)->change();
        });
    }
};
