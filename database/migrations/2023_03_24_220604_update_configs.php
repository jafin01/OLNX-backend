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
            $table->string("model")->change();
            $table->string("system")->change();
            $table->string("temperature")->change();
            $table->string("max_length")->change();
            $table->string("top_p")->change();
            $table->string("frequency_penalty")->change();
            $table->string("presence_penalty")->change();
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
