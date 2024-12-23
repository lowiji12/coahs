<?php

// app/Models/AcademicSchoolYear.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSchoolYear extends Model
{
    use HasFactory;

    protected $fillable = ['year', 'is_default'];
}
