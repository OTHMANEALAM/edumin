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
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_id')->constrained()->cascadeOnDelete();
        $table->string('registration_number')->unique(); // MA-2026XXXXXT
        $table->string('first_name');
        $table->string('last_name');
        $table->date('birth_date')->nullable();
        $table->string('cin')->nullable();
        $table->string('cin_document')->nullable();
        $table->string('phone');
        $table->string('whatsapp')->nullable();
        $table->string('received_by')->nullable();   // الشخص الذي استقبله
        $table->string('registered_by')->nullable(); // الشخص الذي سجله
        $table->enum('training_mode', ['presentiel', 'distance'])->default('presentiel');
        $table->date('registration_date');           // تاريخ التسجيل
        $table->decimal('registration_fee_paid', 10, 2)->default(0); // شحال خلص فالتسجيل
        $table->enum('payment_method', ['cash', 'virement', 'versement', 'cheque'])->default('cash'); // طريقة الأداء
        $table->string('group_name')->nullable();
        $table->string('status')->default('active');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
