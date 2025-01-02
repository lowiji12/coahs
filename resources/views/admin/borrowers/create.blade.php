<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Borrower | COAHS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        /* Background with gradient and animation */
        body {
            background: linear-gradient(135deg,  white, white);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0;
            overflow: hidden;
            animation: gradientAnimation 10s infinite alternate;
        }

        @keyframes gradientAnimation {
            0% { background-color: #74b9ff; }
            100% { background-color: #81ecec; }
        }

        /* Card styling */
        .form-card {
            background: lightblue;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 400px; /* Adjusted width for mid-small size */
            max-height: 600px; /* Restricting height for mid-small form card */
            overflow-y: auto; /* Enables scrolling if content overflows */
            animation: fadeInUp 0.8s;
        }

        /* Smooth button scaling */
        .btn-info:hover {
            background-color: green;
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }

        .btn-secondary:hover {
            background-color: gray;
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }

        /* Input styling */
        input, select {
            border-radius: 10px;
            padding: 12px;
            box-shadow: inset 0px 3px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
            color: #2d3436;
        }

        button {
            background-color: #81ecec;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: green;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="form-card animate__animated animate__fadeInUp">
        <h4 class="text-center mb-4">Add Borrower</h4>

        <!-- Display Flash Messages -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.borrowers.store') }}" method="GET">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Course</label>
                <input type="text" name="course" class="form-control" placeholder="Course" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Year Level</label>
                <input type="text" name="year_level" class="form-control" placeholder="Year Level" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="CHEMICALS">Chemicals</option>
                    <option value="EQUIPMENTS">Equipments</option>
                    <option value="INSTRUMENTS">Instruments</option>
                    <option value="MEDICINES">Medicines</option>
                    <option value="SUPPLIES">Supplies</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Borrowed Item</label>
                <input type="text" name="borrowed_item" class="form-control" placeholder="Borrowed Item" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Borrowed-Date</label>
                <input type="date" name="borrowed_date" class="form-control" placeholder="Borrowed Date" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantity Borrowed</label>
                <input type="number" name="quantity_borrowed" class="form-control" placeholder="Quantity Borrowed" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-info">Add Borrower</button>
                <a href="{{ route('admin.borrowers.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
