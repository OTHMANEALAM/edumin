<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // دالة مساعدة لتوليد الأفواج من G1/A إلى G5/H
    private function generateGroupList($maxG = 5)
    {
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $groups = [];

        for ($g = 1; $g <= $maxG; $g++) {
            foreach ($letters as $letter) {
                $groups[] = "G{$g}/{$letter}";
            }
        }

        return $groups;
    }

    // 1. التوجيه عند فتح لوحة التحكم
    public function dashboard()
    {
        return redirect()->route('students.index');
    }

    // 2. لائحة الطلبة مع الفلترة حسب التخصص، النمط، السنة الدراسية، والفوج
 public function index(Request $request)
    {
        $page_title = 'لائحة الطلبة المسجلين';
        $page_description = 'البحث وإدارة ملفات الطلبة النشطين';
        $action = 'students';

        // 1. جلب أسماء التخصصات الفريدة بدون تكرار
        $courseNames = \App\Models\Course::select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');

        // 2. جلب الأفواج
        $groups = \App\Models\Student::whereNotNull('group_name')
            ->where('group_name', '!=', '')
            ->distinct()
            ->pluck('group_name');

        // التحقق من وجود بحث
        $isSearching = $request->filled('search') 
                    || $request->filled('course_name') 
                    || $request->filled('group_name') 
                    || $request->filled('training_mode');

        $students = collect();

        if ($isSearching) {
            $query = \App\Models\Student::with('course')
                ->where(function($q) {
                    $q->where('is_quitted', false)
                      ->orWhere('is_quitted', 0)
                      ->orWhereNull('is_quitted');
                });

            // بحث بالاسم / الهاتف / CIN / التسجيل
            if ($request->filled('search')) {
                $kw = trim($request->search);
                $query->where(function($sub) use ($kw) {
                    $sub->where('first_name', 'like', "%{$kw}%")
                        ->orWhere('last_name', 'like', "%{$kw}%")
                        ->orWhereRaw("CONCAT(COALESCE(first_name,''), ' ', COALESCE(last_name,'')) LIKE ?", ["%{$kw}%"])
                        ->orWhere('phone', 'like', "%{$kw}%")
                        ->orWhere('cin', 'like', "%{$kw}%")
                        ->orWhere('registration_number', 'like', "%{$kw}%");
                });
            }

           // تصفية باسم التخصص
            if ($request->filled('course_name')) {
                $cName = trim($request->course_name);
                $query->whereHas('course', function($sq) use ($cName) {
                    $sq->where('name', $cName);
                });
            }

            // تصفية بنمط التكوين (حضوري / عن بعد) بدقة صارمة
            if ($request->filled('training_mode')) {
                $mode = trim($request->training_mode);
                
                if (in_array(strtolower($mode), ['presential', 'presentiel', 'حضوري'])) {
                    $targets = ['presential', 'presentiel', 'حضوري'];
                } else {
                    $targets = ['online', 'عن بعد', 'a distance'];
                }

                // يجب أن يتطابق نمط الطالب أو نمط التخصص
                $query->where(function($q) use ($targets) {
                    $q->whereIn('training_mode', $targets)
                      ->orWhereHas('course', function($sq) use ($targets) {
                          $sq->whereIn('training_mode', $targets);
                      });
                });
            }
            // تصفية بالفوج
            if ($request->filled('group_name')) {
                $query->where('group_name', trim($request->group_name));
            }

            $students = $query->orderBy('first_name', 'asc')->paginate(25);
        } // إغلاق if ($isSearching)

        return view('students.index', compact(
            'students',
            'courseNames',
            'groups',
            'isSearching',
            'page_title',
            'page_description',
            'action'
        ));
        // استبعاد الطلاب اللي حالة المغادرة عندهم فعالة (is_quitted != 1)
    $students = Student::where('is_quitted', '!=', 1)->get(); 

    return view('students.index', compact('students'));

    } // إغلاق دالة index بالكامل قبل الدالة التالية public function ...
    // 3. فتح استمارة تسجيل طالب جديد
    public function create()
    {
        $courses = Course::all();

        // توليد رقم تسلسلي تلقائي: MA-YYYYXXXXXT
        $year = date('Y');
        $randomNumbers = str_pad(mt_rand(10000, 99999), 5, '0', STR_PAD_LEFT);
        $autoRegNumber = "MA-{$year}{$randomNumbers}T";

        return view('students.create', compact('courses', 'autoRegNumber'));
    }

    // 4. حفظ بيانات الطالب الجديد
   public function store(Request $request)
{
    // 1. التحقق من صحة البيانات الواردة من النموذج
    $request->validate([
        'first_name'       => 'required|string|max:255',
        'last_name'        => 'required|string|max:255',
        'phone'            => 'required|string|max:20',
        'niveau_scolaire'  => 'nullable|string|max:255', // المستوى الدراسي
        'agreed_price'     => 'nullable|numeric|min:0',   // الثمن المتفق عليه
        'cin_document'     => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        'image'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 2. تجميع البيانات مع استثناء الملفات ورقم الواتساب لمعالجتها بشكل خاص
    $data = $request->except(['cin_document', 'image', 'whatsapp']);

    // 3. حفظ صورة/وثيقة البطاقة الوطنية بالاسم الصحيح
    if ($request->hasFile('cin_document')) {
        $data['cin_document'] = $request->file('cin_document')->store('students/cin', 'public');
    }

    // 4. حفظ الصورة الشخصية إذا كانت متوفرة
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('students/avatars', 'public');
    }

    // 5. حفظ رقم الواتساب بالاسم الصحيح
    if ($request->has('whatsapp')) {
        $data['whatsapp'] = $request->input('whatsapp');
    }

    // 6. إنشاء وحفظ بيانات الطالب في قاعدة البيانات
    \App\Models\Student::create($data);

    return redirect()->route('students.index')->with('success', 'تم تسجيل الطالب بنجاح وحفظ كافة بياناته وصوره.');
}

    // 5. تحديث الفوج مباشرة من الجدول
   public function updateGroup(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        $student->group_name = $request->group_name ?: null;
        $student->save();

        return redirect()->route('students.index')->with('success', "تم تعيين الطالب {$student->first_name} في الفوج: " . ($student->group_name ?? 'بدون فوج'));
    }

    // 6. فتح صفحة تعديل بيانات الطالب
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $courses = Course::all();
        $availableGroups = $this->generateGroupList(5);

        return view('students.edit', compact('student', 'courses', 'availableGroups'));
    }

    // 7. حفظ التعديلات على الطالب
   // حفظ التعديلات على الطالب
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'course_id'       => 'required|exists:courses,id',
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'birth_date'      => 'nullable|date',
            'cin'             => 'nullable|string|max:20',
            'phone'           => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'cin_image'       => 'nullable|image|max:4096',
        ]);
