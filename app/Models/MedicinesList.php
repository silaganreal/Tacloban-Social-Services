<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicinesList extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine','brand','miligram','quantity','created_at','updated_at'
    ];
}
