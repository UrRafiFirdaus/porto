<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->default('Framework & Library'); // Bahasa Pemrograman, Framework & Library, Database & Tools
            $table->string('icon_class')->nullable(); // Devicon / FontAwesome class e.g. devicon-laravel-plain
            $table->string('icon_image')->nullable(); // Optional uploaded logo
            $table->integer('proficiency')->default(85); // 1 - 100
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
