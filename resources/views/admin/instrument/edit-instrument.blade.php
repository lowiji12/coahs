@extends('layouts.admin')

@section('content')
<div class="page-container1">
    <h1 class="title1">Edit Instrument</h1>
    <div class="form-container">
        <form action="{{ route('admin.instruments.update', $instrument->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $instrument->name }}" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ $instrument->location }}" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $instrument->quantity }}" required>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Update Instrument</button>
                <a href="{{ route('admin.instruments.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
