<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // عنوان الحدث (مثلاً: حصة عن بعد - الفوج 1)
        $table->string('category')->default('info'); // نوع الحدث: حضور، عن بعد، تخرج...
        $table->string('color')->default('#593bdb'); // لون الحدث في التقويم
        $table->dateTime('start_time'); // تاريخ وتوقيت البداية
        $table->dateTime('end_time')->nullable(); // تاريخ وتوقيت النهاية
        $table->text('description')->nullable(); // تفاصيل أو رابط الحصة إن كانت عن بعد
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
