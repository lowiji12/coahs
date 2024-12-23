<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    // Ang mga columns na pwedeng i-mass assign
    protected $fillable = [
        'generic_name',
        'brand_name',
        'dose',
        'form',
        'location',
        'stock',
    ];

    // Kung may mga relationships, idagdag dito
    // Example:
    // public function supplier()
    // {
    //     return $this->belongsTo(Supplier::class);
    // }
}
