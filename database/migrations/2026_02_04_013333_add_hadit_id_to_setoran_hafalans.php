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
        Schema::table('setoran_hafalans', function (Blueprint $table) {
            $table->foreignId('hadit_id')->nullable()->constrained('hadits')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setoran_hafalans', function (Blueprint $table) {
            $table->dropForeign(['hadit_id']);
            $table->dropColumn('hadit_id');
        });
    }
};
