@extends('layouts.admin')

@section('content')
<div class="header">
    <h1>Enrolled Student</h1>
    <div class="header-buttons">
        <a href="{{ route('admin.student.information') }}" class="btn btn-gray">← Back to School Year and Semester</a>
        <a href="{{ route('admin.student.export', ['schoolYear' => $schoolYear, 'semester' => $semester]) }}" class="btn btn-blue">↗ Export Data to Spreadsheet</a>
    </div>
</div>

<div class="school-info">
    <div class="school-icon"></div>
    <div class="school-details">
        <div><strong>School Year:</strong> {{ $schoolYear }}</div>
        <div><strong>Semester:</strong> {{ $semester }}</div>
    </div>
    <form action="{{ route('admin.student.redirectToEnroll') }}" method="POST">
        @csrf
        <input type="hidden" name="school_year" value="{{ $schoolYear }}">
        <input type="hidden" name="semester" value="{{ $semester }}">
        <button type="submit" class="btn btn-green">+ Add Student</button>
    </form>
</div>

<div class="search-section">
    <input type="text" placeholder="Search..." class="search-input">
    <select class="select-input">
        <option>Student Number</option>
    </select>
    <select class="select-input">
        <option>Year Level</option>
    </select>
    <select class="select-input">
        <option>Program</option>
    </select>
    <button class="btn btn-gray">Search</button>
</div>

<table>
    <thead>
        <tr>
            <th>Student Number</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Program</th>
            <th>Year Level</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($students->isEmpty())
            <tr>
                <td colspan="7">No students found for the specified School Year and Semester.</td>
            </tr>
        @else
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->student_number }}</td>
                    <td>{{ $student->surname }}</td>
                    <td>{{ $student->given_name }}</td>
                    <td>{{ $student->middle_name }}</td>
                    <td>{{ $student->program }}</td>
                    <td>{{ $student->year_level }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('student.information.view', $student->student_number) }}" class="btn btn-green">Select</a>
                        <form action="{{ route('admin.student.unenroll', ['student_number' => $student->student_number]) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-red">Unenroll</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@endsection

@section('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: system-ui, -apple-system, sans-serif;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header h1 {
        font-size: 24px;
        color: #333;
    }

    .header-buttons {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none; /* Remove underline */
    }

    .btn-gray {
        background-color: #6c757d;
        color: white;
    }

    .btn-blue {
        background-color: #007bff;
        color: white;
    }

    .btn-green {
        background-color: #28a745;
        color: white;
    }

    .btn-red {
        background-color: #dc3545;
        color: white;
    }

    .school-info {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .school-icon {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        margin-right: 20px;
        position: relative;
        background-image: url('{{ asset('images/school.webp') }}'); /* Link to the image */
        background-size: cover; /* Ensure the image covers the entire div */
        background-position: center; /* Center the image */
    }

    .school-details {
        flex-grow: 1;
    }

    .school-details div {
        margin-bottom: 10px;
    }

    .search-section {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .search-input, .select-input {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .search-input {
        flex-grow: 1;
    }

    .select-input {
        min-width: 200px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
    }
</style>
@endsection
