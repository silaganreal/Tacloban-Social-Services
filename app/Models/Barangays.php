<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangays extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay','created_at','updated_at'
    ];
}
