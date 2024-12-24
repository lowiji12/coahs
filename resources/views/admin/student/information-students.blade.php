@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Student Information</h1>
        <a href="{{ route('import.student') }}" class="btn btn-success btn-sm d-flex align-items-center gap-2">
            <i class="fas fa-plus"></i> Import New Student
        </a>
    </div>

    <!-- Filter Section -->
    <div class="d-flex flex-wrap gap-3 mb-4">
        <form action="{{ route('admin.student.filter') }}" method="GET" class="d-flex gap-3 flex-wrap">
            <select class="form-select form-select-sm col-12 col-sm-6 col-md-3" name="schoolYear" id="schoolYear">
                <option value="">All School Year</option>
                @foreach ($schoolYears as $schoolYear)
                    <option value="{{ $schoolYear->year }}" {{ $defaultSchoolYear && $defaultSchoolYear->year === $schoolYear->year ? 'selected' : '' }}>
                        {{ $schoolYear->year }}
                    </option>
                @endforeach
            </select>

            <select class="form-select form-select-sm col-12 col-sm-6 col-md-3" name="semester" id="semester">
                <option value="">All Semester</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->semester }}" {{ $defaultSemester && $defaultSemester->semester === $semester->semester ? 'selected' : '' }}>
                        {{ $semester->semester }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-outline-success btn-sm">Search</button>
        </form>
    </div>

    <!-- School Year and Semester Table -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">School Year</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">No. of Students</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schoolYears as $schoolYear)
                            @foreach ($semesters as $semester)
                                <tr>
                                    <td class="text-center">{{ $schoolYear->year }}</td>
                                    <td class="text-center">{{ $semester->semester }}</td>
                                    <td class="text-center">{{ $studentCounts[$schoolYear->year][$semester->semester] }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.enrolled.students', ['schoolYear' => $schoolYear->year, 'semester' => $semester->semester]) }}"
                                           class="btn btn-success btn-sm">
                                            <i class="nav-icon fas fa-solid fa-hand-pointer"></i> Select
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Student Table (if students are set) -->
    @if(isset($students))
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th>Surname</th>
                                <th>Given Name</th>
                                <th>Middle Name</th>
                                <th>Program</th>
                                <th>Year Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->student_number }}</td>
                                    <td>{{ $student->surname }}</td>
                                    <td>{{ $student->given_name }}</td>
                                    <td>{{ $student->middle_name }}</td>
                                    <td>{{ $student->program }}</td>
                                    <td>{{ $student->year_level }}</td>
                                    <td><a href="{{ route('sis.student.information.view', $student->student_number) }}"
                                           class="btn btn-primary btn-sm">Select</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
