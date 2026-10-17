<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('students')->latest()->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'mode'             => 'required|in:presentiel,distance',
            'duration_months'  => 'required|integer|min:1',
            'academic_year'    => 'required|string|max:50',
            'start_date'       => 'nullable|date',
            'registration_fee' => 'required|numeric|min:0',
            'monthly_fee'      => 'required|numeric|min:0',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'تمت إضافة التخصص بنجاح!');
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'mode'             => 'required|in:presentiel,distance',
            'duration_months'  => 'required|integer|min:1',
            'academic_year'    => 'required|string|max:50',
            'start_date'       => 'nullable|date',
            'registration_fee' => 'required|numeric|min:0',
            'monthly_fee'      => 'required|numeric|min:0',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'تم تحديث بيانات التخصص بنجاح!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'تم حذف التخصص بنجاح!');
    }
}