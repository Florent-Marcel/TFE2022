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
        Schema::create('showings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("movie_id")->constrained("movies");
            $table->foreignId("room_id")->constrained("rooms");
            $table->foreignId("showing_type_id")->constrained("showing_types");
            $table->foreignId("language_id")->constrained("languages");
            $table->dateTime("begin");
            $table->double("price");
            $table->integer("buffer")->default(0);
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
        Schema::dropIfExists('showings');
    }
};
