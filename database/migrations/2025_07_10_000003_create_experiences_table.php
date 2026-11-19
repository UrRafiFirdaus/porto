<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Jabatan / Posisi
            $table->string('organization'); // Perusahaan / Organisasi
            $table->string('type')->default('Kerja'); // Kerja, Magang, Organisasi, Freelance
            $table->string('location')->nullable();
            $table->string('start_date'); // e.g., "Jan 2024"
            $table->string('end_date')->nullable(); // null if is_current
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
