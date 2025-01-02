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
use App\Http\Controllers\Admin\SupplyController;
use App\Http\Controllers\Admin\BorrowerController;

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
    Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
    Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
    Route::get('/medicines/edit/{id}', [MedicineController::class, 'edit'])->name('medicines.edit');
    Route::get('/medicines/delete/{id}/destroy', [MedicineController::class, 'destroy'])->name('medicines.destroy');
    Route::delete('medicines/delete/{id}/destroy', [MedicineController::class, 'destroy'])->name('medicines.delete');
    Route::post('/medicines/store', [MedicineController::class, 'store'])->name('medicines.store');
    Route::post('/medicines/update/{id}', [MedicineController::class, 'update'])->name('medicines.update');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('instruments', [InstrumentController::class, 'index'])->name('instruments.index');
    Route::get('instruments/create', [InstrumentController::class, 'create'])->name('instruments.create');
    Route::post('instruments', [InstrumentController::class, 'store'])->name('instruments.store');
    Route::get('instruments/{id}/edit', [InstrumentController::class, 'edit'])->name('instruments.edit');
    Route::put('instruments/{id}', [InstrumentController::class, 'update'])->name('instruments.update');
    Route::get('instruments/{id}/destroy', [InstrumentController::class, 'destroy'])->name('instruments.destroy');

});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('equipment/create', [EquipmentController::class, 'create'])->name('equipment.create');
    Route::post('equipment/store', [EquipmentController::class, 'store'])->name('equipment.store');
    Route::get('equipment/{id}/edit', [EquipmentController::class, 'edit'])->name('equipment.edit');
    Route::put('equipment/{id}/update', [EquipmentController::class, 'update'])->name('equipment.update');
    Route::get('equipment/{id}/destroy', [EquipmentController::class, 'destroy'])->name('equipment.destroy');

});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('chemicals', [ChemicalController::class, 'index'])->name('chemicals.index');
    Route::get('chemicals/create', [ChemicalController::class, 'create'])->name('chemicals.create');
    Route::post('chemicals/store', [ChemicalController::class, 'store'])->name('chemicals.store');
    Route::get('chemicals/{id}/edit', [ChemicalController::class, 'edit'])->name('chemicals.edit');
    Route::post('chemicals/{id}/update', [ChemicalController::class, 'update'])->name('chemicals.update');
    Route::get('chemicals/{id}/delete', [ChemicalController::class, 'delete'])->name('chemicals.delete');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('supplies', [SupplyController::class, 'index'])->name('supplies.index');
    Route::get('supplies/create', [SupplyController::class, 'create'])->name('supplies.create');
    Route::get('supplies/store', [SupplyController::class, 'store'])->name('supplies.store');
    Route::get('supplies/edit/{id}', [SupplyController::class, 'edit'])->name('supplies.edit');
    Route::get('supplies/update/{id}', [SupplyController::class, 'update'])->name('supplies.update');
    Route::get('supplies/destroy/{id}/destroy', [SupplyController::class, 'destroy'])->name('supplies.destroy');
    Route::get('supplies/search', [SupplyController::class, 'search'])->name('supplies.search');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/borrowers', [BorrowerController::class, 'index'])->name('borrowers.index');
    Route::get('/borrowers/create', [BorrowerController::class, 'create'])->name('borrowers.create');
    Route::get('/borrowers/store', [BorrowerController::class, 'store'])->name('borrowers.store');
    Route::get('/borrowers/edit/{id}', [BorrowerController::class, 'edit'])->name('borrowers.edit');
    Route::get('/borrowers/update/{id}', [BorrowerController::class, 'update'])->name('borrowers.update');
    Route::get('/borrowers/delete/{id}', [BorrowerController::class, 'destroy'])->name('borrowers.destroy');
    Route::delete('borrowers/delete/{id}', [BorrowerController::class, 'destroy'])->name('borrowers.delete');
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
