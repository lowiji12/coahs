@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Import Student Data</h2>
            <p class="text-muted">
                Upload an Excel file to import student data. Please ensure the file follows the correct format.
                You can download the template</a> for guidance.
            </p>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.students.import.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Upload File</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Import</button>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

