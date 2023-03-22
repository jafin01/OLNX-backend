<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->integer('conversation_id')->unsigned();
            $table->foreign('conversation_id')->references('id')->on('conversations');
            $table->string("model_1");
            $table->string("model_2");
            $table->integer("temperature_1");
            $table->integer("temperature_2");
            $table->integer("max_length_1");
            $table->integer("max_length_2");
            $table->integer("top_p_1");
            $table->integer("top_p_2");
            $table->integer("frequency_penalty_1");
            $table->integer("frequency_penalty_2");
            $table->integer("presence_penalty_1");
            $table->integer("presence_penalty_2");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
