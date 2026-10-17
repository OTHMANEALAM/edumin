<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student; // تأكد من مطابقة اسم الـ Model الخاص بالطلاب لديك

class StudentMigrationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. مسح الطلاب القدامى تماماً لتفريغ النظام قبل الاستيراد الجديد
        // نستخدم DB::statement لتخطي قيود Foreign Key لو وجدت
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Student::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('تم تفريغ النظام من الطلاب القدامى بنجاح.');

        // 2. مسار ملف الـ CSV الذي أنشأناه (يمكن وضعه في storage/app/)
        $csvFile = storage_path('app/migrated_students_2026_2027.csv');
        
        if (!file_exists($csvFile)) {
            $this->command->error("ملف الـ CSV غير موجود في المسار: {$csvFile}");
            return;
        }

        $fileStream = fopen($csvFile, 'r');
        
        // قراءة السطر الأول (Headers) وتخطيه
        $header = fputcsv ?? fgetcsv($fileStream);
        
        $batch = [];
        $count = 0;

        while (($row = fgetcsv($fileStream)) !== FALSE) {
            // ترتيب الأعمدة حسب ما صدر في الـ CSV:
            // cohort, specialite, nom_prenom, cin, niveau_scolaire, agreed_price, etat, cin_image_id
            $batch[] = [
                'cohort'          => $row[0] ?? null,
                'specialite'      => $row[1] ?? null,
                'nom_prenom'      => $row[2] ?? null,
                'cin'             => $row[3] ?? null,
                'niveau_scolaire' => $row[4] ?? null,
                'agreed_price'    => !empty($row[5]) ? $row[5] : 0.00,
                'etat'            => $row[6] ?? null,
                'cin_image_id'    => $row[7] ?? null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ];

            $count++;
            
            // إدخال على دفعات لتسريع العملية
            if (count($batch) >= 100) {
                Student::insert($batch);
                $batch = [];
            }
        }

        // إدخال الباقي إن وجد
        if (!empty($batch)) {
            Student::insert($batch);
        }

        fclose($fileStream);
        $this->command->info("تم بنجاح استيراد وربط {$count} طالباً جديداً للموسم 2026/2027 مع الحفاظ على الأثمان والمستويات الدراسية!");
    }
}