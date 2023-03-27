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
        Schema::table('configs', function (Blueprint $table) {
            
            $table->string("temperature_1")->change();
            $table->string("temperature_2")->change();
            $table->string("max_length_1")->change();
            $table->string("max_length_2")->change();
            $table->string("top_p_1")->change();
            $table->string("top_p_2")->change();
            $table->string("frequency_penalty_1")->change();
            $table->string("frequency_penalty_2")->change();
            $table->string("presence_penalty_1")->change();
            $table->string("presence_penalty_2")->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configs', function (Blueprint $table) {
            //
        });
    }
};
