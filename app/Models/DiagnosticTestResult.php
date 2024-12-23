<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosticTestResult extends Model
{
    protected $table = 'diagnostic_test_results';

    protected $fillable = [
        'student_number',
        'school_year',
        'semester',
        'complete_blood_count',
        'complete_blood_count_note',
        'complete_blood_count_remark',
        'complete_blood_count_upload_date',
        'chest_xray',
        'chest_xray_note',
        'chest_xray_remark',
        'chest_xray_upload_date',
        'drug_test',
        'drug_test_note',
        'drug_test_remark',
        'drug_test_upload_date',
        'hearing_test',
        'hearing_test_note',
        'hearing_test_remark',
        'hearing_test_upload_date',
        'hepatitis_b',
        'hepatitis_b_note',
        'hepatitis_b_remark',
        'hepatitis_b_upload_date',
        'fecalysis',
        'fecalysis_note',
        'fecalysis_remark',
        'fecalysis_upload_date',
        'urinalysis',
        'urinalysis_note',
        'urinalysis_remark',
        'urinalysis_upload_date'
    ];

    protected $dates = [
        'complete_blood_count_upload_date',
        'chest_xray_upload_date',
        'drug_test_upload_date',
        'hearing_test_upload_date',
        'hepatitis_b_upload_date',
        'fecalysis_upload_date',
        'urinalysis_upload_date',
        'created_at',
        'updated_at'
    ];
}