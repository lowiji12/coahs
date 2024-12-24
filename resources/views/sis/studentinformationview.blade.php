@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/studentinfo.css') }}">

<div class="container">
    <div class="header">
        <h1>Student Data Profile</h1>
        <div class="button-container">
            <a href="{{ route('sis.student.information') }}" class="back-button">Back</a>
            <button class="apply-button" onclick="applyChanges()">Apply</button>
            <a href="{{ route('admin.student.diagnostic_test_results', $student->student_number) }}"
                class="next-button">Next</a>
        </div>
    </div>

    <p class="privacy-notice">
        The Office of Planning Management and Council complies to protect each student's personal privacy in compliance
        with Data Privacy Act of 2012 while ensuring its ability to fully carry out its responsibilities. It is
        understood that you agree to share your personal information by continuing to fill-up this form.
    </p>

    <h2 class="section-title">Personal Information</h2>

    <div class="avatar-container">
        <div class="avatar-placeholder">
            @php
                $currentHour = date('H'); // Get the current hour in 24-hour format
                $currentMinute = date('i'); // Get the current minute

                // Check if the time is between 10:30 PM (22:30) and 6:30 AM (06:30)
                $isNightTime = ($currentHour >= 22 && $currentMinute >= 30) || ($currentHour >= 23 || $currentHour < 6) || ($currentHour == 6 && $currentMinute <= 30);
            @endphp

            <img src="{{ $isNightTime
    ? asset('images/coahs.png')
    : ($imageExists
        ? 'http://203.177.208.99/images/spix/' . $student->student_number . '.Png'
        : asset('images/coahs.png')) }}" alt="Student Photo">
        </div>

    </div>

    <form id="studentForm">
        @csrf
        <div class="form-content">
            <div class="form-left">
                <div class="form-group">
                    <label for="surname">Surname:</label>
                    <input type="text" id="surname" value="{{ $student->surname ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" value="{{ $student->given_name ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="middleName">Middle Name:</label>
                    <input type="text" id="middleName" value="{{ $student->middle_name ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="ethnicity">Ethnicity:</label>
                    <input type="text" id="ethnicity" value="{{ $student->ethnicity ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="dialect">Dialect:</label>
                    <input type="text" id="dialect" value="{{ $student->dialect ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="religion">Religion:</label>
                    <input type="text" id="religion" value="{{ $student->religion ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label>Birth Date:</label>
                    <div class="birth-date-group">
                        <input type="text"
                            value="{{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('F j, Y') : 'N/A' }}"
                            readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="placeOfBirth">Place of Birth:</label>
                    <input type="text" id="placeOfBirth" value="{{ $student->birth_place ?? 'N/A' }}" readonly>
                </div>
            </div>

            <div class="form-right">
                <div class="form-group">
                    <label for="citizenship">Citizenship:</label>
                    <input type="text" id="citizenship" value="{{ $student->citizenship ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label>Gender:</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="male" name="gender" {{ $student->gender == 'Male' ? 'checked' : '' }}
                                disabled>
                            <label for="male">Male</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="female" name="gender" {{ $student->gender == 'Female' ? 'checked' : '' }} disabled>
                            <label for="female">Female</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Indigenous?</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="indigenous-yes" name="indigenous" {{ $student->indigenous == 'Yes' ? 'checked' : '' }} disabled>
                            <label for="indigenous-yes">Yes</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="indigenous-no" name="indigenous" {{ $student->indigenous == 'No' ? 'checked' : '' }} disabled>
                            <label for="indigenous-no">No</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Civil Status:</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="single" name="civil-status" {{ $student->civil_status == 'Single' ? 'checked' : '' }} disabled>
                            <label for="single">Single</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="taken" name="civil-status" {{ $student->civil_status == 'Taken' ? 'checked' : '' }} disabled>
                            <label for="taken">Taken</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="radio-option">
                        <input type="radio" id="widowed" name="civil-status" {{ $student->civil_status == 'Widowed' ? 'checked' : '' }} disabled>
                        <label for="widowed">Widowed</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="program">Program:</label>
                    <input type="text" id="program"
                        value="{{ $student->program == 'BSP' ? 'Bachelor of Science in Pharmacy' : ($student->program == 'BSN' ? 'Bachelor of Science in Nursing' : ($student->program == 'BSW' ? 'Bachelor of Science in Midwifery' : 'N/A')) }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label for="yearLevel">Year Level:</label>
                    <select id="yearLevel" name="year_level">
                        <option value="1" {{ $student->year_level == '1' ? 'selected' : '' }}>First Year</option>
                        <option value="2" {{ $student->year_level == '2' ? 'selected' : '' }}>Second Year</option>
                        <option value="3" {{ $student->year_level == '3' ? 'selected' : '' }}>Third Year</option>
                        <option value="4" {{ $student->year_level == '4' ? 'selected' : '' }}>Fourth Year</option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <h2 class="section-title">Contact Information</h2>

    <form>
        <div class="form-content">
            <div class="form-left">
                <div class="form-group">
                    <label for="homeAddress">Home Address:</label>
                    <input type="text" id="homeAddress" value="{{ $student->address ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="emailAddress">Email Address:</label>
                    <input type="text" id="emailAddress" value="{{ $student->email_address ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="phoneNumber1">Phone Number 1:</label>
                    <input type="text" id="phoneNumber1"
                        value="{{ $student->contact_number ? (Str::startsWith($student->contact_number, '+63') ? '0' . substr($student->contact_number, 3) : (Str::startsWith($student->contact_number, '9') ? '0' . $student->contact_number : $student->contact_number)) : 'N/A' }}"
                        readonly>
                </div>
            </div>

            <div class="form-right">
                <div class="form-group">
                    <label for="phoneNumber2">Phone Number 2:</label>
                    <input type="text" id="phoneNumber2" value="N/A" readonly>
                </div>
            </div>
        </div>
    </form>

    <h2 class="section-title">Parent/Guardian Data</h2>

    <form>
        <div class="form-content">
            <div class="form-left">
                <h3>Parent</h3>
                <div class="form-group">
                    <label for="parentFullName">Full Name:</label>
                    <input type="text" id="parentFullName" value="{{ $parentGuardianData->parent_fullname ?? 'N/A' }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label for="parentAddress">Address:</label>
                    <input type="text" id="parentAddress" value="{{ $parentGuardianData->parent_address ?? 'N/A' }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label for="parentContactNo">Contact No.:</label>
                    <input type="text" id="parentContactNo"
                        value="{{ $parentGuardianData->parent_contact_number ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="parentRelationship">Relationship:</label>
                    <input type="text" id="parentRelationship"
                        value="{{ $parentGuardianData->parent_relationship ?? 'N/A' }}" readonly>
                </div>
            </div>

            <div class="form-right">
                <h3>Guardian</h3>
                <div class="form-group">
                    <label for="guardianFullName">Full Name:</label>
                    <input type="text" id="guardianFullName"
                        value="{{ $parentGuardianData->guardian_fullname ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="guardianAddress">Address:</label>
                    <input type="text" id="guardianAddress" value="{{ $parentGuardianData->guardian_address ?? 'N/A' }}"
                        readonly>
                </div>

                <div class="form-group">
                    <label for="guardianContactNo">Contact No.:</label>
                    <input type="text" id="guardianContactNo"
                        value="{{ $parentGuardianData->guardian_contact_number ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="guardianRelationship">Relationship:</label>
                    <input type="text" id="guardianRelationship"
                        value="{{ $parentGuardianData->guardian_relationship ?? 'N/A' }}" readonly>
                </div>

                <div class="form-group">
                    <label>Parent as Guardian:</label>
                    <input type="checkbox" id="parentAsGuardian" {{ $parentGuardianData->parent_as_guardian == "1" ? 'checked' : '' }} disabled>
                </div>
            </div>
        </div>
    </form>

    <h2 class="section-title">Student Clinical-Basal Data</h2>

    <form>
        <div class="clinical-form-content">
            <div class="clinical-form-left">
                <div class="clinical-form-group">
                    <label for="height">Height:</label>
                    <input type="text" id="height" value="{{ $clinicalBasalData->height ?? 'N/A' }} cm" readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="weight">Weight:</label>
                    <input type="text" id="weight" value="{{ $clinicalBasalData->weight ?? 'N/A' }} kg" readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="bloodType">Blood Type:</label>
                    <input type="text" id="bloodType" value="{{ $clinicalBasalData->blood_type ?? 'N/A' }}" readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="congenitalDiseases">Congenital (Inborn) Diseases/Disabilities (if any):</label>
                    <input type="text" id="congenitalDiseases" value="{{ $clinicalBasalData->disabilities ?? 'None' }}"
                        readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="dateDiagnosed">Date Diagnosed:</label>
                    <input type="text" id="dateDiagnosed" value="{{ $clinicalBasalData->date_diagnosed ?? 'None' }}"
                        readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="medication1">Medication (Emergency/Maintenance) & Indication(s) (if any):</label>
                    <input type="text" id="medication1" value="{{ $clinicalBasalData->medication1 ?? 'None' }}"
                        readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="medication2">Medication (Emergency/Maintenance) & Indication(s) (if any):</label>
                    <input type="text" id="medication2" value="{{ $clinicalBasalData->medication2 ?? 'None' }}"
                        readonly>
                </div>
            </div>

            <div class="clinical-form-right">
                <div class="clinical-form-group">
                    <label for="previousHospitalization1">Previous Hospitalization Due to Illness/Surgical Operation (if
                        any):</label>
                    <input type="text" id="previousHospitalization1" value="{{ $clinicalBasalData->hdi1 ?? 'None' }}"
                        readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="previousHospitalizationDate1">Date:</label>
                    <input type="text" id="previousHospitalizationDate1"
                        value="{{ $clinicalBasalData->hdi1_date ?? 'None' }}" readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="previousHospitalization2">Previous Hospitalization Due to Illness/Surgical Operation (if
                        any):</label>
                    <input type="text" id="previousHospitalization2" value="{{ $clinicalBasalData->hdi2 ?? 'None' }}"
                        readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="previousHospitalizationDate2">Date:</label>
                    <input type="text" id="previousHospitalizationDate2"
                        value="{{ $clinicalBasalData->hdi2_date ?? 'None' }}" readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="allergiesMedicine">Allergies (if any) - Medicine:</label>
                    <input type="text" id="allergiesMedicine" value="{{ $clinicalBasalData->allergy_med ?? 'None' }}"
                        readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="allergiesFood">Food:</label>
                    <input type="text" id="allergiesFood" value="{{ $clinicalBasalData->allergy_food ?? 'None' }}"
                        readonly>
                </div>

                <div class="clinical-form-group">
                    <label for="allergiesOthers">Others:</label>
                    <input type="text" id="allergiesOthers" value="{{ $clinicalBasalData->allergy_others ?? 'None' }}"
                        readonly>
                </div>
            </div>
        </div>
    </form>

    <script>
        function applyChanges() {
            const form = document.getElementById('studentForm');
            form.action = "{{ route('update.student.yearlevel', $student->student_number) }}";
            form.method = "POST";
            form.submit();
        }
    </script>
    @endsection