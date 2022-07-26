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
        Schema::create('movies_personalities_professions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("personality_id")->constrained("personalities");
            $table->foreignId("profession_id")->constrained("professions");
            $table->foreignId("movie_id")->constrained("movies");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies_personalities_professions');
    }
};
