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
        Schema::table('soals', function (Blueprint $table) {
            $table->foreignId('kitab_id')->nullable()->constrained('kitabs')->nullOnDelete();
            $table->foreignId('bab_id')->nullable()->constrained('babs')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soals', function (Blueprint $table) {
            $table->dropForeign(['kitab_id']);
            $table->dropForeign(['bab_id']);
            $table->dropColumn(['kitab_id', 'bab_id']);
        });
    }
};
