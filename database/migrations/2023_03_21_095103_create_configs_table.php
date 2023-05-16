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
            $table->string('name');
            $table->string("model");
            $table->string("system");
            $table->decimal("temperature", 8, 2);
            $table->integer("maxLength");
            $table->decimal("top_p", 8, 2);
            $table->decimal("frequency_penalty", 8, 2);
            $table->decimal("presence_penalty", 8, 2);
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
