<?php

// app/Http/Controllers/Admin/AcademicSettingsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSchoolYear;
use App\Models\Semester;
use Illuminate\Http\Request;

class AcademicSettingsController extends Controller
{
    public function index()
    {
        $schoolYears = AcademicSchoolYear::all();
        $semesters = Semester::all();

        $settings = [
            'defaultSchoolYear' => AcademicSchoolYear::where('is_default', true)->first(),
            'defaultSemester' => Semester::where('is_default', true)->first(),
        ];

        return view('admin.academic.settings', compact('schoolYears', 'semesters', 'settings'));
    }

    public function setDefaultSchoolYear(Request $request)
    {
        $year = $request->input('year');
        AcademicSchoolYear::where('is_default', true)->update(['is_default' => false]);
        AcademicSchoolYear::where('year', $year)->update(['is_default' => true]);
        return redirect()->back()->with('success', 'Default school year set!');
    }

    public function setDefaultSemester(Request $request)
    {
        $semester = $request->input('semester');
        Semester::where('is_default', true)->update(['is_default' => false]);
        Semester::where('semester', $semester)->update(['is_default' => true]);
        return redirect()->back()->with('success', 'Default semester set!');
    }
}
