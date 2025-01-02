<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowers | COAHS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">List of Borrowers</h2>
        <div class="d-flex">
            <form action="{{ route('admin.borrowers.index') }}" method="GET" class="d-flex position-relative">
                <input type="text" name="search" class="form-control form-control-sm pe-5" placeholder="Search Borrowers..." aria-label="Search">
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
            <a href="{{ route('admin.borrowers.create') }}" class="btn btn-success shadow-sm ms-2 animated-btn">
                <i class="bi bi-plus-circle"></i> Add New Borrower
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
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Course</th>
                    <th>Year-Level</th>
                    <th>Category</th>
                    <th>Borrowed Item</th>
                    <th>Borrowed-Date</th>
                    <th>Quantity-Borrowed</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowers as $borrower)
                    <tr>
                        <td>{{ $borrower->first_name }}</td>
                        <td>{{ $borrower->last_name }}</td>
                        <td>{{ $borrower->course }}</td>
                        <td>{{ $borrower->year_level }}</td>
                        <td>{{ $borrower->category }}</td>
                        <td>{{ $borrower->borrowed_item }}</td>
                        <td>{{ $borrower->borrowed_date }}</td>
                        <td>{{ $borrower->quantity_borrowed }}</td>
                        <td>
                            <a href="{{ route('admin.borrowers.edit', $borrower->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="{{ route('admin.borrowers.delete', $borrower->id) }}" 
                                class="btn btn-danger btn-sm" 
                                data-confirm="Are you sure you want to delete {{ $borrower->first_name }} {{ $borrower->last_name }}?" 
                                onclick="return confirmDelete(event, '{{ $borrower->first_name }} {{ $borrower->last_name }}')">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No borrowers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

<style>
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
        document.querySelector('input[name="search"]').value = '';
        window.location.href = "{{ route('admin.borrowers.index') }}";
    }

    function printTable() {
        const actionCells = document.querySelectorAll('td:nth-child(9), th:nth-child(9)');
        actionCells.forEach(cell => cell.style.display = 'none');

        const printContents = document.getElementById("printArea").innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();

        document.body.innerHTML = originalContents;
        actionCells.forEach(cell => cell.style.display = '');

        location.reload();
    }

    function confirmDelete(event, borrowerName) {
        const confirmation = confirm(`Are you sure you want to delete the borrower "${borrowerName}"?`);
        if (!confirmation) {
            event.preventDefault();
        }
    }
</script>

</body>
</html>
