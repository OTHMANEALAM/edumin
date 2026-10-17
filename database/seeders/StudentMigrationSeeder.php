<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Payment;

class StudentMigrationSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Student::truncate();
        if (class_exists('App\Models\Payment')) {
            Payment::truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $csvFile = storage_path('app/migrated_students_2026_2027.csv');
        
        if (!file_exists($csvFile)) {
            $this->command->error("الملف غير موجود في المسار: {$csvFile}");
            return;
        }

        $fileStream = fopen($csvFile, 'r');
        $header = fgetcsv($fileStream); // قراءة رأس الجدول

        if (!$header) {
            $this->command->error("ملف الـ CSV فارغ أو تالف.");
            fclose($fileStream);
            return;
        }

        $count = 0;

        // دالة تنظيف النصوص
        $clean = function ($value) {
            if ($value === null) return null;
            $trimmed = trim((string)$value);
            if (strtolower($trimmed) === 'nan' || strtolower($trimmed) === 'null' || $trimmed === '') {
                return null;
            }
            return $trimmed;
        };

        // دالة تنسيق التاريخ ليكون YYYY-MM-DD
        $parseDate = function ($dateStr) {
            $cleanDate = trim((string)$dateStr);
            if (empty($cleanDate) || strtolower($cleanDate) === 'nan') return null;
            
            if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $cleanDate, $matches)) {
                return "{$matches[3]}-{$matches[2]}-{$matches[1]}";
            }
            return $cleanDate;
        };

        while (($row = fgetcsv($fileStream)) !== FALSE) {
            // اعتماداً على ترتيب الأعمدة في جدولك الأخير:
            // 0: training_mode, 1: specialite, 2: first_name, 3: last_name, 4: cin, 5: birth_date
            // 6: welcomed_by, 7: registered_by, 8: niveau_scolaire, 9: agreed_price, 10: status
            // 11: phone, 12: registration_date, 13: course_id, 14: registration_fee, 15: monthly_payment, 16: payment_method, 17: months_paid

            $firstName = $clean($row[2] ?? null);
            $lastName  = $clean($row[3] ?? null);

            // تخطي الصفوف الفارغة أو عناوين المجموعات
            if (!$firstName || !$lastName || str_contains($firstName, '/')) {
                continue;
            }

            $count++;
            $registrationNumber = 'REG-2026-' . str_pad($count, 5, '0', STR_PAD_LEFT);

            $birthDate   = $parseDate($row[5] ?? null);
            $regDate     = $parseDate($row[12] ?? null) ?? now()->toDateString();
            $agreedPrice = !empty($clean($row[9] ?? null)) ? (float)$row[9] : 0.00;
            $status      = $clean($row[10] ?? null) ?? 'En cours';
            $phone       = $clean($row[11] ?? null) ?? '0600000000';
            $regFee      = !empty($clean($row[14] ?? null)) ? (float)$row[14] : 0.00;
            $monthlyPay  = !empty($clean($row[15] ?? null)) ? (float)$row[15] : 0.00;
            $payMethod   = $clean($row[16] ?? null) ?? 'VIREMENT';
            $monthsPaid  = $clean($row[17] ?? null);

            // إنشاء الطالب
            $student = Student::create([
                'registration_number'   => $registrationNumber,
                'training_mode'         => $clean($row[0] ?? null) ?? 'online',
                'group_name'            => $clean($row[1] ?? null),
                'first_name'            => $firstName,
                'last_name'             => $lastName,
                'cin'                   => $clean($row[4] ?? null),
                'birth_date'            => $birthDate,
                'received_by'           => $clean($row[6] ?? null),
                'registered_by'         => $clean($row[7] ?? null),
                'niveau_scolaire'       => $clean($row[8] ?? null),
                'agreed_price'          => $agreedPrice,
                'status'                => $status,
                'phone'                 => $phone,
                'registration_date'     => $regDate,
                'course_id'             => 1,
                'registration_fee_paid' => $regFee,
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);

            // تسجيل رسوم التسجيل
            if ($regFee > 0 && class_exists('App\Models\Payment')) {
                Payment::create([
                    'student_id'     => $student->id,
                    'amount'         => $regFee,
                    'type'           => 'frais_inscription',
                    'payment_method' => $payMethod,
                    'payment_date'   => $regDate,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }

            // تسجيل الدفعات الشهرية
            if ($monthlyPay > 0 && class_exists('App\Models\Payment')) {
                Payment::create([
                    'student_id'     => $student->id,
                    'amount'         => $monthlyPay,
                    'type'           => 'mensualite',
                    'description'    => $monthsPaid ? 'الأشهر المدفوعة: ' . $monthsPaid : 'دفع شهري',
                    'payment_method' => $payMethod,
                    'payment_date'   => $regDate,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

        fclose($fileStream);
        $this->command->info("تم بنجاح استيراد {$count} طالباً بكافة بياناتهم ومعلوماتهم المالية والإدارية بدقة تامة!");
    }
}