@extends('layouts.default')

@section('content')
<div class="container-fluid" dir="rtl" style="text-align: right;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary font-weight-bold">
            <i class="fas fa-user-shield"></i> إدارة الموظفين وصلاحيات النظام
        </h3>
        <button type="button" class="btn btn-success font-weight-bold" data-toggle="modal" data-target="#addUserModal">
            <i class="fas fa-user-plus"></i> إضافة موظف جديد
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success font-weight-bold text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>الاسم الكامل</th>
                            <th>البريد الإلكتروني</th>
                            <th>الصلاحية / الدور</th>
                            <th>حالة الحساب</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold text-dark">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge badge-danger p-2">مدير النظام (Admin)</span>
                                    @elseif($user->role === 'accountant')
                                        <span class="badge badge-info p-2">محاسب (Accountant)</span>
                                    @else
                                        <span class="badge badge-secondary p-2">مكتب الاستقبال (Reception)</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge badge-success p-2">مفعل</span>
                                    @else
                                        <span class="badge badge-warning p-2">معطل</span>
                                    @endif
                                </td>
                                <td><small class="text-muted">{{ $user->created_at->format('Y-m-d') }}</small></td>
                                <td>
                                    <div class="d-flex justify-content-center" style="gap: 5px;">
                                        <button class="btn btn-sm btn-info text-white font-weight-bold" data-toggle="modal" data-target="#editUserModal{{ $user->id }}">
                                            <i class="fas fa-edit"></i> تعديل
                                        </button>

                                        <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-warning' : 'btn-success' }} font-weight-bold">
                                                {{ $user->is_active ? 'إيقاف' : 'تفعيل' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal تعديل الموظف -->
                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content text-right" dir="rtl">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title font-weight-bold">تعديل بيانات الموظف: {{ $user->name }}</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">الاسم الكامل:</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">البريد الإلكتروني:</label>
                                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">كلمة السر الجديدة (أتركها فارغة إذا لم ترد التغيير):</label>
                                                    <input type="password" name="password" class="form-control" placeholder="******">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">الصلاحية (الدور):</label>
                                                    <select name="role" class="form-control" required>
                                                        <option value="reception" {{ $user->role == 'reception' ? 'selected' : '' }}>مكتب الاستقبال (Reception)</option>
                                                        <option value="accountant" {{ $user->role == 'accountant' ? 'selected' : '' }}>محاسب (Accountant)</option>
                                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>مدير النظام (Admin)</option>
                                                    </select>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input type="checkbox" name="is_active" class="form-check-input" id="activeCheck{{ $user->id }}" {{ $user->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label font-weight-bold mr-4" for="activeCheck{{ $user->id }}">الحساب نشط ويستطيع الدخول للنظام</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                <button type="submit" class="btn btn-info font-weight-bold">حفظ التعديلات</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">لا يوجد مستخدمون مسجلون حالياً.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal إضافة موظف جديد -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-right" dir="rtl">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-1"></i> إضافة موظف جديد</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">الاسم الكامل:</label>
                        <input type="text" name="name" class="form-control" placeholder="اسم الموظف" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">البريد الإلكتروني (لتسجيل الدخول):</label>
                        <input type="email" name="email" class="form-control" placeholder="employee@tucoso.com" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">كلمة السر:</label>
                        <input type="password" name="password" class="form-control" placeholder="******" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">الصلاحية (الدور):</label>
                        <select name="role" class="form-control" required>
                            <option value="reception">مكتب الاستقبال (Reception)</option>
                            <option value="accountant">محاسب (Accountant)</option>
                            <option value="admin">مدير النظام (Admin)</option>
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="activeCheckNew" checked>
                        <label class="form-check-label font-weight-bold mr-4" for="activeCheckNew">تفعيل الحساب فوراً</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success font-weight-bold">إضافة الموظف</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection