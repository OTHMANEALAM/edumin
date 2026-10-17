@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>استخلاص المصاريف والأداءات (Fees Collection)</h4>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">الأداءات</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">سجل الطلبة</a></li>
            </ol>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>تم بنجاح!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">وضعية أداءات الطلبة</h5>
                    <a href="{{ route('add_fees') }}" class="btn btn-primary font-w600">
                        <i class="fa fa-plus me-1"></i> تسجيل أداء جديد
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="table table-bordered table-striped text-center align-middle" style="min-width: 845px">
                            <thead class="thead-primary">
                                <tr>
                                    <th>رقم التسجيل</th>
                                    <th>اسم الطالب</th>
                                    <th>التخصص</th>
                                    <th>آخر شهر / واجب مؤدى</th>
                                    <th>تاريخ آخر أداء</th>
                                    <th>مجموع ما تم دفعه</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($students) && count($students) > 0): ?>
                                    <?php foreach($students as$student): ?>
                                        <?php 
                                            $lastPayment =$student->payments->first(); 
                                            $totalPaid =$student->payments->sum('amount');
                                        ?>
                                        <tr>
                                            <td><strong><?php echo $student->registration_number; ?></strong></td>
                                            <td><?php echo $student->first_name . ' ' .$student->last_name; ?></td>
                                            <td><?php echo $student->specialty ?? '-'; ?></td>
                                            <td>
                                                <?php if($lastPayment): ?>
                                                    <span class="badge badge-sm badge-info text-white font-w600" style="font-size: 13px;">
                                                        <?php echo $lastPayment->month_name ?: ($lastPayment->fee_type ?: $lastPayment->payment_type); ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-sm badge-secondary">لا يوجد</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $lastPayment ? $lastPayment->payment_date : '-'; ?></td>
                                            <td>
                                                <span class="badge badge-sm badge-success font-w600" style="font-size: 14px;">
                                                    <?php echo number_format($totalPaid, 2); ?> درهم
                                                </span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-outline-primary" onclick="showStudentHistory(<?php echo $student->id; ?>)">
                                                    <i class="fa fa-eye me-1"></i> التفاصيل الكاملة
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-muted py-4">لا توجد أي أداءات مسجلة للطلبة بعد.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal نافذة تفاصيل جميع عمليات الدفع -->
<div class="modal fade" id="studentHistoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="modalStudentTitle">تفاصيل أداءات الطالب</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row bg-light p-3 rounded mb-3">
                    <div class="col-sm-6 mb-2"><strong>رقم التسجيل:</strong> <span id="mRegNumber">-</span></div>
                    <div class="col-sm-6 mb-2"><strong>الشعبة:</strong> <span id="mSpecialty">-</span></div>
                    <div class="col-sm-6"><strong>الهاتف:</strong> <span id="mPhone">-</span></div>
                    <div class="col-sm-6"><strong>المجموع المؤدى:</strong> <span class="badge badge-success" id="mTotalPaid">0 DH</span></div>
                </div>

                <h6 class="font-w600 text-primary mb-2">سجل العمليات المؤداة:</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-sm text-center">
                        <thead class="table-light">
                            <tr>
                                <th>الشهر / الواجب</th>
                                <th>المبلغ</th>
                                <th>تاريخ الأداء</th>
                                <th>طريقة الدفع</th>
                            </tr>
                        </thead>
                        <tbody id="mPaymentsList">
                            <!-- بالـ JS -->
                        </tbody>
                    </table>
                </div>

                <h6 class="font-w600 text-danger mb-2">الأشهر والواجبات المتبقية (غير المؤداة):</h6>
                <div id="mRemainingFeesContainer" class="d-flex flex-wrap gap-2">
                    <!-- بالـ JS -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<script>
function showStudentHistory(studentId) {
    fetch("{{ url('/api/student-payments') }}/" + studentId)
        .then(res => res.json())
        .then(data => {
            const student = data.student;
            const payments = data.payments;
            const remaining = data.remaining_fees;

            document.getElementById('modalStudentTitle').innerText = 'تفاصيل أداءات الطالب: ' + (student.first_name || '') + ' ' + (student.last_name || '');
            document.getElementById('mRegNumber').innerText = student.registration_number || '-';
            document.getElementById('mSpecialty').innerText = student.specialty || '-';
            document.getElementById('mPhone').innerText = student.phone || student.whatsapp || '-';
            document.getElementById('mTotalPaid').innerText = data.total_paid + ' درهم';

            // ملء جدول العمليات
            const tbody = document.getElementById('mPaymentsList');
            tbody.innerHTML = '';
            if (!payments || payments.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-muted">لم يؤدِّ أي شهر بعد.</td></tr>';
            } else {
                payments.forEach(p => {
                    tbody.innerHTML += `
                        <tr>
                            <td><span class="badge badge-outline-primary">${p.month_name || p.fee_type}</span></td>
                            <td><strong class="text-success">${p.amount} DH</strong></td>
                            <td>${p.payment_date}</td>
                            <td>${p.payment_method || '-'}</td>
                        </tr>
                    `;
                });
            }

            // ملء الأشهر المتبقية
            const remainingDiv = document.getElementById('mRemainingFeesContainer');
            remainingDiv.innerHTML = '';
            if (!remaining || remaining.length === 0) {
                remainingDiv.innerHTML = '<span class="badge badge-success p-2">تم تسديد كامل المستحقات (10 أشهر + التسجيل + الدبلوم)</span>';
            } else {
                remaining.forEach(item => {
                    remainingDiv.innerHTML += `<span class="badge badge-outline-danger p-2 me-1 mb-1">${item}</span>`;
                });
            }

            // فتح النافذة المنبثقة
            const modal = new bootstrap.Modal(document.getElementById('studentHistoryModal'));
            modal.show();
        })
        .catch(err => {
            console.error(err);
            alert('حدث خطأ أثناء تحميل السجل.');
        });
}
</script>
@endsection