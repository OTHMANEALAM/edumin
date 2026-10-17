@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>تسجيل أداء جديد للطلبة</h4>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('fees.collection') }}">الأداءات</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">إضافة أداء</a></li>
            </ol>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>تم بنجاح!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- خانة البحث بالكتابة اليدوية -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">البحث عن الطالب</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <label class="form-label font-w600">اكتب اسم الطالب أو رقم التسجيل:</label>
                            <div class="input-group">
                                <input type="text" id="studentSearchInput" class="form-control" placeholder="ابحث برقم التسجيل، الاسم، CIN، أو رقم الهاتف..." onkeypress="if(event.key === 'Enter') searchStudent();">
                                <button class="btn btn-primary px-4" type="button" onclick="searchStudent()">
                                    <i class="fa fa-search me-1"></i> بحث
                                </button>
                            </div>
                            <small class="text-muted">يمكنك كتابة رقم التسجيل أو الاسم ثم الضغط على "بحث" أو زر Enter.</small>
                            <div id="searchError" class="text-danger mt-2 font-w600" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- قسم بيانات الطالب والأداءات والشهور المتبقية -->
    <div id="paymentDetailsSection" style="display: none;">
        <div class="row">
            <!-- تفاصيل الطالب والأشهر المؤداة -->
            <div class="col-xl-7 col-lg-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">الأشهر والواجبات المؤداة سابقاً</h5>
                        <span class="badge badge-success text-white p-2" id="totalPaidBadge" style="font-size: 13px;">المجموع: 0 درهم</span>
                    </div>
                    <div class="card-body">
                        <div class="row bg-light p-3 rounded mb-3">
                            <div class="col-6 mb-2"><strong>الاسم الكامل:</strong> <span id="lblStudentName">-</span></div>
                            <div class="col-6 mb-2"><strong>رقم التسجيل:</strong> <span id="lblStudentReg">-</span></div>
                            <div class="col-6"><strong>الشعبة / التخصص:</strong> <span id="lblStudentSpecialty">-</span></div>
                            <div class="col-6"><strong>الهاتف:</strong> <span id="lblStudentPhone">-</span></div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>الشهر / الواجب</th>
                                        <th>المبلغ المدفوع</th>
                                        <th>تاريخ الدفع</th>
                                        <th>طريقة الدفع</th>
                                    </tr>
                                </thead>
                                <tbody id="paidItemsTableBody">
                                    <!-- تعبأ تلقائياً -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- استمارة تسجيل الشهر غير المؤدى -->
            <div class="col-xl-5 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-primary">تسجيل أداء جديد</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('payments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="student_id" id="formStudentId">

                            <div class="form-group mb-3">
                                <label class="form-label font-w600">اختر الواجب أو الشهر غير المؤدى *</label>
                                <select name="fee_item" id="remainingFeesSelect" class="form-select form-control" style="display: block !important;" required>
                                    <!-- تملأ بالأشهر المتبقية فقط -->
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label font-w600">المبلغ المؤدى (درهم) *</label>
                                <input type="number" step="0.01" name="amount" class="form-control" placeholder="أدخل ثمن الشهر" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label font-w600">تاريخ الأداء *</label>
                                <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label font-w600">طريقة الأداء</label>
                                <select name="payment_method" class="form-control">
                                    <option value="نقداً (Espèces)">نقداً (Espèces)</option>
                                    <option value="تحويل بنكي (Virement)">تحويل بنكي (Virement)</option>
                                    <option value="شيك (Chèque)">شيك (Chèque)</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">ملاحظات (اختياري)</label>
                                <input type="text" name="notes" class="form-control" placeholder="رقم الشيك أو ملاحظة...">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 font-w600">تأكيد وحفظ الأداء</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function searchStudent() {
    const query = document.getElementById('studentSearchInput').value.trim();
    const errorDiv = document.getElementById('searchError');
    const detailsSection = document.getElementById('paymentDetailsSection');

    if (!query) {
        errorDiv.innerText = 'يرجى كتابة اسم الطالب أو رقم التسجيل أولاً.';
        errorDiv.style.display = 'block';
        detailsSection.style.display = 'none';
        return;
    }

    errorDiv.style.display = 'none';

    fetch("{{ url('/api/student-search-payment') }}?query=" + encodeURIComponent(query))
        .then(res => {
            if (!res.ok) throw new Error('الطالب غير موجود');
            return res.json();
        })
        .then(data => {
            const student = data.student;
            const payments = data.payments;
            const remaining = data.remaining_fees;

            document.getElementById('formStudentId').value = student.id;
            document.getElementById('lblStudentName').innerText = (student.first_name || '') + ' ' + (student.last_name || '');
            document.getElementById('lblStudentReg').innerText = student.registration_number || '-';
            document.getElementById('lblStudentSpecialty').innerText = student.specialty || '-';
            document.getElementById('lblStudentPhone').innerText = student.phone || student.whatsapp || '-';
            document.getElementById('totalPaidBadge').innerText = 'المجموع: ' + data.total_paid + ' درهم';

            // ملء جدول العمليات السابقة
            const tableBody = document.getElementById('paidItemsTableBody');
            tableBody.innerHTML = '';
            if (!payments || payments.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="4" class="text-muted">لم يتم تسجيل أي شهر بعد.</td></tr>';
            } else {
                payments.forEach(p => {
                    tableBody.innerHTML += `
                        <tr>
                            <td><span class="badge badge-outline-primary">${p.month_name || p.fee_type}</span></td>
                            <td><strong class="text-success">${p.amount} DH</strong></td>
                            <td>${p.payment_date}</td>
                            <td>${p.payment_method || '-'}</td>
                        </tr>
                    `;
                });
            }

            // ملء قائمة الأشهر المتبقية فقط
            const selectRemaining = document.getElementById('remainingFeesSelect');
            selectRemaining.innerHTML = '';
            if (!remaining || remaining.length === 0) {
                selectRemaining.innerHTML = '<option value="">تم تسديد كامل المستحقات (10 أشهر + التسجيل + الدبلوم)</option>';
            } else {
                remaining.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item;
                    opt.innerText = item;
                    selectRemaining.appendChild(opt);
                });
                // تحديث الـ selectpicker ديال القالب باش يبين الشهور فالبلاصة
            if (window.jQuery && $(selectRemaining).data('selectpicker')) {
                $(selectRemaining).selectpicker('destroy');
            }
            if (window.jQuery && $.fn.selectpicker) {
                $(selectRemaining).selectpicker();
            }
            }

            detailsSection.style.display = 'block';
        })
        .catch(err => {
            detailsSection.style.display = 'none';
            errorDiv.innerText = 'لم يتم العثور على أي طالب بهذا الاسم أو رقم التسجيل.';
            errorDiv.style.display = 'block';
        });
}
</script>
@endsection