$data = $request->except(['cin_document', 'image', 'whatsapp']);

// حفظ صورة البطاقة بالاسم الصحيح في قاعدة البيانات
if ($request->hasFile('cin_document')) {
    $data['cin_document'] = $request->file('cin_document')->store('students/cin', 'public');
}

// حفظ رقم الواتساب بالاسم الصحيح
if ($request->has('whatsapp')) {
    $data['whatsapp'] = $request->input('whatsapp');
}

// (باقي كود الحفظ أو التحديث كما هو)
        $student->update($data);

        return redirect()->route('students.index')->with('success', 'تم حفظ التعديلات وصورة البطاقة بنجاح.');
    }
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'تم حذف الطالب بنجاح!');
    }
    // 1. عرض صفحة الترحيب مع شرط الـ 48 ساعة
    public function welcomeIndex()
    {
        // جلب الطلبة الذين لم يتم الترحيب بهم، أو تم الترحيب بهم خلال آخر 48 ساعة فقط
        $students = Student::with('course')
            ->where(function ($query) {
                $query->where('is_welcomed', false)
                      ->orWhere(function ($q) {
                          $q->where('is_welcomed', true)
                            ->where('welcomed_at', '>=', now()->subHours(48));
                      });
            })
            ->latest()
            ->get();

        return view('students.welcome', compact('students'));
    }

    // 2. تأكيد أو إلغاء الترحيب بالطالب
    public function toggleWelcome($id)
    {
        $student = Student::findOrFail($id);

        if ($student->is_welcomed) {
            $student->update([
                'is_welcomed' => false,
                'welcomed_at' => null,
            ]);
            $msg = "تم إلغاء حالة الترحيب بالطالب {$student->first_name}.";
        } else {
            $student->update([
                'is_welcomed' => true,
                'welcomed_at' => now(),
            ]);
            $msg = "تم تأكيد الترحيب بالطالب {$student->first_name} بنجاح (سيختفي بعد 48 ساعة).";
        }

        return redirect()->back()->with('success', $msg);
    }
    public function show($id)
    {
        $student = Student::with(['course', 'payments' => function ($q) {
            $q->latest('payment_date');
        }])->findOrFail($id);

        // حساب المبالغ المؤداة (التسجيل + الشهور)
        $totalMonthlyPaid = $student->payments->sum('amount');
        $grandTotalPaid = $student->registration_fee_paid + $totalMonthlyPaid;

        return view('students.show', compact('student', 'totalMonthlyPaid', 'grandTotalPaid'));
    }
    // تسجيل مغادرة الطالب
    public function markAsQuitted(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'quit_reason' => 'required|string|max:1000',
        ]);

        $student = \App\Models\Student::findOrFail($id);
        
        $student->update([
            'is_quitted'  => true,
            'quit_reason' => $request->quit_reason,
            'quit_date'   => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'تم تسجيل مغادرة الطالب ونقله للأرشيف بنجاح.');
    }

    // إعادة الطالب للدراسة وتحديث معلوماته
    // إعادة الطالب للدراسة
    public function restoreStudent(\Illuminate\Http\Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $student->update([
            'is_quitted'    => false,
            'quit_reason'   => null,
            'quit_date'     => null,
            'group_name'    => $request->group_name,
            'specialty'     => $request->specialty,
            'training_mode' => $request->training_mode,
        ]);

        return redirect()->back()->with('success', 'تمت إعادة الطالب بنجاح إلى لائحة الطلاب النشطين.');
    }
    public function quittedStudents()
    {
        $page_title = 'الطلاب المغادرون';
        $page_description = 'أرشيف الطلاب المغادرين';
        $action = 'students';

        // جلب الطلاب المغادرين فقط
        $quittedStudents = \App\Models\Student::where('is_quitted', true)
            ->orderBy('quit_date', 'desc')
            ->get();

        return view('students.quitted', compact('quittedStudents', 'page_title', 'page_description', 'action'));
    }
    // تسجيل مغادرة الطالب
    public function quit(Request $request, $id)
{
    // 1. قلب على الطالب بالـ ID ديالو
    $student = Student::findOrFail($id);

    // 2. تحديث الحالة باش يولي مغادر (مثلاً عبر إضافة حقل is_quitted = 1 أو status = 'quitted')
    // أو إذا كنتي كدير SoftDeletes، تقدر تستعمل delete()
    $student->is_quitted = 1; // أو الحقل اللي معتمد عندك في القاعدة
    $student->quit_reason = $request->input('quit_reason'); // حفظ سبب المغادرة إن وجد
    $student->save();

    // جلب فقط الطلاب المغادرين
    $quittedStudents = Student::where('is_quitted', 1)->get();

    return view('students.quitted', compact('quittedStudents'));
}
    public function restore(Request $request, $id)
    {
        $student = \App\Models\Student::findOrFail($id);
        
        // إعادة تفعيل الطالب
        $student->is_quitted = false;
        $student->quit_reason = null;
        $student->quit_date = null;

        if ($request->filled('first_name')) $student->first_name = $request->first_name;
        if ($request->filled('last_name')) $student->last_name = $request->last_name;
        if ($request->filled('phone')) $student->phone = $request->phone;
        if ($request->filled('whatsapp')) $student->whatsapp = $request->whatsapp;
        if ($request->filled('group_name')) $student->group_name = $request->group_name;
        if ($request->filled('registration_fee_paid')) $student->registration_fee_paid = $request->registration_fee_paid;

        // حفظ التغييرات الأساسية أولاً بنجاح
        $student->save();

        // محاولة تحديث نمط التدريب بشكل منفصل ومحمي لتفادي أي خطأ ENUM
        if ($request->filled('training_mode')) {
            try {
                \Illuminate\Support\Facades\DB::table('students')
                    ->where('id', $id)
                    ->update(['training_mode' => $request->training_mode]);
            } catch (\Throwable $th) {
                // إذا رفضت قاعدة البيانات القيمة نتجاهلها بهدوء ويبقى الحفظ الأساسي ناجحاً
            }
        }

    $student = Student::findOrFail($id);
    
    $student->is_quitted = 0; // أو رد الحالة لـ 'active' حسب ما هو معتمد عندك
    $student->quit_date = null;
    $student->quit_reason = null;
    $student->save();

    return redirect()->route('students.quitted')->with('success', 'تم استرجاع الطالب بنجاح');
}
    public function editJson($id)
    {
        $student = \App\Models\Student::with('course')->findOrFail($id);
        return response()->json($student);
    }
   public function paymentHistory($id)
{
    try {
        $student = \App\Models\Student::with(['course', 'payments' => function($q) {$q->orderBy('payment_date', 'desc');
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'student' => [
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'course' => $student->course,
                'group_name' => $student->group_name,
                'registration_fee_paid' => $student->registration_fee_paid,
                'registration_date' => $student->registration_date,
            ],
            'payments' => $student->payments
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}