@extends('layouts.default')<!-- أو الـ Layout الخاص بك حسب ما هو موجود عندك -->

@section('content')
<div class="container-fluid" dir="rtl" style="text-align: right;">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- معلومات الطالب -->
                <div class="col-md-7">
                    <div class="card-body text-right">
                        <h4 class="mb-4 text-primary"><strong>المعلومات الشخصية والتكوينية</strong></h4>
                        
                        <p class="mb-2"><strong>الاسم الكامل:</strong> {{ $student->first_name ?? '' }} {{ $student->last_name ?? '' }}</p>
                        <p class="mb-2"><strong>رقم البطاقة (CIN):</strong> {{ $student->cin_document ?? 'بدون بطاقة' }}</p>
                        <p class="mb-2"><strong>رقم الهاتف:</strong> {{ $student->phone ?? '—' }}</p>
                        <p class="mb-2"><strong>رقم الواتساب:</strong> <span class="text-success font-weight-bold">{{ $student->whatsapp ?? 'غير مسجل' }}</span></p>
                        <p class="mb-2"><strong>تاريخ الازدياد:</strong> {{ $student->birth_date ?? '—' }}</p>
                        <p class="mb-2"><strong>تاريخ التسجيل:</strong> {{ $student->registration_date ?? '—' }}</p>
                        <p class="mb-2"><strong>التخصص المسجل به:</strong> {{ optional($student->course)->name ?? '—' }}</p>
                        <p class="mb-2"><strong>الفوج (Group):</strong> {{ $student->group_name ?? '—' }}</p>
                        <p class="mb-2"><strong>نمط التكوين:</strong> 
                            <span class="badge {{ in_array($student->training_mode, ['حضوري', 'presential']) ? 'badge-success' : 'badge-info' }}">
                                {{ $student->training_mode ?? '—' }}
                            </span>
                        </p>
                        <p class="mb-3"><strong>واجب التسجيل المؤدى:</strong> <span class="text-danger font-weight-bold">{{ number_format(floatval($student->registration_fee ?? 0), 2) }} DH</span></p>
                    </div>
                </div>

                <!-- صورة البطاقة الوطنية وزر الواتساب -->
                <div class="col-md-5 text-center">
                    <div class="card p-3">
                        <h5 class="mb-3">صورة البطاقة الوطنية / الشخصية</h5>
                        @if(!empty($student->cin_document))
                            <img src="{{ asset('storage/' . $student->cin_document) }}" alt="CIN" class="img-fluid rounded mb-3" style="max-height: 220px; object-fit: contain;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(($student->first_name ?? 'S') . ' ' . ($student->last_name ?? 'T')) }}&background=0D8ABC&color=fff&size=200" alt="Avatar" class="img-fluid rounded mb-3">
                        @endif

                        <!-- زر الواتساب المستقل حصرياً -->
                        @php
                            $waNumber = $student->whatsapp ?? '';
                            $cleanWa = preg_replace('/[^0-9]/', '', $waNumber);
                            if (str_starts_with($cleanWa, '0')) {
                                $cleanWa = '212' . substr($cleanWa, 1);
                            }
                        @endphp

                        @if(!empty($waNumber))
                            <div class="mt-3">
                                <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="btn btn-success btn-lg btn-block" style="background-color: #28a745; color: white; padding: 12px; border-radius: 8px; font-weight: bold; text-decoration: none;">
                                    <i class="fab fa-whatsapp" style="font-size: 20px; margin-left: 5px;"></i> مراسلة عبر WhatsApp
                                </a>
                            </div>
                        @else
                            <div class="mt-3">
                                <span class="text-danger font-weight-bold d-block p-2 border border-danger rounded">رقم الواتساب غير مسجل لهذا الطالب</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection