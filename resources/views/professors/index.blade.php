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
    .table td, .table th {
        vertical-align: middle;
    }
</style>

<div class="content-body">
    <div class="container-fluid">
        <!-- شريط الرأس -->
        <div class="card prof-card mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <div class="mr-3" style="font-size: 2.2rem; color: #593bdb;">
                            <i class="la la-user-tie"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 font-weight-bold text-dark">لائحة الأساتذة والمكونين</h4>
                            <p class="text-muted mb-0 small">إدارة بيانات الأساتذة وتخصصاتهم التدريسية بمعهد TuCOSO</p>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 10px;" data-toggle="modal" data-target="#addProfessorModal">
                            <i class="la la-user-plus mr-1"></i> إضافة أستاذ جديد +
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="la la-check-circle mr-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <!-- جدول الأساتذة -->
        <div class="card prof-card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover text-right" dir="rtl">
                        <thead class="bg-light">
                            <tr>
                                <th class="font-weight-bold" style="width: 80px;">#</th>
                                <th class="font-weight-bold">الاسم والنسب</th>
                                <th class="font-weight-bold">رقم الهاتف</th>
                                <th class="font-weight-bold">التخصصات المُدرَّسة</th>
                                <th class="font-weight-bold text-center" style="width: 150px;">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($professors as $index => $prof)
                            <tr>
                                <td><span class="badge badge-light font-weight-bold">{{ $index + 1 }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-2 ml-2" style="width: 38px; height: 38px; font-weight: bold;">
                                            {{ mb_substr($prof->full_name, 0, 1) }}
                                        </div>
                                        <span class="font-weight-bold text-dark">{{ $prof->full_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($prof->phone)
                                        <a href="tel:{{ $prof->phone }}" class="text-secondary font-weight-bold">
                                            <i class="la la-phone text-primary ml-1"></i> {{ $prof->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted small">غير محدد</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($prof->specialties) && is_array($prof->specialties))
                                        @foreach($prof->specialties as $spec)
                                            <span class="specialty-badge">{{ $spec }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">لا توجد تخصصات مسجلة</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-info mr-1" title="تعديل" onclick='editProfessor(@json($prof))'>
                                        <i class="la la-pencil"></i>
                                    </button>
                                    <form action="{{ route('professors.destroy', $prof->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد بالتأكيد حذف هذا الأستاذ؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                            <i class="la la-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="la la-user-tie fa-3x mb-3 text-secondary d-block"></i>
                                    لا يوجد أي أستاذ مسجل حالياً. اضغط على "إضافة أستاذ جديد" للبدء.
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

<!-- Modal 1: إضافة أستاذ جديد -->
<div class="modal fade" id="addProfessorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none;">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white font-weight-bold">إضافة أستاذ جديد</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('professors.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 text-right" dir="rtl">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">الاسم والنسب <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" placeholder="مثال: يوسف الإدريسي" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" placeholder="06XXXXXXXX">
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold">التخصصات المُدرَّسة (يمكن اختيار أكثر من تخصص):</label>
                        <div class="row px-2">
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" name="specialties[]" value="اللغة الإنجليزية"> اللغة الإنجليزية</label>
                            </div>
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" name="specialties[]" value="اللغة الفرنسية"> اللغة الفرنسية</label>
                            </div>
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" name="specialties[]" value="اللغة الألمانية"> اللغة الألمانية</label>
                            </div>
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" name="specialties[]" value="التطوير الرقمي / البرمجة"> التطوير الرقمي / البرمجة</label>
                            </div>
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" name="specialties[]" value="التصميم والتسويق"> التصميم والتسويق</label>
                            </div>
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" name="specialties[]" value="المعلوميات المكتبية (Bureautique)"> المعلوميات المكتبية</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">حفظ الأستاذ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: تعديل بيانات الأستاذ -->
<div class="modal fade" id="editProfessorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none;">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white font-weight-bold">تعديل بيانات الأستاذ</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="editProfessorForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 text-right" dir="rtl">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">الاسم والنسب <span class="text-danger">*</span></label>
                        <input type="text" id="edit_full_name" name="full_name" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">رقم الهاتف</label>
                        <input type="text" id="edit_phone" name="phone" class="form-control">
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold">التخصصات المُدرَّسة:</label>
                        <div class="row px-2">
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" class="edit-spec" name="specialties[]" value="اللغة الإنجليزية"> اللغة الإنجليزية</label>
                            </div>
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" class="edit-spec" name="specialties[]" value="اللغة الفرنسية"> اللغة الفرنسية</label>
                            </div>
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" class="edit-spec" name="specialties[]" value="اللغة الألمانية"> اللغة الألمانية</label>
                            </div>
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" class="edit-spec" name="specialties[]" value="التطوير الرقمي / البرمجة"> التطوير الرقمي / البرمجة</label>
                            </div>
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" class="edit-spec" name="specialties[]" value="التصميم والتسويق"> التصميم والتسويق</label>
                            </div>
                            <div class="col-6 mb-2">
                                <label><input type="checkbox" class="edit-spec" name="specialties[]" value="المعلوميات المكتبية (Bureautique)"> المعلوميات المكتبية</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success font-weight-bold px-4">تحديث البيانات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editProfessor(prof) {
        document.getElementById('editProfessorForm').action = "{{ url('/professors/update') }}/" + prof.id;
        document.getElementById('edit_full_name').value = prof.full_name;
        document.getElementById('edit_phone').value = prof.phone || '';

        // تفريغ وتحديد التخصصات المسجلة
        var checkboxes = document.querySelectorAll('.edit-spec');
        checkboxes.forEach(function(cb) {
            cb.checked = false;
            if (prof.specialties && prof.specialties.includes(cb.value)) {
                cb.checked = true;
            }
        });

        $('#editProfessorModal').modal('show');
    }
</script>
@endsection