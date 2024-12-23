<!-- resources/views/admin/chemicals/edit.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="page-container">
    <div class="header">
        <h1 class="title">Edit Chemical</h1>
    </div>
    <div class="form-container">
        <form action="{{ route('admin.chemicals.update', $chemical->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $chemical->name }}" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ $chemical->location }}" required>
            </div>
            <div class="form-group">
                <label for="stocks">Stocks</label>
                <input type="number" name="stocks" id="stocks" class="form-control" value="{{ $chemical->stocks }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.chemicals.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
