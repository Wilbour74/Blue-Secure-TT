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
        Schema::table('backpacks', function (Blueprint $table) {
            $table->float('max_weight')->change();
            $table->float('max_volume')->change();
            $table->float('weight')->default(0);
            $table->float('volume')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backpacks', function (Blueprint $table) {
            //
        });
    }
};
