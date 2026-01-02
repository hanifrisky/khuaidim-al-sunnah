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
        Schema::create('setoran_hafalans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_hafalan_id')->nullable()->constrained('tugas_hafalans')->nullOnDelete();
            $table->foreignId('siswa_id')->nullable()->constrained('siswas')->nullOnDelete();
            $table->string('media')->nullable();
            $table->enum('status', ['draft', 'review', 'accepted', 'rejected'])->default('draft');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setoran_hafalans');
    }
};
