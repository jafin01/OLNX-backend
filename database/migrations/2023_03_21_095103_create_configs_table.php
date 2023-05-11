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
            $table->integer('user_id')->unsigned();
            $table->string("model");
            $table->string("system");
            $table->integer("temperature");
            $table->integer("max_length");
            $table->integer("top_p");
            $table->integer("frequency_penalty");
            $table->integer("presence_penalty");
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
