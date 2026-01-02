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
        Schema::create('hadits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bab_id')->nullable()->constrained('babs')->nullOnDelete();
            $table->foreignId('kitab_id')->nullable()->constrained('kitabs')->nullOnDelete();
            $table->string('title');
            $table->text('content');
            $table->string('keterangan')->nullable();
            $table->string('source')->nullable();
            $table->text('translate')->nullable();
            $table->string('media')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hadits');
    }
};
