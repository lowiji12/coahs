@extends('layouts.admin')

@section('content')
<div class="page-container">
    <h1 class="title">Add new Medicines</h1>
    <div class="form-container">
        <form action="{{ route('admin.medicines.store') }}" method="POST">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                <label for="generic_name">Generic Name</label>
                <input type="text" name="generic_name" id="generic_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="brand_name">Brand Name</label>
                <input type="text" name="brand_name" id="brand_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="dose">Dose</label>
                <input type="text" name="dose" id="dose" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="form">Form (sample: tablet, capsule etc.)</label>
                <input type="text" name="form" id="form" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" required>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Add new Medicine</button>
                <a href="{{ route('admin.medicines.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
