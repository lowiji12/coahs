<!-- resources/views/admin/Equipments/edit.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="page-container">
    <div class="header">
        <h1 class="title">Edit Equipment</h1>
    </div>
    <div class="form-container">
        <form action="{{ route('admin.equipments.update', $equipment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $equipment->name }}" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ $equipment->location }}" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $equipment->quantity }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.equipments.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
