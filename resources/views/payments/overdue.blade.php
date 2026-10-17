@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4 class="text-danger font-weight-bold">تتبع الدفع المتأخر</h4>
                <p class="mb-0">قائمة الطلبة المطالبين بالأداء والذين تجاوزوا تاريخ الاستحقاق</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 d-flex justify-content-sm-end align-items-center mt-2 mt-sm-0">
            <a href="{{ route('payments.index') }}" class="btn btn-secondary font-weight-bold">
                <i class="la la-arrow-right"></i> العودة لجدول الأداءات
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="card-title text-danger mb-0 font-weight-bold">
                <i class="la la-exclamation-circle mr-1"></i> لائحة المتأخرين عن الخلاص
                <span class="badge badge-danger ml-2">{{ count($overdueStudents) }} طالب</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle mb-0">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th class="text-right">الطالب</th>
                            <th>رقم الهاتف</th>
                            <th>التخصص / الفوج</th>
                            <th>تاريخ الاستحقاق</th>
                            <th>الإجراءات والملف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($overdueStudents as $idx => $st)
                        @php
                            // تنظيف وتنسيق رقم الهاتف للواتساب
                            $phoneRaw = preg_replace('/[^0-9]/', '', $st->phone ?? '');
                            if (str_starts_with($phoneRaw, '0')) {
                                $phoneFormatted = '212' . substr($phoneRaw, 1);
                            } else {
                                $phoneFormatted = $phoneRaw;
                            }
                            $whatsappMsg = rawurlencode("السلام عليكم ورحمة الله، نذكركم بحلول موعد الأداء الشهري للطالب(ة) " . ($st->first_name . ' ' . $st->last_name) . ". وشكراً.");
                        @endphp
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            
                            <!-- اسم الطالب ورقم التسجيل -->
                            <td class="text-right">
                                <strong class="text-dark d-block">{{ $st->first_name }} {{ $st->last_name }}</strong>
                                <small class="text-muted">🆔 {{ $st->registration_number ?? '—' }}</small>
                            </td>

                            <!-- الهاتف -->
                            <td>
                                <div>{{ $st->phone ?? '—' }}</div>
                            </td>

                            <!-- التخصص والفوج -->
                            <td>
                                <div class="font-weight-bold">{{ optional($st->course)->name ?? '—' }}</div>
                                <span class="badge badge-dark mt-1">{{ $st->group_name ?? '—' }}</span>
                            </td>

                            <!-- تاريخ الاستحقاق -->
                            <td>
                                <span class="badge badge-danger font-weight-bold py-1 px-2" style="font-size: 13px;">
                                    {{ $st->next_payment_date }}
                                </span>
                            </td>

                            <!-- الأزرار: أداء + واتساب + كشف الحساب -->
                            <td>
                                <div class="btn-group" role="group">
                                    <!-- زر تسجيل الدفع -->
                                    <a href="{{ route('payments.create', ['student_id' => $st->id]) }}" 
                                       class="btn btn-sm btn-success font-weight-bold" title="تسجيل أداء">
                                        <i class="la la-money"></i> أداء
                                    </a>

                                    <!-- زر المراسلة عبر واتساب -->
                                    @if(!empty($phoneFormatted))
                                        <a href="https://wa.me/{{ $phoneFormatted }}?text={{ $whatsappMsg }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-success font-weight-bold" 
                                           title="تذكير عبر واتساب">
                                            <i class="la la-whatsapp"></i> واتساب
                                        </a>
                                    @endif

                                    <!-- زر كشف الحساب -->
                                    <button type="button" 
                                            class="btn btn-sm btn-info font-weight-bold" 
                                            onclick="showStudentPayments({{ $st->id }})">
                                        <i class="la la-file-invoice-dollar"></i> كشف الحساب
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-success font-weight-bold">
                                <i class="la la-check-circle d-block mb-2" style="font-size: 45px;"></i>
                                ممتاز! لا يوجد أي طالب متأخر عن الأداء حالياً.
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