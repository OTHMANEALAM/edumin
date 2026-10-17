@extends('layouts.default')

@section('content')
<div class="container-fluid" dir="rtl" style="text-align: right;">

    <!-- رأس الصفحة -->
    <div class="row page-titles mx-0 mb-4 bg-white p-3 shadow-sm" style="border-radius: 8px;">
        <div class="col-sm-6 p-md-0">
            <h4 class="text-primary font-weight-bold mb-0">لائحة الطلبة المسجلين</h4>
            <small class="text-muted">إدارة بيانات الطلبة والتسجيلات</small>
        </div>
        <div class="col-sm-6 p-md-0 d-flex justify-content-sm-end align-items-center mt-2 mt-sm-0">
            <a href="{{ route('students.quitted') }}" class="btn btn-outline-danger font-weight-bold ml-2">
                <i class="la la-user-slash"></i> أرشيف المغادرين
            </a>
            <a href="{{ route('students.create') }}" class="btn btn-primary font-weight-bold">
                <i class="la la-user-plus"></i> تسجيل طالب جديد
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show font-weight-bold">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- فلتر البحث والتصفية -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('students.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-2">
                        <label class="font-weight-bold text-dark">بحث عام (الاسم، الهاتف، CIN):</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="اكتب للبحث...">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="font-weight-bold text-dark">التخصص:</label>
                        <select name="course_name" class="form-control">
                            <option value="">-- كل التخصصات --</option>
                            @php
                                $coursesList = isset($courses) ? $courses : \App\Models\Course::select('name')->distinct()->get();
                            @endphp
                            @foreach($coursesList as $c)
                                <option value="{{ $c->name }}" {{ request('course_name') == $c->name ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="font-weight-bold text-dark">نمط التكوين:</label>
                        <select name="training_mode" class="form-control">
                            <option value="">-- الكل --</option>
                            <option value="presential" {{ request('training_mode') == 'presential' ? 'selected' : '' }}>حضوري</option>
                            <option value="online" {{ request('training_mode') == 'online' ? 'selected' : '' }}>عن بعد</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2 d-flex">
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold ml-1">
                            <i class="la la-search"></i> تصفية
                        </button>
                        <a href="{{ route('students.index') }}" class="btn btn-light border font-weight-bold" title="إعادة تعيين">
                            <i class="la la-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- جدول الطلبة (أعمدة مفصولة ومنسقة) -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="width: 45px;">#</th>
                            <th class="text-right">الطالب</th>
                            <th>رقم الهاتف</th>
                            <th>البطاقة (CIN)</th>
                            <th>التخصص / النمط</th>
                            <th>الفوج</th>
                            <th>تاريخ التسجيل</th>
                            <th>واجب التسجيل</th>
                            <th>الإجراءات والملف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $idx => $st)
                        <tr>
                            <!-- 1. الترقيم -->
                            <td>{{ method_exists($students, 'firstItem') ? ($students->firstItem() + $idx) : ($idx + 1) }}</td>
                            
                            <!-- 2. الاسم ورقم التسجيل -->
                            <td class="text-right">
                                <strong class="text-dark d-block">{{ $st->first_name }} {{ $st->last_name }}</strong>
                                <small class="text-muted">🆔 {{ $st->registration_number ?? '—' }}</small>
                            </td>

                            <!-- 3. عمود الهاتف -->
                            <td>
                                <span class="font-weight-bold text-dark dir-ltr">
                                    <i class="la la-phone text-muted mr-1"></i>{{ $st->phone ?? '—' }}
                                </span>
                            </td>

                            <!-- 4. عمود CIN -->
                            <td>
                                <span class="badge badge-light border text-dark font-weight-bold py-1 px-2">
                                    {{ $st->cin ?? 'بدون بطاقة' }}
                                </span>
                            </td>

                            <!-- 5. التخصص والنمط -->
                            <td>
                                <div class="font-weight-bold text-dark">{{ optional($st->course)->name ?? '—' }}</div>
                                <span class="badge {{ in_array($st->training_mode, ['حضوري', 'presential']) ? 'badge-success' : 'badge-info' }} mt-1">
                                    {{ in_array($st->training_mode, ['حضوري', 'presential']) ? 'حضوري' : 'عن بعد' }}
                                </span>
                            </td>

                            <!-- 6. الفوج -->
                            <td>
                                <span class="badge badge-dark">{{ $st->group_name ?? '-' }}</span>
                            </td>

                            <!-- 7. تاريخ التسجيل -->
                            <td>
                                <small class="text-muted">{{ $st->registration_date ?? '—' }}</small>
                            </td>

                            <!-- 8. واجب التسجيل المؤدى -->
                            <td>
                                <span class="text-primary font-weight-bold">
                                    {{ number_format(floatval($st->registration_fee_paid ?? 0), 2) }} DH
                                </span>
                            </td>

                            <!-- 9. الإجراءات (تعديل + زر الملف + زر السجل المالي) -->
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <!-- زر التعديل -->
                                    <a href="{{ route('students.edit', $st->id) }}" 
                                       class="btn btn-xs btn-warning text-white font-weight-bold mr-1" 
                                       title="تعديل">
                                        <i class="la la-edit"></i>
                                    </a>

                                   <button type="button" class="btn btn-sm btn-primary" onclick="showStudentProfile({{ $st->id }})">
    <i class="la la-user"></i> الملف
</button>

                                    <!-- زر السجل المالي -->
                                  <!-- زر السجل المالي -->
<button type="button" class="btn btn-sm btn-info" onclick="showStudentFinancial({{ $st->id }})">
    <i class="la la-file-invoice-dollar"></i> المالي
</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted font-weight-bold">
                                لم يتم العثور على أي طالب.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($students, 'hasPages') && $students->hasPages())
        <div class="card-footer bg-white d-flex justify-content-center">
            {{ $students->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>

<!-- 1. نافذة الملف الشخصي المستقلة -->
<div class="modal fade" id="studentProfileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content text-right" dir="rtl" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="modal-title font-weight-bold text-white mb-0">
                    <i class="la la-user mr-1"></i> الملف الشخصي للطالب: <span id="prof_fullname" class="text-warning"></span>
                </h5>
                <button type="button" class="close text-white m-0" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-7 border-left">
                        <div class="row mb-2"><div class="col-4 text-muted font-weight-bold">رقم التسجيل:</div><div class="col-8" id="prof_reg">—</div></div>
                        <div class="row mb-2"><div class="col-4 text-muted font-weight-bold">رقم البطاقة (CIN):</div><div class="col-8" id="prof_cin">—</div></div>
                        <div class="row mb-2"><div class="col-4 text-muted font-weight-bold">رقم الهاتف:</div><div class="col-8" id="prof_phone">—</div></div>
                        <div class="row mb-2"><div class="col-4 text-muted font-weight-bold">رقم الواتساب:</div><div class="col-8 text-success font-weight-bold" id="prof_whatsapp_display">غير مسجل</div></div>
                        <div class="row mb-2"><div class="col-4 text-muted font-weight-bold">تاريخ الازدياد:</div><div class="col-8" id="prof_dob">—</div></div>
                        <div class="row mb-2"><div class="col-4 text-muted font-weight-bold">تاريخ التسجيل:</div><div class="col-8" id="prof_date">—</div></div>
                        <div class="row mb-2"><div class="col-4 text-muted font-weight-bold">التخصص:</div><div class="col-8 font-weight-bold text-primary" id="prof_course">—</div></div>
                        <div class="row mb-2"><div class="col-4 text-muted font-weight-bold">الفوج (Group):</div><div class="col-8" id="prof_group">—</div></div>
                        <div class="row mb-2"><div class="col-4 text-muted font-weight-bold">نمط التكوين:</div><div class="col-8" id="prof_mode">—</div></div>
                        <div class="row mb-2"><div class="col-4 text-muted font-weight-bold">واجب التسجيل:</div><div class="col-8 text-danger font-weight-bold" id="prof_fee">0.00 DH</div></div>
                    </div>
                    <div class="col-md-5 text-center">
                        <div class="card p-3 shadow-sm bg-light border-0">
                            <h6 class="mb-3 font-weight-bold text-dark">صورة البطاقة الوطنية</h6>
                            <div style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                <img id="prof_cin_image" src="" alt="CIN" class="img-fluid rounded mb-3" style="max-height: 190px; object-fit: contain;">
                            </div>
                            <div class="mt-2">
                                <a href="#" id="prof_whatsapp_btn" target="_blank" class="btn btn-success btn-block font-weight-bold" style="display: none;">
                                    <i class="fab fa-whatsapp" style="font-size: 16px; margin-left: 5px;"></i> مراسلة عبر WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<!-- 2. نافذة السجل المالي المستقلة -->
<div class="modal fade" id="studentPaymentsHistoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content text-right" dir="rtl" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
            <div class="modal-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="modal-title font-weight-bold text-white mb-0">
                    <i class="la la-file-invoice-dollar mr-1"></i> السجل المالي للطالب: <span id="pay_modal_fullname" class="text-warning"></span>
                </h5>
                <button type="button" class="close text-white m-0" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="card bg-light border-0 mb-3 shadow-sm" style="border-radius: 8px;">
                    <div class="card-body py-3 px-3">
                        <div class="row text-center text-md-right">
                            <div class="col-md-4 mb-2 mb-md-0">
                                <small class="text-muted d-block font-weight-bold">التخصص / الفوج:</small>
                                <span id="pay_modal_course" class="font-weight-bold text-dark">—</span>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <small class="text-muted d-block font-weight-bold">واجب التسجيل المؤدى:</small>
                                <span id="pay_modal_reg_fee" class="text-primary font-weight-bold" style="font-size: 15px;">0.00 DH</span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block font-weight-bold">تاريخ التسجيل:</small>
                                <span id="pay_modal_reg_date" class="text-dark font-weight-bold">—</span>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="font-weight-bold text-dark mb-2"><i class="la la-list-alt mr-1"></i> الشهور المؤداة وملاحظاتها:</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>الشهر المؤدى</th>
                                <th>المبلغ (DH)</th>
                                <th>تاريخ الأداء</th>
                                <th>الملاحظة</th>
                            </tr>
                        </thead>
                        <tbody id="pay_modal_records_tbody">
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary font-weight-bold">
                                <td colspan="2" class="text-right pr-3">المجموع الإجمالي المؤدى (تسجيل + شهور):</td>
                                <td id="pay_modal_total_amount" class="text-success font-weight-bold" style="font-size: 16px;">0.00 DH</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<!-- السكربت الموحد لتشغيل الملف الشخصي والسجل المالي معا -->
<script>
    // زر الملف الشخصي المستقل
    function showStudentProfile(studentId) {
        if (!studentId) return;
        fetchStudentData(studentId, 'profile');
    }

    // زر السجل المالي المستقل
    function showStudentFinancial(studentId) {
        if (!studentId) return;
        fetchStudentData(studentId, 'financial');
    }

    // دالة جلب البيانات الموحدة في الخلفية
    function fetchStudentData(studentId, modalType) {
        fetch('/students/' + studentId + '/financial-profile')
            .then(res => res.json())
            .then(response => {
                let student = response.student || {};
                let payments = response.payments || [];

                let fname = student.first_name || '';
                let lname = student.last_name || '';
                let fullname = (fname + ' ' + lname).trim() || '—';

                // تعبئة بيانات الملف الشخصي
                document.getElementById('prof_fullname').innerText = fullname;
                document.getElementById('prof_reg').innerText = student.id || '—';
                document.getElementById('prof_cin').innerText = student.cin || '—';
                document.getElementById('prof_phone').innerText = student.phone || '—';
                document.getElementById('prof_dob').innerText = student.birth_date || '—';
                document.getElementById('prof_date').innerText = student.registration_date || '—';

                let courseName = (student.course && student.course.name) ? student.course.name : (student.course_name || '—');
                document.getElementById('prof_course').innerText = courseName;
                document.getElementById('prof_group').innerText = student.group_name || '—';
                document.getElementById('prof_mode').innerText = student.training_mode || '—';

                let regFee = parseFloat(student.registration_fee_paid || 0);
                document.getElementById('prof_fee').innerText = regFee.toFixed(2) + ' DH';

                // WhatsApp
                let waBtn = document.getElementById('prof_whatsapp_btn');
                let waDisplay = document.getElementById('prof_whatsapp_display');
                if (student.whatsapp || student.phone) {
                    let num = student.whatsapp || student.phone;
                    if (waDisplay) waDisplay.innerText = num;
                    if (waBtn) {
                        waBtn.href = 'https://wa.me/' + num.replace(/[^0-9]/g, '');
                        waBtn.style.display = 'block';
                    }
                } else {
                    if (waDisplay) waDisplay.innerText = 'غير مسجل';
                    if (waBtn) waBtn.style.display = 'none';
                }

                // صورة CIN
                let cinImg = document.getElementById('prof_cin_image');
                if (cinImg) {
                    cinImg.src = student.cin_document ? ('/storage/' + student.cin_document) : 'https://via.placeholder.com/300x180?text=No+CIN+Image';
                }

                // تعبئة بيانات السجل المالي
                document.getElementById('pay_modal_fullname').innerText = fullname;
                document.getElementById('pay_modal_course').innerText = courseName + (student.group_name ? (' | فوج: ' + student.group_name) : '');
                document.getElementById('pay_modal_reg_fee').innerText = regFee.toFixed(2) + ' DH';
                document.getElementById('pay_modal_reg_date').innerText = student.registration_date || '—';

                let tbody = document.getElementById('pay_modal_records_tbody');
                tbody.innerHTML = '';
                let monthlyTotal = 0;

                if (!payments || payments.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-muted py-3">لا توجد أي دفعة شهرية مسجلة لهذا الطالب حتى الآن.</td></tr>';
                } else {
                    payments.forEach((item, index) => {
                        let amt = parseFloat(item.amount || 0);
                        monthlyTotal += amt;
                        let note = item.notes ? item.notes : '—';
                        let monthName = item.month_name || item.month || '—';
                        let pDate = item.payment_date || item.date || '—';

                        tbody.innerHTML += `<tr>
                            <td>${index + 1}</td>
                            <td class="font-weight-bold text-dark">${monthName}</td>
                            <td class="text-success font-weight-bold">${amt.toFixed(2)} DH</td>
                            <td><small class="text-muted">${pDate}</small></td>
                            <td><small>${note}</small></td>
                        </tr>`;
                    });
                }

                let grandTotal = regFee + monthlyTotal;
                document.getElementById('pay_modal_total_amount').innerText = grandTotal.toFixed(2) + ' DH';

                // إظهار النافذة المطلوبة حسب الزر المنقور
                if (modalType === 'financial') {
                    $('#studentPaymentsHistoryModal').modal('show');
                } else {
                    $('#studentProfileModal').modal('show');
                }
            })
            .catch(err => {
                console.error("Error:", err);
                alert('حدث خطأ أثناء تحميل بيانات الطالب');
            });
    }
</script>

    
<script>
    function showStudentPayments(studentId) {
        if (!studentId) return;

        // إرجاع التبويب الافتراضي للتبويب الأول عند الفتح
        $('#studentTab a[href="#student-info"]').tab('show');

        fetch('/students/' + studentId + '/financial-profile')
            .then(res => res.json())
            .then(response => {
                let student = response.student || {};
                let payments = response.payments || [];

                // 1. البيانات الشخصية
                let fname = student.first_name || '';
                let lname = student.last_name || '';
                let fullname = (fname + ' ' + lname).trim() || '—';
                
                document.getElementById('prof_fullname').innerText = fullname;
                document.getElementById('prof_reg').innerText = student.id || '—';
                document.getElementById('prof_cin').innerText = student.cin || '—';
                document.getElementById('prof_phone').innerText = student.phone || '—';
                document.getElementById('prof_dob').innerText = student.birth_date || '—';
                document.getElementById('prof_date').innerText = student.registration_date || '—';
                
                let courseName = (student.course && student.course.name) ? student.course.name : (student.course_name || '—');
                document.getElementById('prof_course').innerText = courseName;
                document.getElementById('prof_group').innerText = student.group_name || '—';
                document.getElementById('prof_mode').innerText = student.training_mode || '—';

                // WhatsApp
                let waBtn = document.getElementById('prof_whatsapp_btn');
                let waDisplay = document.getElementById('prof_whatsapp_display');
                if (student.whatsapp || student.phone) {
                    let num = student.whatsapp || student.phone;
                    if (waDisplay) waDisplay.innerText = num;
                    if (waBtn) {
                        waBtn.href = 'https://wa.me/' + num.replace(/[^0-9]/g, '');
                        waBtn.style.display = 'block';
                    }
                } else {
                    if (waDisplay) waDisplay.innerText = 'غير مسجل';
                    if (waBtn) waBtn.style.display = 'none';
                }

                // صورة البطاقة
                let cinImg = document.getElementById('prof_cin_image');
                if (cinImg) {
                    cinImg.src = student.cin_document ? ('/storage/' + student.cin_document) : 'https://via.placeholder.com/300x180?text=No+CIN+Image';
                }

                // 2. البيانات المالية
                let regFee = parseFloat(student.registration_fee_paid || 0);
                document.getElementById('prof_fee').innerText = regFee.toFixed(2) + ' DH';
                document.getElementById('pay_modal_course').innerText = courseName + (student.group_name ? (' | فوج: ' + student.group_name) : '');
                document.getElementById('pay_modal_reg_fee').innerText = regFee.toFixed(2) + ' DH';
                document.getElementById('pay_modal_reg_date').innerText = student.registration_date || '—';

                // جدول المدفوعات
                let tbody = document.getElementById('pay_modal_records_tbody');
                tbody.innerHTML = '';
                let monthlyTotal = 0;

                if (!payments || payments.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-muted py-3">لا توجد أي دفعة شهرية مسجلة لهذا الطالب حتى الآن.</td></tr>';
                } else {
                    payments.forEach((item, index) => {
                        let amt = parseFloat(item.amount || 0);
                        monthlyTotal += amt;
                        let note = item.notes ? item.notes : '—';
                        let monthName = item.month_name || item.month || '—';
                        let pDate = item.payment_date || item.date || '—';

                        tbody.innerHTML += `<tr>
                            <td>${index + 1}</td>
                            <td class="font-weight-bold text-dark">${monthName}</td>
                            <td class="text-success font-weight-bold">${amt.toFixed(2)} DH</td>
                            <td><small class="text-muted">${pDate}</small></td>
                            <td><small>${note}</small></td>
                        </tr>`;
                    });
                }

                let grandTotal = regFee + monthlyTotal;
                document.getElementById('pay_modal_total_amount').innerText = grandTotal.toFixed(2) + ' DH';

                // فتح الـ Modal الصحيح والموحد
                $('#studentProfileModal').modal('show');
            })
            .catch(err => {
                console.error("Error:", err);
                alert('حدث خطأ أثناء تحميل بيانات الطالب');
            });
    }
</script>
@endsection