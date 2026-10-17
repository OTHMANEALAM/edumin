<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name'); // الاسم والنسب
            $table->string('phone')->nullable(); // رقم الهاتف
            $table->json('specialties')->nullable(); // التخصصات (مصفوفة JSON لدعم تخصصات متعددة)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professors');
    }
};