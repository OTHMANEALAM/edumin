@extends('layouts.default')

@section('content')
<div class="container-fluid" dir="rtl">

    <!-- شريط الرأس -->
    <div class="card agenda-card mb-4 shadow-sm">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12 mb-3 mb-lg-0">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 ml-3" style="font-size: 2.2rem; color: #593bdb;">
                            <i class="la la-calendar"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 font-weight-bold text-dark">أجندة ومواعيد معهد TuCOSO</h4>
                            <p class="text-muted mb-0 small">متابعة وبرمجة الحصص الحضورية، وعن بعد، والفعاليات والإحصائيات</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 text-lg-right text-md-left">
                    <button type="button" class="btn btn-primary font-weight-bold px-3 py-2 ml-2 mb-2 mb-md-0 shadow-sm" onclick="toggleStatsModal()" style="border-radius: 10px;">
                        <i class="la la-chart-bar mr-1"></i> تفاصيل الإحصائيات والكوميرسيال
                    </button>
                    <button type="button" class="btn btn-success font-weight-bold px-4 py-2 shadow-sm" style="border-radius: 10px;" onclick="openCreateModal()">
                        <i class="la la-plus-circle mr-1"></i> إضافة حدث جديد +
                    </button>
                </div>
            </div>

            <!-- بطاقات الإحصائيات السريعة فوق التقويم -->
            <div class="row mt-4 pt-3 border-top">
                <div class="col-xl-2 col-lg-4 col-sm-6 mb-2">
                    <div class="p-2 bg-light rounded border text-center">
                        <span class="text-primary font-weight-bold d-block small">التسجيلات اليوم</span>
                        <span class="font-weight-bold text-dark" style="font-size: 16px;">{{ $registrationsToday ?? 0 }}</span>
                        <small class="d-block text-muted">الأسبوع: {{ $registrationsWeek ?? 0 }}</small>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-4 col-sm-6 mb-2">
                    <div class="p-2 bg-light rounded border text-center">
                        <span class="text-success font-weight-bold d-block small">الطلبة النشيطون</span>
                        <span class="font-weight-bold text-success" style="font-size: 16px;">{{ $activeStudentsCount ?? 0 }} طالب</span>
                        <a href="javascript:void(0);" onclick="toggleCoursesList()" class="small d-block text-muted font-weight-bold mt-1">التخصصات ▼</a>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-4 col-sm-6 mb-2">
                    <div class="p-2 bg-light rounded border text-center">
                        <span class="text-danger font-weight-bold d-block small">متأخرون عن الدفع</span>
                        <span class="font-weight-bold text-danger" style="font-size: 16px;">{{ $overduePaymentsCount ?? 0 }} طالب</span>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-sm-6 mb-2">
                    <div class="p-2 bg-light rounded border text-center">
                        <span class="text-warning font-weight-bold d-block small">في انتظار الترحيب</span>
                        <span class="font-weight-bold text-warning" style="font-size: 16px;">{{ $unwelcomedCount ?? 0 }} طالب</span>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-sm-6 mb-2">
                    <div class="p-2 bg-light rounded border text-center">
                        <span class="text-secondary font-weight-bold d-block small">الطلبة المغادرون</span>
                        <span class="font-weight-bold text-secondary" style="font-size: 16px;">{{ $leftStudentsCount ?? 0 }} طالب</span>
                    </div>
                </div>
            </div>

            <!-- اللائحة المخفية للتخصصات -->
            <div class="mt-3" id="activeCoursesList" style="display: none;">
                <div class="card card-body bg-light border-success p-3">
                    <h6 class="text-success font-weight-bold mb-2">توزيع الطلبة النشيطين حسب التخصصات:</h6>
                    <div class="row">
                        @if(isset($coursesActiveStats) && count($coursesActiveStats) > 0)
                            @foreach($coursesActiveStats as $course)
                                <div class="col-md-4 mb-2">
                                    <div class="p-2 bg-white border rounded d-flex justify-content-between align-items-center">
                                        <span>{{ $course->name }}</span>
                                        <span class="badge badge-success px-2 py-1">{{ $course->students_count ?? 0 }} طالب</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-muted small">لا توجد بيانات حالية للتخصصات.</div>
                        @endif
                    </div>
                </div>
            </div>

            <hr class="my-3">

            <!-- دليل الألوان -->
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex flex-wrap align-items-center">
                    <span class="text-muted small font-weight-bold ml-2">دليل الألوان:</span>
                    <span class="category-chip" style="background:#593bdb;"><i class="fa fa-book ml-1 mr-1"></i> حضوري</span>
                    <span class="category-chip" style="background:#2bc155;"><i class="fa fa-video-camera ml-1 mr-1"></i> عن بعد</span>
                    <span class="category-chip" style="background:#ffaa2b;"><i class="fa fa-graduation-cap ml-1 mr-1"></i> تخرج/مناسبة</span>
                    <span class="category-chip" style="background:#ff3e3e;"><i class="fa fa-exclamation ml-1 mr-1"></i> امتحان/موعد حاسم</span>
                    <span class="category-chip" style="background:#886cff;"><i class="fa fa-users ml-1 mr-1"></i> اجتماع إداري</span>
                </div>
                <div id="quickReminders" class="d-flex align-items-center mt-2 mt-md-0"></div>
            </div>
        </div>
    </div>

    <!-- التقويم FullCalendar -->
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card agenda-card shadow-sm">
                <div class="card-body p-4">
                    <div id="calendar" style="min-height: 750px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: تفاصيل أداء الكوميرسيال باليوم والشهر -->
