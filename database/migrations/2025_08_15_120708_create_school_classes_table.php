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
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->string('jurusan')->nullable();
            $table->string('tingkat'); // 10/11/12 untuk SMA, 7/8/9 untuk SMP
            $table->string('wali_kelas')->nullable();
            $table->foreignId('graduation_period_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};
