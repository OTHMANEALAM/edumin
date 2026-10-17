@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>إضافة تخصص جديد</h4>
                <p class="mb-0">أدخل البيانات المالية والتقنية الخاصة بالتخصص</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary">عرض جميع التخصصات</a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-xxl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('courses.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">اسم التخصص (Filière)</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="مثال: Développeur Web" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">نمط الدراسة</label>
                                    <select name="mode" class="form-control" required>
                                        <option value="presentiel" {{ old('mode') == 'presentiel' ? 'selected' : '' }}>حضوري (Présentiel)</option>
                                        <option value="distance" {{ old('mode') == 'distance' ? 'selected' : '' }}>عن بعد (À distance)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">مدة التكوين (بالأشهر)</label>
                                    <input type="number" name="duration_months" class="form-control" value="{{ old('duration_months', 10) }}" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">السنة الدراسية</label>
                                    <input type="text" name="academic_year" class="form-control" value="{{ old('academic_year', '2026/2027') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">تاريخ بداية التكوين</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">واجب التسجيل (DH)</label>
                                    <input type="number" step="0.01" name="registration_fee" class="form-control" value="{{ old('registration_fee', 0) }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">الواجب الشهري (DH)</label>
                                    <input type="number" step="0.01" name="monthly_fee" class="form-control" value="{{ old('monthly_fee', 0) }}" required>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                <button type="submit" class="btn btn-primary">حفظ التخصص</button>
                                <a href="{{ route('courses.index') }}" class="btn btn-light">إلغاء</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection