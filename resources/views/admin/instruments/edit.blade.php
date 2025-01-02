<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Instrument</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        /* Background with gradient and animation */
        body {
            background: linear-gradient(135deg, white, white);
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
            border-radius: 20px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
            padding: 35px;
            width: 100%;
            max-width: 500px;
            animation: fadeInUp 1s ease-out;
        }

        /* Smooth button scaling */
        .btn-success:hover {
            background-color: #27ae60;
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }

        .btn-secondary:hover {
            background-color: #636e72;
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }

        /* Input styling */
        input {
            border-radius: 10px;
            padding: 12px;
            box-shadow: inset 0px 3px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            color: #2d3436;
        }
    </style>
</head>

<body>
    <div class="form-card animate__animated animate__fadeInUp">
        <h4 class="text-center mb-4">Edit Instrument</h4>

        <form action="{{ route('admin.instruments.update', $instrument->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $instrument->name }}" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location/Shelves</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ $instrument->location }}" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $instrument->quantity }}" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">Update Instrument</button>
                <a href="{{ route('admin.instruments.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
