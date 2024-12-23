@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/studentinfo.css') }}">

<div class="container">
    <div class="header">
        <h1>Diagnostic Test Results</h1>
        <div class="button-container">
            <a href="{{ route('sis.student.information.view', $student->student_number) }}" class="back-button">Back</a>
        </div>
    </div>

    <div class="filters">
        <select class="form-select" id="schoolYearSelect">
            <option value="">SCHOOL YEAR</option>
            @foreach ($schoolYears as $schoolYear)
                <option value="{{ $schoolYear->year }}" {{ $selectedSchoolYear == $schoolYear->year ? 'selected' : '' }}>
                    {{ $schoolYear->year }}
                </option>
            @endforeach
        </select>

        <select class="form-select" id="semesterSelect">
            <option value="">SEMESTER</option>
            @foreach ($semesters as $semester)
                <option value="{{ $semester->semester }}" {{ $selectedSemester == $semester->semester ? 'selected' : '' }}>
                    {{ $semester->semester }}
                </option>
            @endforeach
        </select>

        <button class="search-btn" onclick="filterResults()">Search</button>
    </div>

    <table class="diagnostic-table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Notes</th>
                <th>Remark</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $testTypes = [
                    'complete_blood_count' => 'Complete Blood Count',
                    'chest_xray' => 'Chest X-ray',
                    'drug_test' => 'Drug Test',
                    'hearing_test' => 'Hearing Test',
                    'hepatitis_b' => 'Hepatitis B Screening Test',
                    'fecalysis' => 'Fecalysis',
                    'urinalysis' => 'Urinalysis'
                ];
            @endphp
            @foreach ($testTypes as $key => $name)
                <tr>
                    <td>{{ $name }}</td>
                    <td>{{ $diagnosticTestResults->{$key . '_note'} ?? 'None' }}</td>
                    <td>{{ $diagnosticTestResults->{$key . '_remark'} ?? 'Not Available' }}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="select-btn" onclick="openViewModal('{{ $key }}', '{{ $name }}')">Select</button>
                            <button class="upload-btn" onclick="openModal('{{ $key }}')">Upload</button>
                            <button class="delete-btn" onclick="openDeleteModal('{{ $key }}', '{{ $name }}')">Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Upload File</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="uploadForm" action="{{ route('upload.diagnostic.test.result') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="student_number" value="{{ $student->student_number }}">
                <input type="hidden" name="school_year" id="selectedSchoolYear" value="{{ $selectedSchoolYear }}">
                <input type="hidden" name="semester" id="selectedSemester" value="{{ $selectedSemester }}">
                <input type="hidden" name="test_type" id="testType">

                <div class="form-group">
                    <label for="fileUpload">File Upload:</label>
                    <input type="file" id="fileUpload" name="file" accept=".jpg,.jpeg,.png,.pdf,.docx" required>
                    <small class="file-hint">Allowed files: jpg, jpeg, png, pdf, docx</small>
                </div>

                <div class="form-group">
                    <label for="remarks">Remarks:</label>
                    <select id="remarks" name="remarks" onchange="handleRemarksChange()" required>
                        <option value="">Select Remark</option>
                        <option value="Passed">Passed</option>
                        <option value="Failed">Failed</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div class="form-group" id="notesGroup" style="display: none;">
                    <label for="notes">Notes:</label>
                    <textarea id="notes" name="notes"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="submit-btn">Upload</button>
                    <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>View File</h2>
            <span class="close" onclick="closeViewModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="viewTestType">Test Type:</label>
                <input type="text" id="viewTestType" readonly>
            </div>

            <div class="form-group">
                <label>Current File:</label>
                <div id="filePreview" class="file-preview">
                    <!-- File preview will be inserted here -->
                </div>
            </div>

            <div class="form-group">
                <label>Remarks:</label>
                <textarea id="viewRemarks" readonly></textarea>
            </div>

            <div class="form-group">
                <label>Notes:</label>
                <textarea id="viewNotes" readonly></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="cancel-btn" onclick="closeViewModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Delete File</h2>
            <span class="close" onclick="closeDeleteModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this file?</p>
            <input type="hidden" id="deleteTestType">
            <div class="modal-footer">
                <button type="button" class="cancel-btn" onclick="closeDeleteModal()">Cancel</button>
                <button type="button" class="delete-btn" onclick="deleteFile()">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(testType) {
    document.getElementById('testType').value = testType;
    document.getElementById('uploadModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('uploadModal').style.display = 'none';
    document.getElementById('uploadForm').reset();
    document.getElementById('notesGroup').style.display = 'none';
}

function openViewModal(testType, testName) {
    document.getElementById('viewTestType').value = testName;

    // Fetch the file and remarks
    fetch(`/view-diagnostic-test-result?student_number={{ $student->student_number }}&school_year={{ $selectedSchoolYear }}&semester={{ $selectedSemester }}&test_type=${testType}`)
        .then(response => response.json())
        .then(data => {
            const filePreview = document.getElementById('filePreview');
            if (data.fileUrl.match(/\.(jpg|jpeg|png)$/i)) {
                filePreview.innerHTML = `<img src="${data.fileUrl}" alt="Test Result" style="max-width: 100%;">`;
            } else {
                filePreview.innerHTML = `<a href="${data.fileUrl}" target="_blank">View Document</a>`;
            }
            document.getElementById('viewRemarks').value = data.remark;
            document.getElementById('viewNotes').value = data.note;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error fetching file. Please try again.');
        });

    document.getElementById('viewModal').style.display = 'block';
}

function closeViewModal() {
    document.getElementById('viewModal').style.display = 'none';
}

function openDeleteModal(testType, testName) {
    document.getElementById('deleteTestType').value = testType;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

function deleteFile() {
    const testType = document.getElementById('deleteTestType').value;
    fetch(`/delete-diagnostic-test-result`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            student_number: '{{ $student->student_number }}',
            school_year: '{{ $selectedSchoolYear }}',
            semester: '{{ $selectedSemester }}',
            test_type: testType
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('File deleted successfully.');
            closeDeleteModal();
            location.reload();
        } else {
            alert('Error deleting file: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting file. Please try again.');
    });
}

function filterResults() {
    const selectedSchoolYear = document.getElementById('schoolYearSelect').value;
    const selectedSemester = document.getElementById('semesterSelect').value;
    window.location.href = `{{ route('sis.student.information.view', $student->student_number) }}?school_year=${selectedSchoolYear}&semester=${selectedSemester}`;
}

function handleRemarksChange() {
    const remarks = document.getElementById('remarks').value;
    const notesGroup = document.getElementById('notesGroup');
    if (remarks === 'Others') {
        notesGroup.style.display = 'block';
    } else {
        notesGroup.style.display = 'none';
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const uploadModal = document.getElementById('uploadModal');
    const viewModal = document.getElementById('viewModal');
    const deleteModal = document.getElementById('deleteModal');
    if (event.target === uploadModal) {
        closeModal();
    }
    if (event.target === viewModal) {
        closeViewModal();
    }
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
}
</script>
@endsection
