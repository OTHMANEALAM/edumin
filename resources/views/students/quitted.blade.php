@extends('layouts.default')

@section('content')
<div class="container-fluid" dir="rtl" style="text-align: right;">
    
    <!-- رأس الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-danger font-weight-bold">
            <i class="fas fa-user-slash"></i> أرشيف الطلاب المغادرين
        </h3>
        <a href="{{ route('students.index') }}" class="btn btn-primary font-weight-bold">
            <i class="fas fa-arrow-right"></i> العودة للطلاب النشطين
        </a>
    </div>

    <!-- جدول المغادرين -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>#</th>
                            <th>اسم الطالب</th>
                            <th>الهاتف</th>
                            <th>التخصص / الفوج السابق</th>
                            <th>تاريخ المغادرة</th>
                            <th>سبب المغادرة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
    @if(isset($quittedStudents) && count($quittedStudents) > 0)
        @foreach($quittedStudents as $st)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-right">
                    <strong>{{ $st->first_name }} {{ $st->last_name }}</strong>
                    <br><small class="text-muted">{{ $st->student_id ?? '' }}</small>
                </td>
                <td>{{ $st->phone }}</td>
                <td>
                    {{ $st->course_name ?? ($st->course->name ?? '-') }} | 
                    <span class="badge badge-secondary">{{ $st->group_name ?? '-' }}</span>
                </td>
                <td>{{ $st->quit_date ?? '-' }}</td>
                <td>{{ $st->quit_reason ?? '-' }}</td>
                <td>
                    <div class="d-flex justify-content-center align-items-center flex-wrap" style="gap: 4px;">
                        <form action="{{ route('students.restore', $st->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-success text-white font-weight-bold" title="استرجاع الطالب">
                                <i class="la la-undo"></i> استرجاع
                            </button>
                        </form>
                        <button type="button" class="btn btn-xs btn-primary text-white font-weight-bold" onclick="showStudentProfile({{ $st->id }})" title="الملف الشخصي">
                            <i class="la la-user"></i> الملف
                        </button>
                        <button type="button" class="btn btn-xs btn-info text-white font-weight-bold" onclick="showStudentFinancial({{ $st->id }})" title="السجل المالي">
                            <i class="la la-file-invoice-dollar"></i> المالي
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" class="text-center text-muted py-4">لا يوجد أي طلاب مغادرين حالياً.</td>
        </tr>
    @endif
</tbody>
                </table>
            </div>
        </div>
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
                    <i class="la la-file-invoice-dollar mr-1"></i> السجل المالي للطالب المغادر: <span id="pay_modal_fullname" class="text-warning"></span>
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

<!-- دوال الجافاسكريبت -->
<script>
    function showStudentProfile(studentId) {
        if (!studentId) return;
        fetchStudentData(studentId, 'profile');
    }

    function showStudentFinancial(studentId) {
        if (!studentId) return;
        fetchStudentData(studentId, 'financial');
    }

    function fetchStudentData(studentId, modalType) {
        fetch('/students/' + studentId + '/financial-profile')
            .then(res => res.json())
            .then(response => {
                let student = response.student || {};
                let payments = response.payments || [];

                let fname = student.first_name || '';
                let lname = student.last_name || '';
                let fullname = (fname + ' ' + lname).trim() || '—';

                if (document.getElementById('prof_fullname')) document.getElementById('prof_fullname').innerText = fullname;
                if (document.getElementById('prof_reg')) document.getElementById('prof_reg').innerText = student.id || '—';
                if (document.getElementById('prof_cin')) document.getElementById('prof_cin').innerText = student.cin || '—';
                if (document.getElementById('prof_phone')) document.getElementById('prof_phone').innerText = student.phone || '—';
                if (document.getElementById('prof_dob')) document.getElementById('prof_dob').innerText = student.birth_date || '—';
                if (document.getElementById('prof_date')) document.getElementById('prof_date').innerText = student.registration_date || '—';

                let courseName = (student.course && student.course.name) ? student.course.name : (student.course_name || '—');
                if (document.getElementById('prof_course')) document.getElementById('prof_course').innerText = courseName;
                if (document.getElementById('prof_group')) document.getElementById('prof_group').innerText = student.group_name || '—';
                if (document.getElementById('prof_mode')) document.getElementById('prof_mode').innerText = student.training_mode || '—';

                let regFee = parseFloat(student.registration_fee_paid || 0);
                if (document.getElementById('prof_fee')) document.getElementById('prof_fee').innerText = regFee.toFixed(2) + ' DH';

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

                let cinImg = document.getElementById('prof_cin_image');
                if (cinImg) {
                    cinImg.src = student.cin_document ? ('/storage/' + student.cin_document) : 'https://via.placeholder.com/300x180?text=No+CIN+Image';
                }

                if (document.getElementById('pay_modal_fullname')) document.getElementById('pay_modal_fullname').innerText = fullname;
                if (document.getElementById('pay_modal_course')) document.getElementById('pay_modal_course').innerText = courseName + (student.group_name ? (' | فوج: ' + student.group_name) : '');
                if (document.getElementById('pay_modal_reg_fee')) document.getElementById('pay_modal_reg_fee').innerText = regFee.toFixed(2) + ' DH';
                if (document.getElementById('pay_modal_reg_date')) document.getElementById('pay_modal_reg_date').innerText = student.registration_date || '—';

                let tbody = document.getElementById('pay_modal_records_tbody');
                if (tbody) {
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
                    if (document.getElementById('pay_modal_total_amount')) {
                        document.getElementById('pay_modal_total_amount').innerText = grandTotal.toFixed(2) + ' DH';
                    }
                }

                if (modalType === 'financial') {
                    $('#studentPaymentsHistoryModal').modal('show');
                } else {
                    $('#studentProfileModal').modal('show');
                }
            })
            .catch(err => {
                console.error("Error:", err);
                alert('حدث خطأ أثناء تحميل بيانات الطالب المغادر');
            });
    }
</script>
@endsection