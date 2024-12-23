@extends('layouts.admin')

@section('content')
<div class="header">
    <h1>Student Profile</h1>
    <a href="{{ route('admin.student.information') }}" class="btn btn-gray">← Back to Student</a>
</div>

<div class="profile-section">
    <div class="avatar-container">
        <div class="avatar-placeholder">
            <img src="{{ $imageExists
                            ? 'http://203.177.208.99/images/spix/'.$student->student_number.'.Png'
                            : asset('storage/logo/coahs.png') }}"
                 alt="Student Photo">
        </div>
    </div>

    <div class="profile-details">
        <div class="details-column">
            <div class="detail-row">
                <div class="detail-label">Student Number:</div>
                <div class="detail-value">{{ $student->student_number }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Last Name:</div>
                <div class="detail-value">{{ $student->surname  }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">First Name:</div>
                <div class="detail-value">{{ $student->given_name }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Middle Name:</div>
                <div class="detail-value">{{ $student->middle_name }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Gender:</div>
                <div class="detail-value">{{ $student->gender }}</div>
            </div>
        </div>
        <div class="details-column">
            <div class="detail-row">
                <div class="detail-label">Program:</div>
                <div class="detail-value">{{ $student->program }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Year Level:</div>
                <div class="detail-value">{{ $student->year_level }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Email:</div>
                <div class="detail-value">{{ $student->email_address }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Phone Number:</div>
                <div class="detail-value">{{ $student->contact_number }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Enrolled By:</div>
                <div class="detail-value">oce</div>
            </div>
        </div>
    </div>
</div>

<div class="filters">
    <div class="filter-label">School Year</div>
    <select>
        <option>2022-2023</option>
    </select>
    <div class="filter-label">Semester</div>
    <select>
        <option>First Semester</option>
    </select>
    <button class="btn btn-gray">Search</button>
</div>

<div class="tabs">
    <button class="tab active">Clinical-Basal Data</button>
</div>

<table>
    <thead>
        <tr>
            <th>Age</th>
            <th>Height</th>
            <th>Weight</th>
            <th>Blood Type</th>
            <th>Disabilities</th>
            <th>Date Diagnosed</th>
            <th>HDI1</th>
            <th>HDI1 Date</th>
            <th>HDI2</th>
            <th>HDI2 Date</th>
            <th>Allergy (Med)</th>
            <th>Allergy (Food)</th>
            <th>Allergy (Others)</th>
            <th>Medication 1</th>
            <th>Medication 2</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($clinicalBasalData) && $clinicalBasalData !== null)
            <tr>
                <td>{{ $clinicalBasalData->age }}</td>
                <td>{{ $clinicalBasalData->height }}</td>
                <td>{{ $clinicalBasalData->weight }}</td>
                <td>{{ $clinicalBasalData->blood_type }}</td>
                <td>{{ $clinicalBasalData->disabilities }}</td>
                <td>{{ $clinicalBasalData->date_diagnosed }}</td>
                <td>{{ $clinicalBasalData->hdi1 }}</td>
                <td>{{ $clinicalBasalData->hdi1_date }}</td>
                <td>{{ $clinicalBasalData->hdi2 }}</td>
                <td>{{ $clinicalBasalData->hdi2_date }}</td>
                <td>{{ $clinicalBasalData->allergy_med }}</td>
                <td>{{ $clinicalBasalData->allergy_food }}</td>
                <td>{{ $clinicalBasalData->allergy_others }}</td>
                <td>{{ $clinicalBasalData->medication1 }}</td>
                <td>{{ $clinicalBasalData->medication2 }}</td>
            </tr>
        @else
            <tr>
                <td colspan="15" class="no-data">No data found.</td>
            </tr>
        @endif
    </tbody>
</table>
@endsection

@section('styles')


    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, sans-serif;
        }

        

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 0 4px;
        }

        .header h1 {
            font-size: 24px;
            color: #333;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none; /* Remove underline */
        }

        .btn-gray {
            background-color: #6c757d;
            color: white;
        }

        .btn-green {
            background-color: #28a745;
            color: white;
        }

        .profile-section {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            gap: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .avatar-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
        }

        .avatar-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-details {
            display: flex;
            flex-grow: 1;
            gap: 80px;
        }

        .details-column {
            flex: 1;
        }

        .detail-row {
            margin-bottom: 12px;
            display: flex;
        }

        .detail-label {
            width: 140px;
            color: #333;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            flex: 1;
        }

        .filters {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
        }

        .filter-label {
            font-weight: 500;
            color: #333;
            min-width: 100px;
        }

        select, input[type="search"] {
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 200px;
            font-size: 14px;
        }

        .tabs {
            display: flex;
            gap: 1px;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
        }

        .tab {
            padding: 10px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            color: #666;
            text-decoration: none; /* Remove underline */
        }

        .tab.active {
            background-color: #007bff;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .no-data {
            text-align: left;
            color: #666;
            font-style: italic;
            padding: 12px;
        }

        .qr-code-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
@endsection