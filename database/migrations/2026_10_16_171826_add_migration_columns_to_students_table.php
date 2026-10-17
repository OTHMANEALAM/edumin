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
    Schema::table('students', function (Blueprint $table) {
        if (!Schema::hasColumn('students', 'niveau_scolaire')) {
            $table->string('niveau_scolaire')->nullable();
        }
        if (!Schema::hasColumn('students', 'agreed_price')) {
            $table->decimal('agreed_price', 10, 2)->nullable();
        }
        if (!Schema::hasColumn('students', 'etat')) {
            $table->string('etat')->nullable();
        }
        if (!Schema::hasColumn('students', 'cin_image_id')) {
            $table->string('cin_image_id')->nullable();
        }
        if (!Schema::hasColumn('students', 'cohort')) {
            $table->string('cohort')->nullable();
        }
        if (!Schema::hasColumn('students', 'specialite')) {
            $table->string('specialite')->nullable();
        }
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
