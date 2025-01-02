<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipments Inventory | COAHS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Equipments Inventory</h2>
        <div class="d-flex">
            <form action="{{ route('admin.equipment.index') }}" method="GET" class="d-flex position-relative">
                <input type="text" name="search" class="form-control form-control-sm pe-5" placeholder="Search Equipments..." value="{{ request()->get('search') }}">
                <button type="submit" class="btn btn-primary position-absolute top-0 end-0 rounded-start-0 rounded-end-2">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <button class="btn btn-secondary shadow-sm me-2 animated-btn" onclick="refreshList()">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
            <button class="btn btn-info shadow-sm me-2 animated-btn" onclick="printTable()">
                <i class="bi bi-printer"></i> Print
            </button>
            <a href="{{ route('admin.equipment.create') }}" class="btn btn-success shadow-sm ms-2 animated-btn">
                <i class="bi bi-plus-circle"></i> Add New Equipment
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive" id="printArea">
        <table class="table table-striped bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Location/Shelves</th>
                    <th>Quantity</th>
                    <th>Expire Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipment as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->location }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->expire_date }}</td>
                        <td>
                            <a href="{{ route('admin.equipment.edit', $item->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="{{ route('admin.equipment.destroy', $item->id) }}" 
                                class="btn btn-danger btn-sm" 
                                data-confirm="Are you sure you want to delete {{ $item->name }}?" onclick="return confirmDelete(event, '{{ $item->name }}')">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No equipment found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

<style>
    /* Button Hover Animation */
    .animated-btn {
        transition: all 0.3s ease-in-out;
    }

    .animated-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
</style>

<script>
    function refreshList() {
        // Clear the search input
        document.querySelector('input[name="search"]').value = '';
        // Reload the page to show all items
        window.location.href = "{{ route('admin.equipment.index') }}";
    }

    function printTable() {
        // Hide the "Action" column
        const actionCells = document.querySelectorAll('td:nth-child(5), th:nth-child(5)');
        actionCells.forEach(cell => cell.style.display = 'none');
        
        // Get the contents of the print area
        const printContents = document.getElementById("printArea").innerHTML;
        const originalContents = document.body.innerHTML;

        // Set the document body to print contents and print
        document.body.innerHTML = printContents;
        window.print();

        // Restore the original content and visibility of the "Action" column
        document.body.innerHTML = originalContents;
        actionCells.forEach(cell => cell.style.display = '');

        // Reload the page to reapply any JavaScript and styles
        location.reload();
    }

    function confirmDelete(event, equipmentName) {
        // Display confirmation dialog
        const confirmation = confirm(`Are you sure you want to delete the equipment "${equipmentName}"?`);
        if (!confirmation) {
            // Prevent the link's default action if the user cancels
            event.preventDefault();
        }
    }
</script>

</body>
</html>