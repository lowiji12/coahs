<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Medicine | COAHS</title>
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
            border-radius: 20px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
            padding: 25px;
            width: 100%;
            max-width: 400px;
            max-height: 600px;
            overflow-y: auto;
            animation: fadeInUp 1s ease-out;
        }

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

        input, select {
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
        <h4 class="text-center mb-4">Edit Medicine</h4>

        <form action="{{ route('admin.medicines.update', $medicine->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Generic Name</label>
                <input type="text" name="generic_name" class="form-control" value="{{ $medicine->generic_name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Brand Name</label>
                <input type="text" name="brand_name" class="form-control" value="{{ $medicine->brand_name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Dose</label>
                <input type="text" name="dose" class="form-control" value="{{ $medicine->dose }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Form</label>
                <select id="form" name="form" class="form-control">
                    <option value="">Select Form</option>
                    <option value="Tablet" {{ $medicine->form == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="Capsule" {{ $medicine->form == 'Capsule' ? 'selected' : '' }}>Capsule</option>
                    <option value="Syrup" {{ $medicine->form == 'Syrup' ? 'selected' : '' }}>Syrup</option>
                    <option value="Parenteral" {{ $medicine->form == 'Parenteral' ? 'selected' : '' }}>Parenteral</option>
                    <option value="Inhalation" {{ $medicine->form == 'Inhalation' ? 'selected' : '' }}>Inhalation</option>
                    <option value="Ointment" {{ $medicine->form == 'Ointment' ? 'selected' : '' }}>Ointment</option>
                    <option value="Nasal Spray" {{ $medicine->form == 'Nasal Spray' ? 'selected' : '' }}>Nasal Spray</option>
                    <option value="Otic Drops" {{ $medicine->form == 'Otic Drops' ? 'selected' : '' }}>Otic Drops</option>
                    <option value="Eye Drops" {{ $medicine->form == 'Eye Drops' ? 'selected' : '' }}>Eye Drops</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Other Form (if any)</label>
                <input type="text" id="other_form" name="other_form" class="form-control" value="{{ $medicine->other_form }}" placeholder="Other Form (if any)">
            </div>
            <div class="mb-3">
                <label class="form-label">Expired Date</label>
                <input type="date" name="expired_date" class="form-control" value="{{ $medicine->expired_date }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="{{ $medicine->stock }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Location/Shelves</label>
                <input type="text" name="location" class="form-control" value="{{ $medicine->location }}" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-info">Save Changes</button>
                <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
