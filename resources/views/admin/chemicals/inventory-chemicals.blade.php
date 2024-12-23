<!-- resources/views/admin/chemicals/inventory-chemicals.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="page-container">
    <div class="header">
        <h1 class="title">Chemicals Inventory</h1>
        <a href="{{ route('admin.chemicals.create') }}" class="btn-add">+ Add New Chemical</a>
    </div>
    <div class="table-container">
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Stocks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chemicals as $chemical)
                    <tr>
                        <td>{{ $chemical->name }}</td>
                        <td>{{ $chemical->location }}</td>
                        <td>{{ $chemical->stocks }}</td>
                        <td class="action-cell">
                            <button onclick="redirectToEdit({{ $chemical->id }})" class="btn btn-select">Select</button>
                            <button onclick="showDeleteModal({{ $chemical->id }})" class="btn btn-delete">Delete</button>
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
    document.getElementById('deleteForm').action = "{{ route('admin.chemicals.destroy', '') }}/" + id;
}

function hideDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

function redirectToEdit(id) {
    window.location.href = "{{ url('admin/chemicals/') }}/" + id + "/edit";
}
</script>
@endsection
