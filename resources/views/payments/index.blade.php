@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>سجل الأداءات والمتابعة المالية</h4>
                <p class="mb-0">البحث في السجلات المالية للطلبة حسب الاسم أو التخصص أو الفوج</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
    <!-- زر فتح جدول المتأخرين عبر Modal -->
    <button type="button" class="btn btn-outline-danger font-weight-bold ml-2" onclick="showOverdueStudentsModal()">
        <i class="la la-clock-o"></i> تتبع الدفع المتأخر
    </button>

    <!-- زر تسجيل دفعة جديدة -->
    <a href="{{ route('payments.create') }}" class="btn btn-primary font-weight-bold">
        <i class="la la-plus-circle"></i> تسجيل دفعة جديدة
    </a>
</div>
    </div>

    @if(session('success'))
        <div class="alert alert-success solid alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close h-100" data-dismiss="alert"><span><i class="mdi mdi-close"></i></span></button>
        </div>
    @endif

    <!-- بطاقة البحث والفلترة -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light py-2">
            <h5 class="card-title text-primary mb-0 font-weight-bold">
                <i class="la la-filter mr-1"></i> خيارات البحث والتصفية
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('payments.index') }}" class="row align-items-end">
                
                <!-- بحث الطالب -->
                <div class="col-md-4 mb-2">
                    <label class="font-weight-bold text-dark">بحث عن طالب:</label>
                    <input type="text" name="student_search" class="form-control" 
                           placeholder="الاسم، الهاتف، CIN، أو رقم التسجيل..." 
                           value="{{ request('student_search') }}">
                </div>

                <!-- اختيار التخصص -->
                <div class="col-md-3 mb-2">
                    <label class="font-weight-bold text-dark">التخصص:</label>
                    <select name="course_id" class="form-control">
                        <option value="">-- جميع التخصصات --</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- اختيار الفوج -->
                <div class="col-md-2 mb-2">
                    <label class="font-weight-bold text-dark">الفوج:</label>
                    <select name="group_name" class="form-control">
                        <option value="">-- جميع الأفواج --</option>
                        @foreach($groups as $grp)
                            <option value="{{ $grp }}" {{ request('group_name') == $grp ? 'selected' : '' }}>
                                {{ $grp }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- الشهر (اختياري) -->
                <div class="col-md-2 mb-2">
                    <label class="font-weight-bold text-dark">الشهر:</label>
                    <input type="text" name="month_name" class="form-control" 
                           placeholder="مثال: الشهر 1" 
                           value="{{ request('month_name') }}">
                </div>

                <!-- أزرار الإجراء -->
                <div class="col-md-1 mb-2 d-flex">
                    <button type="submit" class="btn btn-primary w-100 font-weight-bold" title="بحث">
                        <i class="la la-search"></i>
                    </button>
                    @if($isSearching)
                        <a href="{{ route('payments.index') }}" class="btn btn-light ml-1" title="إلغاء البحث">
                            <i class="la la-times"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    <!-- عرض النتائج أو رسالة التوجيه للبحث -->
    @if(!$isSearching)
        <!-- في حالة لم يتم البحث بعد -->
        <div class="card text-center py-5 shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body">
                <i class="la la-search text-muted" style="font-size: 65px;"></i>
                <h5 class="text-dark font-weight-bold mt-3">يرجى تحديد معايير البحث أعلاه</h5>
                <p class="text-muted mb-0">اختر تخصصاً، فوجاً، أو اكتب اسم الطالب للوصول إلى كشف الأداءات المالية.</p>
            </div>
        </div>
    @else
        <!-- في حالة تم البحث: يظهر جدول النتائج -->
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title text-dark mb-0 font-weight-bold">
                    <i class="la la-users mr-1"></i> نتائج البحث 
                    <span class="badge badge-primary">{{ $studentsPayments->total() }} طالب</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th class="text-right">الطالب</th>
                                <th>التخصص / النمط</th>
                                <th>الفوج</th>
                                <th>واجب التسجيل</th>
                                <th>عدد الشهور المؤداة</th>
                                <th>مجموع الدفعات الشهرية</th>
                                <th>المجموع الإجمالي المؤدى</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($studentsPayments as $idx => $st)
                            @php
                                $regFee = floatval($st->registration_fee_paid ?? 0);
                                $monthlyFee = floatval($st->payments_sum_amount ?? 0);
                                $grandTotal = $regFee + $monthlyFee;
                            @endphp
                            <tr>
                                <td>{{ $studentsPayments->firstItem() + $idx }}</td>
                                
                                <!-- الطالب -->
                                <td class="text-right">
                                    <strong class="text-dark d-block">
                                        {{ $st->first_name }} {{ $st->last_name }}
                                    </strong>
                                    <small class="text-muted">
                                        🆔 {{ $st->registration_number ?? '—' }} | 📞 {{ $st->phone ?? '—' }}
                                    </small>
                                </td>

                                <!-- التخصص والنمط -->
                                <td>
                                    <div class="font-weight-bold text-dark">
                                        {{ optional($st->course)->name ?? ($st->specialty ?? '—') }}
                                    </div>
                                    <span class="badge badge-light border mt-1">
                                        {{ $st->training_mode ?? 'حضوري' }}
                                    </span>
                                </td>

                                <!-- الفوج -->
                                <td>
                                    <span class="badge badge-dark">{{ $st->group_name ?? '—' }}</span>
                                </td>

                                <!-- واجب التسجيل -->
                                <td>
                                    <span class="badge badge-info text-white font-weight-bold py-1 px-2">
                                        {{ number_format($regFee, 2) }} DH
                                    </span>
                                </td>

                                <!-- عدد الشهور -->
                                <td>
                                    <span class="badge badge-secondary font-weight-bold">
                                        {{ $st->payments_count }} شهر
                                    </span>
                                </td>

                                <!-- مجموع الشهور -->
                                <td>
                                    <span class="text-primary font-weight-bold">
                                        {{ number_format($monthlyFee, 2) }} DH
                                    </span>
                                </td>

                                <!-- المجموع الكلي -->
                                <td>
                                    <span class="text-success font-weight-bold" style="font-size: 15px;">
                                        {{ number_format($grandTotal, 2) }} DH
                                    </span>
                                </td>

                                <!-- زر كشف الحساب والملف -->
                                <td>
                                    <button type="button" 
                                            class="btn btn-xs btn-outline-info font-weight-bold" 
                                            onclick="showStudentPayments({{ $st->id }})"
                                            style="padding: 3px 8px; font-size: 11px;">
                                        <i class="la la-file-invoice-dollar"></i> كشف الحساب
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted font-weight-bold">
                                    لا توجد أي نتائج مطابقة لمعايير البحث المحددة.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($studentsPayments->hasPages())
                <div class="card-footer bg-white d-flex justify-content-center py-3">
                    {{ $studentsPayments->withQueryString()->links() }}
                </div>
            @endif
        </div>
    @endif
</div>

<!-- Modal الملف المالي التفاعلي للطالب -->
<div class="modal fade" id="studentPaymentsHistoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content text-right" dir="rtl" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="modal-title font-weight-bold text-white mb-0">
                    <i class="la la-file-invoice-dollar mr-1"></i> السجل المالي للطالب: <span id="pay_modal_fullname"></span>
                </h5>
                <button type="button" class="btn btn-sm btn-light font-weight-bold" onclick="$('#studentPaymentsHistoryModal').modal('hide')">✕ إغلاق</button>
            </div>
            <div class="modal-body p-4">
                
                <!-- ملخص تسجيل الطالب -->
                <div class="card bg-light border-0 mb-3 shadow-sm" style="border-radius: 8px;">
                    <div class="card-body py-3 px-3">
                        <div class="row text-center text-md-right">
                            <div class="col-md-4 mb-2 mb-md-0">
                                <small class="text-muted d-block font-weight-bold">التخصص / الفوج:</small>
                                <span id="pay_modal_course" class="font-weight-bold text-dark"></span>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <small class="text-muted d-block font-weight-bold">واجب التسجيل المؤدى:</small>
                                <span id="pay_modal_reg_fee" class="text-primary font-weight-bold" style="font-size: 15px;"></span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block font-weight-bold">تاريخ التسجيل:</small>
                                <span id="pay_modal_reg_date" class="text-dark font-weight-bold"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- جدول الشهور المؤداة بالتفصيل والملاحظات -->
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
                                <td id="pay_modal_total_amount" class="text-success font-weight-bold" style="font-size: 16px;"></td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary font-weight-bold" onclick="$('#studentPaymentsHistoryModal').modal('hide')">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showStudentPayments(studentId) {
        if (!studentId) return;

        fetch('/students/' + studentId + '/financial-profile')
            .then(res => res.json())
            .then(response => {
                let student = response.student || {};
                let payments = response.payments || [];

                // 1. تعبئة الاسم الكامل بأمان
                try {
                    let fname = student.first_name || '';
                    let lname = student.last_name || '';
                    let el = document.getElementById('pay_modal_fullname');
                    if (el) el.innerText = (fname + ' ' + lname).trim() || '—';
                } catch (e) { console.error(e); }

                // 2. تعبئة التخصص والفوج بأمان
                try {
                    let courseName = '—';
                    if (student.course && student.course.name) {
                        courseName = student.course.name;
                    } else if (student.course_name) {
                        courseName = student.course_name;
                    }
                    let groupName = student.group_name ? (' | فوج: ' + student.group_name) : '';
                    let el = document.getElementById('pay_modal_course');
                    if (el) el.innerText = courseName + groupName;
                } catch (e) { console.error(e); }

                // 3. واجب التسجيل وتاريخه بأمان تام
                let regFee = 0;
                try {
                    if (student.registration_fee_paid) {
                        let cleaned = String(student.registration_fee_paid).replace(/[^0-9.]/g, '');
                        regFee = parseFloat(cleaned) || 0;
                    }
                    let elFee = document.getElementById('pay_modal_reg_fee');
                    if (elFee) elFee.innerText = regFee.toFixed(2) + ' DH';

                    let elDate = document.getElementById('pay_modal_reg_date');
                    if (elDate) elDate.innerText = student.registration_date || '—';
                } catch (e) { console.error(e); }

                // 4. تعبئة جدول المدفوعات الشهرية والمجاميع بأمان
                try {
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
                        let elTotal = document.getElementById('pay_modal_total_amount');
                        if (elTotal) elTotal.innerText = grandTotal.toFixed(2) + ' DH';
                    }
                } catch (e) { console.error(e); }

                // 5. إظهار النافذة المنبثقة
                $('#studentPaymentsHistoryModal').modal('show');
            })
            .catch(err => {
                console.error("Error:", err);
                alert('حدث خطأ أثناء تحميل السجل المالي');
            });
    }
