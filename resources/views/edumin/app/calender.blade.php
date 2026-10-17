@extends('layouts.default')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4><i class="la la-calendar text-primary"></i> أجندة ومواعيد معهد TuCOSO</h4>
                    <p class="mb-0">إدارة الحصص الحضورية، الحصص عن بعد، والفعاليات</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <button type="button" class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#createEventModal">
                    <i class="la la-plus"></i> إضافة حدث جديد
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-xxl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-intro-title">دليل فئات المواعيد</h4>
                        <div class="mt-4">
                            <div class="py-2 px-3 mb-2 text-white font-weight-bold rounded" style="background:#593bdb;">
                                <i class="fa fa-circle ml-2"></i> حصة حضورية
                            </div>
                            <div class="py-2 px-3 mb-2 text-white font-weight-bold rounded" style="background:#2bc155;">
                                <i class="fa fa-circle ml-2"></i> حصة عن بعد (Distance)
                            </div>
                            <div class="py-2 px-3 mb-2 text-white font-weight-bold rounded" style="background:#ffaa2b;">
                                <i class="fa fa-circle ml-2"></i> حفل تخرج / مناسبة
                            </div>
                            <div class="py-2 px-3 mb-2 text-white font-weight-bold rounded" style="background:#ff3e3e;">
                                <i class="fa fa-circle ml-2"></i> امتحان / موعد حاسم
                            </div>
                            <div class="py-2 px-3 mb-2 text-white font-weight-bold rounded" style="background:#886cff;">
                                <i class="fa fa-circle ml-2"></i> اجتماع إداري
                            </div>
                        </div>
                        <div class="alert alert-info mt-4 p-2 small">
                            <i class="la la-info-circle"></i> يمكنك النقر على أي حدث في التقويم لتعديله أو حذفه فوراً.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-xxl-8">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar" style="min-height: 700px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1: إضافة حدث جديد -->
<div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">إضافة موعد أو حدث جديد</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formAddEvent">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">عنوان الحدث:</label>
                        <input type="text" name="title" class="form-control" placeholder="مثلاً: حصة إنجليزية حضورية" required>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">النوع واللون:</label>
                        <select name="color" class="form-control" required>
                            <option value="#593bdb" selected>حصة حضورية (أزرق)</option>
                            <option value="#2bc155">حصة عن بعد (أخضر)</option>
                            <option value="#ffaa2b">حفل تخرج / مناسبة (برتقالي)</option>
                            <option value="#ff3e3e">امتحان / موعد حاسم (أحمر)</option>
                            <option value="#886cff">اجتماع إداري (بنفسجي)</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">وقت البداية:</label>
                            <input type="datetime-local" name="start_time" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">وقت النهاية:</label>
                            <input type="datetime-local" name="end_time" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">تفاصيل أو رابط الحصة (اختياري):</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="رابط Google Meet أو ملاحظات..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">حفظ الحدث</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: تعديل أو حذف الحدث -->
<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">تعديل أو حذف الحدث</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formUpdateEvent">
                @csrf
                <input type="hidden" id="modal_event_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">العنوان:</label>
                        <input type="text" id="modal_event_title" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">النوع واللون:</label>
                        <select id="modal_event_color" name="color" class="form-control" required>
                            <option value="#593bdb">حصة حضورية (أزرق)</option>
                            <option value="#2bc155">حصة عن بعد (أخضر)</option>
                            <option value="#ffaa2b">حفل تخرج / مناسبة (برتقالي)</option>
                            <option value="#ff3e3e">امتحان / موعد حاسم (أحمر)</option>
                            <option value="#886cff">اجتماع إداري (بنفسجي)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">ملاحظات / الرابط:</label>
                        <textarea id="modal_event_desc" name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" id="btnDelete" class="btn btn-danger">
                        <i class="la la-trash"></i> حذف الحدث
                    </button>
                    <div>
                        <button type="button" class="btn btn-light" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-success font-weight-bold">حفظ التغييرات</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- FullCalendar -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/ar.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ar',
            direction: 'rtl',
            headerToolbar: {
                right: 'prev,next today',
                center: 'title',
                left: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: "{{ route('agenda.events') }}",
            eventClick: function(info) {
                var event = info.event;
                $('#modal_event_id').val(event.id);
                $('#modal_event_title').val(event.title);
                $('#modal_event_color').val(event.backgroundColor);
                $('#modal_event_desc').val(event.extendedProps.description || '');
                $('#editEventModal').modal('show');
            }
        });
        calendar.render();

        // 1. إضافة حدث
        document.getElementById('formAddEvent').addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            fetch("{{ route('agenda.store') }}", {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(() => {
                $('#createEventModal').modal('hide');
                this.reset();
                calendar.refetchEvents();
            });
        });

        // 2. تعديل حدث
        document.getElementById('formUpdateEvent').addEventListener('submit', function(e) {
            e.preventDefault();
            var id = $('#modal_event_id').val();
            var payload = {
                title: $('#modal_event_title').val(),
                color: $('#modal_event_color').val(),
                description: $('#modal_event_desc').val(),
                _token: '{{ csrf_token() }}'
            };

            fetch("{{ url('/agenda/update') }}/" + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(() => {
                $('#editEventModal').modal('hide');
                calendar.refetchEvents();
            });
        });

        // 3. حذف حدث
        document.getElementById('btnDelete').addEventListener('click', function() {
            var id = $('#modal_event_id').val();
            if (confirm("هل تريد بالتأكيد حذف هذا الحدث؟")) {
                fetch("{{ url('/agenda/delete') }}/" + id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ _method: 'DELETE', _token: '{{ csrf_token() }}' })
                })
                .then(res => res.json())
                .then(() => {
                    $('#editEventModal').modal('hide');
                    calendar.refetchEvents();
                });
            }
        });
    });
</script>
@endsection