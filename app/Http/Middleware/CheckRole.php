<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // التأكد من أن الحساب مفعل
        if (!$user->is_active) {
            Auth::logout();
            return redirect('/login')->with('error', 'تم إيقاف هذا الحساب، يرجى مراجعة الإدارة.');
        }

        // إذا كان الموظف لديه أحد الأدوار المسموح بها أو كان أدمن
        if (in_array($user->role, $roles) || $user->role === 'admin') {
            return $next($request);
        }

        abort(403, 'عذراً، ليس لديك صلاحية للدخول لهذه الصفحة.');
    }
}
