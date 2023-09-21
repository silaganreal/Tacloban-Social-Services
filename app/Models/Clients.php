<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname','mname','lname','birthday','gender','mobileNo','email','barangay','category','spouse','houseNoStName','profile','created_at','updated_at'
    ];
}
