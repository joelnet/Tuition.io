<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'date_of_birth',
        'address1',
        'address2',
        'city',
        'state',
        'postal_code',
        'country',
    ];
}
