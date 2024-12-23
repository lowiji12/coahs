@extends('layouts.admin')

@section('content')
    <div class="py-6 px-4 sm:px-6 lg:px-8 d-flex justify-content-between align-items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Student Data Profile</h2>
        <div>
            <a href="{{ route('sis.student.information') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="text-sm text-gray-600 mt-2" style="margin-top: -10px; font-family: Arial, sans-serif;"> Ramon Magsaysay Memorial Colleges respects each student's 
        personal privacy in accordance with the Data Privacy Act of 2012. By continuing to fill out this form, you agree to share your personal information. </div>

    <!-- Added space below the header -->
    <div style="margin-bottom: 130px;"></div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary card-outline bg-white">
                <div class="card-header">
                    <h3 class="card-title text-center" style="font-size: 1rem; font-weight: bold;">Upload File</h3>
                    <p class="text-muted text-center">
                        Please download this
                        <a download="COAHS-student-information-guide.xlsx"
                            href="{{ asset('excel/COAHS-student-information-guide.xlsx') }}">
                            <strong style="color: blue;">COAHS Students Information</strong>
                        </a> for the guide:
                    </p>
                    <hr>
                </div>
                <div class="card-body">
                    <form action="{{ route('import.student') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input class="form-control" type="file" id="import_file" name='import_file' required>
                        </div>
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Import</button>
                            <a type="button" class="btn btn-secondary"
                                href="{{ route('sis.student.information') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmImportModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmImportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmImportModalLabel">Confirm Import</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Imported Students:</h6>
                    <ul id="importedStudentsList"></ul>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('confirm.import') }}" method="POST">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#confirmImportModal').on('show.bs.modal', function () {
            var students = @json(session('imported_students'));
            var list = $('#importedStudentsList');
            list.empty();
            students.forEach(function (student) {
                list.append('<li>' + student.student_number + ': ' + student.surname + ', ' + student.given_name + ' ' + student.middle_name + ' (' + student.program + ')</li>');
            });
        });
    </script>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ $errors->first() }}',
            });
        </script>
    @endif
@endsection
