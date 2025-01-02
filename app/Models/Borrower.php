<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'course', 'year_level', 'category', 'borrowed_item', 'borrowed_date', 'quantity_borrowed'
    ];
}
