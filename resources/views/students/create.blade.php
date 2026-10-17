@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>استمارة تسجيل طالب جديد</h4>
                <p class="mb-0">يرجى ملء جميع المعلومات الإدارية والمالية بدقة</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <a href="{{ route('students.index') }}" class="btn btn-outline-primary">لائحة الطلاب</a>
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
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
@csrf

                        <!-- 1. البيانات الإدارية الأساسية -->
                        <h5 class="text-primary mb-3"><i class="la la-id-card"></i> 1. البيانات الإدارية الأساسية</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">الرقم التسلسلي (تلقائي)</label>
                                    <input type="text" name="registration_number" class="form-control bg-light font-weight-bold text-primary" value="{{ old('registration_number', $autoRegNumber) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">تاريخ التسجيل *</label>
                                    <input type="date" name="registration_date" class="form-control" value="{{ old('registration_date', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">اسم الشخص الذي استقبله</label>
                                    <input type="text" name="received_by" class="form-control" value="{{ old('received_by') }}" placeholder="اسم الموظف أو المستقبِل">
                                </div>
                                
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">اسم الشخص الذي سجله</label>
                                    <input type="text" name="registered_by" class="form-control" value="{{ old('registered_by') }}" placeholder="المسؤول عن التسجيل">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- 2. المعلومات الشخصية -->
                        <h5 class="text-primary mb-3"><i class="la la-user"></i> 2. المعلومات الشخصية للطالب</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">الاسم الشخصي *</label>
                                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">الاسم العائلي (النسب) *</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                                </div>
                            </div>
                            <!-- المستوى الدراسي -->
<div class="col-md-6 mb-3">
    <label for="niveau_scolaire" class="form-label">المستوى الدراسي</label>
    <input type="text" name="niveau_scolaire" id="niveau_scolaire" class="form-control" value="{{ old('niveau_scolaire') }}" placeholder="مثال: BAC, 3 EME...">
</div>

<!-- الثمن المتفق عليه -->
<div class="col-md-6 mb-3">
    <label for="agreed_price" class="form-label">الثمن المتفق عليه (درهم)</label>
    <input type="number" step="0.01" name="agreed_price" id="agreed_price" class="form-control" value="{{ old('agreed_price') }}" placeholder="مثال: 600.00">
</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">تاريخ الازدياد</label>
                                    <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">رقم البطاقة الوطنية (CIN)</label>
                                    <input type="text" name="cin" class="form-control" value="{{ old('cin') }}" placeholder="مثال: AB123456">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">رقم الهاتف *</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="06XXXXXXXX" required>
                                </div>
                            </div>
                           <div class="form-group col-md-6">
    <label class="font-weight-bold">رقم الواتساب (WhatsApp):</label>
    <<input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $student->whatsapp ?? '') }}">
</div>
                            <div class="form-group col-md-6">
    <label class="font-weight-bold">صورة البطاقة الوطنية (CIN):</label>
    <input type="file" name="cin_document" class="form-control-file" accept="image/*">
</div>

                        <hr class="my-4">

                      <!-- 3. نمط التكوين والتخصص المترابط -->
                        <h5 class="text-primary mb-3"><i class="la la-graduation-cap"></i> 3. نمط التكوين والتخصص</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">طريقة التدريب *</label>
                                    <select name="training_mode" id="training_mode" class="form-control default-select" onchange="filterCoursesByMode(this.value)" required>
                                        <option value="">-- اختر طريقة التدريب أولاً --</option>
                                        <option value="presentiel" {{ old('training_mode') == 'presentiel' ? 'selected' : '' }}>حضوري (Présentiel)</option>
                                        <option value="distance" {{ old('training_mode') == 'distance' ? 'selected' : '' }}>عن بعد (À distance)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">التخصص (Filière) *</label>
                                    <select name="course_id" id="course_id" class="form-control default-select" required>
                                        <option value="">-- اختر التخصص --</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" 
                                                    class="course-option"
                                                    data-mode="{{ $course->mode }}" 
                                                    {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->name }} (السنة: {{ $course->academic_year }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">

                        <!-- 4. الأداء والتسجيل المالي -->
                        <h5 class="text-primary mb-3"><i class="la la-money"></i> 4. الأداء والتسجيل المالي</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">المبلغ المؤدى في التسجيل (DH) *</label>
                                    <input type="number" step="0.01" name="registration_fee_paid" class="form-control" value="{{ old('registration_fee_paid', 0) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">طريقة الأداء *</label>
                                    <select name="payment_method" class="form-control" required>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>نقداً (Espèces / Cash)</option>
                                        <option value="virement" {{ old('payment_method') == 'virement' ? 'selected' : '' }}>تحويل بنكي (Virement)</option>
                                        <option value="versement" {{ old('payment_method') == 'versement' ? 'selected' : '' }}>إيداع بنكي (Versement)</option>
                                        <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>شيك (Chèque)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
    <div class="form-group">
        <label class="font-weight-bold">المبلغ المؤدى يشمل *</label>
        <select name="registration_payment_type" class="form-control" required>
            <option value="registration_only" {{ old('registration_payment_type') == 'registration_only' ? 'selected' : '' }}>واجب التسجيل فقط</option>
            <option value="registration_and_first_month" {{ old('registration_payment_type') == 'registration_and_first_month' ? 'selected' : '' }}>واجب التسجيل + الشهر الأول</option>
        </select>
    </div>
</div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-5 font-weight-bold">حفظ وتسجيل الطالب</button>
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

    // إعادة القائمة للخيار الافتراضي
    courseSelect.value = "";

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

    // تحديث القائمة إن كان القالب يستخدم مكتبة selectpicker الخاصة بـ Edumin
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