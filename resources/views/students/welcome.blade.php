@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4><i class="la la-bullhorn text-primary"></i> مركز الترحيب والتواصل مع الطلبة الجدد</h4>
                <p class="mb-0">متابعة إرسال رسائل الترحيب للطلبة المسجلين حديثاً (الطلبة المرحب بهم يبقون هنا لمدة 48 ساعة للمراقبة)</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <a href="{{ route('students.create') }}" class="btn btn-primary mr-2">+ تسجيل طالب جديد</a>
            <a href="{{ route('students.index') }}" class="btn btn-outline-primary">لائحة الطلاب</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success solid alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped verticle-middle text-center">
                    <thead class="thead-primary">
                        <tr>
                            <th>الطالب</th>
                            <th>التخصص والنمط</th>
                            <th>الفوج</th>
                            <th>المبلغ المؤدى والنوع</th>
                            <th>الهاتف / واتساب</th>
                            <th>مراسلة واتساب</th>
                            <th>حالة الترحيب</th>
                            <th>المهلة المتبقية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            @php
                                // تنظيف رقم الهاتف للواتساب (تحويل 06 إلى 2126)
                                $phoneRaw = $student->whatsapp ?: $student->phone;
                                $cleanPhone = preg_replace('/[^0-9]/', '', $phoneRaw);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $cleanPhone = '212' . substr($cleanPhone, 1);
                                }

                                // نص رسالة الترحيب الجاهزة
                                $welcomeMessage = rawurlencode("مرحباً بك {$student->first_name} في مركزنا التدريبي TUCOSO ACADEMY!\nيسعدنا تأكيد تسجيلك في شعبة {$student->course->name} (فوج: {$student->group_name}).\nإذا كان لديك أي استفسار نحن رهن إشارتك.");
                            @endphp
                            <tr class="{{ $student->is_welcomed ? 'table-light' : 'table-warning' }}">
                                <td>
                                    <strong>{{ $student->first_name }} {{ $student->last_name }}</strong><br>
                                    <small class="text-muted">{{ $student->registration_number }}</small>
                                </td>
                                <td>
                                    <strong>{{ optional($student->course)->name }}</strong><br>
                                    <span class="badge {{ $student->training_mode == 'presentiel' ? 'badge-primary' : 'badge-info' }}">
                                        {{ $student->training_mode == 'presentiel' ? 'حضوري' : 'عن بعد' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-dark font-weight-bold">{{ $student->group_name ?? 'بدون فوج' }}</span>
                                </td>
                                <td>
                                    <span class="text-success font-weight-bold">{{ number_format($student->registration_fee_paid, 2) }} DH</span><br>
                                    @if($student->registration_payment_type === 'registration_and_first_month')
                                        <span class="badge badge-success">التسجيل + الشهر 1</span>
                                    @else
                                        <span class="badge badge-secondary">واجب التسجيل فقط</span>
                                    @endif
                                </td>
                                <td>
                                    <div><i class="la la-phone"></i> {{ $student->phone }}</div>
                                    @if($student->whatsapp)
                                        <div><i class="la la-whatsapp text-success font-weight-bold"></i> {{ $student->whatsapp }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($cleanPhone)
                                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ $welcomeMessage }}" target="_blank" class="btn btn-sm btn-success text-white font-weight-bold">
                                            <i class="la la-whatsapp"></i> إرسال واتساب
                                        </a>
                                    @else
                                        <span class="text-muted">لا يوجد رقم</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('students.toggleWelcome', $student->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if($student->is_welcomed)
                                            <button type="submit" class="btn btn-sm btn-success" title="انقر للإلغاء">
                                                <i class="la la-check-circle"></i> تم الترحيب
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-outline-warning text-dark font-weight-bold" title="انقر لتأكيد الترحيب">
                                                <i class="la la-clock-o"></i> قيد الانتظار
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    @if($student->is_welcomed && $student->welcomed_at)
                                        @php
                                            $hoursLeft = max(0, 48 - (int)now()->diffInHours($student->welcomed_at));
                                        @endphp
                                        <small class="badge badge-info">متبقي {{ $hoursLeft }} ساعة للمراقبة</small>
                                    @else
                                        <small class="text-danger font-weight-bold">لم يتم بعد</small>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted font-weight-bold">
                                    لا يوجد طلبة جدد بانتظار الترحيب حالياً.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection