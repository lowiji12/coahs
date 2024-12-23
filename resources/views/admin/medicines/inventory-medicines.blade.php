@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="header">
        <h1 class="title">Medicines Inventory</h1>
        <a href="{{ route('admin.medicines.create') }}" class="btn-add">+ Add new Medicine</a>
    </div>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Generic Name</th>
                    <th>Brand Name</th>
                    <th>Dose</th>
                    <th>Form</th>
                    <th>Location</th>
                    <th>Stock</th>
                    <th class="action-column">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicines as $medicine)
                <tr>
                    <td>{{ $medicine->generic_name }}</td>
                    <td>{{ $medicine->brand_name }}</td>
                    <td>{{ $medicine->dose }}</td>
                    <td>{{ $medicine->form }}</td>
                    <td>{{ $medicine->location }}</td>
                    <td>{{ $medicine->stock }}</td>
                    <td class="action-cell">
                        <a href="{{ route('admin.medicines.edit', $medicine->id) }}" class="btn btn-edit">Edit</a>
                        <button onclick="showDeleteModal({{ $medicine->id }})" class="btn btn-delete">Delete</button>
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
            <form id="deleteForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-confirm">Yes</button>
            </form>
            <button onclick="hideDeleteModal()" class="btn btn-cancel">Cancel</button>
        </div>
    </div>
</div>

<script>
function showDeleteModal(medicineId) {
    document.getElementById('deleteModal').style.display = 'flex';
    document.getElementById('deleteForm').action = `/admin/medicines/${medicineId}`;
}

function hideDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}
</script>
@endsection

