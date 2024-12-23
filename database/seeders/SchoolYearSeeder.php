<?php

// database/seeders/SchoolYearSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicSchoolYear;

class SchoolYearSeeder extends Seeder
{
    public function run()
    {
        for ($year = 2022; $year <= 2030; $year++) {
            AcademicSchoolYear::create([
                'year' => $year . '-' . ($year + 1),
                'is_default' => false,
            ]);
        }
    }
}
