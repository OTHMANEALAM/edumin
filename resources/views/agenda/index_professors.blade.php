@extends('layouts.default')

@section('content')
<style>
    .prof-card {
        border-radius: 16px !important;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
        border: none !important;
        background: #ffffff;
    }
    .specialty-badge {
        display: inline-block;
        padding: 5px 12px;
        margin: 2px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background-color: #eef2ff;
        color: #4f46e5;
        border: 1px solid #c7d2fe;
    }
</style>

<div class="content-body">
    <div class="container-fluid">
        <div class="card prof-card mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center">
                        <div class="mr-3" style="font-size: 2.2rem; color: #593bdb;">
                            <i class="la la-user-tie"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 font-weight-bold text-dark">لائحة الأساتذة والمكونين</h4>
                            <p class="text-muted mb-0 small">إدارة وتتبع تخصصات أساتذة معهد TuCOSO</p>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 10px;" data-toggle="modal" data-target="#addProfessorModal">
                            <i class="la la-plus"></i> إضافة أستاذ جديد +
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="card prof-card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover text-right" dir="rtl">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 70px;">#</th>
                                <th>الاسم والنسب</th>
                                <th>رقم الهاتف</th>
                                <th>التخصصات المُدرَّسة</th>
                                <th class="text-center" style="width: 140px;">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($professors as $index => $prof)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="font-weight-bold text-dark">{{ $prof->full_name }}</td>
                                <td>{{ $prof->phone ?? 'غير متوفر' }}</td>
                                <td>
                                    @if(!empty($prof->specialties) && is_array($prof->specialties))
                                        @foreach($prof->specialties as $spec)
                                            <span class="specialty-badge">{{ $spec }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">لا توجد تخصصات</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('professors.destroy', $prof->id) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف هذا الأستاذ؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="la la-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    لا يوجد أي أستاذ مسجل حالياً.
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

<!-- Modal إضافة أستاذ -->
<div class="modal fade" id="addProfessorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white font-weight-bold">إضافة أستاذ جديد</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('professors.store') }}" method="POST">
                @csrf
                <div class="modal-body text-right" dir="rtl">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">الاسم والنسب <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" placeholder="مثال: يوسف الإدريسي" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" placeholder="06XXXXXXXX">
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">التخصصات (اختر تخصص أو أكثر):</label>
                        <div class="row px-2">
                            <div class="col-6 mb-2"><label><input type="checkbox" name="specialties[]" value="اللغة الإنجليزية"> اللغة الإنجليزية</label></div>
                            <div class="col-6 mb-2"><label><input type="checkbox" name="specialties[]" value="اللغة الفرنسية"> اللغة الفرنسية</label></div>
                            <div class="col-6 mb-2"><label><input type="checkbox" name="specialties[]" value="اللغة الألمانية"> اللغة الألمانية</label></div>
                            <div class="col-6 mb-2"><label><input type="checkbox" name="specialties[]" value="البرمجة والتطوير"> البرمجة والتطوير</label></div>
                            <div class="col-6 mb-2"><label><input type="checkbox" name="specialties[]" value="التصميم والتسويق"> التصميم والتسويق</label></div>
                            <div class="col-6 mb-2"><label><input type="checkbox" name="specialties[]" value="المعلوميات المكتبية"> المعلوميات المكتبية</label></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">حفظ البيانات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection