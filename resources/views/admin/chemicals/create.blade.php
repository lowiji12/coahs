<!-- resources/views/admin/chemicals/create.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="page-container">
    <div class="header">
        <h1 class="title">Add New Chemical</h1>
    </div>
    <div class="form-container">
        <form action="{{ route('admin.chemicals.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="stocks">Stocks</label>
                <input type="number" name="stocks" id="stocks" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.chemicals.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
