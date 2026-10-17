<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    // عرض لائحة الأساتذة
 public function index()
    {
        $page_title = 'الأساتذة';
        $page_description = 'لائحة الأساتذة والمكونين';
        $action = 'app_calender'; // استخدام نفس الأكشن الشغال في الأجندة

        $professors = \App\Models\Professor::all();

        return view('agenda.index_professors', compact('professors', 'page_title', 'page_description', 'action'));
    }
    // حفظ أستاذ جديد
    public function store(Request $request)
    {
        $request->validate([
            'full_name'   => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'specialties' => 'nullable|array',
        ]);

        Professor::create([
            'full_name'   => $request->full_name,
            'phone'       => $request->phone,
            'specialties' => $request->specialties ?? [],
        ]);

        return redirect()->route('professors.index')->with('success', 'تمت إضافة الأستاذ بنجاح');
    }

    // تعديل بيانات الأستاذ
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name'   => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'specialties' => 'nullable|array',
        ]);

        $professor = Professor::findOrFail($id);
        $professor->update([
            'full_name'   => $request->full_name,
            'phone'       => $request->phone,
            'specialties' => $request->specialties ?? [],
        ]);

        return redirect()->route('professors.index')->with('success', 'تم تحديث بيانات الأستاذ بنجاح');
    }

    // حذف أستاذ
    public function destroy($id)
    {
        $professor = Professor::findOrFail($id);
        $professor->delete();

        return redirect()->route('professors.index')->with('success', 'تم حذف الأستاذ بنجاح');
    }
}