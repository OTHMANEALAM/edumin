@extends('layouts.default')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4 class="text-danger">قائمة الطلبة كيتي (المغادرين)</h4>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('students.index') }}">الطلبة</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">الطلبة كيتي</a></li>
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
                    <h4 class="card-title">لائحة الطلبة الذين غادروا المعهد</h4>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">الرجوع إلى لائحة الطلبة النشيطين</a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" id="quittedSearchInput" class="form-control" placeholder="🔍 بحث في الطلبة المغادرين...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-nowrap" id="quittedTable">
                            <thead>
                                <tr>
                                    <th>رقم التسجيل</th>
                                    <th>الاسم الكامل</th>
                                    <th>رقم البطاقة (CIN)</th>
                                    <th>التخصص</th>
                                    <th>الهاتف</th>
                                    <th>تاريخ المغادرة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        <td><strong>{{ $student->registration_number }}</strong></td>
                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                        <td>{{ $student->cin ?? '-' }}</td>
                                        <td><span class="badge badge-secondary">{{ $student->specialty ?? '-' }}</span></td>
                                        <td>{{ $student->phone ?? '-' }}</td>
                                        <td>{{ $student->deleted_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <!-- زر استرجاع الطالب -->
                                            <form action="{{ route('students.restore', $student->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-xs btn-success" title="استرجاع الطالب">
                                                    <i class="fa fa-undo me-1"></i> استرجاع للدراسة
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-muted mb-0">لا يوجد أي طالب في قائمة المغادرين حالياً.</p>
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
    document.getElementById('quittedSearchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#quittedTable tbody tr');
        rows.forEach(function(row) {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection