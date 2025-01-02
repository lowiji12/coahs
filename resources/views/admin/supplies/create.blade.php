<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplies | COAHS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
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

        .form-card {
            background: lightblue;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            animation: fadeInUp 0.8s;
        }

        .btn-success:hover {
            background-color: green;
            transform: scale(1.05);
            transition: all 0.3s ease;
        }

        input {
            border-radius: 8px;
            padding: 10px;
            box-shadow: inset 0px 3px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="form-card animate__animated animate__fadeInUp">
        <h2 class="text-center mb-4">Add New Supply</h2>

        <form action="{{ route('admin.supplies.store') }}" method="GET">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Location/Shelves</label>
                <input type="text" name="location" class="form-control" placeholder="Location" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" placeholder="Stock" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">Add Supply</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
