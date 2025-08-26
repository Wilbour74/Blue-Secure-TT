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
        Schema::table('items', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->change();
            $table->integer('wear')->nullable()->change();
            $table->float('quantity_cl')->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->float('quantity')->nullable()->change();
            $table->float('wear')->nullable()->change();
            $table->dropColumn('quantity_cl');
        });
    }
};