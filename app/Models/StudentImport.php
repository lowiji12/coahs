<?php

namespace App\Models;

use App\Models\StudentInformation;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    public function model(array $row)
    {
        return new StudentInformation([
            'student_number' => $row[0],
            'surname'        => $row[1],
            'given_name'     => $row[2],
            'middle_name'    => $row[3],
            'program'        => $row[4],
            'citizenship'        => $row[5],
            'gender'        => $row[6],
            'indigenous'        => $row[7],
            'ethnicity'        => $row[8],
            'dialect'        => $row[9],
            'religion'        => $row[10],
            'birth_date'        => $row[11],
            'birth_place'        => $row[12],
            'contact_number'        => $row[13],
            'civil_status'        => $row[14],
            'address'        => $row[15],
            'email_address'        => $row[16],
            'entry_type'        => $row[17],
        ]);
    }
}
