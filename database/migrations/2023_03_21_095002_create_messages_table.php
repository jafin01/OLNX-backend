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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            // $table->integer('conversation_id')->unsigned();
            $table->unsignedBigINteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigINteger('conversation_id');
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            // $table->string("sender")->default("system 1");
            $table->string("sender");
            // $table->integer("user_id")->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
