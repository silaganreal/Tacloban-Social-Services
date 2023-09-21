<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicines extends Model
{
    use HasFactory;

    protected $fillable = [
        'clientID','historyID','diagnosis','treatment','medicine','pieces','dateTime','created_at','updated_at'
    ];
}
