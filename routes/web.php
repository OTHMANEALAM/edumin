<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EduminAdminController;
use App\Http\Controllers\CourseController;



// 1. أول ما يفتح المستخدم الرابط، يذهب مباشرة لصفحة تسجيل الدخول الافتراضية في لارافل
Route::get('/', function () {
    return view('auth.login');
});

// 2. مسار صفحة الأجندة الخاص بك (محمي، ولا يفتحه إلا من سجل الدخول بنجاح)
Route::get('/agenda', function () {
    return view('agenda.index');
})->middleware(['auth'])->name('agenda');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(EduminAdminController::class)->group(function () {
    Route::get('/', 'dashboard');
    Route::get('/index', 'dashboard')->name('dashboard');
    Route::get('/index-2','dashboard_2')->name('dashboard_2');
    Route::get('/index-3','dashboard_3')->name('index_3');
	Route::get('/about-courses', 'about_courses')->name('about_courses');
    Route::get('/about-student', 'about_student')->name('about_student');
	Route::get('/add-courses', 'add_courses')->name('add_courses');
	Route::get('/add-departments', 'add_departments')->name('add_departments');
	Route::get('/add-holiday', 'add_holiday')->name('add_holiday');
    Route::get('/add-library', 'add_library')->name('add_library');
    Route::get('/add-professor', 'add_professor')->name('add_professor');
    Route::get('/add-staff', 'add_staff')->name('add_staff');
    Route::get('/add-student', 'add_student')->name('add_student');
    Route::get('/all-courses', 'all_courses')->name('all_courses');
    Route::get('/all-departments', 'all_departments')->name('all_departments');
    Route::get('/all-holiday', 'all_holiday')->name('all_holiday');
    Route::get('/all-library', 'all_library')->name('all_library');

    Route::get('/all-staff', 'all_staff')->name('all_staff');
    Route::get('/all-students', 'all_students')->name('all_students');
    Route::get('/edit-courses', 'edit_courses')->name('edit_courses');
    Route::get('/edit-departments', 'edit_departments')->name('edit_departments');
    Route::get('/edit-holiday', 'edit_holiday')->name('edit_holiday');
    Route::get('/edit-library', 'edit_library')->name('edit_library');
    Route::get('/edit-professor', 'edit_professor')->name('edit_professor');
    Route::get('/edit-staff', 'edit_staff')->name('edit_staff');
    Route::get('/edit-student', 'edit_student')->name('edit_student');
    Route::get('/event-management', 'event_management')->name('event_management');
    Route::get('/fees-collection', 'fees_collection')->name('fees_collection');
    Route::get('/fees-receipt', 'fees_receipt')->name('fees_receipt');
    Route::get('/holiday-calendar', 'holiday_calendar')->name('holiday_calendar');
    Route::get('/professor-profile', 'professor_profile')->name('professor_profile');
    Route::get('/staff-profile', 'staff_profile')->name('staff_profile');
    Route::get('/content', 'content')->name('content');
    Route::get('/content-add', 'content_add')->name('content_add');
    Route::get('/menu', 'menu')->name('menu');
    Route::get('/email-template', 'email_template')->name('email_template');
    Route::get('/add-email', 'add_email')->name('add_email');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/add-blog', 'add_blog')->name('add_blog');
    Route::get('/blog-category', 'blog_category')->name('blog_category');
    Route::get('/celandar', 'celandar')->name('celandar');
    Route::get('/chat', 'chat')->name('chat');
    Route::get('/app-calender', 'app_calender')->name('app_calender');
    Route::get('/app-profile', 'app_profile')->name('app_profile');
    Route::get('/activity', 'activity')->name('chaactivityt');
    Route::get('/chart-chartist', 'chart_chartist')->name('chart_chartist');
    Route::get('/chart-chartjs', 'chart_chartjs')->name('chart_chartjs');
    Route::get('/chart-flot', 'chart_flot')->name('chart_flot');
    Route::get('/chart-morris', 'chart_morris')->name('chart_morris');
    Route::get('/chart-peity', 'chart_peity')->name('chart_peity');
    Route::get('/chart-sparkline', 'chart_sparkline')->name('chart_sparkline');
    Route::get('/ecom-checkout', 'ecom_checkout')->name('ecom_checkout');
    Route::get('/ecom-customers', 'ecom_customers')->name('ecom_customers');
    Route::get('/ecom-invoice', 'ecom_invoice')->name('ecom_invoice');
    Route::get('/ecom-product-detail', 'ecom_product_detail')->name('ecom_product_detail');
    Route::get('/ecom-product-grid', 'ecom_product_grid')->name('ecom_product_grid');
    Route::get('/ecom-product-list', 'ecom_product_list')->name('ecom_product_list');
    Route::get('/ecom-product-order', 'ecom_product_order')->name('ecom_product_order');
    Route::get('/edit-profile', 'edit_profile')->name('edit_profile');
    Route::match(['get','post'],'/email-compose','email_compose')->name('email_compose');
    Route::get('/email-inbox', 'email_inbox')->name('email_inbox');
    Route::get('/email-read', 'email_read')->name('email_read');
    Route::get('/empty-page', 'empty_page')->name('empty_page');
    Route::get('/form-ckeditor', 'form_ckeditor')->name('form_ckeditor');
    Route::get('/form-element', 'form_element')->name('form_element');
    Route::get('/form-pickers', 'form_pickers')->name('form_pickers');
    Route::get('/form-validation', 'form_validation')->name('form_validation');
    Route::get('/form-wizard', 'form_wizard')->name('form_wizard');
    Route::get('/map-jqvmap', 'map_jqvmap')->name('map_jqvmap');
    Route::get('/page-error-400', 'page_error_400')->name('page_error_400');
    Route::get('/page-error-403', 'page_error_403')->name('page_error_403');
    Route::get('/page-error-404', 'page_error_404')->name('page_error_404');
    Route::get('/page-error-500', 'page_error_500')->name('page_error_500');
    Route::get('/page-error-503', 'page_error_503')->name('page_error_503');
    Route::get('/page-forgot-password', 'page_forgot_password')->name('page_forgot_password');
    Route::get('/page-lock-screen', 'page_lock_screen')->name('page_lock_screen');
    Route::get('/page-login', 'page_login')->name('page_login');
    Route::get('/page-register', 'page_register')->name('page_register');
    Route::match(['get','post'],'/post-details','post_details')->name('post_details');
    Route::get('/table-bootstrap-basic', 'table_bootstrap_basic')->name('table_bootstrap_basic');
    Route::get('/table-datatable-basic', 'table_datatable_basic')->name('table_datatable_basic');
    Route::get('/uc-lightgallery', 'uc_lightgallery')->name('uc_lightgallery');
    Route::get('/uc-nestable', 'uc_nestable')->name('uc_nestable');
    Route::get('/uc-noui-slider', 'uc_noui_slider')->name('uc_noui_slider');
    Route::get('/uc-select2', 'uc_select2')->name('uc_select2');
    Route::get('/uc-sweetalert', 'uc_sweetalert')->name('uc_sweetalert');
    Route::get('/uc-toastr', 'uc_toastr')->name('uc_toastr');
    Route::get('/ui-accordion', 'ui_accordion')->name('ui_accordion');
    Route::get('/ui-alert', 'ui_alert')->name('ui_alert');
    Route::get('/ui-badge', 'ui_badge')->name('ui_badge');
    Route::get('/ui-button', 'ui_button')->name('ui_button');
    Route::get('/ui-button-group', 'ui_button_group')->name('ui_button_group');
    Route::get('/ui-card', 'ui_card')->name('ui_card');
    Route::get('/ui-carousel', 'ui_carousel')->name('ui_carousel');
    Route::get('/ui-dropdown', 'ui_dropdown')->name('ui_dropdown');
    Route::get('/ui-grid', 'ui_grid')->name('ui_grid');
    Route::get('/ui-list-group', 'ui_list_group')->name('ui_list_group');
    Route::get('/ui-media-object', 'ui_media_object')->name('ui_media_object');
    Route::get('/ui-modal', 'ui_modal')->name('ui_modal');
    Route::get('/ui-pagination', 'ui_pagination')->name('ui_pagination');
    Route::get('/ui-popover', 'ui_popover')->name('ui_popover');
    Route::get('/ui-progressbar', 'ui_progressbar')->name('ui_progressbar');
    Route::get('/ui-tab', 'ui_tab')->name('ui_tab');
    Route::get('/ui-typography', 'ui_typography')->name('ui_typography');
    Route::get('/widget-basic', 'widget_basic')->name('widget_basic');



    Route::post('/ajax/featuredcompanies', 'ajax_featuredcompanies')->name('ajax_featuredcompanies');
    Route::post('/ajax/recentactivity', 'ajax_recentactivity')->name('ajax_recentactivity');
    
});
    // مسارات التخصصات والطلبة الجديدة
