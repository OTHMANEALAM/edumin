<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'is_quitted')) {
                $table->boolean('is_quitted')->default(false)->after('id');
            }
            if (!Schema::hasColumn('students', 'quit_reason')) {
                $table->text('quit_reason')->nullable()->after('is_quitted');
            }
            if (!Schema::hasColumn('students', 'quit_date')) {
                $table->date('quit_date')->nullable()->after('quit_reason');
            }
            if (!Schema::hasColumn('students', 'training_mode')) {
                $table->string('training_mode')->nullable()->comment('حضوري / عن بعد / فردي');
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['is_quitted', 'quit_reason', 'quit_date', 'training_mode']);
        });
    }
};