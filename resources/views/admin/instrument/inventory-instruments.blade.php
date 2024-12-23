@extends('layouts.admin')

@section('content')
<div class="page-container">
    <div class="header">
        <h1 class="title">Instrument Inventory</h1>
        <a href="{{ route('admin.instruments.create') }}" class="btn-add">+ Add new Instrument</a>
    </div>
    <div class="table-container">
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($instruments as $instrument)
                    <tr>
                        <td>{{ $instrument->name }}</td>
                        <td>{{ $instrument->location }}</td>
                        <td>{{ $instrument->quantity }}</td>
                        <td class="action-cell">
                            <button onclick="redirectToEdit({{ $instrument->id }})" class="btn btn-select">Select</button>
                            <button onclick="showDeleteModal({{ $instrument->id }})" class="btn btn-delete">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="modal-icon">?</span>
        </div>
        <p class="modal-text">Are you sure you want to delete?</p>
        <div class="modal-actions">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-confirm">Yes</button>
            </form>
            <button onclick="hideDeleteModal()" class="btn btn-cancel">Cancel</button>
        </div>
    </div>
</div>

<script>
function showDeleteModal(id) {
    document.getElementById('deleteModal').style.display = 'flex';
    document.getElementById('deleteForm').action = "{{ route('admin.instruments.destroy', '') }}/" + id;
}

function hideDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

function redirectToEdit(id) {
    window.location.href = "{{ url('admin/instruments/') }}/" + id + "/edit";
}
</script>
@endsection
