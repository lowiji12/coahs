<!-- resources/views/admin/academic/settings.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Set Default School Year
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.academic.settings.setDefaultSchoolYear') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="year">Select School Year</label>
                            <select class="form-control" id="year" name="year">
                                @foreach ($schoolYears as $schoolYear)
                                    <option value="{{ $schoolYear->year }}" {{ $settings['defaultSchoolYear'] && $settings['defaultSchoolYear']->year === $schoolYear->year ? 'selected' : '' }}>
                                        {{ $schoolYear->year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Set to Default</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Set Default Semester
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.academic.settings.setDefaultSemester') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="semester">Select Semester</label>
                            <select class="form-control" id="semester" name="semester">
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->semester }}" {{ $settings['defaultSemester'] && $settings['defaultSemester']->semester === $semester->semester ? 'selected' : '' }}>
                                        {{ $semester->semester }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Set to Default</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    School Years
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>School Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schoolYears as $schoolYear)
                                <tr>
                                    <td>{{ $schoolYear->year }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Semesters
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($semesters as $semester)
                                <tr>
                                    <td>{{ $semester->semester }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