<div class="modal fade" id="statsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content text-right" dir="rtl" style="border-radius: 12px;">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold text-white">
                    <i class="la la-chart-pie mr-1"></i> تفاصيل أداء الكوميرسيال (بالأيام والأشهر)
                </h5>
                <button type="button" class="close text-white ml-0" onclick="toggleStatsModal()">&times;</button>
            </div>
            <div class="modal-body p-4">
                
                <!-- فلتر نوع البحث -->
                <form method="GET" action="{{ route('agenda.index') }}" class="bg-light p-3 rounded border mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label class="font-weight-bold text-dark d-block small">نوع الفلترة:</label>
                            <select name="filter_type" id="filter_type_select" class="form-control form-control-sm font-weight-bold" onchange="toggleFilterInputs()">
                                <option value="month" {{ ($filterType ?? 'month') == 'month' ? 'selected' : '' }}>🗓️ فلترة بشهر كامل</option>
                                <option value="day" {{ ($filterType ?? '') == 'day' ? 'selected' : '' }}>📅 فلترة بيوم محدد</option>
                            </select>
                        </div>

                        <div class="col-md-5 mb-2 mb-md-0" id="month_input_group" style="{{ ($filterType ?? 'month') == 'day' ? 'display:none;' : '' }}">
                            <label class="font-weight-bold text-dark d-block small">اختر الشهر:</label>
                            <input type="month" name="selected_month" class="form-control form-control-sm font-weight-bold" value="{{ $selectedMonth ?? date('Y-m') }}">
                        </div>

                        <div class="col-md-5 mb-2 mb-md-0" id="day_input_group" style="{{ ($filterType ?? 'month') == 'month' ? 'display:none;' : '' }}">
                            <label class="font-weight-bold text-dark d-block small">اختر اليوم بالتفصيل:</label>
                            <input type="date" name="selected_date" class="form-control form-control-sm font-weight-bold" value="{{ $selectedDate ?? date('Y-m-d') }}">
                        </div>

                        <div class="col-md-3 text-left">
                            <label class="d-block small">&nbsp;</label>
                            <button type="submit" class="btn btn-sm btn-primary font-weight-bold btn-block px-3">
                                <i class="la la-filter"></i> تطبيق الفلتر
                            </button>
                        </div>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-primary font-weight-bold mb-0">📊 أداء التسجيلات حسب الفترة المختارة:</h5>
                    <span class="badge badge-info px-3 py-2 font-weight-bold" style="font-size: 13px;">
                        @if(($filterType ?? 'month') == 'day')
                            📅 اليوم المحدد: {{ $selectedDate }}
                        @else
                            🗓️ الشهر المحدد: {{ $selectedMonth }}
                        @endif
                    </span>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered text-center">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>اسم الكوميرسيال (Commercial)</th>
                                <th>عدد التسجيلات المحققة في هذه الفترة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($commercialsStats) && count($commercialsStats) > 0)
                                @foreach($commercialsStats as $comm)
                                <tr>
                                    <td class="font-weight-bold text-dark">{{ $comm->added_by ?? 'غير محدد' }}</td>
                                    <td>
                                        <span class="badge badge-success px-3 py-2 font-weight-bold" style="font-size: 14px;">
                                            {{ $comm->total }} تسجيل
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="text-muted p-3">
                                        لا توجد أي تسجيلات مسجلة للكوميرسيال خلال الفترة المحددة.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <hr>

                <h5 class="text-danger font-weight-bold mb-3">🚪 الطلبة المغادرون (الإجمالي: {{ $leftStudentsCount ?? 0 }}):</h5>
                <div class="row">
                    @if(isset($coursesLeftStats) && count($coursesLeftStats) > 0)
                        @foreach($coursesLeftStats as $leftCourse)
                            <div class="col-md-6 mb-2">
                                <div class="p-2 bg-light border rounded d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold">{{ $leftCourse->name }}</span>
                                    <span class="badge badge-danger px-2 py-1">{{ $leftCourse->students_count ?? 0 }} مغادر</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 text-muted small">إجمالي الطلبة المغادرين: {{ $leftStudentsCount ?? 0 }} طالب.</div>
                    @endif
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary font-weight-bold" onclick="toggleStatsModal()">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: إضافة وتعديل الأحداث -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none;">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white font-weight-bold" id="modalTitleText">إضافة موعد أو حدث جديد</h5>
                <button type="button" class="close text-white" onclick="closeModal('eventModal')"><span>&times;</span></button>
            </div>
            <form id="saveEventForm">
                @csrf
                <input type="hidden" id="event_id" name="event_id">
                <div class="modal-body p-4 text-right" dir="rtl">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">عنوان الحدث أو الحصة <span class="text-danger">*</span></label>
                        <input type="text" id="event_title" name="title" class="form-control" placeholder="مثال: حصة اللغة الإنجليزية" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">نوع الحدث ولونه <span class="text-danger">*</span></label>
                        <select id="event_color" name="color" class="form-control" required>
                            <option value="#593bdb" selected>حصة حضورية (أزرق)</option>
                            <option value="#2bc155">حصة عن بعد (أخضر)</option>
                            <option value="#ffaa2b">مناسبة خاصة (برتقالي)</option>
                            <option value="#ff3e3e">امتحان (أحمر)</option>
                            <option value="#886cff">اجتماع إداري (بنفسجي)</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">تاريخ البداية <span class="text-danger">*</span></label>
                            <input type="datetime-local" id="event_start" name="start_time" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">تاريخ النهاية</label>
                            <input type="datetime-local" id="event_end" name="end_time" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">ملاحظات أو رابط:</label>
                        <textarea id="event_desc" name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between bg-light py-2">
                    <button type="button" id="btnDeleteCurrentEvent" class="btn btn-danger" style="display: none;" onclick="deleteCurrentEvent()">حذف</button>
                    <div>
                        <button type="button" class="btn btn-light" onclick="closeModal('eventModal')">إلغاء</button>
                        <button type="submit" class="btn btn-primary font-weight-bold px-4" id="btnSaveSubmit">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- FullCalendar, Styles and Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<style>
    .agenda-card { border-radius: 16px !important; border: none !important; background: #ffffff; }
    .category-chip { display: inline-flex; align-items: center; padding: 6px 14px; margin: 4px; border-radius: 20px; font-size: 12.5px; font-weight: 600; color: #fff; }
</style>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/ar-ma.js"></script>

<script>
    var calendar;

    function openCreateModal() {
        document.getElementById('saveEventForm').reset();
        document.getElementById('event_id').value = '';
        $('#eventModal').modal('show');
    }

    function closeModal(modalId) {
        $('#' + modalId).modal('hide');
    }

    function toggleStatsModal() {
        if (typeof $ !== 'undefined' && $.fn.modal) {
            $('#statsModal').modal('toggle');
        } else {
            var el = document.getElementById('statsModal');
            if (el.classList.contains('show')) {
                el.classList.remove('show');
                el.style.display = 'none';
            } else {
                el.classList.add('show');
                el.style.display = 'block';
            }
        }
    }

    function toggleCoursesList() {
        var el = document.getElementById('activeCoursesList');
        el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
    }

    function toggleFilterInputs() {
        var type = document.getElementById('filter_type_select').value;
        document.getElementById('month_input_group').style.display = (type === 'day') ? 'none' : 'block';
        document.getElementById('day_input_group').style.display = (type === 'day') ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ar-ma',
            direction: 'rtl',
            height: 'auto',
            contentHeight: 750,
            headerToolbar: {
                right: 'prev,next today',
                center: 'title',
                left: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: "{{ route('agenda.events') }}"
        });
        calendar.render();
    });
</script>
@endsection