@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Student Information</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Student Information</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Student List</h3>
                        <a href="{{ route('import.student') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Import Student
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('sis.student.information') }}" method="GET" class="d-flex align-items-center mb-3">
                        <div class="form-group me-2">
                            <select name="school_year" class="form-control" aria-label="School Year">
                                <option value="">Select School Year</option>
                                @foreach ($schoolYears as $schoolYear)
                                    <option value="{{ $schoolYear->year }}" {{ $selectedSchoolYear == $schoolYear->year ? 'selected' : '' }}>
                                        {{ $schoolYear->year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group me-2">
                            <select name="semester" class="form-control" aria-label="Semester">
                                <option value="">Select Semester</option>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->semester }}" {{ $selectedSemester == $semester->semester ? 'selected' : '' }}>
                                        {{ $semester->semester }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Student Number</th>
                                    <th>Full Name</th>
                                    <th>Program</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->student_number }}</td>
                                        <td>{{ $student->surname }}, {{ $student->given_name }} {{ $student->middle_name }}</td>
                                        <td>{{ $student->program == 'BSP' ? 'BS in Pharmacy' :
                                            ($student->program == 'BSN' ? 'BS in Nursing' :
                                            ($student->program == 'BSW' ? 'BS in Midwifery' : 'N/A')) }}</td>
                                        <td>
                                            <a href="{{ route('student.information.view', $student->student_number) }}"
                                                class="btn btn-primary btn-sm">Select</a>
                                            <button class="btn btn-danger btn-sm">Delete</button>
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
