<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine | COAHS</title>
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
            padding: 20px;
            width: 100%;
            max-width: 400px;
            max-height: 600px;
            overflow-y: auto;
            animation: fadeInUp 0.8s;
        }

        /* Button hover animation */
        .btn-success:hover {
            background-color: green;
            transform: scale(1.05);
            transition: all 0.3s ease;
        }

        /* Custom field styling */
        input, select {
            border-radius: 8px;
            padding: 10px;
            box-shadow: inset 0px 3px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="form-card animate__animated animate__fadeInUp">
        <h4 class="text-center mb-4">Add New Medicine</h4>

        <form action="{{ route('admin.medicines.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Generic Name</label>
                <input type="text" name="generic_name" class="form-control" placeholder="Generic Name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Brand Name</label>
                <input type="text" name="brand_name" class="form-control" placeholder="Brand Name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Dose</label>
                <input type="text" name="dose" class="form-control" placeholder="Dose" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Form</label>
                <select id="form" name="form" class="form-control">
                    <option value="">Select Form</option>
                    <option value="Tablet">Tablet</option>
                    <option value="Capsule">Capsule</option>
                    <option value="Syrup">Syrup</option>
                    <option value="Parenteral">Parenteral</option>
                    <option value="Inhalation">Inhalation</option>
                    <option value="Ointment">Ointment</option>
                    <option value="Nasal Spray">Nasal Spray</option>
                    <option value="Otic Drops">Otic Drops</option>
                    <option value="Eye Drops">Eye Drops</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Other Form (if any)</label>
                <input type="text" id="other_form" name="other_form" class="form-control" placeholder="Other Form (if any)">
            </div>
            <div class="mb-3">
                <label class="form-label">Expired Date</label>
                <input type="date" name="expired_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" placeholder="Stock" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Location/Shelves</label>
                <input type="text" name="location" class="form-control" placeholder="Location" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">Add Medicine</button>
                <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelector("form").addEventListener("submit", function(event) {
            // Check if the "Form" dropdown is empty and "Other Form" is filled
            if (document.getElementById("form").value === "" && document.getElementById("other_form").value === "") {
                alert("Please select a form or provide an other form.");
                event.preventDefault(); // Prevent form submission
            } else {
                if (document.getElementById("form").value === "") {
                    document.getElementById("form").value = document.getElementById("other_form").value;
                }
            }
        });
    </script>
</body>
</html>
