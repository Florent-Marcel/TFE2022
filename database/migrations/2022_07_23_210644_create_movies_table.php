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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->integer('tmdb_id')->unique();
            $table->string("title_fr");
            $table->string("title_en");
            $table->text("synopsis_fr")->nullable();
            $table->text("synopsis_en")->nullable();
            $table->date("date_release");
            $table->integer("duration", false, true);
            $table->double("rating", null, null, true)->nullable();
            $table->string('poster_url', 512)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
};
