<?php

use App\Http\Controllers\DiagnosticTestResultController;
use App\Http\Controllers\Admin\AcademicSettingsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentInformationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Admin\ChemicalController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\InstrumentController;
use App\Http\Controllers\Admin\MedicineController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Student Information
Route::get('/student-information', [StudentInformationController::class, 'index'])->name('sis.student.information');
Route::resource('students', StudentInformationController::class)->parameters([
    'students' => 'student_number',
]);
Route::get('/student-information/{student_number}', [StudentInformationController::class, 'show'])->name('student.information.view');
Route::get('/import-student-information', function () {
    return view('sis.importstudentinformation');
})->name('import.student');
Route::post('/import-student-information', [StudentInformationController::class, 'import'])->name('import.student');
Route::post('/confirm-import', [StudentInformationController::class, 'confirmImport'])->name('confirm.import');
Route::get('/import/confirm', [StudentInformationController::class, 'confirmImport'])->name('import.student.confirm');
Route::post('/import/save', [StudentInformationController::class, 'saveConfirmedImport'])->name('save.confirmed.import');
Route::post('/remove-student', [StudentInformationController::class, 'removeStudent'])->name('remove.student');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('medicines', MedicineController::class);
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('instruments', InstrumentController::class);
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('equipments', EquipmentController::class);
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('chemicals', ChemicalController::class);
    
});

Route::get('/admin/student/information', [StudentInformationController::class, 'student'])->name('admin.student.information');



Route::get('academic/settings', [AcademicSettingsController::class, 'index'])->name('admin.academic.settings');
    Route::post('academic/settings/set-default-school-year', [AcademicSettingsController::class, 'setDefaultSchoolYear'])->name('admin.academic.settings.setDefaultSchoolYear');
    Route::post('academic/settings/set-default-semester', [AcademicSettingsController::class, 'setDefaultSemester'])->name('admin.academic.settings.setDefaultSemester');
    Route::get('student/filter', [StudentInformationController::class, 'filterStudents'])->name('admin.student.filter');
    Route::post('student/add', [StudentInformationController::class, 'addStudent'])->name('admin.student.add');
    Route::get('enrolled/students/{schoolYear}/{semester}', [StudentInformationController::class, 'enrolledStudents'])->name('admin.enrolled.students');
    Route::get('student/export/{schoolYear}/{semester}', [StudentInformationController::class, 'exportStudents'])->name('admin.student.export');
    Route::get('/admin/enrolled/{schoolYear}/{semester}', [StudentInformationController::class, 'enrolledStudents'])->name('admin.enrolled.students');
    Route::post('/admin/student/redirect-to-enroll', [StudentInformationController::class, 'redirectToEnroll'])->name('admin.student.redirectToEnroll');
    Route::get('/admin/enrolled/all/{schoolYear}/{semester}', [StudentInformationController::class, 'enrolledAllStudents'])->name('admin.enrolled.all');
    Route::post('/admin/student/add', [StudentInformationController::class, 'addStudent'])->name('admin.student.add');
    Route::get('/admin/student/select/{student_number}', [StudentInformationController::class, 'selectStudent'])->name('admin.student.select');
    Route::get('/admin/student/unenroll/{student_number}', [StudentInformationController::class, 'unenrollStudent'])->name('admin.student.unenroll');
    Route::post('/admin/student/unenroll', [StudentInformationController::class, 'unenrollStudent'])->name('admin.student.unenroll');
    Route::post('/upload-diagnostic-test-result', [StudentInformationController::class, 'uploadDiagnosticTestResult'])->name('upload.diagnostic.test.result');
    Route::post('/admin/student/unenroll/{student_number}', [StudentInformationController::class, 'unenrollStudent'])->name('admin.student.unenroll');
    Route::get('/student-information/{student_number}', [StudentInformationController::class, 'show'])->name('sis.student.information.view');
    Route::post('/filter-results', [StudentInformationController::class, 'filterResults'])->name('filter.results');
    Route::get('/student/{student_number}', [StudentInformationController::class, 'show'])->name('student.information.view');
    Route::post('/student/information/update-yearlevel/{student_number}', [StudentInformationController::class, 'updateYearLevel'])->name('update.student.yearlevel');
    Route::post('/upload-diagnostic-test-result', [DiagnosticTestResultController::class, 'upload'])->name('upload.diagnostic.test.result');
    Route::get('/view-diagnostic-test-result', [StudentInformationController::class, 'viewDiagnosticTestResult'])->name('view.diagnostic.test.result');
    Route::post('/delete-diagnostic-test-result', [StudentInformationController::class, 'deleteDiagnosticTestResult'])->name('delete.diagnostic.test.result');
    Route::get('/admin/student/diagnostic-test-results/{student_number}', [DiagnosticTestResultController::class, 'show'])->name('admin.student.diagnostic_test_results');
    Route::post('/delete-diagnostic-test-result', [DiagnosticTestResultController::class, 'delete'])->name('delete.diagnostic.test.result');
require __DIR__ . '/auth.php';
