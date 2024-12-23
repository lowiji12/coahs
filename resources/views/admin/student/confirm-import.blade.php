@extends('layouts.admin')

@section('styles')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .header {
        margin-bottom: 20px;
    }
    
    .header h1 {
        font-size: 24px;
        margin: 0 0 10px 0;
    }
    
    .privacy-notice {
        font-size: 14px;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.5;
    }
    
    .section-title {
        font-size: 18px;
        margin: 20px 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background: white;
        border: 1px solid #e5e7eb;
    }
    
    .table th {
        background: #f9fafb;
        padding: 12px;
        text-align: left;
        font-weight: 500;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .table td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .remove-btn {
        background: #EF4444;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 20px;
    }
    
    .confirm-btn {
        background: #10B981;
        color: white;
        padding: 8px 24px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }
    
    .cancel-btn {
        background: #DC2626;
        color: white;
        padding: 8px 24px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .back-btn {
        background: #6B7280;
        color: white;
        padding: 4px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        float: right;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="header">
        <a href="{{ route('admin.students.import') }}" class="back-btn">Back</a>
        <h1>Student Data Profile</h1>
        <p class="privacy-notice">
            The school Ramon Magsaysay Memorial Colleges is committed to respect each student's personal privacy in compliance with Data Privacy Act of 2012 while ensuring its ability to fully carry out its responsibilities. It is understood that you agree to share your personal information by continuing to fill-up this form.
        </p>
    </div>

    <h2 class="section-title">Confirm Imported New Students</h2>
    @if(!empty($newStudents) && count($newStudents) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Surname</th>
                    <th>Given Name</th>
                    <th>Program</th>
                    <th>Year Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($newStudents as $index => $student)
                    <tr>
                        <td>{{ $student['student_number'] }}</td>
                        <td>{{ $student['surname'] }}</td>
                        <td>{{ $student['given_name'] }}</td>
                        <td>{{ $student['program'] }}</td>
                        <td>{{ $student['year_level'] }}</td>
                        <td>
                            <button type="button" class="remove-btn" onclick="removeStudent({{ $index }})">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No new students to import.</p>
    @endif

    <h2 class="section-title">Existing Student</h2>
    @if(!empty($existingStudents) && count($existingStudents) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Surname</th>
                    <th>Given Name</th>
                    <th>Program</th>
                    <th>Year Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($existingStudents as $student)
                    <tr>
                        <td>{{ $student['student_number'] }}</td>
                        <td>{{ $student['surname'] }}</td>
                        <td>{{ $student['given_name'] }}</td>
                        <td>{{ $student['program'] }}</td>
                        <td>{{ $student['year_level'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No existing students found.</p>
    @endif

    <div class="action-buttons">
        <form action="{{ route('admin.students.import.confirm') }}" method="POST">
            @csrf
            <button type="submit" class="confirm-btn">Confirm Import</button>
        </form>
        <a href="{{ route('admin.students.import') }}" class="cancel-btn">Cancel</a>
    </div>
</div>

<script>
function removeStudent(index) {
    if (confirm('Are you sure you want to remove this student?')) {
        fetch('{{ route("admin.students.remove-from-import") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ index: index })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }
}
</script>
@endsection

