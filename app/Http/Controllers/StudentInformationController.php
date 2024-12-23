<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentInformation;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EnrolledStudent;
use App\Models\StudentImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Student;
use App\Models\AcademicSchoolYear;
use App\Models\Semester;
use App\Models\DiagnosticTestResult;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class StudentInformationController extends Controller
{
    public function index(Request $request)
    {
        $schoolYears = AcademicSchoolYear::all();
        $semesters = Semester::all();

        $selectedSchoolYear = $request->input('school_year');
        $selectedSemester = $request->input('semester');

        $query = StudentInformation::query();

        if ($selectedSchoolYear && $selectedSemester) {
            $enrolledStudents = EnrolledStudent::where('school_year', $selectedSchoolYear)
                ->where('semester', $selectedSemester)
                ->pluck('student_number');

            $query->whereIn('student_number', $enrolledStudents);
        }

        $students = $query->get();

        return view('sis.studentinformation', compact('students', 'schoolYears', 'semesters', 'selectedSchoolYear', 'selectedSemester'));
    }

    public function student()
    {
        // Fetch the default school year and semester
        $defaultSchoolYear = AcademicSchoolYear::where('is_default', true)->first();
        $defaultSemester = Semester::where('is_default', true)->first();

        // Fetch all school years and semesters
        $schoolYears = AcademicSchoolYear::all();
        $semesters = Semester::all();

        // Fetch the number of students for each school year and semester combination
        $studentCounts = [];
        foreach ($schoolYears as $schoolYear) {
            foreach ($semesters as $semester) {
                $studentCounts[$schoolYear->year][$semester->semester] = EnrolledStudent::where('school_year', $schoolYear->year)
                    ->where('semester', $semester->semester)
                    ->count();
            }
        }

        return view('admin.student.information-students', compact('defaultSchoolYear', 'defaultSemester', 'schoolYears', 'semesters', 'studentCounts'));
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

        return view('sis.studentinformationview', compact('student', 'scholasticData', 'parentGuardianData', 'clinicalBasalData', 'imageExists', 'selectedSchoolYear', 'selectedSemester', 'schoolYears', 'semesters'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:csv,xlsx,xls',
        ], [
            'import_file.mimes' => 'The file is not valid. Please use csv, xlsx, or xls file types only.',
        ]);

        $data = Excel::toArray(new StudentImport, $request->file('import_file'));

        $students = collect($data[0])->skip(3)->map(function ($row) {
            $birthDate = is_numeric($row[11])
                ? Date::excelToDateTimeObject($row[11])->format('Y-m-d')
                : $row[11];

            return [
                'student_number' => $row[0],
                'surname' => $row[1],
                'given_name' => $row[2],
                'middle_name' => $row[3],
                'program' => $row[4],
                'year_level' => $row[5],
                'citizenship' => $row[6],
                'gender' => $row[7],
                'indigenous' => $row[8],
                'ethnicity' => $row[9],
                'dialect' => $row[10],
                'religion' => $row[11],
                'birth_date' => $row[12],
                'birth_place' => $row[13],
                'contact_number' => $row[14],
                'civil_status' => $row[15],
                'address' => $row[16],
                'email_address' => $row[17],
                'entry_type' => $row[18],
            ];
        })->toArray();

        $scholasticData = collect($data[0])->skip(3)->map(function ($row) {
            return [
                'student_number' => $row[0],
                'elem_school_name' => $row[19],
                'elem_school_year' => $row[20],
                'elem_school_address' => $row[21],
                'jh_school_name' => $row[22],
                'jh_school_year' => $row[23],
                'jh_address' => $row[24],
                'sh_school_name' => $row[25],
                'sh_school_year' => $row[26],
                'sh_address' => $row[27],
                'sh_school_strand' => $row[28],
            ];
        })->toArray();

        $parentGuardianData = collect($data[0])->skip(3)->map(function ($row) {
            return [
                'student_number' => $row[0],
                'parent_fullname' => $row[29],
                'parent_contact_number' => $row[30],
                'parent_address' => $row[31],
                'parent_relationship' => $row[32],
                'house' => (bool) $row[33],
                'parent_as_guardian' => (bool) $row[34],
                'guardian_fullname' => $row[35],
                'guardian_contact_number' => $row[36],
                'guardian_address' => $row[37],
                'guardian_relationship' => $row[38],
            ];
        })->toArray();

        $clinicalBasalData = collect($data[0])->skip(3)->map(function ($row) {
            return [
                'student_number' => $row[0],
                'age' => $row[39],
                'height' => $row[40],
                'weight' => $row[41],
                'blood_type' => $row[42],
                'disabilities' => $row[43],
                'date_diagnosed' => $row[44],
                'hdi1' => $row[45],
                'hdi1_date' => $row[46],
                'hdi2' => $row[47],
                'hdi2_date' => $row[48],
                'allergy_med' => $row[49],
                'allergy_food' => $row[50],
                'allergy_others' => $row[51],
                'medication1' => $row[52],
                'medication2' => $row[53],
            ];
        })->toArray();

        session(['imported_students' => $students, 'imported_scholastic_data' => $scholasticData, 'imported_parent_guardian_data' => $parentGuardianData, 'imported_clinical_basal_data' => $clinicalBasalData]);

        return redirect()->route('import.student.confirm');
    }

    public function confirmImport()
    {
        $importedStudents = session('imported_students');
        $scholasticData = session('imported_scholastic_data');
        $parentGuardianData = session('imported_parent_guardian_data');
        $clinicalBasalData = session('imported_clinical_basal_data');

        // Fetch existing student numbers from the database
        $existingStudentNumbers = StudentInformation::pluck('student_number')->toArray();

        // Separate imported students into new and existing
        $newStudents = [];
        $existingStudents = [];

        foreach ($importedStudents as $student) {
            if (in_array($student['student_number'], $existingStudentNumbers)) {
                $existingStudents[] = $student;
            } else {
                $newStudents[] = $student;
            }
        }

        \Log::info('Confirming import with new students: ', $newStudents);
        \Log::info('Confirming import with existing students: ', $existingStudents);

        // Store the new students in the session
        session(['new_students' => $newStudents]);

        return view('sis.confirmimport', compact('newStudents', 'existingStudents', 'scholasticData', 'parentGuardianData', 'clinicalBasalData'));
    }

    public function saveConfirmedImport()
    {
        // Fetch the new students from the session
        $newStudents = session('new_students', []);
        $scholasticData = session('imported_scholastic_data', []);
        $parentGuardianData = session('imported_parent_guardian_data', []);
        $clinicalBasalData = session('imported_clinical_basal_data', []);

        // Filter the scholastic, parent guardian, and clinical basal data to only include new students
        $newStudentNumbers = array_column($newStudents, 'student_number');

        $filteredScholasticData = array_filter($scholasticData, function ($data) use ($newStudentNumbers) {
            return in_array($data['student_number'], $newStudentNumbers);
        });

        $filteredParentGuardianData = array_filter($parentGuardianData, function ($data) use ($newStudentNumbers) {
            return in_array($data['student_number'], $newStudentNumbers);
        });

        $filteredClinicalBasalData = array_filter($clinicalBasalData, function ($data) use ($newStudentNumbers) {
            return in_array($data['student_number'], $newStudentNumbers);
        });

        // Import the new students and their related data
        foreach ($newStudents as $student) {
            StudentInformation::create($student);
        }

        foreach ($filteredScholasticData as $data) {
            \DB::table('scholastic_data')->insert($data);
        }

        foreach ($filteredParentGuardianData as $data) {
            \DB::table('parent_guardian_data')->insert($data);
        }

        foreach ($filteredClinicalBasalData as $data) {
            \DB::table('student_clinical_basal_data')->insert($data);
        }

        // Clear the session data
        session()->forget(['imported_students', 'imported_scholastic_data', 'imported_parent_guardian_data', 'imported_clinical_basal_data', 'new_students']);

        return redirect()->route('sis.student.information')->with('success', 'New students, scholastic, parent guardian, and clinical basal data imported successfully!');
    }

    public function removeStudent(Request $request)
    {
        $importedStudents = session('imported_students', []);
        $importedScholasticData = session('imported_scholastic_data', []);
        $importedParentGuardianData = session('imported_parent_guardian_data', []);
        $importedClinicalBasalData = session('imported_clinical_basal_data', []);

        // Check if the row exists and remove the student
        if (isset($importedStudents[$request->row_key])) {
            $student = $importedStudents[$request->row_key];
            unset($importedStudents[$request->row_key]);

            // Remove corresponding data from other arrays
            $studentNumber = $student['student_number'];

            // Filter out data for the removed student
            $importedScholasticData = array_filter($importedScholasticData, fn($data) => $data['student_number'] !== $studentNumber);
            $importedParentGuardianData = array_filter($importedParentGuardianData, fn($data) => $data['student_number'] !== $studentNumber);
            $importedClinicalBasalData = array_filter($importedClinicalBasalData, fn($data) => $data['student_number'] !== $studentNumber);

            // Reindex the arrays to maintain proper keys
            session([
                'imported_students' => array_values($importedStudents),
                'imported_scholastic_data' => array_values($importedScholasticData),
                'imported_parent_guardian_data' => array_values($importedParentGuardianData),
                'imported_clinical_basal_data' => array_values($importedClinicalBasalData),
            ]);
        }

        return redirect()->back()->with('success', 'Student removed successfully.');
    }

    public function filterStudents(Request $request)
    {
        $schoolYear = $request->input('schoolYear');
        $semester = $request->input('semester');

        $students = StudentInformation::where('year_level', $schoolYear)
            ->where('program', $semester)
            ->get();

        return view('admin.student.information-students', compact('students', 'schoolYear', 'semester'));
    }

    public function addStudent(Request $request)
    {
        $request->validate([
            'student_number' => 'required|exists:student_information,student_number',
            'school_year' => 'required',
            'semester' => 'required',
        ]);

        EnrolledStudent::create([
            'student_number' => $request->input('student_number'),
            'school_year' => $request->input('school_year'),
            'semester' => $request->input('semester'),
        ]);

        $schoolYear = $request->input('school_year');
        $semester = $request->input('semester');

        return redirect()->route('admin.enrolled.all', compact('schoolYear', 'semester'))->with('success', 'Student enrolled successfully.');
    }

    public function enrolledStudents($schoolYear, $semester)
    {
        $enrolledStudents = EnrolledStudent::where('school_year', $schoolYear)
            ->where('semester', $semester)
            ->get();

        $studentNumbers = $enrolledStudents->pluck('student_number')->toArray();

        $students = StudentInformation::whereIn('student_number', $studentNumbers)
            ->get();

        return view('admin.enrolled.students-enrolled', compact('students', 'schoolYear', 'semester'));
    }

    public function enrolledAllStudents($schoolYear, $semester)
    {
        $students = StudentInformation::whereNotIn('student_number', function($query) use ($schoolYear, $semester) {
            $query->select('student_number')
                  ->from('enrolled_students')
                  ->where('school_year', $schoolYear)
                  ->where('semester', $semester);
        })->get();

        return view('admin.enrolled.enrolled-all-students', compact('students', 'schoolYear', 'semester'));
    }

    public function redirectToEnroll(Request $request)
    {
        $schoolYear = $request->input('school_year');
        $semester = $request->input('semester');

        return redirect()->route('admin.enrolled.all', compact('schoolYear', 'semester'));
    }

    public function exportStudents($schoolYear, $semester)
    {
        $enrolledStudents = EnrolledStudent::where('school_year', $schoolYear)
            ->where('semester', $semester)
            ->get();

        $studentNumbers = $enrolledStudents->pluck('student_number')->toArray();

        $students = StudentInformation::whereIn('student_number', $studentNumbers)
            ->get();

        $data = [];
        foreach ($students as $student) {
            $data[] = [
                'Student Number' => $student->student_number,
                'Last Name' => $student->surname,
                'First Name' => $student->given_name,
                'Middle Name' => $student->middle_name,
                'Program' => $student->program,
                'Year Level' => $student->year_level,
            ];
        }

        return Excel::create('enrolled_students', function($excel) use ($data) {
            $excel->sheet('Enrolled Students', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xlsx');
    }

    public function unenrollStudent($student_number)
    {
        // Find the enrolled student record
        $enrolledStudent = EnrolledStudent::where('student_number', $student_number)->firstOrFail();

        // Delete the enrolled student record
        $enrolledStudent->delete();

        return redirect()->back()->with('success', 'Student unenrolled successfully.');
    }

    public function selectStudent($student_number)
    {
        $student = StudentInformation::where('student_number', $student_number)->firstOrFail();

        $clinicalBasalData = \DB::table('student_clinical_basal_data')
            ->where('student_number', $student_number)
            ->first();

        $imageUrl = "http://203.177.208.99/images/spix/{$student->student_number}.Png";
        $imageExists = @getimagesize($imageUrl) ? true : false;

        return view('admin.student.select', compact('student', 'clinicalBasalData', 'imageExists'));
    }

    public function updateYearLevel(Request $request, $student_number)
    {
        $request->validate([
            'year_level' => 'required|in:1,2,3,4',
        ]);

        $student = StudentInformation::where('student_number', $student_number)->firstOrFail();
        $student->year_level = $request->input('year_level');
        $student->save();

        return redirect()->route('sis.student.information.view', $student_number)->with('success', 'Year level updated successfully.');
    }
}
