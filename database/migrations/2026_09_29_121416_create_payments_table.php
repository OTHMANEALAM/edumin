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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('month_name');              // اسم الشهر (مثال: الشهر 1 أو أكتوبر)
            $table->decimal('amount', 8, 2);           // المبلغ بالدرهم
            $table->enum('payment_method', ['cash', 'virement', 'versement', 'cheque'])->default('cash');
            $table->date('payment_date');              // تاريخ الدفع
            $table->string('received_by')->nullable();  // الموظف المستلم
            $table->text('notes')->nullable();          // ملاحظات
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
