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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('genre');
            $table->date('date');
            $table->string('imageFilename');
            $table->string('youtubeId');
            $table->string('twitchId');
            $table->boolean('twitchSafe')->default(0);
            $table->string('mp3Filename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodes');
    }
};
