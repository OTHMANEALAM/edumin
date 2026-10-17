@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>لائحة التخصصات</h4>
                <p class="mb-0">إدارة التخصصات، الرسوم، وأفواج الدراسة</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <a href="{{ route('courses.create') }}" class="btn btn-primary">+ إضافة تخصص جديد</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success solid alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
            {{ session('success') }}
            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead class="thead-primary">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">اسم التخصص</th>
                                    <th scope="col">نمط الدراسة</th>
                                    <th scope="col">المدة</th>
                                    <th scope="col">السنة الدراسية</th>
                                    <th scope="col">تاريخ البداية</th>
                                    <th scope="col">واجب التسجيل</th>
                                    <th scope="col">الواجب الشهري</th>
                                    <th scope="col">عدد الطلاب</th>
                                    <th scope="col" class="text-center">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $key => $course)
                                    <tr>
                                        <td><strong>{{ $key + 1 }}</strong></td>
                                        <td><strong>{{ $course->name }}</strong></td>
                                        <td>
                                            <span class="badge {{ $course->mode == 'presentiel' ? 'badge-primary' : 'badge-info' }}">
                                                {{ $course->mode == 'presentiel' ? 'حضوري' : 'عن بعد' }}
                                            </span>
                                        </td>
                                        <td>{{ $course->duration_months }} أشهر</td>
                                        <td>{{ $course->academic_year }}</td>
                                        <td>{{ $course->start_date ?? 'غير محدد' }}</td>
                                        <td>{{ number_format($course->registration_fee, 2) }} DH</td>
                                        <td>{{ number_format($course->monthly_fee, 2) }} DH</td>
                                        <td><span class="badge badge-success">{{ $course->students_count }} طالب</span></td>
                                        <td class="text-center">
                                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا التخصص؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="la la-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4 text-muted">
                                            لا توجد تخصصات مسجلة حالياً. اضغط على "+ إضافة تخصص جديد" للبدء.
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
@endsection