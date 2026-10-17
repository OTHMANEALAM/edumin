@extends('layouts.default')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Add Student</h4>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="javascript:void(0);">Students</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Student</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-xxl-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Basic Info</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
    <div class="alert alert-success solid alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
        <strong>نجاح!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger solid alert-dismissible fade show">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
    </div>
@endif

<form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- رقم التسجيل -->
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label" for="registration_number">رقم التسجيل (Matricule) *</label>
                <input type="text" id="registration_number" name="registration_number" class="form-control" placeholder="مثال: MAT-2026-001" required value="{{ old('registration_number') }}">
            </div>
        </div>

        <!-- الاسم الشخصي -->
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label" for="first_name">الاسم الشخصي (Prénom) *</label>
                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="الاسم الشخصي" required value="{{ old('first_name') }}">
            </div>
        </div>

        <!-- النسب -->
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label" for="last_name">النسب (Nom) *</label>
                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="النسب" required value="{{ old('last_name') }}">
            </div>
        </div>

        <!-- رقم البطاقة الوطنية -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label" for="cin">رقم البطاقة الوطنية (CIN)</label>
                <input type="text" id="cin" name="cin" class="form-control" placeholder="رقم لاكارط" value="{{ old('cin') }}">
            </div>
        </div>

        <!-- تحميل صورة لاكارط -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label" for="cin_document">صورة البطاقة الوطنية (PDF / Image)</label>
                <input type="file" id="cin_document" name="cin_document" class="form-control">
            </div>
        </div>

        <!-- تاريخ الازدياد -->
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label" for="date_of_birth">تاريخ الازدياد</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
            </div>
        </div>

        <!-- رقم الهاتف -->
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label" for="phone">رقم الهاتف</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="06XXXXXXXX" value="{{ old('phone') }}">
            </div>
        </div>

        <!-- رقم واتساب -->
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label" for="whatsapp">رقم الواتساب</label>
                <input type="text" id="whatsapp" name="whatsapp" class="form-control" placeholder="06XXXXXXXX" value="{{ old('whatsapp') }}">
            </div>
        </div>
        <!-- التخصص -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label" for="specialty">التخصص (Spécialité) *</label>
                <input type="text" id="specialty" name="specialty" class="form-control" placeholder="مثال: Développement Web, Gestion, Infographie..." required value="{{ old('specialty') }}">
            </div>
        </div>

        <!-- نمط الدراسة -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">نمط الدراسة (Mode d'étude) *</label>
                <select name="study_mode" class="form-control default-select" required>
                    <option value="حضوري (Présentiel)">حضوري (Présentiel)</option>
                    <option value="عن بعد (En ligne)">عن بعد (En ligne / À distance)</option>
                </select>
            </div>
        </div>

        <div class="col-12 mt-4 mb-2">
            <h4 class="text-primary font-w600 border-bottom pb-2">معلومات الأداء الأولي (Paiement)</h4>
        </div>

        <!-- نوع الأداء -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">نوع الخلاص *</label>
                <select name="payment_type" class="form-control default-select" required>
                    <option value="التسجيل فقط">مصاريف التسجيل فقط</option>
                    <option value="التسجيل + الشهر الأول">التسجيل + الشهر الأول</option>
                </select>
            </div>
        </div>

        <!-- المبلغ المؤدى -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label" for="amount">المبلغ المؤدى (درهم) *</label>
                <input type="number" step="0.01" id="amount" name="amount" class="form-control" placeholder="المبلغ بالدرهم" required value="{{ old('amount') }}">
            </div>
        </div>

        <!-- طريقة الدفع -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">طريقة الأداء *</label>
                <select name="payment_method" class="form-control default-select" required>
                    <option value="نقداً (Cash)">نقداً (Cash)</option>
                    <option value="تحويل بنكي (Virement)">تحويل بنكي (Virement Bancaire)</option>
                    <option value="Cash Plus">كاش بلوس (Cash Plus)</option>
                    <option value="Wafacash">وفاكاش (Wafacash)</option>
                </select>
            </div>
        </div>

        <!-- تاريخ الخلاص -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label" for="payment_date">تاريخ الخلاص *</label>
                <input type="date" id="payment_date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>

        <!-- اسم الشخص اللي دخلو -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label" for="entered_by">اسم الشخص الذي أدخل البيانات (Saisi par)</label>
                <input type="text" id="entered_by" name="entered_by" class="form-control" placeholder="اسم المستخدم" value="{{ old('entered_by') }}">
            </div>
        </div>

        <!-- اسم الشخص اللي فاليداه -->
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label" for="validated_by">اسم الشخص الذي صادق على التسجيل (Validé par)</label>
                <input type="text" id="validated_by" name="validated_by" class="form-control" placeholder="اسم المسؤول" value="{{ old('validated_by') }}">
            </div>
        </div>

        <!-- ملاحظات إضافية -->
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label" for="notes">ملاحظات إضافية</label>
                <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="أي ملاحظات حول الطالب أو الدفع...">{{ old('notes') }}</textarea>
            </div>
        </div>

        <!-- أزرار الحفظ -->
        <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
            <button type="submit" class="btn btn-primary">حفظ وتأكيد التسجيل</button>
            <button type="reset" class="btn btn-light">إعادة تعيين</button>
        </div>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