</script>
<!-- Modal جدول الطلبة المتأخرين -->
<div class="modal fade" id="overdueStudentsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content text-right" dir="rtl" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
            <div class="modal-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h5 class="modal-title font-weight-bold text-white mb-0">
                    <i class="la la-exclamation-triangle mr-1"></i> لائحة الطلبة المتأخرين عن الأداء
                </h5>
                <button type="button" class="btn btn-sm btn-light font-weight-bold" onclick="$('#overdueStudentsModal').modal('hide')">✕ إغلاق</button>
            </div>
            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th class="text-right">الطالب</th>
                                <th>الهاتف</th>
                                <th>التخصص / الفوج</th>
                                <th>تاريخ الاستحقاق</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody id="overdue_students_tbody">
                            <tr>
                                <td colspan="6" class="py-4 text-muted">جاري تحميل قائمة المتأخرين...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary font-weight-bold" onclick="$('#overdueStudentsModal').modal('hide')">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<script>
function showOverdueStudentsModal() {
    $('#overdueStudentsModal').modal('show');
    let tbody = document.getElementById('overdue_students_tbody');
    tbody.innerHTML = '<tr><td colspan="6" class="py-4 text-muted"><i class="la la-spinner la-spin" style="font-size:24px;"></i> جاري تحميل البيانات...</td></tr>';

    fetch('/api/students/overdue-list')
        .then(res => res.json())
        .then(data => {
            if (!data || data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-success font-weight-bold"><i class="la la-check-circle d-block mb-1" style="font-size:35px;"></i> لا يوجد أي طالب متأخر عن الأداء حالياً.</td></tr>';
                return;
            }

            let rows = '';
            data.forEach((st, idx) => {
                let phoneRaw = (st.phone || '').replace(/[^0-9]/g, '');
                let phoneFormatted = phoneRaw.startsWith('0') ? '212' + phoneRaw.slice(1) : phoneRaw;
                let msg = encodeURIComponent('السلام عليكم ورحمة الله، نذكركم بحلول موعد الأداء الشهري للطالب(ة) ' + (st.first_name + ' ' + st.last_name) + '. وشكراً.');
                
                let whatsappBtn = phoneFormatted 
                    ? `<a href="https://wa.me/${phoneFormatted}?text=${msg}" target="_blank" class="btn btn-xs btn-outline-success font-weight-bold ml-1"><i class="la la-whatsapp"></i> واتساب</a>`
                    : '';

                rows += `<tr>
                    <td>${idx + 1}</td>
                    <td class="text-right">
                        <strong class="text-dark d-block">${st.first_name || ''} ${st.last_name || ''}</strong>
                        <small class="text-muted">🆔 ${st.registration_number || '—'}</small>
                    </td>
                    <td>${st.phone || '—'}</td>
                    <td>
                        <div class="font-weight-bold">${st.course ? st.course.name : '—'}</div>
                        <span class="badge badge-dark mt-1">${st.group_name || '—'}</span>
                    </td>
                    <td>
                        <span class="badge badge-danger font-weight-bold py-1 px-2" style="font-size: 12px;">${st.next_payment_date || '—'}</span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="/payments/create?student_id=${st.id}" class="btn btn-xs btn-success font-weight-bold ml-1"><i class="la la-money"></i> أداء</a>
                            ${whatsappBtn}
                            <button type="button" class="btn btn-xs btn-info font-weight-bold" onclick="$('#overdueStudentsModal').modal('hide'); showStudentPayments(${st.id});"><i class="la la-file-invoice-dollar"></i> كشف الحساب</button>
                        </div>
                    </td>
                </tr>`;
            });

            tbody.innerHTML = rows;
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-danger font-weight-bold">حدث خطأ أثناء جلب البيانات.</td></tr>';
        });
}
</script>
@endsection