Route::resource('courses', CourseController::class);
Route::resource('students', StudentController::class);
// مسارات النظام الجديد (خارج كل المجموعات السابقة)


Route::get('/add-student', [StudentController::class, 'create'])->name('students.create');
Route::post('/add-student', [StudentController::class, 'store'])->name('students.store');
Route::patch('/students/{id}/group', [StudentController::class, 'updateGroup'])->name('students.updateGroup');
Route::get('/all-students', [StudentController::class, 'index'])->name('students.index');
Route::get('/fees-collection', [StudentController::class, 'feesCollection'])->name('fees.collection');
// مسارات التعديل والحذف
Route::get('/edit-student/{id}', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
Route::post('/students/{id}/quit', [StudentController::class, 'markAsQuitted'])->name('students.quit');
// صفحة الطلبة كيتي (المغادرين) واسترجاعهم
Route::get('/quitted-students', [StudentController::class, 'quittedStudents'])->name('students.quitted');
Route::post('/students/{id}/restore', [StudentController::class, 'restore'])->name('students.restore');
// مسارات استخلاص المصاريف والأداءات
Route::get('/add-fees', [\App\Http\Controllers\StudentController::class, 'feesCollection'])->name('add_fees');
Route::get('/api/student-payments/{id}', [\App\Http\Controllers\StudentController::class, 'getStudentPaymentDetails'])->name('students.payment_details');
Route::post('/payments/store', [\App\Http\Controllers\StudentController::class, 'storePayment'])->name('payments.store');
Route::get('/add-fees', [\App\Http\Controllers\StudentController::class, 'addFees'])->name('add_fees');
Route::get('/api/student-search-payment', [\App\Http\Controllers\StudentController::class, 'searchStudentPayment'])->name('students.search_payment');
Route::get('/', [\App\Http\Controllers\StudentController::class, 'dashboard'])->name('dashboard');
Route::get('/index', [\App\Http\Controllers\StudentController::class, 'dashboard'])->name('dashboard.index');
// الصفحات الحقيقية المربوطة مع قاعدة البيانات
Route::get('/', [\App\Http\Controllers\StudentController::class, 'dashboard'])->name('dashboard');
Route::get('/index', [\App\Http\Controllers\StudentController::class, 'dashboard'])->name('dashboard.index');
Route::get('/add-fees', [\App\Http\Controllers\StudentController::class, 'addFees'])->name('add_fees');
Route::get('/fees-collection', [\App\Http\Controllers\StudentController::class, 'feesCollection'])->name('fees.collection');
Route::resource('courses', CourseController::class);
// مسارات صفحة الترحيب
Route::get('/welcome-students', [App\Http\Controllers\StudentController::class, 'welcomeIndex'])->name('students.welcome');
Route::patch('/students/{id}/toggle-welcome', [App\Http\Controllers\StudentController::class, 'toggleWelcome'])->name('students.toggleWelcome');

Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');

// تفعيل جميع صفحات القالب الأخرى تلقائياً بدون ما يعطيك خطأ 404 أو يتعطل الموقع
Route::get('/{page}', function ($page) {
    if (view()->exists('edumin.dashboard.' . $page)) {
        return view('edumin.dashboard.' . $page, [
            'page_title' => ucfirst($page),
            'page_description' => ''
        ]);
    }
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/payments/overdue', [App\Http\Controllers\PaymentController::class, 'overdueStudents'])->name('payments.overdue');
Route::post('/students/{student}/update-due-date', [App\Http\Controllers\PaymentController::class, 'updateDueDate'])->name('students.updateDueDate');
Route::get('/payments-tracking', [PaymentController::class, 'overdueStudents'])->name('payments.overdue');
Route::get('/agenda', [App\Http\Controllers\PaymentController::class, 'agendaIndex'])->name('agenda.index');
Route::get('/agenda/events', [App\Http\Controllers\PaymentController::class, 'agendaEvents'])->name('agenda.events');
});

Route::get('/agenda', function () {
    return view('agenda.index');
})->name('agenda.index');

Route::get('/agenda/events', [App\Http\Controllers\PaymentController::class, 'agendaEvents'])->name('agenda.events');
// مسارات الأجندة والمواعيد
Route::get('/app-calender', [\App\Http\Controllers\EventController::class, 'index'])->name('app_calender');
Route::get('/agenda', [\App\Http\Controllers\EventController::class, 'index'])->name('agenda.index');

Route::get('/agenda/events', [\App\Http\Controllers\EventController::class, 'getEvents'])->name('agenda.events');
Route::post('/agenda/store', [\App\Http\Controllers\EventController::class, 'store'])->name('agenda.store');
Route::post('/agenda/update/{id}', [\App\Http\Controllers\EventController::class, 'update'])->name('agenda.update');
Route::delete('/agenda/delete/{id}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('agenda.destroy');
Route::get('/agenda/reminders', [\App\Http\Controllers\EventController::class, 'getUpcomingReminders'])->name('agenda.reminders');
use App\Http\Controllers\ProfessorController;

// مسارات الأساتذة
Route::get('/professors', [ProfessorController::class, 'index'])->name('professors.index');
Route::post('/professors/store', [ProfessorController::class, 'store'])->name('professors.store');
Route::put('/professors/update/{id}', [ProfessorController::class, 'update'])->name('professors.update');
Route::delete('/professors/delete/{id}', [ProfessorController::class, 'destroy'])->name('professors.destroy');
// مسارات الأساتذة (اسم خاص لتفادي مسارات القالب القديمة)
Route::get('/teachers', [\App\Http\Controllers\ProfessorController::class, 'index'])->name('professors.index');
Route::post('/teachers/store', [\App\Http\Controllers\ProfessorController::class, 'store'])->name('professors.store');
Route::put('/teachers/update/{id}', [\App\Http\Controllers\ProfessorController::class, 'update'])->name('professors.update');
Route::delete('/teachers/delete/{id}', [\App\Http\Controllers\ProfessorController::class, 'destroy'])->name('professors.destroy');
Route::get('/test-me', function () {
    return 'سيرفر لارافيل شغال بنجاح!';
});
Route::get('/les-profs', function () {
    $professors = \App\Models\Professor::all();
    return view('agenda.index_professors', compact('professors'));
});
Route::get('/check-test', function () {
    return response('<h1>مرحباً، السيرفر يعمل بنجاح 100%!</h1>');
});
Route::get('/teachers', [\App\Http\Controllers\ProfessorController::class, 'index'])->name('professors.index');
Route::post('/students/{id}/quit', [App\Http\Controllers\StudentController::class, 'quit'])->name('students.quit');
Route::post('/students/{id}/restore', [App\Http\Controllers\StudentController::class, 'restore'])->name('students.restore');
Route::post('/students/{id}/quit', [\App\Http\Controllers\StudentController::class, 'quit'])->name('students.quit');
Route::post('/students/{id}/restore', [\App\Http\Controllers\StudentController::class, 'restore'])->name('students.restore');
Route::get('/check-cols', function() {
    return \Illuminate\Support\Facades\Schema::getColumnListing('students');
});
// جلب السجل المالي للطالب
Route::get('/students/{id}/financial-profile', function($id) {
    $student = \App\Models\Student::with('course')->findOrFail($id);
    $payments = \Illuminate\Support\Facades\DB::table('payments')
        ->where('student_id', $id)
        ->orderBy('payment_date', 'asc')
        ->get();

    return response()->json([
        'student' => $student,
        'payments' => $payments,
    ]);
})->name('students.financial.profile');

// البحث السريع عن طالب أثناء إضافة دفع جديد
Route::get('/students/search-ajax', function(\Illuminate\Http\Request $request) {
    $kw = trim($request->get('q', ''));
    if (empty($kw)) {
        return response()->json([]);
    }

    $students = \App\Models\Student::with('course')
        ->where(function($q) use ($kw) {
            $q->whereRaw("CONCAT(COALESCE(first_name,''), ' ', COALESCE(last_name,'')) LIKE ?", ["%{$kw}%"])
              ->orWhere('phone', 'like', "%{$kw}%")
              ->orWhere('whatsapp', 'like', "%{$kw}%")
              ->orWhere('cin', 'like', "%{$kw}%")
              ->orWhere('registration_number', 'like', "%{$kw}%");
        })
        ->limit(10)
        ->get();

    return response()->json($students);
})->name('students.search.ajax');
Route::get('/students/{id}/payment-history', function($id) {
    $student = \App\Models\Student::with('course')->findOrFail($id);
    $payments = \Illuminate\Support\Facades\DB::table('payments')
        ->where('student_id', $id)
        ->orderBy('payment_date', 'asc')
        ->get();

    return response()->json([
        'student' => $student,
        'payments' => $payments
    ]);
});

Route::post('/students/{id}/quit', [\App\Http\Controllers\StudentController::class, 'quit'])->name('students.quit');
Route::get('students/{id}/edit-json', [\App\Http\Controllers\StudentController::class, 'editJson'])->name('students.editJson');
Route::post('/students/{student}/quit', [App\Http\Controllers\StudentController::class, 'quit'])->name('students.quit');
Route::get('/students/{id}/edit-json', [App\Http\Controllers\StudentController::class, 'editJson'])->name('students.editJson');
Route::get('/students/{id}/payment-history', [App\Http\Controllers\StudentController::class, 'paymentHistory']);
Route::get('/students/{id}/payment-history', [PaymentController::class, 'paymentHistory']);
Route::get('/students/{id}/payment-history', [\App\Http\Controllers\StudentController::class, 'paymentHistory']);
Route::get('/students/{id}/payment-history', [\App\Http\Controllers\PaymentController::class, 'paymentHistory']);

// مسارات إدارة المستخدمين والصلاحيات
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\UserController::class, 'store'])->name('store');
    Route::put('/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('update');
    Route::patch('/{id}/toggle-status', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('toggle-status');
});
Route::get('/payments-tracking', [PaymentController::class, 'overdueStudents'])->name('payments.overdue');
Route::get('/api/students/overdue-list', function () {
    try {
        $today = \Carbon\Carbon::today()->format('Y-m-d');

        // جلب الطلبة الذين لديهم تاريخ أداء أو استحقاق قد فات
        // نعتمد هنا على جدول الطلاب أو جدول الدفعات حسب العمود الموجود لديك
        $students = \App\Models\Student::with('course')
            ->whereNotNull('next_payment_date')
            ->where('next_payment_date', '<=', $today)
            ->get();

        $studentsList = [];
        foreach ($students as $st) {
            $studentsList[] = [
                'id' => $st->id,
                'first_name' => $st->first_name ?? '',
                'last_name' => $st->last_name ?? '',
                'registration_number' => $st->registration_number ?? '—',
                'phone' => $st->phone ?? '',
                'group_name' => $st->group_name ?? '—',
                'next_payment_date' => $st->next_payment_date,
                'course' => $st->course ? ['name' => $st->course->name] : null
            ];
        }

        return response()->json($studentsList);
        
    } catch (\Exception $e) {
        return response()->json([], 200);
    }
});
use App\Http\Controllers\EventController;

Route::get('/app-calender', [EventController::class, 'calendar'])->name('agenda.index');