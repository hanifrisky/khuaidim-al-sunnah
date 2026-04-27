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
        Schema::table('hadits', function (Blueprint $table) {
            $table->text('name_normalized')->after('name')->nullable();
            $table->text('content_normalized')->after('content')->nullable();

            $table->fullText(
                ['content_normalized', 'name_normalized', 'translate', 'source'],
                'hadits_ft' // nama pendek
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hadits', function (Blueprint $table) {
            $table->dropColumn('nomor');
            $table->dropColumn('name_normalized');
            $table->dropColumn('content_normalized');
        });
    }
};
