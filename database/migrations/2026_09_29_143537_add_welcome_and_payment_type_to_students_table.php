<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // نوع الدفع في التسجيل: فقط التسجيل أو التسجيل مع الشهر الأول
            $table->string('registration_payment_type')->default('registration_only')->after('registration_fee_paid');
            // حالة الترحيب
            $table->boolean('is_welcomed')->default(false)->after('status');
            // وقت تأكيد الترحيب
            $table->timestamp('welcomed_at')->nullable()->after('is_welcomed');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['registration_payment_type', 'is_welcomed', 'welcomed_at']);
        });
    }
};