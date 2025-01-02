<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Equipment | COAHS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        /* Background gradient */
        body {
            background: linear-gradient(135deg, white, white);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }

        /* Animated card appearance */
        .form-card {
            background: lightblue;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            animation: fadeInUp 0.8s;
        }

        /* Button hover animation */
        .btn-success:hover {
            background-color: #00b894;
            transform: scale(1.05);
            transition: all 0.3s ease;
        }

        /* Custom field styling */
        input {
            border-radius: 8px;
            padding: 10px;
            box-shadow: inset 0px 3px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="form-card animate__animated animate__fadeInUp">
        <h4 class="text-center mb-4">Add New Equipment</h4>

            @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
            @endif

            @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
            @endif

        <form method="POST" action="{{ route('admin.equipment.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Location/Shelves</label>
                <input type="text" name="location" class="form-control" placeholder="Location" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" placeholder="Quantity" required min="1">
            </div>
            <div class="mb-3">
                <label class="form-label">Expire-Date</label>
                <input type="date" name="expire_date" class="form-control" required min="1">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">Add Equipment</button>
                <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

