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
            // Drop old foreign key constraint referencing 'kelas' table
            $table->dropForeign(['bab_id']);
            
            // Add correct foreign key constraint referencing 'babs' table
            $table->foreign('bab_id')
                ->references('id')
                ->on('babs')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setoran_hafalans', function (Blueprint $table) {
            // Drop correct foreign key constraint referencing 'babs' table
            $table->dropForeign(['bab_id']);
            
            // Re-add buggy foreign key constraint referencing 'kelas' table
            $table->foreign('bab_id')
                ->references('id')
                ->on('kelas')
                ->onDelete('set null');
        });
    }
};
