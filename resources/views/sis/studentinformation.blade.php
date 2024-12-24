@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 text-center">Student Information</h1>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Student List</h3>
                    <a href="{{ route('import.student') }}" class="btn btn-success btn-sm">
                        <i class="nav-icon fas fa-solid fa-plus"></i> Import Student
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Search Form -->
                <form action="{{ route('sis.student.information') }}" method="GET">
                    <div class="row mb-4">
                        <!-- School Year Dropdown -->
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="school_year" class="col-sm-4 col-form-label"><strong>School Year</strong></label>
                                <div class="col-sm-8">
                                    <select name="school_year" class="form-control form-control-sm" id="school_year">
                                        <option value="">Select School Year</option>
                                        @foreach ($schoolYears as $schoolYear)
                                            <option value="{{ $schoolYear->year }}" {{ $selectedSchoolYear == $schoolYear->year ? 'selected' : '' }}>
                                                {{ $schoolYear->year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Semester Dropdown -->
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="semester" class="col-sm-4 col-form-label"><strong>Semester</strong></label>
                                <div class="col-sm-8">
                                    <select name="semester" class="form-control form-control-sm" id="semester">
                                        <option value="">Select Semester</option>
                                        @foreach ($semesters as $semester)
                                            <option value="{{ $semester->semester }}" {{ $selectedSemester == $semester->semester ? 'selected' : '' }}>
                                                {{ $semester->semester }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="col-md-2">
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-outline-secondary btn-sm w-100">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Student Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Student Number</th>
                                <th>Full Name</th>
                                <th>Program</th>
                                <th>Year Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->student_number }}</td>
                                    <td>{{ $student->surname }}, {{ $student->given_name }} {{ $student->middle_name }}</td>
                                    <td>
                                        {{ $student->program == 'BSP' ? 'BS in Pharmacy' :
                                            ($student->program == 'BSN' ? 'BS in Nursing' :
                                                ($student->program == 'BSW' ? 'BS in Midwifery' : 'N/A')) }}
                                    </td>
                                    <td>{{ $student->year_level }}</td>
                                    <td>
                                        <a href="{{ route('student.information.view', $student->student_number) }}"
                                            class="btn btn-success btn-sm"><i class="bi bi-hand-index-fill"></i> Select</a>
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash2-fill"></i> Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
