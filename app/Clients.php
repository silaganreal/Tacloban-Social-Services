<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = [
        'fname','mname','lname','birthday','gender','mobileNo','email','barangay','houseNoStName','profile','created_at','updated_at'
    ];
}
