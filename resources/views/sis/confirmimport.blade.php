@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-center">Confirm Imported New Students</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: '{{ session('success') }}',
                        });
                    </script>
                @endif

                @if (isset($newStudents) && count($newStudents) > 0)
                    <table class="table table-striped">
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
                            @foreach ($newStudents as $key => $student)
                                <tr>
                                    <td>{{ $student['student_number'] }}</td>
                                    <td>{{ $student['surname'] }}</td>
                                    <td>{{ $student['given_name'] }}</td>
                                    <td>{{ $student['program'] }}</td>
                                    <td>{{ $student['year_level'] }}</td>
                                    <td>
                                        <form action="{{ route('remove.student') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="row_key" value="{{ $key }}">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-center mt-4">
                        <form action="{{ route('save.confirmed.import') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Confirm Import</button>
                            <a href="{{ route('sis.student.information') }}" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                @else
                    <p>No new students found. Please import a file first.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-center">Existing Student</h3>
            </div>
            <div class="card-body">
                @if (isset($existingStudents) && count($existingStudents) > 0)
                    <table class="table table-striped">
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
                            @foreach ($existingStudents as $student)
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
            </div>
        </div>
    </div>
@endsection
