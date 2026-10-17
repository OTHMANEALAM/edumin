<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // عرض سجل الأداءات مع فلترة البحث
public function index(Request $request)
{
    $page_title = 'سجل الأداءات والمتابعة المالية';
    $page_description = 'البحث في السجلات المالية للطلبة';
    
    $courses = \App\Models\Course::all();
    $groups = \App\Models\Student::select('group_name')->distinct()->pluck('group_name');

    // تحديد واش المستخدم كيدير شي بحث ولا لا
    $isSearching = $request->filled('student_search') || $request->filled('course_id') || $request->filled('group_name') || $request->filled('month_name');

    $studentsPayments = collect(); // أو النتائج الفارغة افتراضياً إذا لم يتم البحث

    if ($isSearching) {
        $query = \App\Models\Student::with(['course', 'payments'])
            ->withSum('payments', 'amount')
            ->withCount('payments');

        if ($request->filled('student_search')) {
            $search = $request->student_search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('group_name')) {
            $query->where('group_name', $request->group_name);
        }

        $studentsPayments = $query->paginate(10);
    }

    // الضروري هنا هو إرسال $isSearching مع compact باش مابقاش يعطي الخطأ
    return view('payments.index', compact(
        'courses', 
        'groups', 
        'studentsPayments', 
        'isSearching', 
        'page_title', 
        'page_description'
    ));
}
    // استمارة تسجيل أداء شهر لطالب
    public function create(Request $request)
    {
        $selectedStudent = null;
        if ($request->filled('student_id')) {
            $selectedStudent = Student::with(['course', 'payments'])->findOrFail($request->student_id);
        }

        $students = Student::with('course')->orderBy('first_name')->get();

        return view('payments.create', compact('students', 'selectedStudent'));
    }

    // حفظ أداء الشهر
    public function store(Request $request)
    {
        // 1. التحقق من صحة المدخلات
        $request->validate([
            'student_id'        => 'required|exists:students,id',
            'amount'            => 'required|numeric|min:0',
            'payment_date'      => 'required|date',
            'month_name'        => 'required|string',
            'next_payment_date' => 'required|date', // التحقق من تاريخ الدفعة القادمة
        ]);

        // 2. تسجيل الدفعة في جدول payments
        $payment = \App\Models\Payment::create([
            'student_id'     => $request->student_id,
            'amount'         => $request->amount,
            'payment_date'   => $request->payment_date,
            'month_name'     => $request->month_name,
            'payment_method' => $request->payment_method ?? 'cash',
            'received_by'    => auth()->user()->name ?? 'الإدارة',
            'notes'          => $request->notes,
        ]);

        // 3. تحديث تاريخ الاستحقاق القادم في جدول الطالب مباشرة
        $student = \App\Models\Student::findOrFail($request->student_id);
        $student->next_payment_date = $request->next_payment_date;
        $student->save();

        return redirect()->route('payments.index')
            ->with('success', 'تم تسجيل الدفعة بنجاح وتحديث موعد الاستحقاق القادم للطالب.');
    }
    // عرض صفحة الأجندة
    public function agendaIndex()
    {
        return view('agenda.index');
    }

    // تزويد التقويم ببيانات مواعيد استحقاق أداءات الطلبة
    public function agendaEvents(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        // جلب الطلبة المستحق عليهم الأداء في نطاق التواريخ المعروضة
        $students = Student::with('course')
            ->where('status', 'active')
            ->whereNotNull('next_payment_date')
            ->whereBetween('next_payment_date', [$start, $end])
            ->get();

        $events = [];

        foreach ($students as $student) {
            $isOverdue = $student->next_payment_date < now()->toDateString();
            
            $events[] = [
                'id'    => $student->id,
                'title' => $student->first_name . ' ' . $student->last_name . ' (' . optional($student->course)->name . ')',
                'start' => $student->next_payment_date,
                'url'   => route('students.show', $student->id),
                'backgroundColor' => $isOverdue ? '#dc3545' : '#ffc107', // أحمر إن فاته الأجل، أصفر/برتقالي إن كان قادماً
                'borderColor'     => $isOverdue ? '#bd2130' : '#d39e00',
                'textColor'       => $isOverdue ? '#ffffff' : '#000000',
            ];
        }

        return response()->json($events);
    }
    // صفحة تتبع المتأخرين حسب تاريخ الاستحقاق
public function overdueStudents(Request $request)
{
    $page_title = 'تتبع الدفع المتأخر';
    $page_description = 'قائمة الطلبة الذين حان أو فات موعد أدائهم الشهري';
    $action = 'payments_overdue';

    $today = \Carbon\Carbon::today()->format('Y-m-d');

    // جلب الطلاب المتأخرين مع حماية البيانات من قيم null
    $overdueStudents = \App\Models\Student::with('course')
        ->whereNotNull('next_payment_date')
        ->where('next_payment_date', '!=', '')
        ->where('next_payment_date', '<=', $today)
        ->orderBy('next_payment_date', 'asc')
        ->get();

    return view('payments.overdue', compact('overdueStudents', 'page_title', 'page_description', 'action'));
}
    // تحديث سريع لتاريخ الأداء والملاحظة دون مغادرة الصفحة
    public function updateDueDate(Request $request, Student $student)
    {
        $request->validate([
            'next_payment_date' => 'required|date',
            'admin_notes' => 'nullable|string',
        ]);

        $student->update([
            'next_payment_date' => $request->next_payment_date,
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', "تم تحديث موعد الأداء للطالب {$student->first_name} بنجاح.");
        // داخل دالة store بعد حفظ Payment:
$student = Student::find($request->student_id);
if ($student) {
    // ترحيل تاريخ الأداء القادم شهراً إضافياً للأمام
    $baseDate = ($student->next_payment_date && $student->next_payment_date > now()->toDateString()) 
                ? \Carbon\Carbon::parse($student->next_payment_date) 
                : now();
    $student->update([
        'next_payment_date' => $baseDate->addMonth()->toDateString(),
        'admin_notes'       => null // مسح أي ملاحظة تأجيل سابقة
    ]);
    
}
    }
    // جلب سجل الأداءات الخاص بطالب معين لعرضه في النافذة المنبثقة (Modal)
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