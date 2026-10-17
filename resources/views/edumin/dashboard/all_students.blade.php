@extends('layouts.default')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>قائمة الطلبة المسجلين</h4>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">الطلبة</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">جميع الطلبة</a></li>
            </ol>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>نجاح!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">لائحة الطلبة المسجلين</h4>
                    <div>
                        <a href="{{ route('students.quitted') }}" class="btn btn-warning me-2"><i class="fa fa-user-times me-1"></i> لائحة الطلبة كيتي</a>
                        <a href="{{ url('add-student') }}" class="btn btn-primary">+ تسجيل طالب جديد</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- خانة البحث الفوري -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" id="studentSearchInput" class="form-control" placeholder="🔍 بحث بالاسم، رقم التسجيل، CIN، أو التخصص...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-nowrap" id="studentsTable">
                            <thead>
                                <tr>
                                    <th>رقم التسجيل</th>
                                    <th>الاسم الكامل</th>
                                    <th>رقم البطاقة (CIN)</th>
                                    <th>التخصص</th>
                                    <th>نمط الدراسة</th>
                                    <th>الهاتف</th>
                                    <th>الخلاص الأولي</th>
                                    <th>وثيقة CIN</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    @php
                                        $firstPayment = $student->payments->first();
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $student->registration_number }}</strong></td>
                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                        <td>{{ $student->cin ?? '-' }}</td>
                                        <td><span class="badge badge-info">{{ $student->specialty ?? '-' }}</span></td>
                                        <td>
                                            @if($student->study_mode == 'حضوري (Présentiel)')
                                                <span class="badge badge-primary">حضوري</span>
                                            @elseif($student->study_mode == 'عن بعد (En ligne)')
                                                <span class="badge badge-secondary">عن بعد</span>
                                            @else
                                                {{ $student->study_mode ?? '-' }}
                                            @endif
                                        </td>
                                       <td>
    @php
        // تنقية رقم الواتساب من الفراغات والرموز
        $cleanWhatsapp = preg_replace('/[^0-9]/', '', $student->whatsapp ?? $student->phone);

        // تحويل الرقم المغربي لي كيبدا بـ 0 لرمز الدولة الدولي 212
        if (str_starts_with($cleanWhatsapp, '0')) {
            $cleanWhatsapp = '212' . substr($cleanWhatsapp, 1);
        }
    @endphp

    @if($student->whatsapp || $student->phone)
        <a href="https://wa.me/{{ $cleanWhatsapp }}" target="_blank" class="btn btn-xs btn-outline-success d-inline-flex align-items-center" title="مراسلة عبر واتساب">
            <i class="fab fa-whatsapp me-1 font-w600" style="font-size: 14px;"></i>
            {{ $student->whatsapp ?? $student->phone }}
        </a>
    @else
        <span class="text-muted">-</span>
    @endif
</td>
                                        <td>
                                            @if($student->cin_document)
                                                <a href="{{ asset('storage/' . $student->cin_document) }}" target="_blank" class="btn btn-xs btn-outline-info">معاينة</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- زر التعديل -->
                                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-xs btn-primary me-1" title="تعديل">
    <i class="fa fa-pencil"></i> تعديل
</a>
                                            <!-- زر نقل إلى كيتي -->
                                            <form action="{{ route('students.quit', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('واش متأكد بغيتي تحول هاد الطالب لقائمة الطلبة كيتي (المغادرين)؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger" title="نقل إلى كيتي">
                                                    <i class="fa fa-user-times"></i> كيتي
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-muted mb-0">لا يوجد أي طالب مسجل حالياً.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // كود البحث الفوري في الجدول
    document.getElementById('studentSearchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#studentsTable tbody tr');
        rows.forEach(function(row) {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection