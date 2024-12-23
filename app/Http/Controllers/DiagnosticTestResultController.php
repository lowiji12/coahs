<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiagnosticTestResult;
use App\Models\StudentInformation;
use App\Models\AcademicSchoolYear;
use App\Models\Semester;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DiagnosticTestResultController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'student_number' => 'required',
            'school_year' => 'required',
            'semester' => 'required',
            'test_type' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx',
            'remarks' => 'required',
        ]);

        $testType = $request->input('test_type');
        $file = $request->file('file');
        $remarks = $request->input('remarks');
        $notes = $request->input('notes', 'None');
        $uploadDate = now();

        // Find the existing diagnostic test result record
        $diagnosticTestResult = DiagnosticTestResult::where('student_number', $request->input('student_number'))
            ->where('school_year', $request->input('school_year'))
            ->where('semester', $request->input('semester'))
            ->first();

        // If an existing file is found, delete it
        if ($diagnosticTestResult && $diagnosticTestResult->{$testType}) {
            $existingFilePath = $diagnosticTestResult->{$testType};
            if (Storage::exists('public/' . $existingFilePath)) {
                Storage::delete('public/' . $existingFilePath);
            }
        }

        // Save the new file and get the file path
        $filePath = $file->storeAs('diagnostic_tests', $file->getClientOriginalName(), 'public');

        // Update or create the diagnostic test result record
        $diagnosticTestResult = DiagnosticTestResult::updateOrCreate(
            [
                'student_number' => $request->input('student_number'),
                'school_year' => $request->input('school_year'),
                'semester' => $request->input('semester'),
            ],
            [
                "{$testType}" => $filePath,
                "{$testType}_remark" => $remarks,
                "{$testType}_note" => $notes,
                "{$testType}_upload_date" => $uploadDate,
            ]
        );

        return redirect()->back()->with('success', 'Diagnostic test result uploaded successfully.');
    }

    public function view(Request $request)
    {
        $studentNumber = $request->input('student_number');
        $schoolYear = $request->input('school_year');
        $semester = $request->input('semester');
        $testType = $request->input('test_type');

        $diagnosticTestResult = DiagnosticTestResult::where('student_number', $studentNumber)
            ->where('school_year', $schoolYear)
            ->where('semester', $semester)
            ->first();

        if ($diagnosticTestResult) {
            $fileUrl = $diagnosticTestResult->{$testType};
            $remark = $diagnosticTestResult->{$testType . '_remark'};
            $note = $diagnosticTestResult->{$testType . '_note'};

            return response()->json([
                'fileUrl' => $fileUrl,
                'remark' => $remark,
                'note' => $note,
            ]);
        }

        return response()->json([
            'fileUrl' => null,
            'remark' => 'No data available',
            'note' => 'None',
        ]);
    }

    public function delete(Request $request)
    {
        $studentNumber = $request->input('student_number');
        $schoolYear = $request->input('school_year');
        $semester = $request->input('semester');
        $testType = $request->input('test_type');

        Log::info('Deleting file for student: ' . $studentNumber . ', school year: ' . $schoolYear . ', semester: ' . $semester . ', test type: ' . $testType);

        $diagnosticTestResult = DiagnosticTestResult::where('student_number', $studentNumber)
            ->where('school_year', $schoolYear)
            ->where('semester', $semester)
            ->first();

        if ($diagnosticTestResult && $diagnosticTestResult->{$testType}) {
            $filePath = $diagnosticTestResult->{$testType};
            Log::info('File path: ' . $filePath);
            if (Storage::exists('public/' . $filePath )) {
                Storage::delete('public/' . $filePath);
            }

            $diagnosticTestResult->{$testType} = null;
            $diagnosticTestResult->{$testType . '_remark'} = null;
            $diagnosticTestResult->{$testType . '_note'} = null;
            $diagnosticTestResult->{$testType . '_upload_date'} = null;
            $diagnosticTestResult->save();

            return response()->json(['success' => true, 'message' => 'File deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'File not found or already deleted.']);
    }

    public function show($student_number)
    {
        $student = StudentInformation::where('student_number', $student_number)->firstOrFail();

        $scholasticData = \DB::table('scholastic_data')
            ->where('student_number', $student_number)
            ->first();

        $parentGuardianData = \DB::table('parent_guardian_data')
            ->where('student_number', $student_number)
            ->first();

        $clinicalBasalData = \DB::table('student_clinical_basal_data')
            ->where('student_number', $student_number)
            ->first();

        $imageUrl = "http://203.177.208.99/images/spix/{$student->student_number}.Png";
        $imageExists = @getimagesize($imageUrl) ? true : false;

        // Fetch all school years and semesters
        $schoolYears = AcademicSchoolYear::all();
        $semesters = Semester::all();

        // Fetch the default school year and semester
        $defaultSchoolYear = AcademicSchoolYear::where('is_default', true)->first();
        $defaultSemester = Semester::where('is_default', true)->first();

        $selectedSchoolYear = $defaultSchoolYear ? $defaultSchoolYear->year : null;
        $selectedSemester = $defaultSemester ? $defaultSemester->semester : null;

        // Fetch diagnostic test results
        $diagnosticTestResults = DiagnosticTestResult::where('student_number', $student_number)
            ->where('school_year', $selectedSchoolYear)
            ->where('semester', $selectedSemester)
            ->first();

        return view('admin.student.diagnostic_test_results', compact('student', 'scholasticData', 'parentGuardianData', 'clinicalBasalData', 'imageExists', 'selectedSchoolYear', 'selectedSemester', 'schoolYears', 'semesters', 'diagnosticTestResults'));
    }
}