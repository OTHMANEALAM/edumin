@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>تسجيل دفعة شهرية جديدة</h4>
                <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold text-dark">تسجيل أداء جديد للطالب</h4>
    
    <!-- زر الانتقال للائحة الدفعات العامة -->
    <a href="{{ route('payments.index') }}" class="btn btn-primary font-weight-bold shadow-sm">
        <i class="la la-list"></i> العودة إلى لائحة الأداءات
    </a>
</div>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <a href="{{ route('payments.index') }}" class="btn btn-outline-primary">سجل الأداءات</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger solid alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('payments.store') }}" method="POST">
                @csrf

                <!-- اختيار الطالب -->
               <!-- خانة البحث الفوري عن الطالب -->
                        <div class="form-group mb-3 position-relative">
                            <label class="font-weight-bold text-dark">البحث عن الطالب واختياره <span class="text-danger">*</span></label>
                            
                            <div class="input-group">
                                <input type="text" id="student_quick_filter" class="form-control form-control-lg font-weight-bold" 
                                       placeholder="🔍 اكتب اسم الطالب، رقم الهاتف، رقم التسجيل، أو بطاقة CIN..."
                                       value="{{ isset($selectedStudent) ? ($selectedStudent->first_name . ' ' . $selectedStudent->last_name . ' (' . ($selectedStudent->registration_number ?? '') . ')') : '' }}"
                                       autocomplete="off">
                                @if(isset($selectedStudent))
                                <div class="input-group-append">
                                    <a href="{{ route('payments.create') }}" class="btn btn-outline-danger font-weight-bold" title="إلغاء واختيار طالب آخر">✕ تغيير الطالب</a>
                                </div>
                                @endif
                            </div>

                            <!-- القائمة المنسدلة للنتائج المطابقة -->
                            <div id="filter_results_box" class="list-group shadow-lg" style="display: none; position: absolute; top: 100%; left: 0; right: 0; z-index: 1050; max-height: 260px; overflow-y: auto; border-radius: 8px;">
                                @foreach($students as $st)
                                @php
                                    $stFullName = trim(($st->first_name ?? '') . ' ' . ($st->last_name ?? ''));
                                    $stSearchData = strtolower($stFullName . ' ' . ($st->phone ?? '') . ' ' . ($st->whatsapp ?? '') . ' ' . ($st->cin ?? '') . ' ' . ($st->registration_number ?? ''));
                                @endphp
                                <a href="javascript:void(0)" 
                                   class="list-group-item list-group-item-action py-2 px-3 student-option-item"
                                   data-search="{{ $stSearchData }}"
                                   onclick="handleStudentSelect('{{ $st->id }}')">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="text-primary" style="font-size: 15px;">{{ $stFullName }}</strong>
                                        <span class="badge badge-light border">{{ $st->registration_number ?? 'بدون رقم' }}</span>
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        📞 {{ $st->phone ?? '—' }} | 🆔 CIN: {{ $st->cin ?? '—' }}
                                    </small>
                                </a>
                                @endforeach
                            </div>

                            <!-- الحقل المخفي الذي يحمل student_id لإرسال الفورم -->
                            <input type="hidden" name="student_id" id="hidden_student_id" value="{{ $selectedStudent->id ?? '' }}" required>
                        </div>

                @if($selectedStudent)
                    <!-- شريط إعلامي بالشهور التي سبق أداؤها -->
                    <div class="alert alert-info py-2 mb-4">
                        <strong>الشهور المؤداة سابقاً لهذا الطالب:</strong>
                        @forelse($selectedStudent->payments as $paid)
                            <span class="badge badge-light text-dark border mr-1 font-weight-bold">{{ $paid->month_name }} ({{ $paid->amount }} DH)</span>
                        @empty
                            <span class="text-white">لم يؤد أي شهر بعد (مسجل فقط).</span>
                        @endforelse
                    </div>
                @endif

                <div class="row">
                    <!-- اسم الشهر -->
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">الشهر المستحق *</label>
                        <select name="month_name" class="form-control" required>
                            <option value="">-- اختر الشهر --</option>
                            @foreach(['الشهر 1', 'الشهر 2', 'الشهر 3', 'الشهر 4', 'الشهر 5', 'الشهر 6', 'الشهر 7', 'الشهر 8', 'الشهر 9', 'الشهر 10', 'شهر أكتوبر', 'شهر نونبر', 'شهر دجنبر', 'شهر يناير', 'شهر فبراير', 'شهر مارس', 'شهر أبريل', 'شهر ماي', 'شهر يونيو'] as $m)
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- المبلغ -->
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">المبلغ المؤدى (DH) *</label>
                        <input type="number" step="0.01" name="amount" class="form-control" placeholder="مثال: 500" required>
                    </div>

                    <!-- طريقة الدفع -->
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">طريقة الدفع *</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="cash">نقداً (Espèces)</option>
                            <option value="virement">تحويل بنكي (Virement)</option>
                            <option value="versement">إيداع بنكي (Versement)</option>
                            <option value="cheque">شيك (Chèque)</option>
                        </select>
                    </div>
<!-- خانة موعد استحقاق الدفعة القادمة -->
<div class="col-md-6 mb-3">
    <label class="font-weight-bold text-dark">
        <i class="la la-calendar-check-o text-primary"></i> موعد استحقاق الدفعة القادمة:
    </label>
    <input type="date" 
           name="next_payment_date" 
           id="next_payment_date" 
           class="form-control" 
           value="{{ old('next_payment_date', \Carbon\Carbon::now()->addMonth()->format('Y-m-d')) }}" 
           required>
    <small class="text-muted">عند حلول هذا التاريخ، سيظهر الطالب تلقائياً في صفحة التتبع للمطالبة بالأداء.</small>
</div>
                    <!-- تاريخ الأداء -->
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">تاريخ الأداء *</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- المسؤول المستلم -->
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">المسؤول عن الاستلام</label>
                        <input type="text" name="received_by" class="form-control" placeholder="اسم الموظف أو المسؤول">
                    </div>

                    <!-- ملاحظات -->
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">ملاحظات إضافية</label>
                        <input type="text" name="notes" class="form-control" placeholder="اختياري...">
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary px-5 font-weight-bold">تسجيل الدفعة في السجل</button>
                    <a href="{{ route('payments.index') }}" class="btn btn-light ml-2 border">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var input = document.getElementById('student_quick_filter');
        var resultsBox = document.getElementById('filter_results_box');
        var items = document.querySelectorAll('.student-option-item');

        if (input && resultsBox) {
            // إظهار وتصفية النتائج أثناء الكتابة
            input.addEventListener('input', function () {
                var val = this.value.trim().toLowerCase();
                if (val.length < 1) {
                    resultsBox.style.display = 'none';
                    return;
                }

                var matchCount = 0;
                items.forEach(function (item) {
                    var searchData = item.getAttribute('data-search') || '';
                    if (searchData.includes(val)) {
                        item.style.display = 'block';
                        matchCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                resultsBox.style.display = matchCount > 0 ? 'block' : 'none';
            });

            // إخفاء القائمة عند النقر خارجها
            document.addEventListener('click', function (e) {
                if (!input.contains(e.target) && !resultsBox.contains(e.target)) {
                    resultsBox.style.display = 'none';
                }
            });
        }
    });

    // عند اختيار الطالب: يتم ملء الـ ID وتحميل بياناته فوراً
    function handleStudentSelect(studentId) {
        document.getElementById('hidden_student_id').value = studentId;
        window.location.href = "{{ route('payments.create') }}?student_id=" + studentId;
    }
</script>
@endsection