<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">لوحة التحكم والتسيير</li>

            <!-- 1. الإحصائيات -->
            <li>
                <a href="{{ url('/') }}" aria-expanded="false">
                    <i class="la la-dashboard"></i>
                    <span class="nav-text">الإحصائيات</span>
                </a>
            </li>

             <li class="{{ request()->is('app-calender') || request()->is('agenda*') ? 'mm-active' : '' }}">
    <a href="{{ url('/app-calender') }}" class="ai-icon" aria-expanded="false">
        <i class="la la-calendar"></i>
        <span class="nav-text">الأجندة (Agenda)</span>
    </a>
</li>
          

      
            <!-- 4. تسجيل الطلبة -->
            <li>
                <a href="{{ url('/students/create') }}" aria-expanded="false">
                    <i class="la la-user-plus"></i>
                    <span class="nav-text">تسجيل الطلبة</span>
                </a>
            </li>

            <!-- 5. التخصصات -->
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="la la-graduation-cap"></i>
                    <span class="nav-text">التخصصات</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('/courses') }}">جميع التخصصات</a></li>
                    <li><a href="{{ url('/courses/create') }}">إضافة تخصص جديد</a></li>
                </ul>
            </li>

            <!-- 6. لائحة الطلاب -->
            <li>
                <a href="{{ url('/students') }}" aria-expanded="false">
                    <i class="la la-users"></i>
                    <span class="nav-text">لائحة الطلاب</span>
                </a>
            </li>

            <!-- 7. الدفع -->
            <li>
                <a href="{{ url('/payments') }}" aria-expanded="false">
                    <i class="la la-money"></i>
                    <span class="nav-text">الدفع</span>
                </a>
            </li>

            <!-- 8. الترحيب -->
           <li>
    <a href="{{ route('students.welcome') }}" aria-expanded="false">
        <i class="la la-bullhorn"></i>
        <span class="nav-text">صفحة الترحيب</span>
    </a>
</li>

            <!-- 9. تتبع الدفع -->
            <li>
                <a href="{{ url('/payments-tracking') }}" aria-expanded="false">
                    <i class="la la-credit-card"></i>
                    <span class="nav-text">تتبع الدفع</span>
                </a>
            </li>

            <!-- 10. المراقبة -->
          

            <!-- 11. المغادرون -->
            <li>
                <a href="{{ url('/students-dropped') }}" aria-expanded="false">
                    <i class="la la-user-times"></i>
                    <span class="nav-text">المغادرون</span>
                </a>
            </li>

            <!-- 12. المشاكل -->
          

            <!-- 13. الإدارة -->
            <li>
                <a href="{{ url('/administration') }}" aria-expanded="false">
                    <i class="la la-building"></i>
                    <span class="nav-text">الإدارة</span>
                </a>
            </li>

           


            <!-- 16. الحساب -->
            <li>
                <a href="{{ url('/profile') }}" aria-expanded="false">
                    <i class="la la-cog"></i>
                    <span class="nav-text">الحساب</span>
                </a>
            </li>
            </li>
        </ul>
    </div>
</div>