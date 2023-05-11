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
        if(!Schema::hasTable('conversations')){
            Schema::create('conversations', function (Blueprint $table) {
                $table->id()->unsigned();
                $table->string('name');
                // $table->integer('user_id')->unsigned();
                $table->unsignedBigINteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                // $table->text("system_1")->nullable();
                // $table->text("system_2")->nullable();
                // $table->timestamp('created_at')->now();
                // $table->timestamp('updated_at')->now();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
