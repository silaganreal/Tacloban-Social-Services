<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'clientID','service','medicine','diagnosis','treatment','remarks','diagnosis','treatment','dateTime','assisstedBy','type','barangay','office','amount','reference','created_at','updated_at'
    ];
}