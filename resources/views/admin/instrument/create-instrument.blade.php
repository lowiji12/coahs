@extends('layouts.admin')

@section('content')
<div class="page-container1">
    <h1 class="title1">Add new Instrument</h1>
    <div class="form-container1">
        <form action="{{ route('admin.instruments.store') }}" method="POST">
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
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" required>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Add new Instrument</button>
                <a href="{{ route('admin.instruments.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
