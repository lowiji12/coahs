<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplies Inventory | COAHS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Supplies Inventory</h2>
        <div class="d-flex">
        <form action="{{ route('admin.supplies.search') }}" method="GET" class="d-flex position-relative">
                <input type="text" name="search" class="form-control form-control-sm pe-5" placeholder="Search Supplies..." value="{{ request()->get('search') }}">
                <button type="submit" class="btn btn-primary position-absolute top-0 end-0 rounded-start-0 rounded-end-2">
            <i class="bi bi-search"></i>
          </button>
        </form>

            <!-- Refresh Button -->
            <button class="btn btn-secondary shadow-sm me-2 animated-btn" onclick="refreshList()">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>

            <!-- Print Button -->
            <button class="btn btn-info shadow-sm me-2 animated-btn" onclick="printTable()">
                <i class="bi bi-printer"></i> Print
            </button>

            <!-- Add New Supply Button -->
                <a href="{{ route('admin.supplies.create') }}" class="btn btn-success shadow-sm ms-2 animated-btn">
                <i class="bi bi-plus-circle"></i> Add New Supply
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
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($supplies as $supply)
                    <tr>
                        <td>{{ $supply->name }}</td>
                        <td>{{ $supply->location }}</td>
                        <td>{{ $supply->stock }}</td>
                        <td>
                            <a href="{{ route('admin.supplies.edit', $supply->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="{{ route('admin.supplies.destroy', $supply->id) }}" 
                                class="btn btn-danger btn-sm" 
                                data-confirm="Are you sure you want to delete {{ $supply->name }}?" onclick="return confirmDelete(event, '{{ $supply->name }}')">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No supplies found.</td>
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
        window.location.href = "{{ route('admin.supplies.index') }}";
    }

    function printTable() {
        // Hide the "Actions" column
        const actionCells = document.querySelectorAll('td:nth-child(4), th:nth-child(4)');
        actionCells.forEach(cell => cell.style.display = 'none');
        
        // Get the contents of the print area
        const printContents = document.getElementById("printArea").innerHTML;
        const originalContents = document.body.innerHTML;

        // Set the document body to print contents and print
        document.body.innerHTML = printContents;
        window.print();

        // Restore the original content and visibility of the "Actions" column
        document.body.innerHTML = originalContents;
        actionCells.forEach(cell => cell.style.display = '');

        // Reload the page to reapply any JavaScript and styles
        location.reload();
    }

    function confirmDelete(event, supplyName) {
        // Display confirmation dialog
        const confirmation = confirm(`Are you sure you want to delete the supply "${supplyName}"?`);
        if (!confirmation) {
            // Prevent the link's default action if the user cancels
            event.preventDefault();
        }
    }
</script>

</body>
</html>
