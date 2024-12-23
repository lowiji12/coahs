<!-- resources/views/admin/student/information-students.blade.php -->

@extends('layouts.admin')

@section('styles')
<style>
    .container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header h1 {
        font-size: 24px;
        margin: 0;
    }

    .import-btn {
        background: #10B981;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-section {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }

    .filter-select {
        padding: 8px;
        border: 1px solid #E5E7EB;
        border-radius: 4px;
        min-width: 200px;
    }

    .search-btn {
        background: #10B981;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .table-container {
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #F9FAFB;
        padding: 12px;
        text-align: left;
        font-weight: 500;
        border-bottom: 1px solid #E5E7EB;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #E5E7EB;
    }

    .select-btn {
        background: #10B981;
        color: white;
        padding: 6px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="header">
        <h1>Student Information</h1>
        <a href="{{ route('import.student') }}" class="import-btn">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.3333 13.3333L9.99997 10M9.99997 10L6.66663 13.3333M9.99997 10V17.5M16.9916 15.3583C17.8044 14.6734 18.3981 13.7385 18.6955 12.6933C18.9929 11.6482 18.9822 10.537 18.6642 9.49819C18.3463 8.45941 17.7345 7.53965 16.9089 6.87029C16.0833 6.20093 15.0826 5.80988 14.0333 5.75001C13.7591 4.62683 13.1929 3.59356 12.3964 2.76121C11.5998 1.92886 10.6028 1.32698 9.51284 1.01532C8.42285 0.703659 7.27321 0.689358 6.17554 0.973765C5.07788 1.25817 4.07634 1.83175 3.25875 2.64934C2.44116 3.46693 1.86758 4.46847 1.58317 5.56614C1.29877 6.6638 1.31307 7.81344 1.62473 8.90343C1.93639 9.99343 2.53827 10.9904 3.37062 11.787C4.20297 12.5836 5.23624 13.1498 6.35942 13.4239" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Import New Student
        </a>
    </div>

    <div class="filter-section">
        <form action="{{ route('admin.student.filter') }}" method="GET">
            <select class="filter-select" name="schoolYear" id="schoolYear">
                <option value="">All School Year</option>
                @foreach ($schoolYears as $schoolYear)
                    <option value="{{ $schoolYear->year }}" {{ $defaultSchoolYear && $defaultSchoolYear->year === $schoolYear->year ? 'selected' : '' }}>
                        {{ $schoolYear->year }}
                    </option>
                @endforeach
            </select>

            <select class="filter-select" name="semester" id="semester">
                <option value="">All Semester</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->semester }}" {{ $defaultSemester && $defaultSemester->semester === $semester->semester ? 'selected' : '' }}>
                        {{ $semester->semester }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>School Year</th>
                    <th>Semester</th>
                    <th>No. of Students</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schoolYears as $schoolYear)
                    @foreach ($semesters as $semester)
                        <tr>
                            <td>{{ $schoolYear->year }}</td>
                            <td>{{ $semester->semester }}</td>
                            <td>{{ $studentCounts[$schoolYear->year][$semester->semester] }}</td>
                            <td>
                                <a href="{{ route('admin.enrolled.students', ['schoolYear' => $schoolYear->year, 'semester' => $semester->semester]) }}" class="select-btn">Select</a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    @if(isset($students))
        <div class="table-container">
            <table>
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
                            <td><a href="{{ route('sis.student.information.view', $student->student_number) }}" class="select-btn">Select</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
