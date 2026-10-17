<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. عرض لائحة المستخدمين/الموظفين
 public function index()
{
    $users = \App\Models\User::all();
    return "الكنترولر يعمل، وجلبت " . $users->count() . " مستخدم، والمشكلة محصورة قطعا في ملف الـ Blade أو الـ Layout.";
}

    // 2. حفظ مستخدم جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,reception,accountant',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        return redirect()->route('users.index')->with('success', 'تم إنشاء حساب الموظف بنجاح.');
    }

    // 3. تحديث بيانات المستخدم
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,reception,accountant',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات الموظف بنجاح.');
    }

    // 4. تفعيل أو تعطيل الحساب (Toggle Status)
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        
        // منع المدير من تعطيل نفسه بالخطأ
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'لا يمكنك تعطيل حسابك الشخصي!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('users.index')->with('success', 'تم تغيير حالة الحساب بنجاح.');
    }
}