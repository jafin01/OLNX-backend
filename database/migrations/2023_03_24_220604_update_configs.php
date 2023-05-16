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
            $table->decimal("temperature", 8, 2)->change();
            $table->decimal("maxLength", 8, 2)->change();
            $table->decimal("top_p", 8, 2)->change();
            $table->decimal("frequency_penalty", 8, 2)->change();
            $table->decimal("presence_penalty", 8, 2)->change();
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
