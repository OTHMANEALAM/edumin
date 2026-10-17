@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>تعديل بيانات الطالب: {{ $student->first_name }} {{ $student->last_name }}</h4>
                <p class="mb-0">الرقم التسلسلي: <span class="badge badge-primary">{{ $student->registration_number }}</span></p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <a href="{{ route('students.index') }}" class="btn btn-outline-primary">العودة للائحة الطلاب</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger solid alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
                        @csrf
                        @method('PUT')

                        <!-- 1. البيانات الإدارية -->
                        <h5 class="text-primary mb-3"><i class="la la-id-card"></i> 1. البيانات الإدارية</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">الرقم التسلسلي</label>
                                    <input type="text" class="form-control bg-light font-weight-bold" value="{{ $student->registration_number }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">تاريخ التسجيل *</label>
                                    <input type="date" name="registration_date" class="form-control" value="{{ old('registration_date', $student->registration_date) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">استقبله</label>
                                    <input type="text" name="received_by" class="form-control" value="{{ old('received_by', $student->received_by) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">سجله</label>
                                    <input type="text" name="registered_by" class="form-control" value="{{ old('registered_by', $student->registered_by) }}">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- 2. المعلومات الشخصية -->
                        <h5 class="text-primary mb-3"><i class="la la-user"></i> 2. المعلومات الشخصية</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">الاسم الشخصي *</label>
                                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $student->first_name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">الاسم العائلي *</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $student->last_name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">تاريخ الازدياد</label>
                                    <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $student->birth_date) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">رقم البطاقة الوطنية (CIN)</label>
                                    <input type="text" name="cin" class="form-control" value="{{ old('cin', $student->cin) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">رقم الهاتف *</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">رقم الواتساب</label>
                                    <<input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $student->whatsapp ?? '') }}">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
    <label class="font-weight-bold">صورة البطاقة الوطنية (CIN):</label>
    
    @if($student->cin_image)
        <div class="mb-2">
            <small class="text-muted d-block mb-1">الصورة الحالية المخزنة:</small>
            <a href="{{ asset('storage/' . $student->cin_image) }}" target="_blank">
                <img src="{{ asset('storage/' . $student->cin_image) }}" alt="CIN" class="img-thumbnail" style="max-height: 120px;">
            </a>
        </div>
    @endif

    <input type="file" name="cin_document" class="form-control-file" accept="image/*">
    <small class="text-muted">اترك الحقل فارغاً إذا كنت لا تريد تغيير الصورة الحالية.</small>
</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- 3. التكوين والفوج -->
                        <h5 class="text-primary mb-3"><i class="la la-graduation-cap"></i> 3. نمط التكوين والتخصص والفوج</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">طريقة التدريب *</label>
                                    <select name="training_mode" id="training_mode" class="form-control default-select" onchange="filterCoursesByMode(this.value)" required>
                                        <option value="presentiel" {{ old('training_mode', $student->training_mode) == 'presentiel' ? 'selected' : '' }}>حضوري (Présentiel)</option>
                                        <option value="distance" {{ old('training_mode', $student->training_mode) == 'distance' ? 'selected' : '' }}>عن بعد (À distance)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">التخصص (Filière) *</label>
                                    <select name="course_id" id="course_id" class="form-control default-select" required>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" class="course-option" data-mode="{{ $course->mode }}" {{ old('course_id', $student->course_id) == $course->id ? 'selected' : '' }}>
                                                {{ $course->name }} (السنة: {{ $course->academic_year }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">الفوج (Groupe)</label>
                                    <select name="group_name" class="form-control default-select">
                                        <option value="">-- بدون فوج --</option>
                                        @foreach($availableGroups as $grp)
                                            <option value="{{ $grp }}" {{ old('group_name', $student->group_name) == $grp ? 'selected' : '' }}>{{ $grp }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- 4. الشق المالي -->
                        <h5 class="text-primary mb-3"><i class="la la-money"></i> 4. الأداء المالي للتسجيل</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">المبلغ المؤدى في التسجيل (DH) *</label>
                                    <input type="number" step="0.01" name="registration_fee_paid" class="form-control" value="{{ old('registration_fee_paid', $student->registration_fee_paid) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">طريقة الأداء *</label>
                                    <select name="payment_method" class="form-control default-select" required>
                                        <option value="cash" {{ old('payment_method', $student->payment_method) == 'cash' ? 'selected' : '' }}>نقداً (Espèces / Cash)</option>
                                        <option value="virement" {{ old('payment_method', $student->payment_method) == 'virement' ? 'selected' : '' }}>تحويل بنكي (Virement)</option>
                                        <option value="versement" {{ old('payment_method', $student->payment_method) == 'versement' ? 'selected' : '' }}>إيداع بنكي (Versement)</option>
                                        <option value="cheque" {{ old('payment_method', $student->payment_method) == 'cheque' ? 'selected' : '' }}>شيك (Chèque)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-5 font-weight-bold">تحديث البيانات</button>
                            <a href="{{ route('students.index') }}" class="btn btn-light ml-2">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterCoursesByMode(mode) {
    var courseSelect = document.getElementById('course_id');
    var options = courseSelect.querySelectorAll('.course-option');

    options.forEach(function(opt) {
        if (!mode) {
            opt.style.display = 'none';
        } else if (opt.getAttribute('data-mode') === mode) {
            opt.style.display = 'block';
            opt.disabled = false;
        } else {
            opt.style.display = 'none';
            opt.disabled = true;
        }
    });

    if (window.jQuery && typeof jQuery(courseSelect).selectpicker === 'function') {
        jQuery(courseSelect).selectpicker('refresh');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var initialMode = document.getElementById('training_mode').value;
    filterCoursesByMode(initialMode || '');
});
</script>
@endsection