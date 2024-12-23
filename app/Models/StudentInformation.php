<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInformation extends Model
{
    use HasFactory;

    protected $table = 'student_information';

    protected $primaryKey = 'student_number'; // Set the primary key

    public $incrementing = false; // Indicate that the primary key is not an auto-incrementing integer

    protected $keyType = 'string'; // Specify the type of the primary key

    protected $fillable = [
        'student_number',
        'surname',
        'given_name',
        'middle_name',
        'program',
        'citizenship',
        'gender',
        'indigenous',
        'ethnicity',
        'dialect',
        'religion',
        'birth_date',
        'birth_place',
        'contact_number',
        'civil_status',
        'address',
        'email_address',
        'entry_type',
        'year_level',
    ];
}
