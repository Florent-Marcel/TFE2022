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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("showing_id")->constrained("showings");
            $table->string("unique_code")->unique();
            $table->boolean("is_used")->default(false);
            $table->boolean("is_blocked")->default(false);
            $table->integer("num_seat");
            $table->string("paypal_capture_id");
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
        Schema::dropIfExists('tickets');
    }
};
