<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'clientID','service','remarks','dateTime','assisstedBy','type','barangay','office','amount','reference','created_at','updated_at'
    ];
}
