<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Student;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EventController extends Controller
{
    public function calendar(Request $request)
    {
        $page_title = 'الأجندة والإحصائيات الشاملة';
        $page_description = 'متابعة وبرمجة الحصص والفعاليات مع الإحصائيات الشاملة';

        $today = Carbon::today();
        $todayStr = $today->format('Y-m-d');
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        // 1. التسجيلات
        $registrationsToday = Student::whereDate('created_at', $today)->count();
        $registrationsWeek = Student::where('created_at', '>=', $startOfWeek)->count();
        $registrationsMonth = Student::where('created_at', '>=', $startOfMonth)->count();
        $registrationsYear = Student::where('created_at', '>=', $startOfYear)->count();

        // 2. الطلبة النشيطون وتوزيع التخصصات
        $activeStudentsCount = Student::where('is_quitted', 0)->orWhereNull('is_quitted')->count();
        $coursesActiveStats = Course::withCount(['students' => function($query) {
            $query->where('is_quitted', 0)->orWhereNull('is_quitted');
        }])->get();

        // 3. المغادرون
        $leftStudentsCount = Student::where('is_quitted', 1)->count();
        $coursesLeftStats = Course::leftJoin('students', 'courses.id', '=', 'students.course_id')
            ->where('students.is_quitted', 1)
            ->select('courses.name', DB::raw('count(students.id) as students_count'))
            ->groupBy('courses.id', 'courses.name')
            ->get();

        // 4. المتأخرون عن الدفع (حساب مرن يغطي جدول الطلاب وجدول الدفعات)
        $overdueStudentIds = collect();

        // أ) من جدول الطلاب عبر next_payment_date
        if (Schema::hasColumn('students', 'next_payment_date')) {
            $fromStudents = Student::where(function($q) {
                    $q->where('is_quitted', 0)->orWhereNull('is_quitted');
                })
                ->whereNotNull('next_payment_date')
                ->where('next_payment_date', '!=', '')
                ->where('next_payment_date', '!=', '0000-00-00')
                ->where('next_payment_date', '<=', $todayStr)
                ->pluck('id');
            $overdueStudentIds = $overdueStudentIds->merge($fromStudents);
        }

        // ب) من جدول payments
        if (Schema::hasTable('payments')) {
            $pCols = Schema::getColumnListing('payments');
            $pQuery = DB::table('payments');

            if (in_array('rest', $pCols)) {
                $pQuery->where('rest', '>', 0);
            } elseif (in_array('remaining', $pCols)) {
                $pQuery->where('remaining', '>', 0);
            }

            if (in_array('next_payment_date', $pCols)) {
                $pQuery->whereNotNull('next_payment_date')
                       ->where('next_payment_date', '!=', '')
                       ->where('next_payment_date', '<=', $todayStr);
            }

            if (in_array('student_id', $pCols)) {
                $fromPayments = $pQuery->pluck('student_id');
                $overdueStudentIds = $overdueStudentIds->merge($fromPayments);
            }
        }

        $overduePaymentsCount = $overdueStudentIds->unique()->filter()->count();

        // 5. في انتظار الترحيب
        $unwelcomedCount = Student::where('is_quitted', 0)
            ->where(function($q) {
                $q->where('is_welcomed', 0)
                  ->orWhere('is_welcomed', '0')
                  ->orWhereNull('is_welcomed');
            })->count();

        // 6. أداء الكوميرسيال (بالأيام والأشهر)
        $commColumn = Schema::hasColumn('students', 'registered_by') ? 'registered_by' : 'received_by';
        $filterType = $request->input('filter_type', 'month');
        $selectedDate = $request->input('selected_date', Carbon::now()->format('Y-m-d'));
        $selectedMonth = $request->input('selected_month', Carbon::now()->format('Y-m'));

        $query = Student::select($commColumn . ' as added_by', DB::raw('count(*) as total'))
            ->whereNotNull($commColumn)
            ->where($commColumn, '!=', '');

        if ($filterType === 'day' && $selectedDate) {
            $query->whereDate('created_at', $selectedDate);
        } else {
            $start = Carbon::parse($selectedMonth . '-01')->startOfMonth();
            $end = Carbon::parse($selectedMonth . '-01')->endOfMonth();
            $query->whereBetween('created_at', [$start, $end]);
        }

        $commercialsStats = $query->groupBy($commColumn)->get();

        return view('agenda.index', compact(
            'page_title',
            'page_description',
            'registrationsToday',
            'registrationsWeek',
            'registrationsMonth',
            'registrationsYear',
            'activeStudentsCount',
            'coursesActiveStats',
            'leftStudentsCount',
            'coursesLeftStats',
            'overduePaymentsCount',
            'unwelcomedCount',
            'commercialsStats',
            'filterType',
            'selectedDate',
            'selectedMonth'
        ));
    }

    public function getEvents()
    {
        $events = Event::all();
        $formattedEvents = [];
        foreach ($events as $event) {
            $formattedEvents[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_time,
                'end' => $event->end_time,
                'backgroundColor' => $event->color ?? '#593bdb',
                'borderColor' => $event->color ?? '#593bdb',
                'extendedProps' => ['description' => $event->description]
            ];
        }
        return response()->json($formattedEvents);
    }

    public function getReminders()
    {
        $today = Carbon::today()->format('Y-m-d');
        $events = Event::whereDate('start_time', $today)->orderBy('start_time', 'asc')->get();
        return response()->json($events);
    }

    public function store(Request $request)
    {
        $event = Event::create([
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'color' => $request->color ?? '#593bdb',
            'description' => $request->description,
        ]);
        return response()->json(['success' => true, 'event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update([
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'color' => $request->color,
            'description' => $request->description,
        ]);
        return response()->json(['success' => true, 'event' => $event]);
    }

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}