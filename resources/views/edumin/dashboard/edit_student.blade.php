@extends('layouts.default')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>تعديل بيانات الطالب: {{ $student->first_name }} {{ $student->last_name }}</h4>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('students.index') }}">الطلبة</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">تعديل طالب</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-xxl-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">تحديث المعلومات الأساسية</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="registration_number">رقم التسجيل (Matricule) *</label>
                                    <input type="text" id="registration_number" name="registration_number" class="form-control" required value="{{ old('registration_number', $student->registration_number) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="cin">رقم البطاقة الوطنية (CIN)</label>
                                    <input type="text" id="cin" name="cin" class="form-control" value="{{ old('cin', $student->cin) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="first_name">الاسم الشخصي (Prénom) *</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" required value="{{ old('first_name', $student->first_name) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="last_name">الاسم العائلي (Nom) *</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" required value="{{ old('last_name', $student->last_name) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="date_of_birth">تاريخ الازدياد</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $student->date_of_birth) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="phone">رقم الهاتف</label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="whatsapp">رقم الواتساب</label>
                                    <input type="text" id="whatsapp" name="whatsapp" class="form-control" value="{{ old('whatsapp', $student->whatsapp) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="specialty">التخصص (Spécialité)</label>
                                    <input type="text" id="specialty" name="specialty" class="form-control" value="{{ old('specialty', $student->specialty) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">نمط الدراسة (Mode d'étude)</label>
                                    <select name="study_mode" class="form-control default-select">
                                        <option value="حضوري (Présentiel)" {{ $student->study_mode == 'حضوري (Présentiel)' ? 'selected' : '' }}>حضوري (Présentiel)</option>
                                        <option value="عن بعد (En ligne)" {{ $student->study_mode == 'عن بعد (En ligne)' ? 'selected' : '' }}>عن بعد (En ligne / À distance)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="cin_document">تغيير وثيقة CIN (اختياري)</label>
                                    <input type="file" id="cin_document" name="cin_document" class="form-control" accept="image/*,application/pdf">
                                    @if($student->cin_document)
                                        <small class="text-muted d-block mt-1">الوثيقة الحالية: <a href="{{ asset('storage/' . $student->cin_document) }}" target="_blank">معاينة</a></small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                <a href="{{ route('students.index') }}" class="btn btn-light ms-2">إلغاء</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection